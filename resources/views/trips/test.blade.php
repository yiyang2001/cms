@extends('backend.layouts.app')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- @section('content') --}}
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Trip</h1>
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
    <div class="container">
        <div class="row">
            <div class='col-sm-6'>
                <div class="form-group">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='datetime-local' class="form-control" name="date" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[type=datetime-local]").click(function() {
            var now = new Date();
            config = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today", // Disable dates before today
                defaultDate: now // Set default date and time to now
            }
            flatpickr("input[type=datetime-local]", config).open();
        });
    });
</script>
{{-- @endsection --}}
