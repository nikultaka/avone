$(document).ready(function () {
    $('form[id="login_form"]').validate({
        rules: {
          email: 'required',
          password: {
            required: true,
            minlength: 6,
          }
        },
        messages: {
          email: 'This field is required',
          password: {
            required:'Password is required',
            minlength: 'Password must be at least 6 characters long'
          }
        },
        submitHandler: function(form) {
            $.ajax({
                url: BASE_URL + '/api/auth/login',
                type: 'post',
                data: $('#login_form').serialize(),
                success: function (responce) {
                    var data = JSON.parse(JSON.stringify(responce))
                    if (data.status != 401 && data.status != 422) {
                        successMsg('Login Successfully')
                        $('#email').val('');
                        $('#password').val('');                
                        document.location.href=""+ BASE_URL + '/' +ADMIN+ "/dashboard";
                    } else if (data.status == 422) {
                        // printErrorMsg(data.error)
                        errorMsg(data.error)
                    }  else if(data.status == 401){
                        errorMsg(data.error)
                    }
                }
            });
        }
      });
});