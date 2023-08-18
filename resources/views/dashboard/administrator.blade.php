@extends('template')
@section('content')

<div class="d-flex text-center align-items-center justify-content-center" >
<div class="container">
    <form id="frmFilter" action="{{ route('dashboards') }}" method="GET">
        <div class="row">
            <div class="col-lg-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Desde: </span>
                    <input class="form-control" type="date" id="initialdate" onkeypress="return false" name="initialdate" value="{{$initialDate}}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="input-group input-group-lg">
                    <span class="input-group-text">Hasta: </span>
                    <input class="form-control" type="date" id="finaldate" onkeypress="return false" name="finaldate" value="{{$finalDate}}">
                </div>
            </div>
        </div>            
    </form>
    <hr>
    <div class="row">
      <div class="col-lg-6" >
        

        <div class="card" style="height: 500px;" >
            <div class="card-header" style="background:#1B396A; color: white">
                <strong>Solicitudes atendidas </strong>
            </div>
          <div class="card-body">
            <div id="serviceGraph">

            </div>
          </div>
        </div>

        <div class="card" style="height: 500px;">
            <div class="card-header" style="background:#1B396A; color: white">
                <strong>Calidad del servicio </strong>
            </div>            
          <div class="card-body">
            <div id="qualityGraph">

            </div>
          </div>
        </div>        

      </div>


      <div class="col-lg-6">

        <div class="card" style="height: 500px;">
            <div class="card-header" style="background:#1B396A; color: white">
                <strong>Condiciones del hardware </strong>
            </div>            
          <div class="card-body">
            <div id="hardwareGraph">

            </div>
          </div>
        </div>
        @if(Session::has('rol'))
            @if(Session::get('rol')<=2)
            <div class="card" >
                <div class="card-header" style="background:#1B396A; color: white">
                    <strong>Nuevas solicitudes </strong>
                </div>            
                <div class="card-body">
                    <div>
                        <i class="fas fa-bell fa-lg" style="color: #1B396A;font-size:90px;padding: 30px 0px;"></i>
                        <span class="position-relative translate-middle badge rounded-pill bg-danger" style="font-size:15px;">
                        {{$totalRequestPending}}
                        </span>
                        <p></p>
                    </div>
                </div>
                <div class="card-footer">
                    @if ($totalRequestPending>0)
                        <a href="/receptionrequests" style="color:#1B396A;"><strong>Revisar las solicitudes</strong></a>
                    @endif
                </div>
            </div>
            @else 
            <div class="card" >
                <div class="card-header" style="background:#1B396A; color: white">
                    <strong>Solicitudes por aprobar </strong>
                </div>            
                <div class="card-body">
                    <div>
                        <i class="fas fa-bell fa-lg" style="color: #1B396A;font-size:90px;padding: 30px 0px;"></i>
                        <span class="position-relative translate-middle badge rounded-pill bg-danger" style="font-size:15px;">
                        {{$totalPendingForApprove}}
                        </span>
                        <p></p>
                    </div>
                </div>
                <div class="card-footer">
                    @if ($totalPendingForApprove>0)
                        <a href="/workorders/listxapprove" style="color:#1B396A;"><strong>Revisar las solicitudes</strong></a>
                    @endif
                </div>
            </div>            
            @endif
        @endif
      </div>

      
    </div>
  </div>

</div>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
// --------------------------------------------------------------------------
    //--- sección de servicios concretados
    const serviceFinished =  JSON.parse(`<?php echo $serviceFinished ?>`);
    let months = [];
    let totals = [];

    serviceFinished.forEach(item =>{ 
        months.push(item.meses);
        totals.push(item.total);
    });
    Highcharts.chart('serviceGraph', {
        title: {
            text: 'Solicitudes atendidas'
        },
         xAxis: {
            categories: months
        },
        yAxis: {
            title: {
                text: 'Numero de solicitudes atendidas'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'Total',
            data: totals
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});

// --------------------------------------------------------------------------
    const qualityOfService =  JSON.parse(`<?php echo $qualityOfService ?>`);
    Highcharts.chart('qualityGraph', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Calidad del servicio'
            },
            tooltip: {
                pointFormat: '<b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Calidad',
                colorByPoint: true,
                data: qualityOfService
            }]
        });
    
//----------------------------------------------------------------------------        
const statusHardware =  JSON.parse(`<?php echo $statusHardware ?>`);
Highcharts.chart('hardwareGraph', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'center',
        text: 'Condiciones del Hardware'
    },
    subtitle: {
        align: 'center',
        text: ''
    },
    accessibility: {
        announceNewData: {
            enabled: true
        }
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total de hardware'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> <br/>'
    },

    series: [
        {
            name: "Condiciones del equipo",
            colorByPoint: true,
            data: statusHardware
           
        }
    ]
});
</script>
@endsection