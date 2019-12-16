@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>
                        {{ $classroom['name'] }}
                    </h3>
                    Dosen : <strong>{{ $classroom['lecturer']['name'] }}</strong>
                </div>
                @can('dosen')
                    <div class="col-md-3">
                    <span class="float-right">
                        <a href="{{ route('classroom.edit', $classroom) }}" class="btn btn-primary btn-sm"><i
                                class="icon icon-edit"></i> Edit Kelas</a>
                    </span>
                    </div>
                @endcan
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow no-b">
                    <div class="card-body">
                        <strong>
                            <span id="intermezzo">Loading Intermezzo...</span> - <span id="year"></span>
                        </strong>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="card shadow no-b">
                            <div class="card-header bg-white">
                                <span class="card-title"><strong>Deskripsi</strong></span>
                            </div>
                            <div class="card-body">
                                {{ strip_tags($classroom['description']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
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
                                            @can('dosen')
                                                <th width="8%">Aksi</th>
                                            @endcan
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
                                                @can('dosen')
                                                    <td><a href="#"
                                                           onclick="deleteCourse('{{$course['id']}}', '{{ $course['title'] }}')"
                                                           class="btn btn-danger btn-sm" title="Hapus"><i
                                                                class="icon-trash"></i></a></td>
                                                @endcan
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card shadow no-b">
                            <div class="card-header bg-white">
                                <strong>List Quiz</strong>
                                @can('dosen')
                                    <span class="float-right">
                                         <a href="{{ route('classroom.quiz.result', $classroom) }}"
                                            class="btn btn-outline-danger btn-sm mr-2"><i
                                                 class="icon icon-history"></i> Hasil Quiz Siswa</a>
                                    <a href="{{ route('quiz.create', $classroom) }}"
                                       class="btn btn-outline-primary btn-sm"><i
                                            class="icon icon-tasks"></i> Buat Quiz</a>
                                </span>
                                @endcan
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover dataTable">
                                        <thead>
                                        <tr>
                                            <th width="8%">No</th>
                                            <th>Quiz</th>
                                            <th>Deskripsi</th>
                                            <th>Waktu</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($classroom['quizzes'] as $quiz)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $quiz['name'] }}</td>
                                                <td>{{ strip_tags($quiz['description']) }}</td>
                                                <td>{{ $quiz['start_date']->format('d M Y, H:i')}}
                                                    - {{ $quiz['end_date']->format('d M Y, H:i') }}</td>
                                                <td>
                                                    @can('dosen')
                                                        <a href="{{ route('quiz.edit', ['classroom' => $classroom, 'quiz' => $quiz]) }}"
                                                           class="btn btn-success btn-xs">Edit</a>
                                                    @else
                                                        <button type="button" onclick="takeQuiz('{{$quiz['id']}}')"
                                                                class="btn btn-primary btn-xs">Kerjakan Quiz
                                                        </button>
                                                    @endcan
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
            @can('dosen')
                <div class="col-md-4">
                    <div class="row">
                        @if($url)
                            <div class="col-md-12 mb-4">
                                <div class="card shadow no-b">
                                    <div class="card-header bg-white">
                                        <span class="card-title"><strong>Enroll URL Classroom</strong></span>
                                    </div>
                                    <div class="card-body">
                                        <pre>{{ $url }}</pre>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-12 mb-4">
                            <div class="card shadow no-b">
                                <div class="card-header bg-white">
                                    <span class="card-title"><strong>Siswa</strong></span>
                                    <span class="float-right">
                            <a href="{{ route('classroom.student', $classroom) }}">Lihat Semua</a>
                        </span>
                                </div>
                                <div class="card-body">
                                    @forelse($classroom->students->take(5) as $student)
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
                                    @empty
                                        <div class="card light no-b">
                                            <div class="card-body text-center">
                                                <span>Belum ada siswa, Invite Sekarang !</span>
                                            </div>
                                        </div>
                                    @endforelse
                                    <hr>
                                    @can('dosen')
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger">
                                                {{ session()->get('error') }}
                                            </div>
                                        @endif
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
                        <div class="col-md-12">
                            <div class="card shadow no-b">
                                <div class="card-body">
                                    <a href="#"
                                       onclick="deleteClassroom('{{ $classroom['id'] }}', '{{ $classroom['name'] }}')"
                                       class="btn btn-sm btn-danger btn-block"><i class="icon icon-trash"></i>
                                        Hapus Kelas Ini</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @endcan
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

        @if(session()->has('showModel'))
        $('#add_materi').modal('show');
        @endif
    </script>

    <script>
        $('.dataTable').DataTable({
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
        $.ajax({
            url: '{{ route('resource.intermezzo') }}',
            success: function (res) {
                $('#intermezzo').text(res.data.text);
                $('#year').text(`(${res.data.year})`);
            },
            error: function (res) {
                console.log(res);
            }
        })
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
                data: function (params) {
                    return {
                        q: params.term,
                        classroom_id: '{{ $classroom['id'] }}'

                    }
                },
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.id,
                                text: item.name + " (" + item.email + ")"
                            }
                        })
                    }
                }
            },
            cache: true
        });

        @can('dosen')

        function deleteClassroom(classroomId, classroomName) {
            swal({
                title: "Apa anda yakin?",
                text: "Anda Menghapus Kelas " + classroomName,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete => {
                if (willDelete) {
                    let theUrl = "{{ route('classroom.destroy', ':classroomId') }}";
                    theUrl = theUrl.replace(":classroomId", classroomId);
                    $.ajax({
                        type: 'POST',
                        url: theUrl,
                        data: {_method: "delete"},
                        success: function (data) {
                            window.location.href = data;
                        },
                        error: function (data) {
                            console.log(data);
                            swal("Oops", "We couldn't connect to the server!", "error");
                        }
                    });
                }
            }));
        }

        function deleteCourse(courseId, courseTitle) {
            swal({
                title: "Apa anda yakin?",
                text: "Anda Menghapus Materi " + courseTitle,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete => {
                if (willDelete) {
                    let theUrl = "{{ route('course.destroy', ':courseId') }}";
                    theUrl = theUrl.replace(":courseId", courseId);
                    $.ajax({
                        type: 'POST',
                        url: theUrl,
                        data: {_method: "delete"},
                        success: function (data) {
                            window.location.href = data;
                        },
                        error: function (data) {
                            console.log(data);
                            swal("Oops", "We couldn't connect to the server!", "error");
                        }
                    });
                }
            }));
        }

        @endcan

        @cannot('dosen')
        function takeQuiz(id) {
            swal({
                text: 'Masukan Password Quiz',
                content: {
                    element: "input",
                    attributes: {
                        type: "password",
                    },
                },
                button: {
                    text: "Submit",
                    closeModal: false,
                },
            })
                .then(password => {
                    if (!password) throw null;

                    let theUrl = "{{ route('quiz.take', ':quizId') }}";
                    theUrl = theUrl.replace(":quizId", id);
                    return $.ajax({
                        type: 'POST',
                        url: theUrl,
                        data: {
                            password: password
                        }
                    })
                })
                .then(json => {
                    if (json.url) {
                        return window.location.href = json.url;
                    } else {
                        return swal("Oops!", json.message, "error");
                    }
                })
                .catch(err => {
                    if (err) {
                        swal("Oh noes!", err.toString(), "error");
                    } else {
                        swal.stopLoading();
                        swal.close();
                    }
                });
        }
        @endcannot
    </script>
@endpush
