@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Settings')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Settings')
@section('leftbreadcrumb', 'Setting')
@section('leftsubbreadcrumb', 'Change Settings')
{{-- End Breadcrumb --}}

@section('admincontent')
    <div class="card card-primary card-outline">
        {{-- <div class="card-header">
            <h3 class="card-title">Deployment List</h3>
            <button class="btn btn-info float-right" id="addNewDeployment">Add New Deployment</button>
        </div> <!-- /.card-body --> --}}
        <div class="card-body">
            <form onsubmit="return false" method="post" id="settingForm" name="settingForm" autocomplete="false">
                {{ csrf_field() }}
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="EC API KEY">EC API KEY :</label>
                    </div>
                    <div class="col-sm-10">
                       <input type="text" class="form-control" id="ecApiKey" name="ecApiKey"  placeholder="Enter Ec Api Key" value="{{isset($settingData['ecapikey']) ? $settingData['ecapikey'] : ''}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="version">Version :</label>
                    </div>
                    <div class="col-sm-10">
                       <input type="text" class="form-control" id="version" name="version"  placeholder="Enter version" value="{{isset($settingData['version']) ? $settingData['version'] : ''}}">
                    </div>
                </div>
                <button type="submit" class="btn btn-success float-right">Save Settings</button>
            </form>    
        </div><!-- /.card-body -->
    </div>
@endsection


@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/setting.js') }}"></script>
@endsection
