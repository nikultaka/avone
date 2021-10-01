$(document).ready(function () {
    $('form[id="settingForm"]').validate({
        rules: {
          ecApiKey: 'required',
          version: 'required'
        },
        messages: {
          ecApiKey: 'This field is required',
          version: 'This field is required',
        },
        submitHandler: function(form) {
          showloader();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/save/settings',
                type: 'post',
                data: $('#settingForm').serialize(),
                success: function (response) {
                    var data = JSON.parse(response);
                    if(data.status == 1){
                        successMsg(data.msg)
                        hideloader();
                    }else{
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