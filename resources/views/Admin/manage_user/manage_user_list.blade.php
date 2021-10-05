@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Manage Users')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Manage Users')
@section('leftbreadcrumb', 'Users')
@section('leftsubbreadcrumb', 'User List')
{{-- End Breadcrumb --}}

@section('admincontent')
@include('Admin/manage_user/manage_user_modal')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">User List</h3>
            <button class="btn btn-info float-right" id="addNewUser">Add New User</button>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="userDataTable">
                    @csrf
                    <thead>
                        <tr>
                            {{-- <th>#Id</th> --}}
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th style="min-width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody >
                    </tbody>
                </table>
            </div>
             
        </div><!-- /.card-body -->
    </div>
@endsection


@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/manage_users.js') }}"></script>
@endsection
