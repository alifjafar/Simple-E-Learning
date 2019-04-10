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
                            <li class="nav-item">
                                <a href="#" class="nav-link active" data-toggle="tab">Profile</a></li>
                            <li><a href="{{ route('edit-password', $user->username) }}" class="nav-link">Change
                                    Password</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="mt-2">
                            <form class="form-horizontal" action="{{ route('update.profile', $user->id) }}"
                                  method="post">
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
                                    <label for="nama">Name</label>

                                    <input type="text" class="form-control" name="name" id="nama"
                                           placeholder="Name"
                                           value="{{ $user->name }}">
                                </div>

                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" name="username"
                                           id="username"
                                           value="{{ $user->username }}">

                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>

                                    <input type="email" class="form-control" id="email"
                                           placeholder="Email"
                                           value="{{ $user->email }}" name="email">
                                </div>

                                <div class="form-group">
                                    <label for="role">Role</label>
                                    <input type="text" id="role" class="form-control" value="{{ ucwords($user->role) }}"
                                           readonly>
                                </div>

                                <div class="form-group">
                                    <button type="submit" id="submit-data" class="btn btn-danger btn-sm"
                                            disabled>
                                        Save Changes
                                    </button>
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
        let button = $('#submit-data');
        let orig = [];
        $.fn.getType = function () {
            return this[0].tagName == "INPUT" ? $(this[0]).attr("type").toLowerCase() : this[0].tagName.toLowerCase();
        }
        $("form :input").each(function () {
            let type = $(this).getType();
            let tmp = {
                'type': type,
                'value': $(this).val()
            };
            if (type == 'radio') {
                tmp.checked = $(this).is(':checked');
            }
            orig[$(this).attr('id')] = tmp;
        });
        $('form').bind('change keyup', function () {
            let disable = true;
            $("form :input").each(function () {
                let type = $(this).getType();
                let id = $(this).attr('id');
                if (type == 'text' || type == 'select' || type == 'email' || type == 'textarea') {
                    disable = (orig[id].value == $(this).val());
                } else if (type == 'radio') {
                    disable = (orig[id].checked == $(this).is(':checked'));
                }
                if (!disable) {
                    return false; // break out of loop
                }
            });
            button.prop('disabled', disable);
        });
    </script>
@endpush
