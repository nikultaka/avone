$(document).ready(function () {
  deploymentDataTable();
  // $('#deploymentDataTable').DataTable();
  $('#addNewDeployment').on('click', function () {
    $('#deploymentModal').modal('show');
  });
  $("#deploymentModal").on("hidden.bs.modal",function(){
    $('#deploymentName').val('');
    $('#deploymentHdnID').val('');
    $('#addNewDeploymentForm')[0].reset();
    $('.modal-title').html('Add new deployment');
    $('#addNewDeploymentBtn').html('Add');
  });
  
  $('#addNewDeploymentBtn').on('click', function () {
    const access_token = getAccessToken();
    var error = 0;
    var deploymentName = $('#deploymentName').val();
    var sizePerZoneElastic = $('#sizePerZoneElastic').val();
    var availabilityZonesElastic = $('input[name="availabilityZonesElastic"]:checked').val();
    var sizePerZoneKibana = $('#sizePerZoneKibana').val();
    var availabilityZonesKibana = $('input[name="availabilityZonesKibana"]:checked').val();
    var sizePerZoneApm = $('#sizePerZoneApm').val();
    var availabilityZonesApm = $('input[name="availabilityZonesApm"]:checked').val();
    var deploymentHdnID = $('#deploymentHdnID').val();
    
    if (deploymentName == '' || deploymentName == null) {
      $('#deploymentName').css('border-color', 'red');
      error++;
    }
    if (error == 0) {
      showloader();
      if(deploymentHdnID == ''){    
        var settings = {
          "url": API_PREFIX + "/api/deployment/create",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Bearer " + access_token + "",
            "Content-Type": "application/json"
          },
          "data": JSON.stringify({
            "name": deploymentName,
            "resources": {
              "elasticsearch": [
                {
                  "region": ELASTIC_REGION,
                  "ref_id": "main-elasticsearch",
                  "plan": {
                    "cluster_topology": [
                      {
                        "node_type": {
                          "data": true,
                          "master": true,
                          "ingest": true
                        },
                        "instance_configuration_id": "azure.data.highio.l32sv2",
                        "zone_count": availabilityZonesElastic,
                        "size": {
                          "resource": "memory",
                          "value": sizePerZoneElastic
                        }
                      }
                    ],
                    "elasticsearch": {
                      "version": ELASTIC_VERSION
                    },
                    "deployment_template": {
                      "id": "azure-io-optimized-v2"
                    }
                  }
                }
              ],
              "kibana": [
                {
                  "region": ELASTIC_REGION,
                  "elasticsearch_cluster_ref_id": "main-elasticsearch",
                  "ref_id": "main-kibana",
                  "plan": {
                    "cluster_topology": [
                      {
                        "instance_configuration_id": "azure.kibana.e32sv3",
                        "zone_count": availabilityZonesKibana,
                        "size": {
                          "resource": "memory",
                          "value": sizePerZoneKibana
                        }
                      }
                    ],
                    "kibana": {
                      "version": ELASTIC_VERSION
                    }
                  }
                }
              ],
              "apm": [
                {
                  "region": ELASTIC_REGION,
                  "elasticsearch_cluster_ref_id": "main-elasticsearch",
                  "ref_id": "main-apm",
                  "plan": {
                    "apm": {
                      "version": ELASTIC_VERSION
                    },
                    "cluster_topology": [
                      {
                        "instance_configuration_id": "azure.apm.e32sv3",
                        "zone_count": availabilityZonesApm,
                        "size": {
                          "value": sizePerZoneApm,
                          "resource": "memory"
                        }
                      }
                    ]
                  }
                }
              ]
            }
          }),
        };
        $.ajax(settings).done(function (response) {
          hideloader();
          if (response != '' && response != null) {
            if (response.id != '' && response.id != null) {
              successMsg("Deployments created successfully")
              $('#deploymentModal').modal('hide');
              deploymentDataTable();
            } else {
              errorMsg("Something went wrong please try again")
            }
          } else {
            errorMsg("Something went wrong please try again")
          }
        });
      }else{
        var settings = {
          "url": API_PREFIX+"/api/deployment/update",
          "method": "POST",
          "timeout": 0,
          "headers": {
            "Authorization": "Bearer "+access_token+"",
            "Content-Type": "application/json",
            "deploymentID": deploymentHdnID
          },
          "data": JSON.stringify({
            "name": deploymentName,
            "prune_orphans": false,
            "resources": {
              "elasticsearch": [
                {
                  "region": ELASTIC_REGION,
                  "ref_id": "main-elasticsearch",
                  "plan": {
                    "cluster_topology": [
                      {
                        "node_type": {
                          "data": true,
                          "master": true,
                          "ingest": true
                        },
                        "instance_configuration_id": "azure.data.highio.l32sv2",
                        "zone_count": availabilityZonesElastic,
                        "size": {
                          "resource": "memory",
                          "value": sizePerZoneElastic
                        }
                      }
                    ],
                    "elasticsearch": {
                      "version": ELASTIC_VERSION
                    },
                    "deployment_template": {
                      "id": "azure-io-optimized-v2"
                    }
                  }
                }
              ],
              "kibana": [
                {
                  "region": ELASTIC_REGION,
                  "elasticsearch_cluster_ref_id": "main-elasticsearch",
                  "ref_id": "main-kibana",
                  "plan": {
                    "cluster_topology": [
                      {
                        "instance_configuration_id": "azure.kibana.e32sv3",
                        "zone_count": availabilityZonesKibana,
                        "size": {
                          "resource": "memory",
                          "value": sizePerZoneKibana
                        }
                      }
                    ],
                    "kibana": {
                      "version": ELASTIC_VERSION
                    }
                  }
                }
              ],
              "apm": [
                {
                  "region": ELASTIC_REGION,
                  "elasticsearch_cluster_ref_id": "main-elasticsearch",
                  "ref_id": "main-apm",
                  "plan": {
                    "apm": {
                      "version": ELASTIC_VERSION
                    },
                    "cluster_topology": [
                      {
                        "instance_configuration_id": "azure.apm.e32sv3",
                        "zone_count": availabilityZonesApm,
                        "size": {
                          "value": sizePerZoneApm,
                          "resource": "memory"
                        }
                      }
                    ]
                  }
                }
              ]
            }
          }),
        };
        
        $.ajax(settings).done(function (response) {
          hideloader();
            if (response != '' && response != null) {
                successMsg("Deployments updated successfully")
                $('#deploymentModal').modal('hide');
                deploymentDataTable();
            } else {
              errorMsg("Something went wrong please try again")
            }
        });
      }

    }

  });
});
setInterval(function(){
    $.ajax({
         url: BASE_URL + '/' + ADMIN + '/change/status/info',
         type: 'post',
         data: {
            "_token": $("[name='_token']").val(),
          },
         success: function (response){
          var data = JSON.parse(response);
          if (data.lastStatusChange == 1) {
            var changedDeploymentArray =  data.changedDeployment;
            changedDeploymentArray.forEach(function(changedDeploymentData) {
              var statusString = 'Pending';
              if(changedDeploymentData.status) {
                statusString = 'Healthy';
              }
              infoMsg(changedDeploymentData.name+' Status is : '+ statusString);
              deploymentDataTable();    
            });
          }
         }
    });
   }, 30000);
