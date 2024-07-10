@extends('layouts.app')

@section('content')
@if(isset($nombre))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >Solicitudes De Amistad</div>
                <?php
                    require "../resources/php/BaseDatos.php";
                    $a=new BaseDato();
                    $amigos=$a->Amigos($id);
                    if (count($amigos)>0) {
                        echo "<h4>Amigos</h4>";
                        echo "<table class='table'>";
                        echo "<tr><td>Amigos</td><td>Conectados</td></tr>";
                        for ($i=0; $i < count($amigos); $i++) { 
                            echo "<tr align='center'><td>".$amigos[$i]."</td><td>Proximamente</td></tr>";
                        }
                        echo "</table>";
                    }
                ?>
                 <?php
                    $a=new BaseDato();
                    $Solicitudes=$a->Solicitudes($id);
                    function Amigos($id){
                        $a=new BaseDato();
                        $Solicitudes=$a->SolicitudAceptada($id);  
                    }
                    ?>
                    <form action="" onsubmit="Amigos();return false" method="POST" r>
                    <?php
                    if (count($Solicitudes)>0) {
                        echo "<table width='100%' border='1px' class='card-body' style='text-align:center;'>";
                        echo "<tr ><td colspan='2' align='center'>Solicitudes</td></tr>";
                        for ($i=0; $i < count($Solicitudes); $i++) { 
                            echo "<tr><td align='center' id='00".$i."' value='".$Solicitudes[$i]."'>".$Solicitudes[$i]."</td>";
                            ?>
                            <td><input type="submit" value="Aceptar"></td></tr>
                            <?php
                        }
                        echo "</table>";
                        echo "<input id='Solicitudes' value='".var_dump($Solicitudes)."'>";
                    }     
                ?>
                    </form>
            </div>
            <div class="card" id="Partida" >
            </div>
            
            

        </div>
    </div>
</div>

@endif
@endsection