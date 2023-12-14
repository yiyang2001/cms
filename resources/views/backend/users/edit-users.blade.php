@extends('backend.layouts.app')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Manangement</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User Management</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        @if (auth()->user()->role == 'Customer')
        @endif
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-1">
                </div>
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong>Edit User for {{ $edit->name }}</strong></h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <!-- /.card body start -->
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif
                                    @if ($errors->any())
                                        {{-- <strong>Whoops! There is something wrong with your input </strong> --}}
                                        <div class="alert alert-danger">
                                            <strong>Whoops! There is something wrong with your input </strong>
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        {{-- <strong>Whoops! There is something wrong with your input </strong> --}}
                                        <div class="alert alert-danger">
                                            <strong>{{ session('error') }}</strong>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('update-users', $edit->id) }}">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control"
                                                    placeholder="Enter your name" value="{{ $edit->name }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control"
                                                    placeholder="Enter email" value="{{ $edit->email }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Reset the password as Administrator (Left it empty if don't want to reset)">
                                            </div>
                                        </div>
                                        {{-- <div class="form-group row">
                                            <label for="role" class="col-sm-2 col-form-label">Role</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="role" id="role">
                                                    <option value="Admin" {{'Admin'== $edit->role ? 'selected':''}}>Admin</option>
                                                    <option value="Manager"  {{'Manager'== $edit->role ? 'selected':''}}>Manager</option>
                                                    <option value="User"  {{'User'== $edit->role ? 'selected':''}}>User</option>
                                                </select>
                                            </div>
                                        </div> --}}
                                        <div class="form-group row">
                                            <label for="status" class="col-sm-2 col-form-label">Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="status" id="status">
                                                    <option value="Active" {{ 'Admin' == $edit->status ? 'selected' : '' }}>
                                                        Active</option>
                                                    <option value="Blacklist"
                                                        {{ 'Blacklist' == $edit->status ? 'selected' : '' }}>Blacklist</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="status" class="col-sm-2 col-form-label">Verification
                                                Status</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="verification" id="verification">
                                                    <option value="1"
                                                        {{ '1' == $edit->verified_by_admin ? 'selected' : '' }}>Approved
                                                    </option>
                                                    <option value="0"
                                                        {{ '0' == $edit->verified_by_admin ? 'selected' : '' }}>Awaiting
                                                        Approval</option>
                                                    <option value="2"
                                                        {{ '2' == $edit->verified_by_admin ? 'selected' : '' }}>Rejected
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Edit User</button>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <!-- /.container-fluid -->
        </section>

    </div>
@endsection
