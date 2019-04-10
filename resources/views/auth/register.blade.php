@extends('layouts.app')
@section('content')
    <div id="primary" class="p-t-b-100 height-full ">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mx-md-auto">
                    <div class="text-center">
                        <img src="{{ asset('img/icon/sydney-opera-house.png') }}" class="img-fluid"
                             style="max-width: 150px"
                             alt="Logo">
                        <h2 class="p-t-b-20 bolder">Buat akun baru</h2>
                    </div>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group has-icon"><i class="icon-person"></i>
                            <input type="text" class="form-control form-control-lg"
                                   placeholder="Nama" name="name" required>
                        </div>
                        <div class="form-group has-icon"><i class="icon-verified_user"></i>
                            <input type="text" class="form-control form-control-lg"
                                   placeholder="Username" name="username" required>
                        </div>
                        <div class="form-group has-icon"><i class="icon-envelope-o"></i>
                            <input type="text" class="form-control form-control-lg"
                                   placeholder="Email" name="email" required>
                        </div>
                        <div class="form-group has-icon"><i class="icon-user-secret"></i>
                            <input type="password" class="form-control form-control-lg"
                                   placeholder="Password" name="password" required>
                        </div>
                        <div class="form-group has-icon"><i class="icon-user-secret"></i>
                            <input type="password" class="form-control form-control-lg"
                                   placeholder="Confirmation Password" name="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="role" value="mahasiswa" id="student" required="required"
                                       class="custom-control-input">
                                <label for="student" class="custom-control-label">Saya Mahasiswa</label></div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" name="role" value="dosen" id="lecturer"
                                       class="custom-control-input">
                                <label for="lecturer" class="custom-control-label">Saya Dosen</label></div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
