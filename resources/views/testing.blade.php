<!DOCTYPE html>
<html lang="en">

<head>
    <title>Testing</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/plugins/daterangepicker/daterangepicker.css') }}">
    <script src="{{ asset('vendor/plugins/daterangepicker/daterangepicker.js') }}"></script>
</head>

<body>
    <h1>Testing</h1>

    <div class="form-group">
        <label>Date and time:</label>
        <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
            <input type="text" class="form-control datetimepicker-input" data-target="#reservationdatetime" />
            <div class="input-group-append" data-target="#reservationdatetime" data-toggle="datetimepicker">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    </script>
</body>

</html>
