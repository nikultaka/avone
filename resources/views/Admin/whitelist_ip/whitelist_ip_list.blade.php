@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Whitelist Ip')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Whitelist Ip')
@section('leftbreadcrumb', 'Ips')
@section('leftsubbreadcrumb', 'Whitelist Ip List')
{{-- End Breadcrumb --}}

@section('admincontent')
@include('Admin/whitelist_ip/whitelist_ip_modal')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Whitelist Ip List</h3>
            <button class="btn btn-info float-right" id="addWhitelistIp">Add Whitelist Ip </button>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="whitelistIpDataTable">
                    @csrf
                    <thead>
                        <tr>
                            {{-- <th>#Id</th> --}}
                            <th>Ip Address</th>
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
    <script type="text/javascript" src="{{ asset('assets/admin/js/whitelist_ip.js') }}"></script>
@endsection
