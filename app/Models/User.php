<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\UserObserver;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'password',
        'deleted_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getCompany()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    
    public function getCard()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
    
    protected static function boot()
    {
        parent::boot();
        self::observe(UserObserver::class);
    }
    
    public function getNameAttribute($value)
    {
        return $this->replaceGeorgianSymbols($value);
    }

    public function getLastnameAttribute($value)
    {
        return $this->replaceGeorgianSymbols($value);
    }

    private function replaceGeorgianSymbols($text)
{
    $georgian = ['ა', 'ბ', 'გ', 'დ', 'ე', 'ვ', 'ზ', 'თ', 'ი', 'კ', 'ლ', 'მ', 'ნ', 'ო', 'პ', 'ჟ', 'რ', 'ს', 'ტ', 'უ', 'ფ', 'ქ', 'ღ', 'ყ', 'შ', 'ჩ', 'ც', 'ძ', 'წ', 'ჭ', 'ხ', 'ჯ', 'ჰ'];
    $latin = ['a', 'b', 'g', 'd', 'e', 'v', 'z', 't', 'i', 'k', 'l', 'm', 'n', 'o', 'p', 'zh', 'r', 's', 't', 'u', 'f', 'k', 'gh', 'q', 'sh', 'ch', 'ts', 'dz', 'ts', 'ch', 'kh', 'j', 'h'];
    
    // Check if there is already a Latin character in the text
    $hasLatinCharacter = preg_match('/[a-zA-Z]/', $text);
    
    // If there is no Latin character, replace Georgian symbols
    if (!$hasLatinCharacter) {
        $text = str_replace($georgian, $latin, $text);
    }

    return $text;
}
}
