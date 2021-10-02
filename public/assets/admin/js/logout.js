$(document).ready(function () {
    $(document).on('click', '.adminLogout', function () {
        Swal.fire({
            title: 'Are you sure you want to logout?',
            // text: "Are you sure you want to logout?!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Log out me !'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: BASE_URL + '/' + ADMIN + '/logout',
                    type: 'get',
                    data: {
                      "_token": $("[name='_token']").val(),
                    },
                    success: function (response) {
                        $data = JSON.parse(response);
                        if($data.status = 1){
                            document.location.href=""+ BASE_URL + '/' +ADMIN+ "/login";
                        }
                    }
                })
            }
        })
    })
});
