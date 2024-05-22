<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\ResetCodePassword;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\CodeCheckRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\TemporaryPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class CodeCheckController extends ApiController
{
    /**
     * Check if the code is exist and vaild one (Setp 2)
     *
     * @param  mixed $request
     * @return void
     */
    public function __invoke(CodeCheckRequest $request)
    {
        $passwordReset = ResetCodePassword::firstWhere('code', $request->code);
        if (!$passwordReset) {
            return $this->jsonResponse(null, trans('validation.code_is_incorrect'), 400);
        }
        if ($passwordReset->isExpire()) {
            return $this->jsonResponse(null, trans('validation.code_is_expire'), 422);
        }

        //Change User Password and Send Email
        $random_string = Str::random(8);
        
        $user = User::firstWhere('email', $passwordReset->email);
        
        $mail = Mail::to($passwordReset->email)->send(new TemporaryPassword($random_string));
        
        $user->password = Hash::make($random_string);
        $user->save();

        return $this->jsonResponse(['code' => $passwordReset->code], trans('validation.code_is_valid'), 200);
    }
}