@extends('dashboard.layout')

@section('main')
    <a href="{{ route('author.create') }}" id="createAuthor" class="btn btn-success mb-3">Tambah</a>

    <table id="authorsTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($authors as $author)
                <tr>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{{ route('author.edit', ['author' => $author->slug]) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('author.destroy', ['author' => $author->slug]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" id="deleteAuthor">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    </table>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#authorsTable').DataTable({
                columns: [
                    null,
                    {
                        width: '25%'
                    }
                ]
            })
        })

        $(document).on('click', '#deleteAuthor', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin menghapus penulis ini?',
                text: '* Semua buku dan review yang terkait akan terhapus',
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
