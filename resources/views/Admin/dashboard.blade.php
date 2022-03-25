@extends('Admin.layouts.dashbord.index')
@section('admintitle', 'Admin Dashboard')

{{-- Breadcrumb --}}
@section('rightbreadcrumb','Dashboard')
@section('leftbreadcrumb','Home')
@section('leftsubbreadcrumb','Dashboard')
{{-- End Breadcrumb --}}

@section('admincontent')
<section class="content">
  <!-- Small boxes (Stat box) -->
<?php 
$isSuperadmin = userIsSuperAdmin(); 
if ($isSuperadmin != 1 && $isSuperadmin == '') { 
?>


  <div class="app-dashcontent col-md-12" style="padding: 0px;">
    <div class="messages-dashsection">
      <div class="projects-section-dashheader">
        <b>
          <p style="font-size: 25px;">Titles</p>
        </b>
      </div>
      <div class="messages">
        <ul class="nav nav-tabs" style="display: unset !important;">
          <?php foreach ($titles as $title) { ?>
            <li class="">
              <div class="message-dashbox">
                <div class="message-dashcontent">
                  <div class="message-dashheader">
                    <center>
                      <a href="<?php echo "#mk_" . $title['_id'] ?>" class="navTabsClass custom-btn btn-16 addActive_{{$title['_id']}} " data-id="{{$title['_id']}}" data-toggle="tab">{{$title['title']}}</a>
                    </center><br />
                  </div>
                </div>
              </div>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
    <div class="projects-dashsection">
      <div class="tab-content">
        <?php foreach ($allDashboardData as $allData) { ?>
          <div class="tab-pane" id="<?php echo "mk_" . $allData['_id'] ?>">
            <div class="projects-section-dashheader">
              <b>
                <p style="font-size: 25px;">{{$allData['title']}}</p>
              </b></br>
            </div>
            <div class="project-dashboxes jsGridView">
              <div class="row">
                <div class="project-dashbox-wrapper col-md-7">
                  <div class="project-dashbox" style="background-color: #fee4cb">
                    <p class="dashbox-content-header" style="color: #ff942e">Network Assessment Findings</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['network_assessment_findings'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-2">
                  <div class="project-dashbox" style="background-color: #ccccffbd">
                    <p class="dashbox-content-header" style="color: #4f3ff0">Severity</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['severity'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-3">
                  <div class="project-dashbox" style="background-color: #ffd3e2">
                    <p class="dashbox-content-header" style="color: #df3670">Published Exploit</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['published_exploit'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-2">
                  <div class="project-dashbox" style="background-color: #f4433636">
                    <p class="dashbox-content-header" style="color: #f44336">CVE/CWE</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['cve_cwe'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-2">
                  <div class="project-dashbox" style="background-color: #01490447">
                    <p class="dashbox-content-header" style="color: #014904d4">CVSS3</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['cvss3'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-8">
                  <div class="project-dashbox" style="background-color: #d5deff">
                    <p class="dashbox-content-header" style="color: #4067f9">Buisness Impact</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['buisness_impact'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-6">
                  <div class="project-dashbox" style="background-color: #F9E79F">
                    <p class="dashbox-content-header" style="color: #B7950B">Recommendation</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['recommendation'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-6">
                  <div class="project-dashbox" style="background-color: #0abfef63">
                    <p class="dashbox-content-header" style="color: #096c86">Monitor Your Threat</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['monitor_your_threat'] ?>
                    </p>
                  </div>
                </div>

                <div class="project-dashbox-wrapper col-md-12">
                  <div class="project-dashbox" style="background-color: #c8f7dc">
                    <p class="dashbox-content-header" style="color: #34c471">Description</p>
                    <p class="dashbox-content-subheader">
                      <?php echo $allData['description'] ?>
                    </p>
                  </div>
                </div>
              </div>
            </div></br>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

<?php } else { ?>
          


          <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{$numberOfUser}}</h3>
              <p>Total User</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <h3>{{$totalRegister}}</h3>
              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fas fa-chart-pie mr-1"></i>
                Sales
              </h3>
              <div class="card-tools">
                <ul class="nav nav-pills ml-auto">
                  <li class="nav-item">
                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>
                </ul>
              </div>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content p-0">
                <!-- Morris chart - Sales -->
                <div class="chart tab-pane active" id="revenue-chart"
                     style="position: relative; height: 300px;">
                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                 </div>
                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                  <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                </div>
              </div>
            </div><!-- /.card-body -->
          </div>
          <!-- /.card -->

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map card -->
          <div class="card bg-gradient-primary">
            <div class="card-header border-0">
              <h3 class="card-title">
                <i class="fas fa-map-marker-alt mr-1"></i>
                Visitors
              </h3>
              <!-- card tools -->
              <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm daterange" title="Date range">
                  <i class="far fa-calendar-alt"></i>
                </button>
                <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <div class="card-body">
              <div id="world-map" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.card-body-->
            <div class="card-footer bg-transparent">
              <div class="row">
                <div class="col-4 text-center">
                  <div id="sparkline-1"></div>
                  <div class="text-white">Visitors</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-2"></div>
                  <div class="text-white">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-4 text-center">
                  <div id="sparkline-3"></div>
                  <div class="text-white">Sales</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.card -->

          <!-- /.card -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->
  </section>

       <?php }  ?>


</section>
@endsection


@section('footersection')
<script type="text/javascript">
  $('.navTabsClass').on('click', function() {
    var id = $(this).data('id')
    $(".navTabsClass").removeClass("active");
    $("addActive_" + id).addClass("active");
  })
</script>
<script type="text/javascript" src="{{ asset('assets/admin/js/dashboard.js') }}"></script>
@endsection