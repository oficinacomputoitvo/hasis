let folio=0;
let isAlreadyStored=true;

let maintenancescheduleDefault= (folio) => JSON.parse(`
        {
            "maintenancescheduleservice_id": 0,
            "number": ${folio},
            "maintenanceschedule_id": 0,
            "service": "",
            "type": "I",
            "maintenancescheduleservicedetail": [
                {
                    "maintenancescheduleservicedetail_id": 0,
                    "maintenancescheduleservice_id": 0,
                    "time": "P",
                    "january": "",
                    "february": "",
                    "march": "",
                    "april": "",
                    "may": "",
                    "june": "",
                    "july": "",
                    "august": "",
                    "september": "",
                    "october": "",
                    "november": "",
                    "december": "",
                    "comments": ""
                },
                {
                    "maintenancescheduleservicedetail_id": 0,
                    "maintenancescheduleservice_id": 0,
                    "time": "R",
                    "january": "",
                    "february": "",
                    "march": "",
                    "april": "",
                    "may": "",
                    "june": "",
                    "july": "",
                    "august": "",
                    "september": "",
                    "october": "",
                    "november": "",
                    "december": "",
                    "comments": ""
                },
                {
                    "maintenancescheduleservicedetail_id": 0,
                    "maintenancescheduleservice_id": 0,
                    "time": "O",
                    "january": "",
                    "february": "",
                    "march": "",
                    "april": "",
                    "may": "",
                    "june": "",
                    "july": "",
                    "august": "",
                    "september": "",
                    "october": "",
                    "november": "",
                    "december": "",
                    "comments": ""
                }
            ]
        }
`);

$("#btnPreview").hide();
$("#addRow").hide();

