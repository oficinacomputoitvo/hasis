<style>
    @import url('https://fonts.cdnfonts.com/css/montserrat');
    body {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        margin-top: 5cm;
        margin-left: 0cm;
        margin-right: 0cm;
        margin-bottom: 2cm;
    }
    header {
        width:100%;
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 5cm;
    }
    footer {
        width:100%;
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        height: 1cm;
    }
    /* Force PDF page breaks between rows, not mid-row */
    .hg-pdf table tr {
        page-break-inside: avoid;
    }

    tr{
        page-break-inside: avoid; 
        page-break-after: auto;
    }
    tr:nth-child(15n){
        page-break-after:always;
    }

    table, th, td {
        border: 1px solid;
        border-collapse: collapse;
        text-align: left;
        width:100%;
    }
    td {
        vertical-align: top;
        text-align: left;
    }
    .sinborde {
        border:none;
    }
    .sinborde td, th {
        border:none;
    }

    .colmeses {
        width:40px;
    }
    .colnumero{
        width: 20px;
    }
    .page-break {
        page-break-before: always;
    }


</style>
<body>
<header>
    <table  width="100%">
        <tr>
            <th  rowspan="3" style="text-align:center; width:20%;"><img src="images/logoitvo.jpg" width="100" heigth="100" alt="logoitvo.jpg"></th>
            <th rowspan="2" style="width:50%;">Nombre de la Información Documentada <br>
                Formato para Orden de Trabajo de Mantenimiento
            </th>
            <th style="width:30%;">Código: {{ $template->code}}</th>
        </tr>
        <tr>
            <th style="width:30%;">Revisión: {{ $template->review}}</th>
        </tr>       
        <tr>
            <th style="width:50%;" >{{ $template->reference}}</th>
            <th style="width:30%;"> 
            </th>
        </tr> 
    </table>
    <h3 style="text-align:center">ORDEN DE TRABAJO DE MANTENIMIENTO</h3>
</header>
<footer>
    <table class="sinborde">
        <tr>
            <td style="width:20%">{{ $template->code }}</td>
            <td style="width:70%">{{ $template->legendfootercenter }}</td>
            <td style="width:10%; text-align:right;">REV. {{ $template->review}}</td>
        </tr>
    </table>
</footer>

@php 
    $dateApproved = "";
    $dateReleased = "";
    if ($executionofservice->dateapproved){
        $dateApproved = Carbon\Carbon::parse($executionofservice->dateapproved)->format('d-m-Y');
    }
    if ($executionofservice->datereleased){
        $dateReleased = Carbon\Carbon::parse($executionofservice->datereleased)->format('d-m-Y');
    }

@endphp
<main>
    <table class="sinborde">
        <tr>
            <td style="width:100%;text-align:right">Número de control: <u><u>&nbsp;&nbsp;&nbsp;&nbsp;{{$executionofservice->folio}}</u></td>
        </tr>
    </table>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th style="border:none">Mantenimiento: </th>
                <th style="border:none">Interno  [&nbsp;@if($executionofservice->internalservice==1)X @endif&nbsp;]</th>
                <th style="border:none">Externo  [&nbsp;@if($executionofservice->internalservice==0)X @endif&nbsp;]</th>
            </tr>
            <tr>
                <th colspan="3">Tipo de servicio: {{$executionofservice->servicetype}}</th>
            </tr>
            <tr>
                <th colspan="3">Asignado a: {{$executionofservice->whoperformedtheservice}}</th>
            </tr>            
        </thead>
    </table>
    <br>
    <table class="table">
        <tbody>
            <tr>
                <td colspan="2">Fecha de realización: {{Carbon\Carbon::parse($executionofservice->dateofservice)->format('d-m-Y')}} </td>
            </tr>
            <tr >
                <td colspan="2" style="height:200px">Trabajo Realizado: <br>
                {{$executionofservice->actions}} <br> <br>
                <table class="sinborde">
                    <tr>
                        <th>Equipo</th> <th>Inventario</th>
                    </tr>
                    @foreach($hardwares as $hardware)
                        <tr>
                            <td>{{$hardware->features}}</td>
                            <td>{{$hardware->inventorynumber}}</td>
                        </tr>
                    @endforeach
                </table>
             </td>
            </tr> 
            <tr>
                <td colspan="2" style="height:200px">Material utilizado: <br> {{$executionofservice->materialsused}} </td>
            </tr>  
            <tr>
                <td  style="height:40px">Verificado y liberado por: <br> {{$executionofservice->requester}} </td>
                <td  style="height:40px">Fecha y Firma <br> {{$dateReleased}}</td>
            </tr>        
            <tr>
                <td  style="height:40px">Aprobado por: <br> {{$executionofservice->approver}} </td>
                <td  style="height:40px">Fecha y Firma <br> {{$dateApproved}}  </td>
            </tr>                                
        </tbody>    
    </table>
    <br>
    C.c.p. Área solicitante
</main>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Montserrat Bold","bold");
            $pdf->text(415, 100, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);

        ');
    }
</script>

</body>