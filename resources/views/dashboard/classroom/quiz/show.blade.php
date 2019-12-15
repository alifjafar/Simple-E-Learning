@extends('layouts.app')
@section('title','Quiz - ' .  $quiz['name'] . ' - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-8">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>{{ $quiz['name'] }}</h6>
                    </div>
                    <form action="{{ route('quiz.submit', $quiz) }}" method="post" enctype="multipart/form-data">
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

                            @csrf
                            <ol>
                                @foreach($quizProvider['questions'] as $question)
                                    <input type="hidden" name="questions[{{$question['id']}}][id]" value="{{ $question['id'] }}">
                                    <li class="mb-3"><h6> {{ strip_tags($question['content']) }}</h6>
                                        <ul class="p-2 s-18">
                                            @foreach($question['options'] as $option)
                                                <li>
                                                    <div
                                                        class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio"
                                                               name="questions[{{$question['id']}}][answer]"
                                                               value="{{ $option['id'] }}" id="answer{{$option['id']}}"
                                                               required="required"
                                                               class="custom-control-input">
                                                        <label for="answer{{$option['id']}}"
                                                               class="custom-control-label">{{ $option['content'] }}</label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                        <div class="card-footer">
                            <div class="form-group">
                                <a href="{{ route('classroom.index') }}" class="btn btn-danger btn-sm">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm float-right">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card no-b my-3 shadow">
                    <div class="card-header bg-white">
                        <h6>Informasi Quiz</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="category"><strong>Kategori</strong></label>
                            <input type="text" id="category" value="{{ $quizProvider['category']['name'] }}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="questions"><strong>Jumlah Pertanyaan</strong></label>
                            <input type="text" id="questions" value="{{ $quizProvider['total_question']}}" disabled
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description"><strong>Deskripsi</strong></label>
                            <textarea id="description" rows="5" class="form-control"
                                      disabled="true">{{ strip_tags($quizProvider['description']) }}</textarea>
                        </div>
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


