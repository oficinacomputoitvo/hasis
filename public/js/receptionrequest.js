$("#tblServiceRequest").on('click','.btnSave',function(){
    let currentRow=$(this).closest("tr"); 
    let servicerequest_id = currentRow.find("td:eq(0)").text();
    let probabledateexecution = currentRow.find(".probabledateexecution").val();
    let comment = currentRow.find(".comment").val(); 
    let email = $("#email").val();
    let data=`{"servicerequest_id":"${servicerequest_id}", ` +
        `"email":"${email}", ` +
        `"probabledateexecution":"${probabledateexecution}", ` +
        `"comment":"${comment}"}`; 

    $.ajax({
        url: '/api/receptions/save',
        method: 'POST',
        dataType: 'json',
        data:$.parseJSON(data),
        success: function(response) {
            if (response.success){
                currentRow.find(".btnSave").attr('disabled', true);
                currentRow.find(".probabledateexecution").attr('disabled', true);
                currentRow.find(".comment").attr('disabled', true);
                console.log(response.data);
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
});