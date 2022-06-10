@extends('dashboard.layout')

@section('main')
    <a href="{{ route('user.createModerator') }}" id="createModerator" class="btn btn-success mb-3">Tambah</a>

    <table id="moderatorsTable" class="table table-striped table-dark" style="width:100%">
        <thead>
            <tr>
                <th>Foto Profil</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($moderators as $moderator)
                <tr>
                    <td>
                        <img src="{{ asset('storage/' . $moderator->photo) }}" class="rounded-circle img-fluid bg-dark" alt="Foto Profil {{ $moderator->username }}" title="Foto profil {{ $moderator->username }}" width="50px">
                    </td>
                    <td>{{ $moderator->name }}</td>
                    <td>{{ $moderator->email }}</td>
                    <td>
                        <a href="{{ route('user.show', ['user' => $moderator->username]) }}" class="btn btn-sm btn-primary">Lihat</a>

                        <form action="{{ route('user.update', ['user' => $moderator->username]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="level" value="0">

                            <button type="submit" class="btn btn-sm btn-danger" id="demoteModerator">Pecat</button>
                        </form>
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
            $('#moderatorsTable').DataTable({
                columns: [
                    null,
                    null,
                    {
                        width: '25%'
                    }
                ]
            })
        })

        $(document).on('click', '#demoteModerator', function() {
            event.preventDefault()

            Swal.fire({
                title: 'Anda yakin ingin memecat moderator ini?',
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
