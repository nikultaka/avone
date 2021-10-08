@extends('Admin.layouts.login.index')
@section('logintitle', 'Admin Set New password')
@section('adminlogin')
    <div class="login-box">
        <div class="login-logo">
            <p>Logo</p>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Enter your new password</p>
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
                        <strong>Whoops!</strong>Some problems with your input.
                        <br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- <form method="POST" action="{{ route('admin-login-proccess') }}"  id="login_form" name="login_form"> --}}
                    <form method="POST" action="{{route('admin-set-new-password')}}">
                        {{ csrf_field() }}
                        <input type="hidden" id="newpasswordtoken" name="newpasswordtoken" value="{{$newpasswordtoken}}">
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text passwordShow"><span id="passwordShowIcon" class="fa fa-eye"></span></div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                            <div class="input-group-append">
                                <div class="input-group-text passwordShow"><span id="passwordShowIcon" class="fa fa-eye"></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <a href="{{route('admin-login')}}">Log In</a>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Send mail</button>
                            </div>
                        </div>

                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection

@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/forgot_password.js') }}"></script>
@endsection
