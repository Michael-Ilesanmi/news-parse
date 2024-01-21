<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;


    /**
     * Use UUID as primary key
     */
    protected $keyType = 'string';
    public $incrementing = false;
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'date_added',
        'link',
    ];

    /**
    * Get the talent's avatar.
    *
    * @param  string  $value
    *
    * @return string
    */
    public function getImageAttribute($value)
    {
        if ($value) {
            return $value;
        } else {
            return "https://fakeimg.pl/400x400?text=NEWS";
        }
    }
}
