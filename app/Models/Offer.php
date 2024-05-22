<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;
use Auth;
use Spatie\Translatable\HasTranslations;

class Offer extends Model
{
    use HasFactory, Markable, HasTranslations;
    public $translatable = ['name','subtitle', 'description','sale_text', 'benefits'];
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'benefits' => 'array',
    ];
    protected static $marks = [
        Like::class
    ];
    /**
     * Append custom columns to the model
     * 
     * @var array
     */
    protected $appends = ['favorited'];
    public function getCompany()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    
    public function getCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', 1)->where('deleted_at', null);
    }
   
    
    public function getFavoritedAttribute(){
        return Like::has($this, Auth::user());
    }

}
