$(document).ready(function () {
    userDataTable();
    $('#addNewUser').on('click', function () {
      $('#userModal').modal('show');
    });
    $("#userModal").on("hidden.bs.modal",function(){
      $('#addNewUserForm')[0].reset();
      $("#password").rules("add", "required");
      $("#userEmail").rules("add", "required");
      $('#userEmail').css('cursor', 'text');
      $('#userEmail').prop('readonly',false);
      $('.modal-title').html('Add new user');
      $('#addUserBtn').html('Add');
    });

    $('form[id="addNewUserForm"]').validate({
        rules: {
          userName: 'required',
          userEmail: {
            required: true,
            email: true,
            remote:{
              url: BASE_URL + '/' + ADMIN + '/user/email/exist/ornot',
              type: "get",
              data: { 
                userHdnID: function(){
                      return $('#userHdnID').val();
                  }
              },
            }
          },
          password: {
            required: true,
            minlength: 6,
          },
          is_admin: 'required',
          status: 'required',
        },
        messages: {
          userName: 'This field is required',
          userEmail: {
            required:'Password is required',
            email: 'Enter valid email',
            remote:'That email address is already exist.'
          },
          password: {
            required:'Password is required',
            minlength: 'Password must be at least 6 characters long'
          },
          is_admin: 'This field is required',
          status: 'This field is required',
        },
        submitHandler: function(form) {
          showloader();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/manage/users/save',
                type: 'post',
                data: $('#addNewUserForm').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                      $('#userName').val('');
                      $('#userEmail').val('');
                      $('#password').val('');
                      $('#is_admin').val('');
                      $('#status').val('');      
                      $('#userModal').modal('hide');
                      successMsg(data.msg)
                      hideloader();
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
    

  function userDataTable() {
    $('#userDataTable').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,     
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL+'/'+ADMIN+'/manage/users/dataTable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            {data: '_id', name: '_id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'is_admin', name: 'is_admin'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
}

$(document).on('click','.deleteUser',function(){
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
                url: BASE_URL + '/' + ADMIN + '/manage/users/delete',
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
                          userDataTable();
                    } else {
                          errorMsg(data.msg)
                          hideloader();
                    }
                }
            });
        }
    })
});


$(document).on('click','.editUser',function(){
  var deleteID = $(this).data('id');
  $.ajax({
    url: BASE_URL + '/' + ADMIN + '/manage/users/edit',
    type: 'POST',
    data: {
        'id': deleteID,
        "_token": $("[name='_token']").val(),
    },
    success: function (response) {
        $('#addUserBtn').html('Update');
        $('.modal-title').html('Update User Data');
        $('#password').prop('required',false);
        $('#userEmail').prop('required',false);
        var data = JSON.parse(response);
        if (data.status == 1) {
            var result = data.userData;
            $('#userHdnID').val(result._id);
            var hid = $('#userHdnID').val();
            if(hid != '' && hid != null){
                $("#password").rules("remove", "required");
                $("#userEmail").rules("remove", "required");
            }
            $('#userName').val(result.name);
            $('#userEmail').val(result.email).prop('readonly',true);
            $('#userEmail').css('cursor', 'not-allowed');
            $('#is_admin').val(result.is_admin);
            $('select[name="status"]').val(result.status).trigger("change");
            $('#userModal').modal('show');
        }
    }
});

});