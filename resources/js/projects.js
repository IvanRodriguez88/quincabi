$(function () {
    $("#client_id").on("change", function(){
        $.ajax({
            url: `${getBaseUrl()}/projects/getclientinfo/${$(this).val()}`,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success: function(response) {
                $("#client_info").empty().append(response)
            },error: function(xhr, textStatus, errorThrown) {
                errorMessage(xhr.status, errorThrown)
            }
        });
    })


})