// $(document).ready(function () {



// });

function validation(rowNo) {
    var error = 0;
    if ($('#title_' + rowNo).val() == '' || $('#title_' + rowNo).val() == null) {
        $("#title_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#networkAssessmentFindings_' + rowNo).val() == '' || $('#networkAssessmentFindings_' + rowNo).val() == null) {
        $("#networkAssessmentFindings_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#severity_' + rowNo).val() == '' || $('#severity_' + rowNo).val() == null) {
        $("#severity_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#cve_cwe_' + rowNo).val() == '' || $('#cve_cwe_' + rowNo).val() == null) {
        $("#cve_cwe_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#cvss3_' + rowNo).val() == '' || $('#cvss3_' + rowNo).val() == null) {
        $("#cvss3_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#description_' + rowNo).val() == '' || $('#description_' + rowNo).val() == null) {
        $("#description_" + rowNo).css("border", "2px solid red");
        error++;
    } if ($('#buisnessImpact_' + rowNo).val() == '' || $('#buisnessImpact_' + rowNo).val() == null) {
        $("#buisnessImpact_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#publishedExploit_' + rowNo).val() == '' || $('#publishedExploit_' + rowNo).val() == null) {
        $("#publishedExploit_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#recommendation_' + rowNo).val() == '' || $('#recommendation_' + rowNo).val() == null) {
        $("#recommendation_" + rowNo).css("border", "2px solid red");
        error++;
    }
    if ($('#monitorYourThreat_' + rowNo).val() == '' || $('#monitorYourThreat_' + rowNo).val() == null) {
        $("#monitorYourThreat_" + rowNo).css("border", "2px solid red");
        error++;
    }
    return error;
}



$(document).on('click', '.saveRowBtn', function () {
    var rowNo = $(this).data('id');
    if (validation(rowNo) == 0) {
        showloader();
        $.ajax({
            url: BASE_URL + '/' + ADMIN + '/userDashboard/save',
            type: 'post',
            data: {
                'userId': $('#userIdHdn').val(),
                'recordId': $('#recordIdHdn').val(),
                'title': $('#title_' + rowNo).val(),
                'networkAssessmentFindings': $('#networkAssessmentFindings_' + rowNo).val(),
                'severity': $('#severity_' + rowNo).val(),
                'cve_cwe': $('#cve_cwe_' + rowNo).val(),
                'cvss3': $('#cvss3_' + rowNo).val(),
                'description': $('#description_' + rowNo).val(),
                'buisnessImpact': $('#buisnessImpact_' + rowNo).val(),
                'publishedExploit': $('#publishedExploit_' + rowNo).val(),
                'recommendation': $('#recommendation_' + rowNo).val(),
                'monitorYourThreat': $('#monitorYourThreat_' + rowNo).val(),
                "_token": $("[name='_token']").val(),
            },
            success: function (responce) {
                var data = JSON.parse(responce);
                if (data.status == 1) {
                    $("#dashboardMainDiv").load("" + $('#userIdHdn').val() + " .userDashboardTable", function () {
                        $('.saveRowData').hide();
                    });
                    // $('.form-control').attr('readonly', true);
                    successMsg(data.msg)
                    hideloader();
                } else {
                    errorMsg(data.msg)
                    hideloader();
                }
            }
        });
    }
})


$(document).on('click', '.deleteRowData', function () {
    var delId = $(this).data('deleteid');
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
            showloader();
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/userDashboard/delete',
                type: 'POST',
                data: {
                    'id': delId,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        $("#dashboardMainDiv").load("" + $('#userIdHdn').val() + " .userDashboardTable", function () {
                            $('.saveRowData').hide();
                        });
                        successMsg(data.msg)
                        hideloader();
                    } else {
                        errorMsg(data.msg)
                        hideloader();
                    }
                }
            });
        }
    })
});


$(document).on('click', '.editRowData', function () {
    var rowNo = $(this).data('id');
    $('#recordIdHdn').val($(this).data('editid'));
    $('.row_' + rowNo).attr('readonly', false);
    $('#title_' + rowNo).css('background-color', '');
    $('.editBtn_' + rowNo).hide();
    $('.saveBtn_' + rowNo).show();
});


$('#addNewRow').on('click', function () {
    var lastRow = parseInt($('#lastRow').val())+1
    if (validation($('#lastRow').val()) == 0) {
    $('.userDashboardTbody').append(`<tr> <td colspan="10">
            <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="title_`+lastRow+`" name="title_`+lastRow+`"  placeholder="Title">
            </div> </td> </tr>
    <tr>
        <td>
            <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="networkAssessmentFindings_`+lastRow+`" name="networkAssessmentFindings_`+lastRow+`" placeholder="Network Assessment Findings">
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="severity_`+lastRow+`" name="severity_`+lastRow+`" placeholder="Severity">
            </div>
        </td>
        <td>
             <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="cve_cwe_`+lastRow+`" name="cve_cwe_`+lastRow+`" placeholder="CVE/CWE">
            </div>
        </td>
        <td>
             <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="cvss3_`+lastRow+`" name="cvss3_`+lastRow+`" placeholder="CVSS3">
            </div>
        </td>
        <td>
             <div class="form-group">
                <textarea class="form-control row_`+lastRow+`" id="description_`+lastRow+`" name="description_`+lastRow+`" rows="3"></textarea>
            </div>
        </td>
        <td>
             <div class="form-group">
                <textarea class="form-control row_`+lastRow+`" id="buisnessImpact_`+lastRow+`" name="buisnessImpact_`+lastRow+`" rows="3"></textarea>
            </div>
        </td>
        <td>
             <div class="form-group">
                <input type="text" class="form-control row_`+lastRow+`" id="publishedExploit_`+lastRow+`" name="publishedExploit_`+lastRow+`" placeholder="Published Exploit">
            </div>
        </td>
        <td>
             <div class="form-group">
                <textarea class="form-control row_`+lastRow+`" id="recommendation_`+lastRow+`" name="recommendation_`+lastRow+`" rows="3"></textarea>
            </div>
        </td>
        <td>
             <div class="form-group">
                <textarea class="form-control row_`+lastRow+`" id="monitorYourThreat_`+lastRow+`" name="monitorYourThreat_`+lastRow+`" rows="3"></textarea>
            </div>
        </td>
        <td>
            <div style="display:flex;">
                <button type="button" class="btn btn-success btn-sm saveRowBtn row_`+lastRow+`" data-id="`+lastRow+`" style="border-radius:50%"><i class="fas fa-save"></i></button>
            </div>
       </td>
    </tr>`)
    $('#lastRow').val(lastRow)
    }
});