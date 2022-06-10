@extends('layouts.app')

@section('main-container')
    <div class="row justify-content-center">
        <div class="col col-md-9 col-lg-8">
            <div class="row row-cols-1 row-cols-md-2" style="height: 400px">
                <div class="col-md-5 h-100">
                    <img class="img-fluid mw-100 mh-100" src="{{ asset('storage/' . $book->cover) }}" alt="{{ $book->title }}">
                </div>

                <div class="col-md-7 h-100 d-flex flex-column">
                    <div>
                        <h3 class="mb-3">{{ $book->title }}</h3>
                        <p>Ditulis oleh {{ $book->author->name }}</p>
                        <p>Kategori : <a href="{{ route('book.index', ['category' => $book->category->slug]) }}" class="text-reset">{{ $book->category->name }}</a></p>
                    </div>

                    <div class="overflow-auto">
                        <p>{{ $book->synopsis }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col col-md-9 col-lg-8">
            <h5>Ulasan</h5>

            @auth
                @if (!$book->reviews->firstWhere('reviewer_id', Auth::user()->id))
                    <form action="{{ route('review.store') }}" method="POST" class="mt-5">
                        @csrf

                        <div class="d-flex flex-row">
                            <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="rounded-circle me-3" height="50">

                            <div class="d-flex flex-column">
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <input type="hidden" name="reviewer_id" value="{{ Auth::user()->id }}">

                                <textarea name="body" id="body" cols="200" rows="5" class="form-control bg-dark text-light" placeholder="Berikan ulasan..."></textarea>

                                <button type="submit" class="btn btn-secondary btn-sm ms-auto mt-2">Kirim</button>
                            </div>
                        </div>
                    </form>
                @endif
            @else
                <h6 class="mt-5"><a href="{{ route('auth.login') }}" class="text-reset">Masuk</a> untuk memberikan ulasan</h6>
            @endauth

            @forelse ($book->reviews as $review)
                @if (!$loop->first)
                    <hr class="my-5">
                @endif

                <div class="d-flex flex-row mt-5">
                    <img src="{{ asset('storage/' . $review->reviewer->photo) }}" alt="{{ $review->reviewer->name }}" class="rounded-circle me-3" height="50">

                    <div class="d-flex flex-column">
                        <div class="d-flex flex-row justify-content-between">
                            <p class="small">{{ $review->reviewer->name }}</p>
                            <p class="small">{{ $review->created_at->diffForHumans() }}</p>
                        </div>

                        <p>{{ $review->body }}</p>

                        @if (Auth::check() && $review->reviewer->id == Auth::user()->id)
                            <div>
                                <button class="btn btn-sm btn-secondary me-1" onclick="editMyReview('{{ route('review.update', ['review' => $review->id]) }}')">Ubah</button>
                                <form action="{{ route('review.destroy', ['review' => $review->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger" id="deleteMyReview">Hapus</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <h4 class="text-center">Tidak ada ulasan</h4>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        function editMyReview(action) {
            Swal.fire({
                title: 'Ubah Ulasan',
                html: `
                    <form action="${action}" method="POST" id="updateMyReview">
                        @csrf
                        @method('PUT')

                        <textarea name="body" id="body" cols="200" rows="5" class="form-control bg-dark text-light" placeholder="Berikan ulasan..."></textarea>
                    </form>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Selesai',
                showCancelButton: true,
                cancelButtonText: 'Kembali',
                preConfirm: () => {
                    const body = Swal.getPopup().querySelector('[name="body"]').value

                    if (!body) {
                        Swal.showValidationMessage(`Harap masukkan ulasan`)
                    }

                    return {
                        body: body
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.getPopup().querySelector('form#updateMyReview').submit()
                }
            })
        }

        $('#deleteMyReview').click(function(event) {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin menghapus ulasan ini?',
                icon: 'warning',
                confirmButtonText: 'Hapus',
                showCancelButton: true,
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form').submit()
                }
            })
        })
    </script>
@endpush
