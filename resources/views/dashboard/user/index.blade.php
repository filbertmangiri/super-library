@extends('dashboard.layout')

@section('main')
    <table id="usersTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $user->photo) }}" class="rounded-circle img-fluid bg-dark" alt="Foto Profil {{ $user->username }}" title="Foto profil {{ $user->username }}" width="50px">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if ($user->deleted_at)
                            <form action="{{ route('user.restore') }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="username" value="{{ $user->username }}">

                                <button type="submit" class="btn btn-sm btn-success" id="restoreUser">Unblock</button>
                            </form>

                            <form action="{{ route('user.forceDelete') }}" method="POST" class="mt-1">
                                @csrf
                                @method('DELETE')

                                <input type="hidden" name="username" value="{{ $user->username }}">

                                <button type="submit" class="btn btn-sm btn-danger" id="forceDeleteUser">Block Permanen</button>
                            </form>
                        @else
                            <a href="{{ route('user.show', ['user' => $user->username]) }}" class="btn btn-sm btn-primary">Lihat</a>

                            <form action="{{ route('user.destroy', ['user' => $user->username]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger" id="deleteUser">Block</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </tfoot>
    </table>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#usersTable').DataTable({
                columns: [
                    null,
                    null,
                    null,
                    {
                        width: '25%'
                    }
                ]
            })
        })

        $(document).on('click', '#restoreUser', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin membuka blokir user ini?',
                text: '* Semua review yang terkait akan dipulihkan',
                icon: 'warning',
                confirmButtonText: 'Unblock',
                showCancelButton: true,
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form').submit()
                }
            })
        })

        $(document).on('click', '#forceDeleteUser', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin memblokir user ini secara permanen?',
                text: '* Semua review yang terkait akan terhapus secara permanen',
                icon: 'warning',
                confirmButtonText: 'Block Permanen',
                showCancelButton: true,
                cancelButtonText: 'Kembali'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents('form').submit()
                }
            })
        })

        $(document).on('click', '#deleteUser', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin memblokir user ini?',
                text: '* Semua review yang terkait akan terhapus',
                icon: 'warning',
                confirmButtonText: 'Block',
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
