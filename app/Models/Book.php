<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Http\Request;
// use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Laravel\Scout\Attributes\SearchUsingFullText;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory/* , Searchable */, SoftDeletes;

    protected $guarded = [
        'id'
    ];

    protected $with = [
        'author',
        'category'
    ];

    /* #[SearchUsingFullText(['synopsis'])]
    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'synopsis' => $this->synopsis
        ];
    } */

    public function scopeFilter(Builder $query, Request $request)
    {
        $query->when($request->has('search'), function (Builder $query) use ($request) {
            // return $query->search($request->get('search'));

            $search = $request->get('search');

            return $query
                ->where('title', 'like', '%' . $search . '%')
                ->orWhereFullText('synopsis', $search);
        });

        $query->when($request->has('author'), function (Builder $query) use ($request) {
            return $query->whereHas('author', function (Builder $query) use ($request) {
                $query->where('slug', $request->get('author'));
            });
        });

        $query->when($request->has('category'), function (Builder $query) use ($request) {
            return $query->whereHas('category', function (Builder $query) use ($request) {
                $query->where('slug', $request->get('category'));
            });
        });
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
