// $(document).ready(function () {
    
//     $('form[id="forgot_enter_email_form"]').validate({
//         rules: {
//           email: {
//             required: true,
//             email: true,
//             remote: BASE_URL + '/' + ADMIN + '/user/email/exist/ornot?forgot=1',
//           },
//         },
//         messages: {
//           email: {
//             required:'Email is required',
//               email:'Enter a valid email',
//               remote: 'That email address is not registered.'
//           },
//         },
//         submitHandler: function(form) {
//             $.ajax({
//                 url: BASE_URL+'/'+ADMIN+'/forgot/password/send/mail' ,
//                 type: 'post',
//                 data: {
//                     "_token": $("[name='_token']").val(),
//                     "email":$('#email').val(),
//                 },
//                 success: function (responce) { 
//                     var data = responce;
//                     if (data.status == 1) {
//                         $('#email').val('');
//                         successMsg('Your account created sucessfully')
//                     } else if (data.status == 0) {
//                         printErrorMsg(data.error)
//                     } else {
//                       errorMsg(data.error)
//                     }
//                 }
//             });
//         }
//       });
// });

// function printErrorMsg(msg) {
//   $(".print-error-msg").find("ul").html('');
//   $(".print-error-msg").css('display', 'block');
//   $.each(msg, function (key, value) {
//   $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
//   });
// }

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


  