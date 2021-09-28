$(document).ready(function () {
    
    $('form[id="register_form"]').validate({
        rules: {
          name:'required',
          email: {
            required: true,
            email: true,
            remote: BASE_URL + '/api/auth/checkemail',
          },
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
          email: {
            required:'Email is required',
              email:'Enter a valid email',
              remote: 'That email address is already registered.'
          },
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
                    var data = responce;
                    if (data.status == 201) {
                        $('#name').val('');
                        $('#email').val('');
                        $('#password').val('');        
                        $('#confirm_password').val('');      
                        successMsg('User create Sucessfully')
                    } else if (data.status == 400) {
                        printErrorMsg(data.error)
                    }  else if(data.status == 401){
                      errorMsg(data.error)
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