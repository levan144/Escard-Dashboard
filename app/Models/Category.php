<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasFactory, HasTranslations;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $translatable = ['name'];
    protected $fillable = [
        'parent_id',
        'icon',
        'icon_hover',
        'color'
    ];
}
