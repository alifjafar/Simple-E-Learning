@extends('layouts.app')
@section('title','Edit Classroom - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Edit Kelas</h6>
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

                        <form action="{{ route('classroom.update', $classroom) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ $classroom['name'] }}"
                                       required>
                            </div>

                            <div class="form-group">
                                <label for="editor">Deskripsi</label>
                                <textarea name="description" id="editor" class="form-control"
                                          rows="5">{{ $classroom['description'] }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="enroll">Enroll Code</label>
                                <input type="text" name="enroll_code" id="enroll" class="form-control" value="{{ old('enroll_code', $classroom['enroll_code']) }}">
                            </div>

                            <div class="form-group">
                                <label for="status">Status Kelas</label>
                                <select name="is_private" id="status" class="form-control">
                                    <option value="1" {{ old('is_private', $classroom['is_private']) == '1' ? 'selected': ''}}>Private</option>
                                    <option value="0" {{ old('is_private', $classroom['is_private']) == '0' ? 'selected': ''}}>Public</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <a href="{{ route('classroom.show', $classroom) }}" class="btn btn-danger btn-sm">Cancel</a>
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/config-tiny.js') }}"></script>
@endpush


