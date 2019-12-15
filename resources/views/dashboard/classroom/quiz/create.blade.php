@extends('layouts.app')
@section('title','Create Quiz - ')
@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b my-3 shadow">
                    <div class="card-header white">
                        <h6>Buat Quiz Baru</h6>
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
                        <form action="{{ route('quiz.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="classroom_id" value="{{ $classroom['id'] }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control"
                                               value="{{ old('name') }}"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Category <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category" class="form-control select2">
                                            @foreach($categories as $item)
                                                <option
                                                    value="{{ $item['id'] }}" {{ old('category_id') == $item['id'] ? 'selected': '' }}>{{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="start_date">Waktu Mulai <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="date-time-picker form-control"
                                                           name="start_date"
                                                           data-options='{"timepicker":true, "format":"d-m-Y H:m"}'
                                                           value="{{ old('start_date') }}" required/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text add-on white">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="end_date">Waktu Selesai <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="text" class="date-time-picker form-control"
                                                           name="end_date"
                                                           data-options='{"timepicker":true, "format":"d-m-Y H:m"}'
                                                           value="{{ old('end_date') }}" required/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text add-on white">
                                                            <i class="icon-calendar"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="password" id="password" class="form-control"
                                               value="{{ old('password') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="editor">Deskripsi <span class="text-danger">*</span></label>
                                        <textarea name="description" id="editor" class="form-control" rows="5">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row border-top border-list mb-4 pt-3" id="question-area">
                                <div class="col-md-12 mb-2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6>Pertanyaan</h6>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" id="add-question"
                                                    class="btn btn-primary btn-sm float-right"><i
                                                    class="icon-add"></i>
                                                Tambah Pertanyaan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if(old('questions'))
                                    @foreach(old('questions') as $key => $question)
                                        <div class="col-md-12 mb-2">
                                            <div class="form-group">
                                                <div class="input-group">
                                            <textarea name="questions[{{$key}}][content]" rows="2"
                                                      class="form-control">{{ $question['content'] }}</textarea>
                                                    @if($loop->first)
                                                        <div class="input-group-append" style="cursor: pointer">
                                                        <span class="input-group-text add-on">
                                                            <i class="icon-check text-success"></i>
                                                        </span>
                                                        </div>
                                                    @else
                                                        <div class="input-group-append"
                                                             onclick="$(this).parents()[2].remove()"
                                                             style="cursor: pointer">
                                                        <span class="input-group-text add-on"><i
                                                                class="icon-trash text-danger"></i>
                                                        </span>
                                                        </div>
                                                    @endif

                                                </div>

                                                <h6 class="mt-3">Pilihan / Option :</h6>
                                                <div class="row justify-content-end option">
                                                    @foreach($question['options'] as $opKey => $option)
                                                        @if($loop->parent->last && $loop->last)
                                                            <input type="hidden" id="option-helper"
                                                                   value="{{ $opKey }}">
                                                        @endif
                                                        <div class="col-md-11 mb-2">
                                                            <div class="input-group">
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text">
                                                                        <div
                                                                            class="custom-control custom-radio custom-control-inline"
                                                                            onclick="clicked(this, '{{$key}}')">
                                                                            <input type="radio"
                                                                                   name="answer{{$key}}"
                                                                                   value="true" id="answer{{$key+$opKey}}"
                                                                                   required="required"
                                                                                   class="custom-control-input" {{ isset($option['answer']) ? 'checked': '' }}>
                                                                            <label for="answer{{$key+$opKey}}"
                                                                                   class="custom-control-label">Tetapkan
                                                                                Sebagai Jawaban</label></div>
                                                                    </div>
                                                                </div>
                                                                <textarea
                                                                    class="form-control option-content"
                                                                    type="text" required
                                                                    name="questions[{{$key}}][options][{{$opKey}}][content]">{{ $option['content'] }}</textarea>
                                                                @if(isset($option['answer']))
                                                                    <input type="hidden" class="{{ $key }}"
                                                                           name="questions[{{$key}}][options][{{$opKey}}][answer]:boolean"
                                                                           value="true">
                                                                @endif
                                                                @if($loop->first)
                                                                    <div class="input-group-append" data-id="{{$key}}"
                                                                         onclick="addOption(this)"
                                                                         style="cursor: pointer">
                                                                        <div class="input-group-text">
                                                                            <i class="text-success icon-plus-circle"></i>
                                                                        </div>
                                                                    </div>
                                                                @else
                                                                    <div class="input-group-append"
                                                                         onclick="$(this).parents()[1].remove()"
                                                                         style="cursor: pointer">
                                                                        <div class="input-group-text"><i
                                                                                class="text-danger icon-trash"></i>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-md-12 mb-2">
                                        <div class="form-group">
                                            <div class="input-group">
                                            <textarea name="questions[10][content]" rows="2"
                                                      class="form-control"></textarea>
                                                <div class="input-group-append" style="cursor: pointer">
                                                        <span class="input-group-text add-on">
                                                            <i class="icon-check text-success"></i>
                                                        </span>
                                                </div>
                                            </div>

                                            <h6 class="mt-3">Pilihan / Option :</h6>
                                            <div class="row justify-content-end option">
                                                <div class="col-md-11 mb-2">
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <div
                                                                    class="custom-control custom-radio custom-control-inline"
                                                                    onclick="clicked(this, '10')">
                                                                    <input type="radio"
                                                                           name="answer10"
                                                                           value="true" id="answer" required="required"
                                                                           class="custom-control-input">
                                                                    <label for="answer" class="custom-control-label">Tetapkan
                                                                        Sebagai Jawaban</label></div>
                                                            </div>
                                                        </div>
                                                        <textarea
                                                            class="form-control option-content"
                                                            type="text" required
                                                            name="questions[10][options][1][content]"></textarea>
                                                        <div class="input-group-append" data-id="10"
                                                             onclick="addOption(this)"
                                                             style="cursor: pointer">
                                                            <div class="input-group-text">
                                                                <i class="text-success icon-plus-circle"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('js/config-tiny.js') }}"></script>
    <script>
        let counter = 1;
        let optionCounter = 1;

        @if(old('questions'))
            counter = parseInt('{{ count(old('questions')) }}');
        optionCounter = parseInt($('#option-helper').val());

        @endif


        function addOption(e) {
            let i = $(e).data('id');
            optionCounter = optionCounter + 1;
            let optionfield = $(e).parents('.option');
            let uniqueKey = Math.random().toString(36).substr(2, 9);
            optionfield.append("<div class=\"col-md-11 mb-2\">\n" +
                "                                                <div class=\"input-group\">\n" +
                "                                                    <div class=\"input-group-append\">\n" +
                "                                                        <div class=\"input-group-text\">\n" +
                "                                                            <div class=\"custom-control custom-radio custom-control-inline\" onclick=\"clicked(this," + i.toString() + ")\">\n" +
                "                                                                <input type=\"radio\" name=\"answer" + i + "\" value=\"true\" id=\"" + uniqueKey + "\" required=\"required\" class=\"custom-control-input\">\n" +
                "                                                                <label for=\"" + uniqueKey + "\" class=\"custom-control-label\">Tetapkan Sebagai Jawaban</label></div>\n" +
                "                                                        </div>\n" +
                "                                                    </div>\n" +
                "                                            <textarea\n" +
                "                                                class=\"form-control\"\n" +
                "                                                type=\"text\" required\n" +
                "                                                name=\"questions[" + i + "][options][" + optionCounter + "][content]\"></textarea>\n" +
                "                                                    <div class=\"input-group-append\" onclick=\"$(this).parents()[1].remove()\"\n" +
                "                                                         style=\"cursor: pointer\">\n" +
                "                                                        <div class=\"input-group-text\">\n" +
                "                                                            <i class=\"text-danger icon-trash\"></i>\n" +
                "                                                        </div>\n" +
                "                                                    </div>\n" +
                "                                                </div>\n" +
                "                                            </div>")
        }

        $("#add-question").click(function (e) {
            counter = counter + 1;
            let uniqueKey = Math.random().toString(36).substr(2, 9);
            $('#question-area').append('                                <div class="col-md-12 mb-2">\n' +
                '                                    <div class="form-group">\n' +
                '                                        <div class="input-group">\n' +
                '                                            <textarea name="questions[' + counter + '0][content]" rows="2"\n' +
                '                                                      class="form-control"></textarea>\n' +
                '                                            <div class="input-group-append" onclick="$(this).parents()[2].remove()" style="cursor: pointer">\n' +
                '                                                        <span class="input-group-text add-on">\n' +
                '                                                            <i class="icon-trash text-danger"></i>\n' +
                '                                                        </span>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '\n' +
                '                                        <h6 class="mt-3">Pilihan / Option :</h6>\n' +
                '                                        <div class="row justify-content-end option">\n' +
                '                                            <div class="col-md-11 mb-2">\n' +
                '                                                <div class="input-group">\n' +
                '                                                    <div class="input-group-append">\n' +
                '                                                        <div class="input-group-text">\n' +
                '                                                            <div\n' +
                '                                                                class="custom-control custom-radio custom-control-inline" onclick="clicked(this, ' + counter + '0)">\n' +
                '                                                                <input type="radio" name="answer' + counter + '0"\n' +
                '                                                                       value="true" id="' + uniqueKey + '" required="required"\n' +
                '                                                                       class="custom-control-input">\n' +
                '                                                                <label for="' + uniqueKey + '" class="custom-control-label">Tetapkan\n' +
                '                                                                    Sebagai Jawaban</label></div>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                    <textarea\n' +
                '                                                        class="form-control"\n' +
                '                                                        type="text" required\n' +
                '                                                        name="questions[' + counter + '0][options][' + counter + '][content]"></textarea>\n' +
                '                                                    <div class="input-group-append" data-id="' + counter + '0" onclick="addOption(this)"\n' +
                '                                                         style="cursor: pointer">\n' +
                '                                                        <div class="input-group-text">\n' +
                '                                                            <i class="text-success icon-plus-circle"></i>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>\n' +
                '                                        </div>\n' +
                '                                    </div>\n' +
                '                                </div>')
        });


        let lastClick = null;

        function clicked(e, i) {
            const now = Date.now();
            const DOUBLE_PRESS_DELAY = 300;
            if (lastClick && (now - lastClick) < DOUBLE_PRESS_DELAY) {
                let el = $(e).parent().parent().parent().find('textarea');
                let text = el.attr('name');
                text = text.replace('content', 'answer');
                console.log(el.parents(3).find("." + i).remove());
                el.after('<input type="hidden" class="' + i + '" name="' + text + ':boolean" value="true">')
            } else {
                lastClick = now;
            }
        }
    </script>
@endpush


