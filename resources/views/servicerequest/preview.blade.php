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

    .sinborde {
        border:none;
    }
    .sinborde td {
        border:none;
    }
    .sinborde th {
        border:none;
    }

  
    .page-break {
        page-break-before: always;
    }

    .min-height {
        min-height: 300px;
    }

</style>

<body>
<header>
    <table>
        <tr>
            <th  rowspan="3" style="text-align:center; width:20%;"><img src="images/logoitvo.jpg" width="100" heigth="100" alt="logoitvo.jpg"></th>
            <th rowspan="2" style="width:50%;">Nombre de la Información Documentada <br>
                Formato para Solicitud de Mantenimiento Correctivo
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
    <h3 style="text-align:center">SOLICITUD DE MANTENIMIENTO CORRECTIVO</h3>

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


<main>
    <div style="float: right;">
        <table>
            <tr>
                <td>Recursos materiales y servicios</td>
                <td></td>
            </tr>
            <tr>
                <td>Mantenimiento de equipo</td>
                <td></td>
            </tr>  
            <tr>
                <td>Cómputo</td>
                <td style="text-align:center;">&nbsp;&nbsp;X&nbsp;&nbsp;</td>
            </tr>      
        </table>
    </div>

    <br><br><br> <br><br>
    <div style="float: right;">
        Folio: <strong><u>&nbsp;&nbsp;&nbsp;&nbsp;{{ $servicerequest->folio}}&nbsp;&nbsp;&nbsp;&nbsp;</u></strong>
    </div>
    <br><br><br>

    <table>
        <tbody>
            <tr>
                <td style="width:30%; height:40px"> <strong>Area solicitante: </strong></td>
                <td style="width:70%; height:40px">  {{$servicerequest->area}} </td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tbody>
            <tr>
                <td colspan="2" style="width:100%;height:40px"> <strong>Nombre y firma del solicitante: </strong> {{$servicerequest->username}} </td>
            </tr>
            <tr>
                <td style="width:30%;height:40px"> <strong>Fecha de elaboración: </strong></td>
                <td style="width:70%;height:40px"> {{ $servicerequest->daterequest }} </td>
            </tr>
            <tr>
                <td colspan="2" style="width:100%;height:40px"> <strong>Descripción del servicio solicitado o falla a reparar:</strong></td>
            </tr>     
            <tr>
                <td colspan="2" style="width:100%; height:300px; text-align:justify; vertical-align: top; "> 
                {{ $servicerequest->description }} <br> <br>
                <table class="sinborde">
                    <tr>
                        <th>Equipo</th>
                        <th>Inventario</th>
                    </tr>
                    @foreach($hardwaresrepaired as $hardwareRepaired)
                        <tr>
                            <td>{{$hardwareRepaired->features}}</td>
                            <td>{{$hardwareRepaired->inventorynumber}} </td>
                        </tr>
                    @endforeach
                </table>

                
              </td>
            </tr> 
        </tbody>      
    </table>
    <br> <br>
    c.c.p. Departamento de Planeación, Programación y Presupuestación <br>
    c.c.p. Área solicitante
</main>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Montserrat Bold","bold");
            $pdf->text(416, 100, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);

        ');
    }
</script>

</body>