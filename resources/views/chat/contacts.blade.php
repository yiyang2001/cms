@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Contacts</h1>
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
                        <div class="container-fluid">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Contacts</h3>
                                </div>
                                <div class="card-body pb-0">
                                    <form action="{{ route('contacts.search') }}" method="GET" class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search...">
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary">Search</button>
                                            </div>
                                        </div>
                                    </form>
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
                                    <div class="row">
                                        @if (count($users) == 0)
                                            <div class="col-12">
                                                <div class="alert alert-warning text-center">
                                                    <strong>No User Found</strong>
                                                </div>
                                            </div>
                                        @endif
                                        @foreach ($users as $user)
                                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                                <div class="card bg-light d-flex flex-fill">
                                                    <div class="card-header text-muted border-bottom-0">
                                                        @if ($user->role == 'Admin')
                                                            <span class="badge badge-danger">Admin</span>
                                                        @elseif($user->role == 'Customer')
                                                            <span class="badge badge-success">User</span>
                                                        @endif
                                                    </div>
                                                    <div class="card-body pt-0">
                                                        <div class="row">
                                                            <div class="col-7">
                                                                <h2 class="lead"><b>{{ $user->name }}</b></h2>
                                                                <p class="text-muted text-sm"><b>Email:
                                                                    </b>{{ $user->email }}</p>
                                                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                    <li class="small"><span class="fa-li"><i
                                                                                class="fas fa-lg fa-building"></i></span>
                                                                        Loction: {{ $user->location }}</li>
                                                                    <li class="small"><span class="fa-li"><i
                                                                                class="fas fa-lg fa-phone"></i></span> Phone
                                                                        #: {{ $user->phone_no }}</li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-5 text-center">
                                                                @if (isset($user->image_path))
                                                                    <img src="{{ asset($user->image_path) }}"
                                                                        alt="User Image" class="rounded-circle img-fluid"
                                                                        style="height: 150px; width: 150px; ">
                                                                @else
                                                                    <img src="{{ asset('vendor/dist/img/user1-128x128.jpg') }}"
                                                                        alt="user-avatar" class="img-circle img-fluid">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="text-right">
                                                            <a href="{{ route('chat.chat', $user->id) }}"
                                                                class="btn btn-sm bg-teal">
                                                                <i class="fas fa-comments"></i>
                                                            </a>
                                                            <a href="{{ route('user-profile', $user->id) }}"
                                                                class="btn btn-sm btn-primary">
                                                                <i class="fas fa-user"></i> View Profile
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-center">
                                        {{ $users->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
