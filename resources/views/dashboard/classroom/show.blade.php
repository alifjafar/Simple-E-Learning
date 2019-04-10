@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <h3>
                {{ $classroom['name'] }}
            </h3>
            Dosen : <strong>{{ $classroom['lecturer']['name'] }}</strong>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card shadow no-b">
                            <div class="card-header bg-white">
                                <span class="card-title"><strong>Deskripsi</strong></span>
                            </div>
                            <div class="card-body">
                                {!! $classroom['description'] !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow no-b">
                            <div class="card-header bg-white">
                                <strong>List Materi</strong>
                                @can('dosen')
                                    <span class="float-right">
                                    <a href="#" data-toggle="modal" data-target="#add_materi"
                                       class="btn btn-outline-primary btn-sm"><i
                                            class="icon icon-file"></i> Upload Materi</a>
                                </span>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover dataTable" id="data-table">
                                        <thead>
                                        <tr>
                                            <th width="8%">No</th>
                                            <th>Materi</th>
                                            <th>Deskripsi</th>
                                            <th>File</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($classroom['course'] as $course)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $course['title'] }}</td>
                                                <td>{{ $course['description'] }}</td>
                                                <td>
                                                    <a href="{{ route('file.download', $course['files'][0]['id']) }}"
                                                       class="btn btn-success btn-sm"><i
                                                            class="icon icon-angle-down"></i> Download</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow no-b">
                    <div class="card-header bg-white">
                        <span class="card-title"><strong>Siswa</strong></span>
                    </div>
                    <div class="card-body">
                        @foreach($classroom->students->take(5) as $student)
                            <div class="mb-3">
                                <div class="image mr-3 avatar-sm float-left">
                                    <img src="{{ $student['avatar'] }}" style="border-radius: 50%"
                                         alt="User Image">
                                </div>
                                <div class="mt-1">
                                    <div>
                                        <strong>{{ $student['name'] }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <hr>
                        @can('dosen')
                            <form action="{{ route('students.invite') }}" method="POST">
                                @csrf
                                <input type="hidden" name="classroom_id" value="{{ $classroom['id'] }}">
                                <div class="form-group">
                                    <label for="student">Invite Siswa</label>
                                    <select name="students[]" id="student" class="form-control"
                                            multiple></select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-sm">Invite</button>
                                </div>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('dosen')
        @component('components.modal', ['selector' => 'add_materi'])
            @slot('title')
                Upload Materi
            @endslot

            @slot('content')
                <form action="{{ route('course.store') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
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
                        <input type="hidden" name="classroom_id" value="{{ $classroom['id'] }}">
                        <div class="form-group">
                            <label for="title">Judul Materi</label>
                            <input type="text" name="title" id="title" class="form-control" required
                                   value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi Materi</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                      required>{{old('description')}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="file">Pilih File Dokumen</label>
                            <div class="custom-file text-left">
                                <input type="file" name="file" class="custom-file-input" id="file"
                                       value="{{ old('file') }}">
                                <label class="custom-file-label" for="file">Pilih File</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </div>
                </form>
            @endslot

        @endcomponent
    @endcan
@endsection
@push('js')
    <script>
        @if(session()->has('success'))
        swal("Berhasil !", '{{ session()->get('success') }}', "success");
        @endif
    </script>

    <script>
        $('#data-table').DataTable({
            "columnDefs": [{
                "orderable": false
            }],
            "responsive": true,
            "pageLength": 10,
            "language": {
                "lengthMenu": "Tampilkan _MENU_ per halaman",
                "zeroRecords": "Tidak ada data",
                "info": "Tampilkan _PAGE_ dari _PAGES_ halaman",
                "infoEmpty": "",
                "search": "Cari Data :",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });

    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#student').select2({
            ajax: {
                url: '{{ route('students.ajax') }}',
                data: {classroom_id: '{{ $classroom['id'] }}'},
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name
                            }
                        })
                    }
                }
            },
            cache: true
        });
    </script>
@endpush
