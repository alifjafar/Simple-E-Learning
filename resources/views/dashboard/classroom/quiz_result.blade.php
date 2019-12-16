@extends('layouts.app')
@section('title','Quiz Result History - ')
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
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <a href="{{ route('classroom.show', $classroom) }}" class="btn btn-primary btn-xs mr-2"><i
                                class="icon-arrow_back"></i> Back</a>
                        <span class="card-title">Quiz Result History</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th>Quiz</th>
                                <th>Nama Siswa</th>
                                <th>Nilai</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($classroom['quizzes'] as $item)
                                @foreach($item['result'] as $result)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $result['student']['name'] }}</td>
                                        <td>{{ $result['score'] }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                            </tbody>
                        </table>
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
@endpush

