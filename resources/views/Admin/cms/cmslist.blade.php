@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Deployment')
{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'CMS')
@section('leftbreadcrumb', 'CMS')
@section('leftsubbreadcrumb', 'CMS List')
{{-- End Breadcrumb --}}

@section('admincontent')
    @include('Admin.cms.cms_modal')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Cms List</h3>
            <div class="box-tools float-right">
                        <button class="btn btn-info float-right" id="addNewCms">Create New CMS</button>
            </div>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <div class="table-responsive">
                <table id="cms_list_table" class="table table-striped table-bordered">
                    {{ csrf_field() }}
                    <thead>
                        <th>Title</th>
                        <th>Slug URL</th>
                        <th>Status</th>
                        <th style="min-width: 200px">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection

@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/cms.js') }}"></script>
    <script src="//cdn.ckeditor.com/4.7.3/full-all/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        // admin.cms.initialize();
        CKEDITOR.replace('description');
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.extraAllowedContent ﻿= 'p(*)[*]{*};span(*)[*]{*};div(*)[*]{*};li(*)[*]{*};ul(*)[*]{*}';
    });
</script>
@endsection
