@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Deployment')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Deployment')
@section('leftbreadcrumb', 'Deployment')
@section('leftsubbreadcrumb', 'Deployment List')
{{-- End Breadcrumb --}}

@section('admincontent')
@include('Admin.deployment.deployment_modal')
    <div class="card card-primary card-outline">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Deployment List</h3>
            <button class="btn btn-info float-right" id="addNewDeployment">Add New Deployment</button>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="deploymentDataTable">
                    <thead>
                        <tr>
                            <th>#Id</th>
                            <th>Name</th>
                            <th style="min-width: 200px">Action</th>
                        </tr>
                    </thead>
                    <tbody class="ajaxResponse">
                    </tbody>
            
                </table>
            </div>
             
        </div><!-- /.card-body -->
    </div>
@endsection


@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/deployment.js') }}"></script>
@endsection
