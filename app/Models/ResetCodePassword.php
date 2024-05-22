<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResetCodePassword extends Model
{
    use HasFactory;
    public $timestamps = TRUE;
    protected $fillable = [
        'email',
        'code',
        'created_at',
        'updated_at'
    ];

    /**
     * check if the code is expire then delete
     *
     * @return void
     */
    public function isExpire()
    {
        if ($this->created_at > now()->addHour()) {
            $this->delete();
        }
    }
}