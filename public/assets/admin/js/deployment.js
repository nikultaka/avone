$(document).ready(function () {
  $('#addNewDeployment').on('click', function () {
    $('#deploymentModal').modal('show');
  });
  deploymentDataTable();
  $('#addNewDeploymentBtn').on('click', function () {
    const access_token = document.cookie
      .split('; ')
      .find(row => row.startsWith('access_token='))
      .split('=')[1];
    var error = 0;
    var deploymentName = $('#deploymentName').val();

    var sizePerZoneElastic = $('#sizePerZoneElastic').val();
    var availabilityZonesElastic = $('input[name="availabilityZonesElastic"]:checked').val();

    var sizePerZoneKibana = $('#sizePerZoneKibana').val();
    var availabilityZonesKibana = $('input[name="availabilityZonesKibana"]:checked').val();

    var sizePerZoneApm = $('#sizePerZoneApm').val();
    var availabilityZonesApm = $('input[name="availabilityZonesApm"]:checked').val();

    if (deploymentName == '' || deploymentName == null) {
      $('#deploymentName').css('border-color', 'red');
      error++;
    }
    if (error == 0) {
      showloader();
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
    }

  });
});

function printErrorMsg(msg) {
  $(".print-error-msg").find("ul").html('');
  $(".print-error-msg").css('display', 'block');
  $.each(msg, function (key, value) {
    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
  });
}

function deploymentDataTable() {
  var urlbase = API_PREFIX;
  showloader();
  $.ajax({
    url: BASE_URL + '/' + ADMIN + '/deployment/dataTable',
    type: 'get',
    data: {
      "_token": $("[name='_token']").val(),
      "urlbase": urlbase,
    },
    success: function (responce) {
      var data = JSON.parse(responce);
      if (data.status == 1) {
        $('.ajaxResponse').html(data.table);
        hideloader();
      }
      hideloader();
    }
  });
}

$(document).on('click', '.deleteDeployment', function () {

  var deploymentID = $(this).data("id");
  if (deploymentID != '') {
    showloader();
    const access_token = document.cookie
      .split('; ')
      .find(row => row.startsWith('access_token='))
      .split('=')[1];
    var settings = {
      "url": API_PREFIX+"/api/deployment/delete",
      "method": "POST",
      "timeout": 0,
      "headers": {
        "Authorization": "Bearer " + access_token + "",
        "deploymentID": deploymentID
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
  }else{
    errorMsg('Something went wrong please try again')
  }

})
