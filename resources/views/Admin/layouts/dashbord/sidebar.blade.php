<?php  $routeName = Request::route()->getName(); ?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin-dashboard')}}" class="brand-link">
      <img src="{{asset('assets/theme/admin/img/logo.png')}}" alt="Logo" class="ml-4"  style="opacity: .8; max-width:165px">
      {{-- <a href="{{route('admin-dashboard')}}"><img src="{{asset('assets/theme/admin/img/logo.png')}}" alt="Logo"></a> --}}
      {{-- <span class="brand-text font-weight-light">AdminLTE 3</span> --}}
    </a>

   <!-- Sidebar -->
   <div class="sidebar">
     <!-- Sidebar user panel (optional) -->
     <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       <div class="image">
         <img src="{{asset('assets/theme/admin/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
       </div>
       <div class="info">
         <a href="{{ route('admin-dashboard') }}" class="d-block">{{$logInUserData['name']}}</a>
       </div>
     </div>

     <!-- SidebarSearch Form -->
     {{-- <div class="form-inline">
       <div class="input-group" data-widget="sidebar-search">
         <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
         <div class="input-group-append">
           <button class="btn btn-sidebar">
             <i class="fas fa-search fa-fw"></i>
           </button>
         </div>
       </div>
     </div> --}}

     <!-- Sidebar Menu -->
     <nav class="mt-2">
       <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
         <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
         <li class="nav-item">
           <a href="{{ route('admin-dashboard') }}" class="nav-link <?php echo $routeName == 'admin-dashboard' ? 'active':'';?>">
             <i class="nav-icon fas fa-tachometer-alt"></i>
             <p>Dashboard</p>
           </a>
         </li>
         <li class="nav-item">
            <a href="{{ route('admin-deployment') }}" class="nav-link <?php echo $routeName == 'admin-deployment' ? 'active':'';?>">
              <i class="nav-icon fas fa-cloud-upload-alt"></i>
              <p>Deployment</p>
            </a>
          </li>
          <?php
            if($logInUserData['is_admin'] == 1){ ?>
                  <li class="nav-item">
                    <a href="{{ route('admin-manage-users') }}" class="nav-link <?php echo $routeName == 'admin-manage-users' ? 'active':'';?>">
                       <i class="nav-icon fa fa-users"></i>
                       <p>Manage Users</p>
                     </a>
                   </li>
                   <li class="nav-item">
                    <a href="{{ route('admin-whitelist-ip') }}" class="nav-link <?php echo $routeName == 'admin-whitelist-ip' ? 'active':'';?>">
                       <i class="nav-icon fas fa-server"></i>
                       <p>Whitelist Ip</p>
                     </a>
                   </li>
                   <li class="nav-item">
                    <a href="{{ route('admin-cms') }}" class="nav-link <?php echo $routeName == 'admin-cms' ? 'active':'';?>">
                       <i class="nav-icon fas fa-pager"></i>
                       <p>CMS Pages</p>
                     </a>
                   </li>
                   <li class="nav-item">
                    <a href="{{ route('admin-setting') }}" class="nav-link <?php echo $routeName == 'admin-setting' ? 'active':'';?>">
                       <i class="nav-icon fas fa-cogs"></i>
                       <p>Settings</p>
                     </a>
                   </li>
           <?php }
          ?>          
       
         <li class="nav-item">
          <a href="javascript:void(0)" class="nav-link adminLogout">
             <i class="nav-icon fas fa-sign-out-alt"></i>
             <p>Sign Out</p>
           </a>
         </li>
       </ul>
     </nav>
     <!-- /.sidebar-menu -->
   </div>
   <!-- /.sidebar -->
 </aside>