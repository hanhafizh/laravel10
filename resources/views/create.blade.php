@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Data User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <form action="{{ route('admin.user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title"></h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Photo Profile</label>
                                            <div id="image-preview" class="mt-2 mb-2">
                                                <!-- Gambar akan ditampilkan di sini -->
                                            </div>
                                            <input type="file" class="form-control" id="image" name="image"
                                                onchange="previewImage(event)">
                                            @error('image')
                                                <small>{{ $message }}</small>
                                            @enderror

                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email"
                                                placeholder="Masukkan Email" value="{{ old('email') }}">
                                            @error('email')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Nama</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="Masukkan Nama" value="{{ old('name') }}">
                                            @error('name')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" name="password"
                                                placeholder="Password">
                                            @error('password')
                                                <small>{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const imagePreview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.innerHTML =
                        `<img src="${e.target.result}" alt="Preview" style="max-width: 100%; max-height: 200px;">`;
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.innerHTML = '';
            }
        }
    </script>
@endsection
