
function successMsg(msg)
{
    toastr.options.progressBar = true;
    toastr.success(msg);
}

function errorMsg(msg)
{
    toastr.options.progressBar = true;
    var check = Array.isArray(msg)
    if (check) {
        var msgs = "";
        $.each(msg, function (key, value) {
            msgs += value + '<br/>';
        });
        toastr.error(msgs);
    } else {
        toastr.error(msg);
    }
}

function warningMsg(msg)
{
    toastr.options.progressBar = true;
    toastr.warning(msg);
}

function infoMsg(msg)
{
    toastr.options.progressBar = true;
    var check = Array.isArray(msg)
    if (check) {
        var msgs = "";
        $.each(msg, function (key, value) {
            msgs += value + '<br/>';
        });
        toastr.info(msgs);
    } else {
        toastr.info(msg);
    }
}

function getAccessToken(){
    var accessToken = document.cookie
                        .split('; ')
                        .find(row => row.startsWith('access_token='))
                        .split('=')[1];
     return accessToken;
}
function showloader() {
    $("#loader").css("display", "block !important;");
    $("#loader").show();
}
function hideloader() {
    $("#loader").css("display", "none;");
    $("#loader").hide();
}
