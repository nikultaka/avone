@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Users Dashboard')

{{-- Breadcrumb --}}
@section('rightbreadcrumb', 'Manage User Dashboard')
@section('leftbreadcrumb', 'Users Dashboard')
@section('leftsubbreadcrumb', 'Dashboard')
{{-- End Breadcrumb --}}

@section('admincontent')
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Dashboard</h3>
            <button class="btn btn-info ml-2 float-right" id="addNewRow"><i class="fas fas fa-plus"></i> Add New Row</button> &nbsp;
            <a href="{{route("admin-manage-users")}}" class="btn btn-secondary float-right"><i class="fas fa-caret-left"></i> Back</a>
        </div> <!-- /.card-body -->
        <div class="card-body">
            <input type="hidden" name="userIdHdn" id="userIdHdn" value="{{ isset($id) ? $id : '' }}">
            <input type="hidden" name="recordIdHdn" id="recordIdHdn" value="">
            @csrf
            <div class="dashboardMainDiv" id="dashboardMainDiv">
                <table class="table-responsive table table-striped table-bordered userDashboardTable">
                    <thead>
                        <th>Network Assessment Findings</th>
                        <th>Severity</th>
                        <th>CVE/CWE</th>
                        <th>CVSS3</th>
                        <th>Description</th>
                        <th>Buisness Impact</th>
                        <th>Published Exploit</th>
                        <th>Recommendation</th>
                        <th>Monitor Your Threat</th>
                        <th>Action</th>
                    </thead>
                    <tbody class="userDashboardTbody">
                        <?php 
                            if(!empty($dashboardList) && count($dashboardList) > 0){ ?>
                                <input type="hidden" name="lastRow" id="lastRow" value="{{count($dashboardList)}}">
                                @foreach ($dashboardList as $k => $val)
                                @php
                                if(strtolower($val['severity']) == 'high'){
                                    $headerBGcolor = '#ff0000';
                                } elseif (strtolower($val['severity']) == 'medium') {
                                    $headerBGcolor = '#ffc000';
                                } elseif (strtolower($val['severity']) == 'low') {
                                    $headerBGcolor = '#5b9bd5';
                                }
                                @endphp
    
                                <div data-row="{{$k+1}}">
                                    <tr>
                                        <td colspan="10">
                                            <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="title_{{$k+1}}" name="title_{{$k+1}}" style="background-color: {{$headerBGcolor}}" value="{{isset($val['title']) ? $val['title'] : ''}}" placeholder="Title">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="networkAssessmentFindings_{{$k+1}}" name="networkAssessmentFindings_{{$k+1}}"  value="{{isset($val['network_assessment_findings']) ? $val['network_assessment_findings'] : ''}}" placeholder="Network Assessment Findings">
                                            </div>
                                        </td>
                                        <td>
                                            {{-- <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="severity_{{$k+1}}" name="severity_{{$k+1}}" value="{{isset($val['severity']) ? $val['severity'] : ''}}" placeholder="Severity">
                                            </div> --}}
                                            <select class="custom-select row_{{$k+1}}" id="severity_{{$k+1}}" style="width: 95px;" name="severity_{{$k+1}}" disabled="true">
                                                <option value="high" {{isset($val['severity']) && $val['severity'] == 'high' ? 'selected' : ''}}>High</option>
                                                <option value="medium" {{isset($val['severity']) && $val['severity'] == 'medium' ? 'selected' : ''}}>Medium</option>
                                                <option value="low" {{isset($val['severity']) && $val['severity'] == 'low' ? 'selected' : ''}}>Low</option>
                                              </select>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="cve_cwe_{{$k+1}}" name="cve_cwe_{{$k+1}}" value="{{isset($val['cve_cwe']) ? $val['cve_cwe'] : ''}}" placeholder="CVE/CWE">
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="cvss3_{{$k+1}}" name="cvss3_{{$k+1}}" value="{{isset($val['cvss3']) ? $val['cvss3'] : ''}}" placeholder="CVSS3">
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                {{-- <input readonly type="textarea" class="form-control row_{{$k+1}}" id="description" name="description" value="{{isset($val['cvss3']) ? $val['cvss3'] : ''}}" placeholder="description"> --}}
                                                <textarea class="form-control row_{{$k+1}}" id="description_{{$k+1}}" name="description_{{$k+1}}" readonly rows="3">{{isset($val['description']) ? $val['description'] : ''}}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <textarea class="form-control row_{{$k+1}}" id="buisnessImpact_{{$k+1}}" name="buisnessImpact_{{$k+1}}" readonly rows="3">{{isset($val['buisness_impact']) ? $val['buisness_impact'] : ''}}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <input readonly type="text" class="form-control row_{{$k+1}}" id="publishedExploit_{{$k+1}}" name="publishedExploit_{{$k+1}}" readonly value="{{isset($val['published_exploit']) ? $val['published_exploit'] : ''}}" placeholder="Published Exploit">
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <textarea class="form-control row_{{$k+1}}" id="recommendation_{{$k+1}}" name="recommendation_{{$k+1}}" readonly rows="3">{{isset($val['recommendation']) ? $val['recommendation'] : ''}}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                             <div class="form-group">
                                                <textarea class="form-control row_{{$k+1}}" id="monitorYourThreat_{{$k+1}}" name="monitorYourThreat_{{$k+1}}" readonly rows="3">{{isset($val['monitor_your_threat']) ? $val['monitor_your_threat'] : ''}}</textarea>
                                            </div>
                                        </td>
                                        <td>
                                            <div style="display:flex;">
                                                <button type="button" class="btn btn-danger btn-sm  deleteRowData row_{{$k+1}} deleteBtn_{{$k+1}}" style="border-radius:50%" data-deleteid="{{isset($val['_id']) ? $val['_id'] : ''}}" data-id="{{$k+1}}"><i class="fas fa-trash"></i></button>&nbsp;
                                                <button type="button" class="btn btn-success btn-sm editRowData editBtn_{{$k+1}}" data-id="{{$k+1}}" data-editid="{{isset($val['_id']) ? $val['_id'] : ''}}" style="border-radius:50%"><i class="fas fa-pen"></i></button>
                                                <button type="button" class="btn btn-success btn-sm saveRowData saveRowBtn saveBtn_{{$k+1}}  row_{{$k+1}}" data-id="{{$k+1}}" style="border-radius:50%;display:none"><i class="fas fa-save"></i></button>
                                            </div>
                                       </td>
                                    </tr>
                                </div>
                                @endforeach
                           <?php  } else {  ?>
                            <input type="hidden" name="lastRow" id="lastRow" value="0">
                            <div data-row="0">
                                <tr>
                                    <td colspan="10">
                                        <div class="form-group">
                                            <input type="text" class="form-control row_0" id="title_0" name="title_0"  placeholder="Title">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <input type="text" class="form-control row_0" id="networkAssessmentFindings_0" name="networkAssessmentFindings_0" placeholder="Network Assessment Findings">
                                        </div>
                                    </td>
                                    <td>
                                        <select class="custom-select" aria-label="Default select example" id="severity_0" id="severity_0">
                                            <option value="high">High</option>
                                            <option value="medium">Medium</option>
                                            <option value="low">Low</option>
                                          </select>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <input type="text" class="form-control row_0" id="cve_cwe_0" name="cve_cwe_0" placeholder="CVE/CWE">
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <input type="text" class="form-control row_0" id="cvss3_0" name="cvss3_0" placeholder="CVSS3">
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            {{-- <input type="textarea" class="form-control row_0" id="description" name="description" placeholder="description"> --}}
                                            <textarea class="form-control row_0" id="description_0" name="description_0" rows="3"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <textarea class="form-control row_0" id="buisnessImpact_0" name="buisnessImpact_0" rows="3"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <input type="text" class="form-control row_0" id="publishedExploit_0" name="publishedExploit_0" placeholder="Published Exploit">
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <textarea class="form-control row_0" id="recommendation_0" name="recommendation_0" rows="3"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                         <div class="form-group">
                                            <textarea class="form-control row_0" id="monitorYourThreat_0" name="monitorYourThreat_0" rows="3"></textarea>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display:flex;">
                                            {{-- <button type="button" class="btn btn-danger btn-sm" style="border-radius: 50%"><i class="fas fa-pen"></i></button>&nbsp; --}}
                                            <button type="button" class="btn btn-success btn-sm saveRowBtn row_0" data-id="0" style="border-radius:50%"><i class="fas fa-save"></i></button>
                                        </div>
                                   </td>
                                </tr>
                            </div>
                           <?php }  ?>
                      
                       
                    </tbody>
                </table>
            </div>
            
        </div><!-- /.card-body -->
    </div>

@endsection


@section('footersection')
    <script type="text/javascript" src="{{ asset('assets/admin/js/users_dashboard.js') }}"></script>
@endsection
