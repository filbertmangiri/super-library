@extends('dashboard.layout')

@section('main')
    <a href="{{ route('book.create') }}" id="createBook" class="btn btn-success mb-3">Tambah</a>

    <table id="booksTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Sampul</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>SAMPUL</td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>
                        <a href="{{ route('book.show', ['book' => $book->slug]) }}" class="btn btn-sm btn-primary">Lihat</a>
                        <a href="{{ route('book.edit', ['book' => $book->slug]) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('book.destroy', ['book' => $book->slug]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" id="deleteBook">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Sampul</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    </table>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#booksTable').DataTable()
        })

        $(document).on('click', '#deleteBook', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin menghapus buku ini?',
                text: '* Semua review yang terkait akan terhapus',
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
