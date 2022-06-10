<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public static function boot()
    {
        parent::boot();

        static::softDeleted(function (Author $author) {
            $author->books()->delete();
        });
    }
}
