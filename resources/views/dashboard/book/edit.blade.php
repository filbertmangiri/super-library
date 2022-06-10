@extends('dashboard.layout')

@push('styles')
    {{-- Select2 4.1.0 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('main')
    <h3 class="mb-3">Edit Buku</h3>

    <form action="{{ route('book.update', ['book' => $book->slug]) }}" method="POST" id="editBookForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-floating mb-3">
            <input type="text" name="title" class="form-control bg-dark text-light @error('title') is-invalid @enderror" id="title" placeholder=" " value="{{ old('title', $book->title) }}">
            <label for="title">Judul</label>

            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <select name="author_id" class="w-100 @error('author_id') is-invalid @enderror" id="author">
                @php($oldAuthor = old('author_id', $book->author_id))

                <option disabled {{ !$oldAuthor ? 'selected' : '' }}>Pilih Penulis</option>

                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ $author->id == $oldAuthor ? 'selected' : '' }}>{{ $author->name }}</option>
                @endforeach
            </select>

            @error('author_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <select name="category_id" class="w-100 @error('category_id') is-invalid @enderror" id="category">
                @php($oldCategory = old('category_id', $book->category_id))

                <option disabled {{ !$oldCategory ? 'selected' : '' }}>Pilih Kategori</option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $oldCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>

            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            Sampul
            <input type="hidden" name="old_cover" value="{{ $book->cover }}">
            <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid mt-1 mb-3 col-5 col-sm-3 col-md-2 d-block" id="bookCoverPreview">
            <input type="file" name="cover" class="form-control bg-dark text-light @error('cover') is-invalid @enderror">

            @error('cover')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <textarea name="synopsis" id="synopsis" cols="200" rows="5" class="form-control bg-dark text-light @error('synopsis') is-invalid @enderror" placeholder="Sinopsis">{{ $book->synopsis }}</textarea>

            @error('synopsis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Selesai</button>
    </form>
@endsection

@push('scripts')
    {{-- Select2 4.1.0 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#editBookForm select').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
            })
        })

        $('#editBookForm input[name="cover"]').change(function() {
            const _image = document.querySelector('#editBookForm input[name="cover"]')
            const _bookCoverPreview = document.querySelector('#bookCoverPreview')

            _bookCoverPreview.style.display = 'block'

            const oFReader = new FileReader()
            oFReader.readAsDataURL(_image.files[0])

            oFReader.onload = function(oFREvent) {
                _bookCoverPreview.src = oFREvent.target.result
            }
        })
    </script>
@endpush
