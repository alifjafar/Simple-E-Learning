@extends('layouts.app')
@section('title','Enroll Classroom - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Enroll Kelas {{ $classroom['name'] }}</h6>
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

                        <form action="{{ route('enroll.classroom', $classroom) }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="enroll">Enroll Code</label>
                                <input type="password" name="enroll_code" id="enroll" class="form-control" value="{{ old('enroll_code') }}">
                            </div>

                            <div class="form-group">
                                <a href="{{ route('classroom.index') }}" class="btn btn-danger btn-sm">Cancel</a>
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
    @if(session()->has('error'))
        <script>
            swal("Oops!", '{{ session()->get('error') }}', "error");
        </script>
    @endif
@endpush

