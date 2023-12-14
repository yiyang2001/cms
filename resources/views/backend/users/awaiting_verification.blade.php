@extends('backend.layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Awaiting Approval List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" id="current-page"> </li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header info">
                                <h3 class="card-title">User Awaiting Approval List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        <strong>{{ session('error') }}</strong>
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="alert alert-warning">
                                        <strong>{{ session('warning') }}</strong>
                                    </div>
                                @endif
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created Date</th>
                                            <th>IC</th>
                                            <th>Driver License</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($usersAwaitingVerification as $user)
                                            <tr>
                                                <td>{{ $user->id }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }} </td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    @if ($user->ic_document)
                                                        <a href="{{ asset('storage/' . $user->ic_document) }}"
                                                            target="_blank">View</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->driving_license_document)
                                                        <a href="{{ asset('storage/' . $user->driving_license_document) }}"
                                                            target="_blank">View</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user->status == 0)
                                                        <span class="badge badge-warning">Awaiting Approval</span>
                                                    @elseif($user->status == 1)
                                                        <span class="badge badge-success">Approved</span>
                                                    @elseif($user->status == 2)
                                                        <span class="badge badge-danger">Rejected</span>
                                                    @else
                                                        <span class="badge badge-danger">Awaiting Approval</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <a href="{{ route('user-profile', $user->id) }}"
                                                        class="btn btn-info btn-sm">Profile</a>
                                                    <a href="{{ route('users.verify', $user->id) }}"
                                                        class="btn btn-success btn-sm">Approve</a>
                                                    <a href="{{ route('users.reject', $user->id) }}"
                                                        class="btn btn-danger btn-sm">Reject</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Created Date</th>
                                            <th>IC</th>
                                            <th>Driver License</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section><!-- /.content -->
    </div>
@endsection
