$(document).ready(function () {
    whitelistIpDataTable();
    $('#addWhitelistIp').on('click', function () {
      $('#whitelistIpModal').modal('show');
    });
    $("#whitelistIpModal").on("hidden.bs.modal",function(){
      $('#whitelistIpForm')[0].reset();
      $('.modal-title').html('Add new whitelist Ip');
      $('#addWhitelistIpBtn').html('Add');
    });

    $('form[id="whitelistIpForm"]').validate({
        rules: {
          ipName: 'required',
          status: 'required',
        },
        messages: {
          ipName: 'This field is required',
          status: 'This field is required',
        },
        submitHandler: function(form) {
          showloader();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/whitelist/ip/save',
                type: 'post',
                data: $('#whitelistIpForm').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                      $('#ipName').val('');
                      $('#status').val('');      
                      $('#whitelistIpModal').modal('hide');
                      successMsg(data.msg)
                      hideloader();
                      whitelistIpDataTable();
                    } else if  (data.status == 0) {
                         printErrorMsg(data.msg)
                         hideloader();
                    } else {
                        errorMsg(data.msg)
                        hideloader();
                    }
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
    

  function whitelistIpDataTable() {
    $('#whitelistIpDataTable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,     
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL+'/'+ADMIN+'/whitelist/ip/dataTable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            {data: 'ip_name', name: 'ip_name'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$(document).on('click','.deleteIp',function(){
  var deleteID = $(this).data('id');
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
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/whitelist/ip/delete',
                type: 'POST',
                data: {
                    'id': deleteID,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                          successMsg(data.msg)
                          hideloader();
                          whitelistIpDataTable();
                    } else {
                          errorMsg(data.msg)
                          hideloader();
                    }
                }
            });
        }
    })
});


$(document).on('click','.editIp',function(){
  var deleteID = $(this).data('id');
  $.ajax({
    url: BASE_URL + '/' + ADMIN + '/whitelist/ip/edit',
    type: 'POST',
    data: {
        'id': deleteID,
        "_token": $("[name='_token']").val(),
    },
    success: function (response) {
        $('#addWhitelistIpBtn').html('Update');
        $('.modal-title').html('Update whitelist Ip Data');
        var data = JSON.parse(response);
        if (data.status == 1) {
            var result = data.ipData;
            $('#ipHdnID').val(result._id);
            $('#ipName').val(result.ip_name);
            $('select[name="status"]').val(result.status).trigger("change");
            $('#whitelistIpModal').modal('show');
        }
    }
});

});