$("#saveSchedule").click(function (){
    if ( $("#whoelaborated").val()==null){
        alert("Es necesario agregar previamente el usuario administrador o colaborador");
        return;
    }
    if ($("#schoolcycle").val().trim().length===0 || ($("#year").val()+ "").trim().length!=4 )
    {
        alert("Es necesario indicar el ciclo escolar, la persona que elabora el documento y el año debe ser de 4 digitos");
        return;
    }

    $.ajax({
            url: '/api/maintenances/save',
            method: 'POST',
            dataType: 'json',
            data:{"schoolcycle":$("#schoolcycle").val(), "year":$("#year").val(),
                    "whoelaborated": "" +  $("#whoelaborated").val(),
                    "dateofpreparation": "" +  $("#dateofpreparation").val(),
                    "whoautorized":""+ $("#whoautorized").val(),
                    "dateofapproval":"" + $("#dateofapproval").val()
            },
            success: function(response) {
                
                if (response.success){
                    $("#maintenanceschedule_id").val(response.data[0].maintenanceschedule_id);
                    $("#dateofpreparation").val(response.data[0].dateofpreparation.slice(0,10));
                    $("#whoelaborated").val(response.data[0].whoelaborated);
                    $("#whoautorized").val(response.data[0].whoautorized);
                    if (response.data[0].dateofapproval !== null && response.data[0].dateofapproval !== undefined)
                        $("#dateofapproval").val(response.data[0].dateofapproval.slice(0,10));
                  
                    let total=0;
                    $("#tblMaintenance").find("tr:gt(0)").remove();
                    $.each(response.data[0].maintenancescheduleservice, function( key, obj ) {
                        addRow(obj);
                        total++;
                        $("#btnPreview").show();   
                    });
                    if (total<=0){
                        isAlreadyStored=false;
                        folio=1;
                        addRow(maintenancescheduleDefault(folio));
                    }
                    $("#addRow").show();
                } else {
                    alert (JSON.stringify(response.data[0]));
                }
                
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
    });
});

$("#addRow").click(function (){
    if (isAlreadyStored){
        folio++;
        addRow(maintenancescheduleDefault(folio));
        isAlreadyStored=false;
    }else {
        alert("Es necesario guardar los datos anteriores");
    }
    
});


$("#tblMaintenance").on('click','.btnSave',function(){
    let currentRow=$(this).closest("tr"); 
    let rowForRealExecution = currentRow.next('tr');
    let rowForReprogrammer= rowForRealExecution.next('tr');

    let maintenancescheduleservice_id = currentRow.find("td:eq(0)").text(); 
    let number = currentRow.find("td:eq(1)").text(); 
    let service = currentRow.find(".service").val(); 
    let serviceType = currentRow.find(".type-service:checked").val(); 

    //--validate data
    if (service.length === 0){
        alert("Es necesario indicar el servicio para proceder a guardar los datos "); 
        return;
    }
    let fechaProgramada = currentRow.find(".january_P").val().trim() +  currentRow.find(".february_P").val().trim()   +
        currentRow.find(".march_P").val().trim() +  currentRow.find(".april_P").val().trim()   +
        currentRow.find(".may_P").val().trim() +  currentRow.find(".june_P").val().trim()   +
        currentRow.find(".july_P").val().trim() +  currentRow.find(".august_P").val().trim()   +
        currentRow.find(".september_P").val().trim() +  currentRow.find(".october_P").val().trim()   +
        currentRow.find(".november_P").val().trim() +  currentRow.find(".december_P").val().trim();
    if (fechaProgramada.length===0){
        alert("Es necesario indicar cuando se hará el servicio para proceder a guardar los datos "); 
        return;
    }

    let data=`{"maintenancescheduleservice_id":"${maintenancescheduleservice_id}",` +
        `"number":"${number}",` + 
        `"maintenanceschedule_id":"${$("#maintenanceschedule_id").val()}",` +
        ` "service":"${service}",` + 
        `"type":"${serviceType}",` + 
        '"details":[' + 
        '{"time":"P","january":"' +  currentRow.find(".january_P").val() + '"' + ',' +
        ' "february":"' + currentRow.find(".february_P").val() + '"' + ',' +
        ' "march":"' + currentRow.find(".march_P").val() + '"' + ',' +
        ' "april":"' + currentRow.find(".april_P").val() + '"' + ',' +
        ' "may":"' + currentRow.find(".may_P").val() + '"' + ',' +
        ' "june":"' + currentRow.find(".june_P").val() + '"' + ',' +
        ' "july":"' + currentRow.find(".july_P").val() + '"' + ',' +
        ' "august":"' + currentRow.find(".august_P").val() + '"' + ',' +
        ' "september":"' + currentRow.find(".september_P").val() + '"' + ',' +
        ' "october":"' + currentRow.find(".october_P").val() + '"' + ',' +
        ' "november":"' + currentRow.find(".november_P").val() + '"' + ',' +
        ' "december":"' + currentRow.find(".december_P").val() + '"' + '},' +
        '{"time":"R","january":"' +  rowForRealExecution.find(".january_R").val() + '"' + ',' +
        ' "february":"' + rowForRealExecution.find(".february_R").val() + '"' + ',' +
        ' "march":"' + rowForRealExecution.find(".march_R").val() + '"' + ',' +
        ' "april":"' + rowForRealExecution.find(".april_R").val() + '"' + ',' +
        ' "may":"' + rowForRealExecution.find(".may_R").val() + '"' + ',' +
        ' "june":"' + rowForRealExecution.find(".june_R").val() + '"' + ',' +
        ' "july":"' + rowForRealExecution.find(".july_R").val() + '"' + ',' +
        ' "august":"' + rowForRealExecution.find(".august_R").val() + '"' + ',' +
        ' "september":"' + rowForRealExecution.find(".september_R").val() + '"' + ',' +
        ' "october":"' + rowForRealExecution.find(".october_R").val() + '"' + ',' +
        ' "november":"' + rowForRealExecution.find(".november_R").val() + '"' + ',' +
        ' "december":"' + rowForRealExecution.find(".december_R").val() + '"' + '},' + 
        '{"time":"O","january":"' +  rowForReprogrammer.find(".january_O").val() + '"' + ',' +
        ' "february":"' + rowForReprogrammer.find(".february_O").val() + '"' + ',' +
        ' "march":"' + rowForReprogrammer.find(".march_O").val() + '"' + ',' +
        ' "april":"' + rowForReprogrammer.find(".april_O").val() + '"' + ',' +
        ' "may":"' + rowForReprogrammer.find(".may_O").val() + '"' + ',' +
        ' "june":"' + rowForReprogrammer.find(".june_O").val() + '"' + ',' +
        ' "july":"' + rowForReprogrammer.find(".july_O").val() + '"' + ',' +
        ' "august":"' + rowForReprogrammer.find(".august_O").val() + '"' + ',' +
        ' "september":"' + rowForReprogrammer.find(".september_O").val() + '"' + ',' +
        ' "october":"' + rowForReprogrammer.find(".october_O").val() + '"' + ',' +
        ' "november":"' + rowForReprogrammer.find(".november_O").val() + '"' + ',' +
        ' "december":"' + rowForReprogrammer.find(".december_O").val() + '"' + '}]}' ;                                       
    
    
    $.ajax({
            url: '/api/maintenances/add-service',
            method: 'POST',
            dataType: 'json',
            data:$.parseJSON(data),
            success: function(response) {
                if (response.success){
                    alert (`Servicio ${service} ` + response.message );
                    currentRow.find("td:eq(0)").text(response.data.maintenancescheduleservice_id); 
                    isAlreadyStored=true;
                }
                $("#btnPreview").show();
                $("#addRow").show();
            },
            error: function(xhr, status, error) {
                console.log(error);
            }
    });
    
});



function cellForMonths(maintenancescheduleservicedetail) {
    let tds=`<td><input type="text" value="${maintenancescheduleservicedetail.january}" class="maintenance-data january_${maintenancescheduleservicedetail.time}" maxlength="5" placeholder="00-00" ></td> ` +    
    ` <td><input type="text" value="${maintenancescheduleservicedetail.february}"  class="maintenance-data february_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00" ></td> ` +  
    ` <td><input type="text" value="${maintenancescheduleservicedetail.march}"     class="maintenance-data march_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00" ></td> ` +     
    ` <td><input type="text" value="${maintenancescheduleservicedetail.april}"     class="maintenance-data april_${maintenancescheduleservicedetail.time}"   maxlength="5"  placeholder="00-00" ></td> ` + 
    ` <td><input type="text" value="${maintenancescheduleservicedetail.may}"       class="maintenance-data may_${maintenancescheduleservicedetail.time}"    maxlength="5" placeholder="00-00"></td> ` +        
    ` <td><input type="text" value="${maintenancescheduleservicedetail.june}"      class="maintenance-data june_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00" ></td> ` +   
    ` <td><input type="text" value="${maintenancescheduleservicedetail.july}"      class="maintenance-data july_${maintenancescheduleservicedetail.time}"    maxlength="5" placeholder="00-00"></td> ` +      
    ` <td><input type="text" value="${maintenancescheduleservicedetail.august}"    class="maintenance-data august_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00"></td> ` +  
    ` <td><input type="text" value="${maintenancescheduleservicedetail.september}" class="maintenance-data september_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00" ></td> ` +   
    ` <td><input type="text" value="${maintenancescheduleservicedetail.october}"   class="maintenance-data october_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00"></td> ` +   
    ` <td><input type="text" value="${maintenancescheduleservicedetail.november}"  class="maintenance-data november_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00" ></td> ` +   
    ` <td><input type="text" value="${maintenancescheduleservicedetail.december}"  class="maintenance-data december_${maintenancescheduleservicedetail.time}"   maxlength="5" placeholder="00-00"></td> `;                        
        return tds;
}

function addRow(maintenanceschedule){
    let table = $("#tblMaintenance");
    let checkedI = maintenanceschedule.type=="I"? " checked ":""; 
    let checkedE = maintenanceschedule.type=="E"? " checked ":""; 
    folio = maintenanceschedule.number; 
    const rowTable ='<tr>' + 
        `<td rowspan='3' style='display:none;'>${maintenanceschedule.maintenancescheduleservice_id}</td>` +
        `<td rowspan="3" class="align-middle">${maintenanceschedule.number}</td> ` + 
        `<td rowspan="3"><textarea name="service" class="service" rows="5">${maintenanceschedule.service}</textarea></td> ` + 
        '<td rowspan="3" class="align-middle">  ' + 
        '<input type="radio" class="form-check-input type-service" ' + 
        `" name="optradioType${maintenanceschedule.number}" value="I" ${checkedI} >I ` + 
        '<input type="radio" class="form-check-input type-service" ' + 
        ` " name="optradioType${maintenanceschedule.number}" value="E" ${checkedE} >E ` + 
        ' </td> ' +   
        ' <td>P</td> ' + cellForMonths(maintenanceschedule.maintenancescheduleservicedetail[0] ) + 
        '<td rowspan="3" class="align-middle">' +
        '<button type="button" class="btn btnSave" data-bs-toggle="tooltip"  data-bs-placement="left" data-bs-original-title="guardar o actualizar el servicio" aria-label="guardar o actualizar el servicio"  data-bs-custom-class="color-tooltip">' +
        '<i class="fa-solid fa-floppy-disk fa-2xl" style="color:#1B396A;"></i> </button>  </td>' + 
        '</tr>' +
        '<tr>' +
        '<td>R</td>' + 
            cellForMonths(maintenanceschedule.maintenancescheduleservicedetail[1]) +
        '</tr>' +
        '<tr>' +
        '<td>O</td>' + 
            cellForMonths(maintenanceschedule.maintenancescheduleservicedetail[2]) +
        '</tr>';

        $("#tblMaintenance tbody").append(rowTable);
}