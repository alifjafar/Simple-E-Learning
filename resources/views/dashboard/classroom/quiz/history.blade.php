@extends('layouts.app')
@section('title','Quiz Result History - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Quiz Result History</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover dataTable">
                            <thead>
                            <tr>
                                <th width="8%">No</th>
                                <th>Quiz</th>
                                <th>Kelas</th>
                                <th>Deskripsi</th>
                                <th>Nilai</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($results as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['quiz']['name'] }}</td>
                                    <td>{{ $item['quiz']['classroom']['name'] }}</td>
                                    <td>{{ strip_tags($item['quiz']['description']) }}</td>
                                    <td>{{ $item['score'] }}</td>
                                </tr>
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

