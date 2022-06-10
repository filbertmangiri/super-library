<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('book.index', [
            'categories' => Category::all(), // For filtering by category
            'authors' => Author::all(), // For filtering by author
            'books' => Book::filter($request)->paginate(20)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.book.create', [
            'categories' => Category::all(),
            'authors' => Author::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->file('cover')) {
            $validated['cover'] = $request->file('cover')->store('book-covers');
        } else {
            $validated['cover'] = Book::IMAGE_PATH;
        }

        Book::create($validated);

        return Redirect::route('dashboard.book')->with('alert', [
            'text' => 'Berhasil menambahkan buku'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', [
            'book' => $book->load([
                'category',
                'reviews.reviewer:id,name,username'
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('dashboard.book.edit', [
            'categories' => Category::all(),
            'authors' => Author::all(),
            'book' => $book
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->file('cover')) {
            if ($request->input('old_cover') && $request->input('old_cover') != Book::IMAGE_PATH) {
                Storage::delete($request->input('old_cover'));
            }

            $validated['cover'] = $request->file('cover')->store('book-covers');
        }

        $book->update($validated);

        return Redirect::route('dashboard.book')->with('alert', [
            'text' => 'Berhasil memperbarui buku'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Book::destroy($book->id);

        return Redirect::route('dashboard.book')->with('alert', [
            'text' => 'Berhasil menghapus buku'
        ]);
    }
}
