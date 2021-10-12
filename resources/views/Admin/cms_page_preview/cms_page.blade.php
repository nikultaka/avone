@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'CMS PAGE')

{{-- Breadcrumb --}}
{{-- @section('rightbreadcrumb', $cmsPageData->title) --}}
@section('leftbreadcrumb', 'CMS')
@section('leftsubbreadcrumb', $cmsPageData->title)
{{-- End Breadcrumb --}}

@section('admincontent')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{$cmsPageData->title}}</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            {!! $cmsPageData->descriptioneditor !!}
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
@endsection


@section('footersection')

@endsection
