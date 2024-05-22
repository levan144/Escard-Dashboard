<?php

namespace App\Imports;

use App\Models\Notification;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\FromCollection;

class MessageUsersImport implements FromCollection, WithHeadingRow
{
    public function collection()
    {   
        return Notification::all();
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        
        dd($row);
        $email = $row['email'];
        $promo_code = $row['promo'];
        
    }
}
