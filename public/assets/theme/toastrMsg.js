
function successMsg(msg)
{
    toastr.success(msg);
}

function errorMsg(msg)
{
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
    toastr.warning(msg);
}

function infoMsg(msg)
{
    toastr.info(msg);
}

