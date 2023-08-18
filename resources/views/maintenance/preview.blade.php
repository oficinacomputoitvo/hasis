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
                Formato para Programa de Mantenimiento Preventivo
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
    <h3 style="text-align:center">Programa de Mantenimiento Preventivo</h3>

</header>
<footer>
    <table class="sinborde">
        <tr>
            <td style="width:25%">{{ $template->code }}</td>
            <td style="width:60%">{{ $template->legendfootercenter }}</td>
            <td style="width:15%; text-align:right;">REV. {{ $template->review}}</td>
        </tr>
    </table>
</footer>


<main>
    <table class="sinborde">
        <tr>
            <td> <strong>Semestre: </strong><u> {{$maintenanceschedule[0]->schoolcycle}} </u> </td>
            <td> <strong>Año: </strong><u> {{$maintenanceschedule[0]->year}} </u> </td>
        </tr>
    </table>
    <br>
    <table>
        <thead>
            <tr>
                <th rowspan="2" class="colnumero">NO.</th>
                <th rowspan="2" style="text-align:center;" >SERVICIO</th>
                <th colspan="2" >TIPO</th>
                <th rowspan="2" class="colmeses">TIEMPO</th>
                <th rowspan="2" class="colmeses">ENE</th>
                <th rowspan="2" class="colmeses">FEB</th>
                <th rowspan="2" class="colmeses">MAR</th>
                <th rowspan="2" class="colmeses">ABR</th>
                <th rowspan="2" class="colmeses">MAY</th>
                <th rowspan="2" class="colmeses">JUN</th>
                <th rowspan="2" class="colmeses">JUL</th>
                <th rowspan="2" class="colmeses">AGO</th>
                <th rowspan="2" class="colmeses">SEP</th>
                <th rowspan="2" class="colmeses">OCT</th>
                <th rowspan="2" class="colmeses">NOV</th>
                <th rowspan="2" class="colmeses">DIC</th>
            </tr>
            <tr>
                <th style="width:20px">I</th><th style="width:20px">E</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $service_id = "";  
                $row = 0;
            @endphp

            @foreach($maintenanceschedule as $ms)

                @php 
                    $tipoI=''; $tipoE=''; 
                    if ($ms->type=="I"){
                        $tipoI='X' ;
                    } else {
                        $tipoE='X' ;
                    }
                @endphp

                <tr>
                    @if ($service_id != $ms->maintenancescheduleservice_id)
                        <td rowspan="3">{{ $ms->number}}</td>
                        <td rowspan="3">{{ $ms->service}}</td>
                        <td rowspan="3">{{ $tipoI }}</td>
                        <td rowspan="3">{{ $tipoE }}</td>
                    @endif 
                    <td style="text-align:center;">{{ $ms->time }}</td>
                    <td>{{ $ms->january }}</td>
                    <td>{{ $ms->february }}</td>
                    <td>{{ $ms->march }}</td>
                    <td>{{ $ms->april }}</td>
                    <td>{{ $ms->may }}</td>
                    <td>{{ $ms->june }}</td>
                    <td>{{ $ms->july }}</td>
                    <td>{{ $ms->august }}</td>
                    <td>{{ $ms->september }}</td>
                    <td>{{ $ms->october }}</td>
                    <td>{{ $ms->november }}</td>
                    <td>{{ $ms->december }}</td>
                    
                </tr>
                @php $service_id = $ms->maintenancescheduleservice_id; $row++; @endphp

            @endforeach
        </tbody>
    </table>
    <br>
    Nota: En la columna de servicio, en caso de requerir mayor espacio anexar información en otra hoja <br>
    <br>

    <table class="sinborde">
        <tr>
            <td> <strong>FECHA DE ELABORACIÓN: </strong><u> {{$maintenanceschedule[0]->dateofpreparation}} </u> </td>
            <td> <strong>ELABORÓ: </strong><u> {{$maintenanceschedule[0]->name}} </u> </td>
        </tr>
        <tr>
            <td>&nbsp;</td><td>&nbsp;</td>
        </tr>
        <tr>
            <td> <strong>FECHA DE APROBACIÓN: </strong><u> {{$maintenanceschedule[0]->dateofapproval}} </u> </td>
            <td> <strong>APROBÓ: </strong><u> {{$maintenanceschedule[0]->whoautorized}} </u> </td>
        </tr>        
    </table>
</main>
<script type="text/php">
    if ( isset($pdf) ) {
        $pdf->page_script('
            $font = $fontMetrics->get_font("Montserrat Bold","bold");
            $pdf->text(542, 100, "Pagina $PAGE_NUM de $PAGE_COUNT", $font, 10);

        ');
    }
</script>

</body>