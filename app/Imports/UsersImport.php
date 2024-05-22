<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordMail;
use Illuminate\Support\Facades\DB;
use Throwable;
use Illuminate\Support\Facades\Validator;

class UsersImport implements OnEachRow, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    protected $users = [];

    public function onRow(Row $row)
    {

        $rowIndex = $row->getIndex();
        $row = $row->toArray();
        
         // Skip the row if all columns are null
        if (empty(array_filter($row))) {
            return;
        }
       
      
         // Validate the row
        $validator = Validator::make($row, [
            'name' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'sid' => ['required'],
            'phone' => ['required'],
            'company_id' => ['required']
        ]);
         
        if ($validator->fails()) {
        // Handle the validation failure
        // For example, you can throw an exception with the validation error messages
            throw new \Exception('Validation error in row '.$rowIndex.': '.implode(', ', $validator->errors()->all()));
        }
        
        // Check for required columns
        $requiredColumns = ['name', 'lastname', 'email', 'sid', 'phone', 'company_id'];
        foreach ($requiredColumns as $column) {
            if (!array_key_exists($column, $row)) {
                    throw new \Exception("The {$column} column is required in row {$rowIndex}.");
            }
        }

        $password = $this->generatePassword();
        
        // Create a new user instance
        $user = new User([
            'name' => $row['name'],
            'lastname' => $row['lastname'],
            'email' => $row['email'],
            'sid' => $row['sid'],
            'phone' => $row['phone'],
            'company_id' => $row['company_id'],
            'password' => Hash::make($password)
        ]);
        
        // Check if the user already exists in the array
        foreach ($this->users as $storedUser) {
            if (strtolower($storedUser['user']->email) === strtolower($user->email)) {
                // Skip the current iteration if the user already exists
                return;
            }
        }
        // Store the user instance and its password in an array
        // It will be used later to save the users and send emails
        $this->users[] = ['user' => $user, 'password' => $password];
    }

    private function generatePassword()
    {
        // Generate a random password
        return bin2hex(random_bytes(6));
    }

    private function sendPasswordByEmail(User $user, string $password)
    {
        try {
            // Logic for sending the password to the user's email
            // Use your preferred email sending method, such as Laravel's built-in Mail facade
            // Here's an example using the Mail facade:
            Mail::to($user->email)->cc('info@escard.ge')->send(new PasswordMail($password, $user->email));
        } catch (\Exception $e) {
            return true;
            // return response()->json(['error' => 'Failed to send email.'], 500);
        }
    }

    public function importComplete()
    {
        try {
        // Save the users and send emails
        DB::transaction(function () {
            foreach ($this->users as $item) {
                $user = $item['user'];
                $password = $item['password'];
                
                $userModel = new User;
                $userModel->name = $user->name;
                $userModel->lastname = $user->lastname;
                $userModel->email = $user->email;
                $userModel->sid = $user->sid;
                $userModel->phone = $user->phone;
                $userModel->company_id = $user->company_id;
                $userModel->password = $user->password;
                // Save the user record
                $userModel->save();
                
                // Send password to the user's email
                $this->sendPasswordByEmail($user, $password);
            }
        });
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required'],
            '*.lastname' => ['required'],
            '*.email' => ['required', 'email', 'unique:users'],
            '*.sid' => ['required', 'unique:users'],
            '*.phone' => ['required'],
            '*.company_id' => ['required']
        ];
    }

    public function onFailure(Failure ...$failures)
{
    // Handle the failures
    foreach ($failures as $failure) {
        $rowIndex = $failure->row();
        $errorMessage = 'Error in row ' . $rowIndex . ': ' . $failure->errors()[0];

        // Check if the error is due to empty fields
        $rowData = $failure->values();
        if (count(array_filter($rowData, function ($value) {
            return $value !== null && $value !== '';
        })) === 0) {
            continue; // Skip this failure if all values are empty
        }

        // Handle other failures
        $errors = session()->get('errors', []);
        array_push($errors, $errorMessage);
        session()->flash('errors', $errors);
    }
}

// Add this to the UsersImport class
public function hasFailures()
{
    return !empty(session()->get('errors'));
}
    public function onError(Throwable $error)
{
    // Handle the error
    $errorMessage = 'Error: '.$error->getMessage();
    // Similarly, store or log the error message as per your requirements
    $errors = session()->get('errors', []);
    array_push($errors, $errorMessage);
    session()->flash('errors', $errors);
}
}
