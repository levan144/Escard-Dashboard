<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedUser extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'sid',
        'phone', 
        'company_id',
        'card_id'
    ];
    
    public function getCompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
    public function getCard()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
