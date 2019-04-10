@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <h2 class="card-title">Kelas Saya</h2>
                <div>
                    @can('dosen')
                        <a href="{{ route('classroom.create') }}" class="btn btn-primary"> <i class="icon-add"></i> Buat
                            Kelas Baru</a>
                    @endcan
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    @forelse($classrooms as $class)
                        <div class="col-md-3">
                            <div class="card shadow my-3 no-b">
                                <div class="card-body">
                                    <h3 class="mb-1">{{ $class['name'] }}</h3>
                                    <span>{!! $class['description'] !!} </span>
                                    <strong>Jumlah Siswa :</strong> {{ count($class['students']) }}
                                </div>
                                <div class="p-2 b-t">
                                    <span class="float-right">
                                        <a href="{{ route('classroom.show', $class) }}"
                                           class="btn btn-primary btn-sm">Lihat Kelas</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-md-12">
                            <h2>NOT YET</h2>
                        </div>
                    @endforelse
                </div>
            </div>
            @if($classrooms)
                <div class="col-md-12">
                    {{ $classrooms->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection
@push('js')
    <script>
        @if(session()->has('success'))
        swal("Berhasil !", '{{ session()->get('success') }}', "success");
        @endif
    </script>
@endpush
