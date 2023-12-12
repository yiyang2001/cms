@extends('backend.layouts.app')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Announcements</h1>
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
                                    <h3 class="card-title">Announcements</h3>
                                    <div class="card-tools">
                                        <a href="{{ route('announcements.create') }}" class="btn btn-primary">Create New
                                            Announcement</a>
                                    </div>
                                </div>
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
                                    <div>
                                        <table id="announcementTable" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Title</th>
                                                    {{-- <th>Content</th> --}}
                                                    {{-- <th>Image</th> --}}
                                                    {{-- <th>File</th> --}}
                                                    <th>Created At</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($announcements as $announcement)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $announcement->title }}</td>
                                                        {{-- <td>{!! $announcement->content !!}</td> --}}
                                                        {{-- <td>
                                                            @if ($announcement->image)
                                                                <img src="{{ asset('storage/' . $announcement->image) }}"
                                                                    alt="Image" class="img-thumbnail"
                                                                    style="max-height: 100px;">
                                                            @else
                                                                No Image
                                                            @endif
                                                        </td> --}}
                                                        {{-- <td>
                                                            @if ($announcement->file)
                                                                <a href="{{ asset('storage/' . $announcement->file) }}"
                                                                    target="_blank">View File</a>
                                                            @else
                                                                No File
                                                            @endif
                                                        </td> --}}
                                                        <td>{{ $announcement->created_at }}</td>
                                                        <td>
                                                            <a href="{{ route('announcements.show', $announcement->id) }}"
                                                                class="btn btn-info btn-sm">View</a>

                                                            @if (auth()->user()->role == 'Admin')
                                                                <a href="{{ route('announcements.edit', $announcement->id) }}"
                                                                    class="btn btn-primary btn-sm">Edit</a>
                                                                <form
                                                                    action="{{ route('announcements.destroy', $announcement->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        onclick="return confirm('Are you sure?')"
                                                                        class="btn btn-danger btn-sm">Delete</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $("#announcementTable").DataTable({
                // columnDefs: [{
                //     targets: [2], // Adjust the column index where you want to limit the content
                //     render: function(data, type, row) {
                //         if (type === 'display' && data.length > 50) {
                //             return data.substr(0, 200) +
                //                 '...'; // Truncate content to 50 characters
                //         }
                //         return data;
                //     }
                // }]
            });
        });
    </script>
@endsection
