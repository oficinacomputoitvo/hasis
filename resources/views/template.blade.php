<!DOCTYPE html>
<html lang="es">

<head>
<meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Hardware Software Incident Support</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  
  <link href="{{ asset('fontawesome/css/fontawesome.min.css') }}" rel="stylesheet" >
  <link href="{{ asset('fontawesome/css/solid.min.css') }}" rel="stylesheet" >
  <link href="{{ asset('fontawesome/css/regular.min.css') }}" rel="stylesheet" >
  <link href="{{ asset('fontawesome/css/v5-font-face.min.css') }}" rel="stylesheet" >
  
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
  <link href="{{ asset('css/tooltips.css') }}" rel="stylesheet">
  <link href="{{ asset('css/alert.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <!-- ======= Top Bar ======= -->
    <div class="navbar navbar-lefts" >
    <div class="row me-auto "  >
        <div class="col-lg-12 offset-md-2 me-auto">
            <img class="rounded float-left" src="{{ asset('images/logotecnm.png') }}" width="130px" height="50px" />
            <img class="rounded float-right" src="{{ asset('images/logotipoitvo.png') }}" width="250px" height="62px"/>
        </div>
    </div>
    </div>
    <!-- ======= End Top Bar ======= -->  


    <!-- ======= Header ======= -->
    <header id="header" class="d-flex align-items-center  sticky-top">
        <nav id="navbar" class="navbar sticky-top navbar-expand-lg p-3 navbar-dark " >    
            <div class="container-fluid">     
                <button type="button" class="navbar-toggler"  data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>             
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav" >
                        @if (Session::get('menu') ) 
                            {!! html_entity_decode(Session::get('menu'), ENT_QUOTES, 'UTF-8') !!}
                        @endif
                    </div>
                </div>
            </div>  
        </nav>
    </header>
    <!-- End Header -->

    <script src="{{ asset('js/hasis.js') }}"></script>
    <script src="{{ asset('js/alert.js') }}"></script>
    <script>
        function init_tooltip(){
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        
        }
        $(document).ready(function (){
            init_tooltip();
            $(document).ajaxStart(function () {
                $('#wait').show();
            });
            $(document).ajaxStop(function () {
                $('#wait').hide();
            });
            $(document).ajaxError(function () {
                $('#wait').hide();
            });   
            
        });
        			
    </script>

    <div id="wait" style="display: none; width: 100%; height: 100%; top: 100px; left: 0px; position: fixed; z-index: 10000; text-align: center;">
                <img src="{{ asset('images/loading.gif') }}" width="64" heigth="64" alt="Loading..." style="position: fixed; top: 50%; left: 50%;" />
    </div>

    <div class="modal fade" tabindex="-1" 
        data-bs-backdrop="static" 
        data-bs-keyboard="false"
        aria-hidden="true"
        id="alertWindow">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" >
                    <h5>Harware Softwate Incident Support</h5>
					<button type="button" class="btn-close btn-close-white"  data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p id="alert-message"></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="submit" onclick="$('#alertWindow').hide();" data-bs-dismiss="modal">OK</button>
				</div>
			</div>
		</div>
	</div>

    <main>
        @yield('content')  
    </main>

    <!-- ======= Footer ======= -->
    <!--
    <footer class="mt-auto text-align-center" >
        <div>
            <a>Ex-Hda. de Nazareno, Santa Cruz Xoxocotlán, Oaxaca, C.P. 71230</a>
            Conmutador: 951 517 04 44 
            Contacto Email: <a href="mailto:cyd_voaxaca@tecnm.mx "> cyd_voaxaca@tecnm.mx</a>
        </div>
        <div class="copyright">
            Copyright &copy; <strong><span>2023</span></strong>- ITVO
        </div>
    </footer>
    -->
    <!--======= End Footer ======= -->

</body>

</html>