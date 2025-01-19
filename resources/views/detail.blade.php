@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">DetailUser</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Detail User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Photo Profile</label>
                                    <div class="mt-2 mb-2">
                                        <img src="{{ asset('storage/photo-user/' . $data->image) }}" alt=""
                                            width="100">
                                    </div>
                                    @error('image')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <p>{{ $data->email }}</p>
                                    @error('email')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Nama</label>
                                    <p>{{ $data->name }}</p>
                                    @error('name')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Type Rumah</th>
                                            <th>Harga Rumah</th>
                                            <th>Lokasi Rumah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- nik relasi one to many --}}
                                        @foreach ($data->rumahs as $rumahUser)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $rumahUser->type_rumah }}</td>
                                                <td>{{ $rumahUser->harga_rumah }}</td>
                                                <td>{{ $rumahUser->lokasi_rumah }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
        </section>
    </div>
@endsection
