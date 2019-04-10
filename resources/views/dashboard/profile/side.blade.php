<div class="col-md-3">

    <!-- Profile Image -->
    <div class="card no-b my-3 shadow">
        <div class="card-header bg-white">
            Foto Profil
        </div>
        <div class="card-body">
            <div align="center">
                <img class="avatar" src="{{ $user->avatar }}" style="width: 120px; height: 120px;">

                <p class="mt-3 s-18">{{ $user->name }}</p>
            </div>

            <div class="text-center">
                <form action="{{ route('update.foto', $user->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <div class="custom-file text-left">
                            <input type="file" name="picture" class="custom-file-input" id="image" accept="image/*" value="{{ old('picture') }}">
                            <label class="custom-file-label" for="upload">Pilih File</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">Save Change</button>
                </form>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
