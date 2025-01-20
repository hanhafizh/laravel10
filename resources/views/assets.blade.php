@extends('layout.main')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Data Assets User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Data Assets User</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary mb-3">Tambah Data</a>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Responsive Hover Table</h3>

                                {{-- search-page --}}
                                <div class="card-tools">
                                    <form action="{{ route('admin.user.index') }}" method="GET">
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Search" value="{{ $request->get('search') }}">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Photo Profile</th>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Asset</th>
                                            <th>Jumlah Asset</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $dataUser)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><img src="{{ asset('storage/photo-user/' . $dataUser->image) }}"
                                                        alt="" width="50"></td>
                                                {{-- nik relasi one to one --}}
                                                <td>{{ $dataUser->ktp->nik ?? '' }}</td>
                                                <td>{{ $dataUser->name }}</td>
                                                <td>
                                                    {{-- relasi many to many --}}
                                                    <ul>
                                                        @foreach ($dataUser->assets as $asset)
                                                            <li>
                                                                {{ $asset->nama_asset }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                {{-- relasi many to many --}}
                                                <td>{{ count($dataUser->assets) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
