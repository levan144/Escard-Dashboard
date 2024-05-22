<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Company extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;
    public $translatable = ['name','working_hours','address'];
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function getUsers()
    {
        return $this->hasMany(User::class, 'company_id');
    }
    
    public function getOffers(){
        return $this->hasMany(Offer::class, 'company_id');
    }
    
   
}
