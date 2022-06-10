<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* return view('author.index', [
            'authors' => Author::all()
        ]); */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.author.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAuthorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAuthorRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        Author::create($validated);

        return Redirect::route('dashboard.author')->with('alert', [
            'text' => 'Berhasil menambahkan penulis'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return Redirect::route('book.index', ['author' => $author->slug]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
        return view('dashboard.author.edit', [
            'author' => $author
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAuthorRequest  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);

        $author->update($validated);

        return Redirect::route('dashboard.author')->with('alert', [
            'text' => 'Berhasil memperbarui penulis'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        Author::destroy($author->id);

        return Redirect::route('dashboard.author')->with('alert', [
            'text' => 'Berhasil menghapus penulis'
        ]);
    }
}
