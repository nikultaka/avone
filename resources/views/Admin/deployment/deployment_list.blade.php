@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Deployment')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Deployment')
@section('leftbreadcrumb', 'Deployment')
@section('leftsubbreadcrumb', 'Deployment List')
{{-- End Breadcrumb --}}

@section('admincontent')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Deployment List</h3>
            <button class="btn btn-info float-right">Add New Deployment</button>
        </div> <!-- /.card-body -->
        <div class="card-body">
            
        </div><!-- /.card-body -->
    </div>
@endsection

@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/deployment.js') }}"></script>
@endsection
