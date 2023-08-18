@extends('template')
@section('content')

<div class="vh-100 d-flex " style="width:100%; padding: 10px; background-color:white;" >
    <div class="table-responsive"  style="width:100%" >     

		<form action="{{ route('templates.update', $template->template_id) }}"  method="POST"
             enctype="multipart/form-data"   >
             @csrf
             @method('PUT')
            <table class="table table-bordered caption-top" style="width:100%"> 
                <caption>Edición de plantilla para reportes</caption>
                <tr>
                    <td rowspan="3" style="text-align: center; width:200px">
                        <img src="/images/{{$template->logo}}" width="100px" heigth="100px"> <br>
                        <input style="width: 175px"  type="file" name="logo"  accept="image/png, image/jpeg" >
                    </td>
                    <td rowspan="2" style="min-width:500px">
                        Nombre de la información documentada <br>
                        <textarea name="documentname"  readonly style="width:100%"  
                        required >{{ $template->documentname}} </textarea>                       
                    </td>
                    <td>
                        Código: <input type="text" name="code" id="code" oninput="changeCode();" value ="{{$template->code }}">
                    </td>
                </tr>
                <tr>
                    
                    <td>Revisión: <input type="text" name="review" id="review" oninput="changeReview();" value ="{{ $template->review}}"></td>
                </tr>
                <tr>
                    <td><textarea name="reference" required style="width:100%">{{ $template->reference}}</textarea></td>
                    <td>Página x de n</td>
                </tr>

                <tr>
                    <td style="width:100px; border:none">&nbsp;</td>
                    <td style="min-width:500px; border:none">&nbsp;</td>
                    <td style="border:none">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width:100px; border:none">&nbsp;</td>
                    <td style="min-width:500px; border:none">&nbsp;</td>
                    <td style="border:none">&nbsp;</td>
                </tr>
                <tr>
                    <td style="width:100px"><input type="text"  id="codefooter" readonly value="{{ $template->code }}"></td>
                    <td style="min-width:500px"><textarea name="legendfootercenter" style="width:100%">{{ $template->legendfootercenter }}</textarea></td>
                    <td><input type="text" readonly id="reviewfooter" value="REV. {{ $template->review }}"></td>
                </tr>

            </table>
            <div style="text-align:center" >
                <button type="submit" class="submit">Aplicar cambios</button>
            </div>

        </form>
    </div>
</div>
<script>
    function changeCode(){
        $("#codefooter").val($("#code").val());
    }
    function changeReview(){
        $("#reviewfooter").val("REV. " + $("#review").val());
    }
    $(document).ready(function (){

    });
</script>
@endsection
