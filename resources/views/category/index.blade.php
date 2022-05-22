@extends('layouts.app')

@section('main-container')
    <h1>Ini Categories</h1>

    @if ($categories->count())
        @foreach ($categories as $category)
            <a href="{{ route('book.index', ['category' => $category->slug]) }}" class="text-reset">
                <h3>{{ $category->name }}</h3>
            </a>
        @endforeach
    @else
        <h3>Tidak ada kategori yang tersedia</h3>
    @endif
@endsection
