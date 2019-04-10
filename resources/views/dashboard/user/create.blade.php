@extends('layouts.app')
@section('title','Create User - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Tambah User Baru</h6>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" id="username" class="form-control"
                                       value="{{ old('username') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control"
                                       value="{{ old('email') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" id="role" class="custom-select">
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected':'' }}>Admin</option>
                                    <option value="dosen" {{ old('role') == 'dosen' ? 'selected':'' }}>Dosen</option>
                                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected':'' }}>
                                        Mahasiswa
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Foto Profile (Opsional)</label>
                                <div class="custom-file text-left">
                                    <input type="file" name="picture" accept="image/*" class="custom-file-input"
                                           id="file"
                                           value="{{ old('picture') }}">
                                    <label class="custom-file-label" for="file">Pilih Foto Profile</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <a href="{{ route('users.index') }}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        @if(Session::has('success'))
        swal("Berhasil !", '{{ Session::get('success') }}', "success");
        @endif
    </script>
@endpush
