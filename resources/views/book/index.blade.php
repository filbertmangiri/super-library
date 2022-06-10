@extends('layouts.app')

@push('styles')
    {{-- Select2 4.1.0 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('main-container')
    <div class="d-flex justify-content-center mb-5">
        <div class="col col-sm-8 col-md-6 col-lg-5">
            <form action="{{ route('book.index') }}" method="GET">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif

                <div class="input-group">
                    <input type="search" class="form-control bg-dark border-secondary text-light" placeholder="Cari.." name="search" value="{{ request('search') }}" />

                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col col-sm-8 col-md-6 col-lg-4">
            <form action="{{ route('book.index') }}" method="GET" id="bookFilters">
                <div class="mb-2">
                    <select name="category" class="w-100" id="category">
                        @php($currentCategory = request('category'))

                        <option disabled selected>Pilih Kategori</option>

                        <option value="" {{ !$currentCategory ? 'selected' : '' }}>Semua Kategori</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" {{ $category->slug === $currentCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <select name="author" class="w-100" id="author">
                    @php($currentAuthor = request('author'))

                    <option disabled selected>Pilih Penulis</option>

                    <option value="" {{ !$currentAuthor ? 'selected' : '' }}>Semua Penulis</option>

                    @foreach ($authors as $author)
                        <option value="{{ $author->slug }}" {{ $author->slug === $currentAuthor ? 'selected' : '' }}>{{ $author->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if ($books->count())
        <div class="card bg-dark mb-4 mb-md-5 h-100">
            <div class="position-absolute px-3 py-2" style="background-color: rgba(0, 0, 0, 0.7)">
                <a href="{{ route('book.index', ['category' => $books[0]->category->slug]) }}" class="text-decoration-none text-reset stretched-link">{{ $books[0]->category->name }}</a>
            </div>

            <a href="{{ route('book.show', $books[0]->slug) }}" class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px">
                <img src="{{ asset('storage/' . $books[0]->cover) }}" class="img-fluid mw-100 mh-100" alt="{{ $books[0]->title }}" />
            </a>

            <div class="card-body text-center">
                <a href="{{ route('book.show', $books[0]->slug) }}" class="text-decoration-none text-reset">
                    <h5 class="card-title">{{ $books[0]->title }}</h5>
                </a>
                <p class="small text-muted mb-2">Ditulis oleh <a href="{{ route('book.index', ['author' => $books[0]->author->slug]) }}" class="text-decoration-none text-reset">{{ $books[0]->author->name }}</a></p>
                <p class="small card-text mb-3">{{ $books[0]->synopsis }}</p>
            </div>
        </div>

        <div class="card-group row d-flex flex-wrap justify-content-evenly row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 {{-- row-cols-1 row-cols-sm-2 row-cols-md-3 --}} gx-3 gx-md-4 gy-4 gy-md-5">
            @foreach ($books->skip(1) as $book)
                <div class="col">
                    <div class="card bg-dark h-100">
                        <div class="position-absolute px-3 py-2" style="background-color: rgba(0, 0, 0, 0.7)">
                            <a href="{{ route('book.index', ['category' => $book->category->slug]) }}" class="text-decoration-none text-reset stretched-link">{{ $book->category->name }}</a>
                        </div>

                        <a href="{{ route('book.show', $book->slug) }}" class="card-img-top d-flex align-items-center justify-content-center">
                            <img src="{{ asset('storage/' . $book->cover) }}" class="img-fluid mw-100 mh-100" alt="{{ $book->title }}">
                        </a>

                        <div class="card-body">
                            <a href="{{ route('book.show', $book->slug) }}" class="text-decoration-none text-reset">
                                <h6 class="card-title">{{ $book->title }}</h6>
                            </a>
                            <p class="small text-muted mb-2">Ditulis oleh <a href="{{ route('book.index', ['author' => $book->author->slug]) }}" class="text-decoration-none text-reset">{{ $book->author->name }}</a></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5">
            {{ $books->links() }}
        </div>
    @else
        <h3 class="text-center">Tidak ada buku</h3>
    @endif
@endsection

@push('scripts')
    {{-- Select2 4.1.0 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#bookFilters select').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
            })

            $('#bookFilters select').change(function() {
                $('#bookFilters select').filter(function(e) {
                    if ($(this).val().length == 0) {
                        return true
                    }
                }).remove()

                $('#bookFilters').submit()
            })
        })
    </script>
@endpush
