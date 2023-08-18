<!DOCTYPE html>
<html>
    <head>
        <title>Hasis</title>
    </head>
    <body>
        <h1>{{ $mailData['title'] }}</h1>
        <p>
        La solicitud con folio:<strong>{{ $mailData['body']['folio'] }} </strong> </p> 
        se realizó con fecha <strong>{{ $mailData['body']['dateofservice'] }} </strong> 
        <p>Usuario solicitante: <strong>{{ $mailData['body']['requester'] }} </strong> </p> 
        <p>Area: <strong>{{ $mailData['body']['area'] }} </strong> </p> 
        <br/>
        <p>Actividades realizadas: <strong>{{ $mailData['body']['actions'] }} </strong> </p>       
        <p>Materiales utilizados:</p> 
        <p> <strong>{{ $mailData['body']['materialsused'] }} </strong> </p>   
        <br>
        <p><strong>Se le invita a liberar el servicio para concluir el proceso desde la plataforma </strong></p>
        <div style="text-align:center">
            <p> Atentamente </p>

            <strong>{{ $mailData['body']['username'] }}</strong>
        </div>

    </body>
</html>