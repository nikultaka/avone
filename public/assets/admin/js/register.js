$(document).ready(function () {
    
    $('form[id="register_form"]').validate({
        rules: {
          name:'required',
          email: 'required',
          password: {
            required: true,
            minlength: 6,
          },
          confirm_password: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            },
        },
        messages: {
          name: 'Name field is required',
          email: 'Email field is required',
          password: {
            required:'Password is required',
            minlength: 'Password must be at least 6 characters long'
          },
          confirm_password:{
            required:'Confirm password is required',
            minlength: 'Confirm password must be at least 6 characters long',
            equalTo : 'Password and confirm password should be same',
          },
        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/api/auth/register',
                type: 'post',
                data: $('#register_form').serialize(),
                success: function (responce) {
                    var data = JSON.parse(JSON.stringify(responce))
                    if (data.status != 401 && data.status != 422) {
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');                
                    } else if (data.status == 422) {
                        printErrorMsg(data.error)
                    }  else if(data.status == 401){
                        Swal.fire({
                            icon: 'error',
                            title: data.error,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            });
        }
      });
});