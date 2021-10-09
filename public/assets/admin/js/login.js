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
          showloader();
            $.ajax({
                url: API_PREFIX + '/api/auth/login',
                type: 'post',
                data: $('#login_form').serialize(),
                success: function (responce) {
                    var data = JSON.parse(JSON.stringify(responce))
                    if (data.status != 401 && data.status != 422) {
                        $('#email').val('');
                        $('#password').val('');                
                          // Store token
                          var now = new Date();
                          var expire = new Date();
                              expire.setFullYear(now.getFullYear());
                              expire.setMonth(now.getMonth());
                              expire.setDate(now.getDate()+1);
                              expire.setHours(0);
                              expire.setMinutes(0);
                              if(data.user.status == 1){
                                if(data.user.is_admin == 1){
                                    document.cookie = "access_token="+data.access_token+";expires="+expire.toString()+"";
                                    document.cookie = "userName="+data.user.name+";expires="+expire.toString()+"";
                                    document.cookie = "is_admin="+data.user.is_admin+";expires="+expire.toString()+"";
                                    document.location.href=""+ BASE_URL + '/' +ADMIN+ "/dashboard";
                                }else{
                                    if(data.user.userIP == USER_IP){
                                      document.cookie = "access_token="+data.access_token+";expires="+expire.toString()+"";
                                      document.cookie = "userName="+data.user.name+";expires="+expire.toString()+"";
                                      document.cookie = "is_admin="+data.user.is_admin+";expires="+expire.toString()+"";
                                      document.location.href=""+ BASE_URL + '/' +ADMIN+ "/dashboard";
                                    }else{
                                        errorMsg("You have not authorized to login");  
                                    }
                                }
                              }else{
                                errorMsg("Your account not active");        
                              }
                        hideloader();
                    } else if (data.status == 422) {
                         printErrorMsg(data.error)
                         hideloader();
                    }  else if(data.status == 401){
                        errorMsg(data.error)
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


$('.passwordShow').click(function(){
  if('password' == $('#password').attr('type')){
       $('#password').prop('type', 'text');
       $('#passwordShowIcon').removeClass('fa fa-eye');
       $('#passwordShowIcon').addClass('fa fa-eye-slash');
  }else{
       $('#password').prop('type', 'password');
       $('#passwordShowIcon').removeClass('fa fa-eye-slash');
       $('#passwordShowIcon').addClass('fa fa-eye');
  }
});