<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="../../index2.html" class="h1"><b>Carpool </b>Manangement</a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership</p>
                @if ($errors->any())
                    <div class="mt-3">
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full name" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Password" required>
                        <div class="input-group-append">

                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye-slash" id="eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Retype password" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye-slash" id="confirm-eye-icon"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        {{-- <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div> --}}
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                {{-- <div class="social-auth-links text-center">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i>
          Sign up using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i>
          Sign up using Google+
        </a>
      </div> --}}

                <a href="{{ route('login') }}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/dist/js/adminlte.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("form").addEventListener("submit", function(event) {
                // Prevent the form from submitting by default
                event.preventDefault();

                // Get the password value
                var password = document.getElementById("password").value;

                // Define regular expressions to check for the required criteria
                var uppercaseRegex = /[A-Z]/;
                var lowercaseRegex = /[a-z]/;
                var numberRegex = /[0-9]/;
                var specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;

                // Check if the password meets all criteria
                if (
                    password.length >= 8 &&
                    uppercaseRegex.test(password) &&
                    lowercaseRegex.test(password) &&
                    numberRegex.test(password) &&
                    specialCharRegex.test(password)
                ) {
                    // If password meets the criteria, submit the form
                    this.submit();
                } else {
                    // If password doesn't meet the criteria, show an error message or handle it accordingly
                    alert(
                        "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character."
                    );
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const passwordField = document.getElementById("password");
            const togglePasswordButton = document.getElementById("togglePassword");
            const eyeIcon = document.getElementById("eye-icon");

            togglePasswordButton.addEventListener("click", function() {
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    eyeIcon.classList.remove("fa-eye-slash");
                    eyeIcon.classList.add("fa-eye");
                } else {
                    passwordField.type = "password";
                    eyeIcon.classList.remove("fa-eye");
                    eyeIcon.classList.add("fa-eye-slash");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const confirmPasswordField = document.getElementById("password_confirmation");
            const toggleConfirmPasswordButton = document.getElementById("toggleConfirmPassword");
            const confirmEyeIcon = document.getElementById("confirm-eye-icon");

            toggleConfirmPasswordButton.addEventListener("click", function() {
                if (confirmPasswordField.type === "password") {
                    confirmPasswordField.type = "text";
                    confirmEyeIcon.classList.remove("fa-eye-slash");
                    confirmEyeIcon.classList.add("fa-eye");
                } else {
                    confirmPasswordField.type = "password";
                    confirmEyeIcon.classList.remove("fa-eye");
                    confirmEyeIcon.classList.add("fa-eye-slash");
                }
            });
        });
    </script>

</body>

</html>
