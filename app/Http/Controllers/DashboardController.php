<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function book()
    {
        return view('dashboard.book.index', [
            'books' => Book::all()
        ]);
    }

    public function category()
    {
        return view('dashboard.category.index', [
            'categories' => Category::all()
        ]);
    }

    public function author()
    {
        return view('dashboard.author.index', [
            'authors' => Author::all()
        ]);
    }

    public function review()
    {
        return view('dashboard.review.index', [
            'reviews' => Review::with(['book', 'reviewer'])->get()
        ]);
    }

    public function user()
    {
        return view('dashboard.user.index', [
            'users' => User::withTrashed()->get()
        ]);
    }

    public function moderator()
    {
        if (Gate::denies('admin')) {
            return Redirect::back()->with('alert', [
                'icon' => 'error',
                'title' => 'ERROR',
                'text' => 'Anda bukan admin',
                'timer' => 2500
            ]);
        }

        return view('dashboard.moderator.index', [
            'moderators' => User::withTrashed()->where('level', 1)->get()
        ]);
    }
}
