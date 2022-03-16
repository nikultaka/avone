<div id="outer">
    <form action="{{route('admin-import-user-dashboard')}}" class="inner"  name="importDashboard" id="importDashboard" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="userId" name="userId" value="{{isset($userId) ? $userId : ''}}">
        <span class="btn btn-sm btn-warning text-light mx-1 mb-2 btn-file">
            <i class="fas fa-fw fa-file-import"></i> Import  <input type="file" name="file" id="file" onchange="form.submit()">
        </span>
    </form>
</div>