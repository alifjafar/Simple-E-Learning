@extends('layouts.app')
@section('title','Classroom - ')
@section('content')
    <header class="white b-b p-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <h3>
                        Kelas Saya
                    </h3>
                    <span>Kumpulan Kelas Yang Saya Ikuti</span>
                </div>
                @can('dosen')
                    <div class="col-md-3">
                    <span class="float-right">
                        <a href="{{ route('classroom.create') }}" class="btn btn-primary"> <i class="icon-add"></i> Buat
                            Kelas Baru</a>
                    </span>
                    </div>
                @endcan
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    @forelse($classrooms as $class)
                        <div class="col-md-3">
                            <div class="card shadow my-3 no-b">
                                <div class="card-body bg-pattern">
                                    <h3 class="mb-1">{{ $class['name'] }}</h3>
                                    <div class="mt-2 mb-2">
                                        {{ strlen($class['description']) > 30 ?
                                        substr(strip_tags($class['description']), 0,30 ) . "..." : strip_tags($class['description']) }}
                                    </div>
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
                            <div class="card shadow my-3 no-b">
                                <div class="card-body text-center pt-5 pb-5">
                                    <div class="center" style="font-size:28px; font-weight: bold">Oops !</div>
                                    <div class="center" style="font-size:18px">Kamu belum mempunyai kelas</div>
                                </div>
                            </div>
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
