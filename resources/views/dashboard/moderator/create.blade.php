@extends('dashboard.layout')

@push('styles')
    {{-- Select2 4.1.0 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
@endpush

@section('main')
    <h3 class="mb-3">Tambah Moderator</h3>

    <form action="{{ route('user.storeModerator') }}" method="POST" id="createModeratorForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="level" value="1">

        <div class="mb-3">
            <select name="user_id" class="w-100 @error('user_id') is-invalid @enderror" id="user">
                @php($oldAuthor = old('user_id'))

                <option disabled {{ !$oldAuthor ? 'selected' : '' }}>Pilih User</option>

                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $oldAuthor ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>

            @error('user_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Tambah</button>
    </form>
@endsection

@push('scripts')
    {{-- Select2 4.1.0 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#createModeratorForm select').select2({
                theme: 'bootstrap-5',
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style'
            })
        })
    </script>
@endpush
