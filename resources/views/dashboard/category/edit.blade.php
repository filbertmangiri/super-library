@extends('dashboard.layout')

@section('main')
    <h3 class="mb-3">Edit Kategori</h3>

    <form action="{{ route('category.update', ['category' => $category->slug]) }}" method="POST" id="editCategoryForm">
        @csrf
        @method('PUT')

        <div class="form-floating mb-3">
            <input type="text" name="name" class="form-control bg-dark text-light @error('name') is-invalid @enderror" id="name" placeholder=" " value="{{ old('name', $category->name) }}">
            <label for="name">Nama Kategori</label>

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Selesai</button>
    </form>
@endsection