function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display', 'block');
  $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
  });
}

function deploymentDataTable() {
  var urlbase = API_PREFIX;
  if(userIsSuperAdmin == 1){
          $('#deploymentDataTable').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,     
            "bAutoWidth": false,
            "ajax": {
                type: 'get',
                url: BASE_URL + '/' + ADMIN + '/deployment/dataTable',
                data: {
                    "_token": $("[name='_token']").val(),
                    "urlbase": urlbase,
                },
            },
            columns: [
                // {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'cloud_id', name: 'cloud_id'},
                {data: 'deploymentStatus', name: 'deploymentStatus'},
                {data: 'kibanaLink', name: 'kibanaLink'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
  }else{
          $('#deploymentDataTable').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,     
            "bAutoWidth": false,
            "ajax": {
                type: 'get',
                url: BASE_URL + '/' + ADMIN + '/deployment/dataTable',
                data: {
                    "_token": $("[name='_token']").val(),
                    "urlbase": urlbase,
                },
            },
            columns: [
                // {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'deploymentStatus', name: 'deploymentStatus'},
                {data: 'kibanaLink', name: 'kibanaLink'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
  }
}

$(document).on('click', '.deleteDeployment', function () {
  const access_token = getAccessToken();
  var deploymentID = $(this).data("id");
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
              showloader();
              var settings = {
                "url": API_PREFIX + "/api/deployment/delete",
                "method": "POST",
                "timeout": 0,
                "headers": {
                  "Authorization": "Bearer " + access_token + "",
                  "deploymentID": deploymentID,
                },
              };
              $.ajax(settings).done(function (response) {
                hideloader()
                if (response != '' && response != null) {
                  if (response.id != '' && response.id != null) {
                    successMsg("Deployments Delete successfully")
                    deploymentDataTable();
                  } else {
                    errorMsg("Something went wrong please try again")
                  }
                } else {
                  errorMsg("Something went wrong please try again")
                }
              });
        }
      })
});


$(document).on('click', '.editDeployment', function () {
    $('#deploymentModal').modal('show');
    $('.modal-title').html('Update deployment');
    $('#addNewDeploymentBtn').html('Update');

    // var urlbase = API_PREFIX;
    var deploymentID = $(this).data("id");
    showloader();
    $.ajax({
      url: BASE_URL + '/' + ADMIN + '/deployment/edit',
      type: 'post',
      data: {
        "_token": $("[name='_token']").val(),
        "urlbase": API_PREFIX,
        "deploymentID":deploymentID,
      },
      success: function (response) {
        var data = JSON.parse(response);
        if (data.status == 1) {
          var result = data.deploymentsEditData;
          var cluster_topology = result.resources.elasticsearch[0].info.plan_info.current.plan.cluster_topology;
          var elasticsearch = '';
              cluster_topology.forEach(function(index) {
                  if(index.size.value != 0){
                    elasticsearch = index;
                  }
              });
          var sizePerZoneElastic = elasticsearch.size.value;
          var availabilityZonesElastic = elasticsearch.zone_count;
          $('#deploymentHdnID').val(result.id);
          $('#deploymentName').val(result.name);
          $('#'+availabilityZonesElastic+'zoneElastic')[0].checked = true;
          $('select[name="sizePerZoneElastic"]').val(sizePerZoneElastic).trigger("change");

          var sizePerZoneKibana = result.resources.kibana[0].info.plan_info.current.plan.cluster_topology[0].size.value;
          var availabilityZonesKibana = result.resources.kibana[0].info.plan_info.current.plan.cluster_topology[0].zone_count;
          $('#'+availabilityZonesKibana+'zoneKibana')[0].checked = true;
          $('select[name="sizePerZoneKibana"]').val(sizePerZoneKibana).trigger("change");

          var sizePerZoneApm = result.resources.apm[0].info.plan_info.current.plan.cluster_topology[0].size.value;
          var availabilityZonesApm = result.resources.apm[0].info.plan_info.current.plan.cluster_topology[0].zone_count;
          $('#'+availabilityZonesApm+'zoneApm')[0].checked = true;
          $('select[name="sizePerZoneApm"]').val(sizePerZoneApm).trigger("change");
          hideloader();
        }
        hideloader();
      }
    });
});

$(document).on('click', '.viewDeployment', function () {
  var deploymentID = $(this).data("id");
  showloader();
  $.ajax({
    url: BASE_URL + '/' + ADMIN + '/deployment/edit',
    type: 'post',
    data: {
      "_token": $("[name='_token']").val(),
      "urlbase": API_PREFIX,
      "deploymentID":deploymentID,
    },
    success: function (response) {
      var data = JSON.parse(response);
      if (data.status == 1) {
        var result = data.deploymentsEditData;
        if(result.healthy == 1){
          var cluster_id_elasticsearch = result.resources.elasticsearch[0].info.cluster_id;
          var cluster_name_elasticsearch = result.resources.elasticsearch[0].info.cluster_name;
          var status_elasticsearch = result.resources.elasticsearch[0].info.status;

          var cluster_id_kibana = result.resources.kibana[0].info.cluster_id;
          var cluster_name_kibana = result.resources.kibana[0].info.cluster_name;
          var status_kibana = result.resources.kibana[0].info.status;

          var cluster_id_apm = result.resources.apm[0].info.id;
          var cluster_name_apm = result.resources.apm[0].info.name;
          var status_apm = result.resources.apm[0].info.status;
        }
        $('#clusterIdElasticSearch').html((cluster_id_elasticsearch) ? cluster_id_elasticsearch : 'Deployment status is pending now');
        $('#clusterNameElasticSearch').html((cluster_name_elasticsearch) ? cluster_name_elasticsearch : '-');
        $('#statusElasticSearch').html((status_elasticsearch) ? status_elasticsearch : '-');

        $('#clusterIdKibana').html((cluster_id_kibana) ? cluster_id_kibana : 'Deployment status is pending now');
        $('#clusterNameKibana').html((cluster_name_kibana) ? cluster_name_kibana : '-');
        $('#statusKibana').html((status_kibana) ? status_kibana : '-');

        $('#clusterIdApn').html((cluster_id_apm) ? cluster_id_apm : 'Deployment status is pending now');
        $('#clusterNameApn').html((cluster_name_apm) ? cluster_name_apm : '-');
        $('#statusApn').html((status_apm) ? status_apm : '-');
        hideloader();
        $('#deploymentDataModal').modal('show');
      }
      hideloader();
    }
  });
  

});
