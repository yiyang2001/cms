@extends('backend.layouts.app')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Profile</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" id="current-page"></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Your Vehicles</h3>
                                <div class="card-tools">
                                    <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Add New Vehicle</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    {{-- <strong>Whoops! There is something wrong with your input </strong> --}}
                                    <div class="alert alert-danger">
                                        <strong>{{ session('error') }}</strong>
                                    </div>
                                @endif
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Type</th>
                                            <th>Created At</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vehicles as $key => $vehicle)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $vehicle->name }}</td>
                                                <td>{{ $vehicle->vehicle_type }}</td>
                                                <td>{{ $vehicle->created_at }}</td>
                                                <td>{{ $vehicle->updated_at }}</td>
                                                <td>
                                                    <a href="{{ route('vehicles.show', $vehicle->id) }}"
                                                        class="btn btn-primary">View</a>
                                                    {{-- <a href="{{ route('edit-users', $user->id) }}"
                                                        class="btn btn-primary">Edit</a> --}}
                                                    {{-- <a href="{{ route('delete-users', $user->id) }}"
                                                        class="btn btn-danger">Delete</a> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th>Vehicle Name</th>
                                            <th>Vehicle Type</th>
                                            <th>Created At</th>
                                            <th>Last Update</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
    </div>
@endsection
