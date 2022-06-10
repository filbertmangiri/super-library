@extends('dashboard.layout')

@section('main')
    <a href="{{ route('category.create') }}" id="createCategory" class="btn btn-success mb-3">Tambah</a>

    <table id="categoriesTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('category.edit', ['category' => $category->slug]) }}" class="btn btn-sm btn-warning">Ubah</a>
                        <form action="{{ route('category.destroy', ['category' => $category->slug]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger" id="deleteCategory">Hapus</button>
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
            $('#categoriesTable').DataTable({
                columns: [
                    null,
                    {
                        width: '25%'
                    }
                ]
            })
        })

        $(document).on('click', '#deleteCategory', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin menghapus kategori ini?',
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
