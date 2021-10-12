@extends('Admin.layouts.login.index')
@section('logintitle', 'Admin Login')
@section('adminlogin')
    <div class="register-box">
        <div class="register-logo">
            <a href="../../index2.html"><b>Admin</b>LTE</a>
        </div>

        <div class="card">
            <div class="card-body register-card-body">
                <p class="login-box-msg">Register a new membership</p>
                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <ul>
                        <li>{!! \Session::get('success') !!}</li>
                    </ul>
                </div>
                @endif
                @if (\Session::has('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{!! \Session::get('error') !!}</li>
                    </ul>
                </div>
                @endif
                @if (count($errors))
                <div class="alert alert-danger">
                    <!-- <strong>Whoops!</strong> There were some problems with your input.
                    <br /> -->
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="alert alert-danger print-error-msg" style="display:none;">
                    <ul></ul>
                </div>
                <form onsubmit="return false" method="post" id="register_form" name="register_form">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full name">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                        {{-- <div class="error_div"> --}}
                            <label id="name-error" class="error" for="name"></label>
                        {{-- </div> --}}
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        {{-- <div class="error_div"> --}}
                            <label id="email-error" class="error" for="email"></label>
                        {{-- </div> --}}
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        {{-- <div class="error_div"> --}}
                                <label id="password-error" class="error" for="password"></label>
                        {{-- </div> --}}
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Retype password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        {{-- <div class="error_div"> --}}
                            <label id="confirm_password-error" class="error" for="confirm_password"></label>
                        {{-- </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                <label for="agreeTerms"> I agree to the <a href="#">terms</a></label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <a href="{{route('admin-login')}}" class="text-center">I already have a membership</a>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->
@endsection

@section('footersection')
<script type="text/javascript" src="{{ asset('assets/admin/js/register.js')}}"></script>
@endsection