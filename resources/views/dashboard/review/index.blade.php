@extends('dashboard.layout')

@section('main')
    <table id="reviewsTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Isi Ulasan</th>
                <th>Judul Buku</th>
                <th>User Pengulas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reviews as $review)
                <tr>
                    <td>{{ $review->body }}</td>
                    <td><a href="{{ route('book.show', ['book' => $review->book->slug]) }}" class="text-reset">{{ $review->book->title }}</a></td>
                    <td><a href="{{ route('user.show', ['user' => $review->reviewer->username]) }}" class="text-reset">{{ $review->reviewer->name }}</a></td>
                    <td>
                        <form action="{{ route('review.destroy', ['review' => $review->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" id="deleteReview">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Isi Ulasan</th>
                <th>Judul Buku</th>
                <th>User Pengulas</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    </table>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#reviewsTable').DataTable({
                columns: [{
                        width: '40%'
                    },
                    null,
                    null,
                    null
                ]
            })
        })

        $(document).on('click', '#deleteReview', function() {
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
