@extends('layouts.app')
@section('title','Student Classroom - ')
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
            <div class="col-md-12 mb-4">
                <div class="card shadow no-b">
                    <div class="card-header bg-white">
                        <a href="{{ route('classroom.show', $classroom) }}" class="btn btn-primary btn-xs mr-2"><i
                                class="icon-arrow_back"></i> Back</a>
                        <span class="card-title">Siswa (Participant)</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover dataTable" id="data-table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    @can('dosen')
                                        <th width="8%">Aksi</th>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($classroom['students'] as $student)
                                    <tr>
                                        <td>
                                            <div class="image mr-3 avatar-sm float-left">
                                                <img src="{{ $student['avatar'] }}" style="border-radius: 50%"
                                                     alt="User Image">
                                            </div>
                                            <div class="mt-1">
                                                <div>
                                                    <strong>{{ $student['name'] }}</strong>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $student['email'] }}
                                        </td>
                                        <td>{{ ucwords($student['role']) }}</td>
                                        @can('dosen')
                                            <td><a href="#"
                                                   onclick="deleteStudent('{{ $student['id'] }}', '{{ $student['name'] }}')"
                                                   class="btn btn-danger btn-sm" title="Hapus"><i
                                                        class="icon icon-trash"></i>Remove</a></td>
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
    </div>

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

        @can('dosen')
        function deleteStudent(studentId, studentName) {
            swal({
                title: "Apa anda yakin?",
                text: "Anda Menghapus Siswa " + studentName,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete => {
                if (willDelete) {
                    let theUrl = "{{ route('classroom.student.destroy', [':classroomId',':studentId']) }}";
                    theUrl = theUrl.replace(":studentId", studentId);
                    theUrl = theUrl.replace(":classroomId", '{{ $classroom['id'] }}');
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
    </script>
@endpush
