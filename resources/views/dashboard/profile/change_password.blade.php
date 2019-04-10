@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
        @include('dashboard.profile.side')
        <!-- /.col -->
            <div class="col-md-9">
                <div class="card no-b my-3 shadow">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs nav-material">
                            <li class="nav-item"><a class="nav-link" href="{{ route('profile', $user->username) }}">Profile</a>
                            </li>
                            <li class="nav-item"><a class="nav-link active" href="#">Change Password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="mt-3">
                            <form class="form-horizontal" action="{{ route('update.password', $user->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="current_password">Current
                                        Password</label>


                                    <input type="password" name="current_password" id="current_password"
                                           class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="new_password">New
                                        Password</label>

                                    <input type="password" name="new_password" id="new_password"
                                           class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirmation_password">Confirmation
                                        Password</label>

                                    <input type="password" name="confirmation_password"
                                           id="confirmation_password"
                                           class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger btn-sm">Save Changes</button>
                                </div>
                            </form>
                        </div>
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
