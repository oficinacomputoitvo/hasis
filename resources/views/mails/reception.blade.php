<!DOCTYPE html>
<html>
    <head>
        <title>Hasis</title>
    </head>
    <body>
        <h1>{{ $mailData['title'] }}</h1>

         Se recibió el documento con fecha: <strong>{{ $mailData['body']['receptiondate'] }} </strong> 
         y folio: <strong>{{ $mailData['body']['folio'] }} </strong> </p> 
        <p>Descripción:</p>
        <strong>{{ $mailData['body']['description'] }} </strong> 
        <br/>
        <p>Usuario solicitante: <strong>{{ $mailData['body']['requester'] }} </strong> </p> 
        <p>Area: <strong>{{ $mailData['body']['area'] }} </strong> </p> 
        <br/>
        <p>Probable fecha de atención: <strong>{{ $mailData['body']['probabledateexecution'] }} </strong> </p>       
        <p>Observaciones:</p> 
        <p> <strong>{{ $mailData['body']['comment'] }} </strong> </p>       
        <div style="text-align:center">
            <p> Atentamente </p>

            <strong>{{ $mailData['body']['username'] }}</strong>
        </div>

    </body>
</html>