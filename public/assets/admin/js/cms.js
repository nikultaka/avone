$(document).ready(function () {
    $('#addNewCms').on('click',function(){
        $('#cmsModal').modal('show');
    });
    $("#title").on("keyup", function () {
        var text = $(this).val();
        var text = text.replace(" ", "-");
        $("#slug").val(text);
    });
    cmslistdata();
    $('form[id="addcmsform"]').validate({
        ignore: [],
        debug: false,
        rules: {
            title: 'required',
            slug:{
                required:true,
                remote:{
                   url: BASE_URL + '/' + ADMIN + '/cms/checkslug',
                   type:'get',
                   data:{
                       hid : $("#hid").val(),
                   }
                }
            },
            description: {
                required: function(){
                    CKEDITOR.instances.description.updateElement();
                },
            },
            // metatitle: 'required',
            // metakeyword: 'required',
            // metadescription: 'required',
        },
        messages: {
          title: 'Title is required',
          slug: {
            // unique: 'Slug Must be unique',
            required:'Supg is required',
            remote:'Slug is Already Exist'

          },
          description: {
            required:"Discription is required",
          },
        //   metatitle: 'Meta title is required',
        //   metakeyword: 'Meta keyword is required',
        //   metadescription: 'Meta description is required.',
        },
        
        submitHandler: function(form) {
            for (var i in CKEDITOR.instances) {
                CKEDITOR.instances[i].updateElement();
            };
            $.ajax({
                url: BASE_URL + '/' + ADMIN + '/cms/add',
                type: 'post',
                data: $('#addcmsform').serialize(),
                success: function (responce) {
                    var data = JSON.parse(responce);
                    if (data.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            window.location = BASE_URL + '/' + ADMIN + '/cms/list';
                        });
                        $('#hid').val('');
                        $('#title').val('');
                        $('#slug').val('');
                        // $('#description').val('');
                        $('#metatitle').val('');
                        $('#metakeyword').val('');
                        $('#metadescription').val('');
                        $('#status').val('');
                        $("#addcmsform").removeClass("was-validated");
                        $('label[class="error"]').remove();
                        $('select').removeClass('error');
                        CKEDITOR.instances.description.setData('');
    
                        cmslistdata();
                    } else if (data.status == 0) {
                        printErrorMsg(data.error)
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: data.msg,
                            showConfirmButton: false,
                            timer: 1500
                        })
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

function cmslistdata() {
    var table = $('#cms_list_table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        "bAutoWidth": false,
        "ajax": {
            type: 'POST',
            url: BASE_URL + '/' + ADMIN + '/cms/datatable',
            data: {
                "_token": $("[name='_token']").val(),
            },
        },
        columns: [
            { data: 'title', name: 'title' },
            { data: 'slug', name: 'slug' },
            // { data: 'metatitle', name: 'metatitle' },
            // { data: 'metakeyword', name: 'metakeyword' },
            // { data: 'created_at', name: 'created_at' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
}

function delete_cms(id) {
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
                url: BASE_URL + '/' + ADMIN + '/cms/delete',
                type: 'POST',
                data: {
                    'id': id,
                    "_token": $("[name='_token']").val(),
                },
                success: function (response) {
                    var data = JSON.parse(response);
                    if (data.status == 1) {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'success'
                        )
                    } else {
                        Swal.fire(
                            'Deleted!',
                            data.msg,
                            'error'
                        )
                    }
                    cmslistdata();
                }
            });
        }
    })
}

function edit_cms(id) {
    alert("sd")
    $.ajax({
        url: BASE_URL + '/' + ADMIN + '/cms/edit',
        type: 'POST',
        data: {
            'id': id,
            "_token": $("[name='_token']").val(),
        },
        success: function (response) {
            $('#cmsModal').modal('show');
            $('#addcms').html('Update');
            $('.modal-title').html('Update Cms level');
            var data = JSON.parse(response);
            if (data.status == 1) {
                var result = data.cms;
                console.log(result);
                $('#hid').val(result.id);
                $('#salary').val(result.salary);
                $('#status').val(result.status);
            }
        }
    });
}

