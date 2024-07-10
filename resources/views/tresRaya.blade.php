@extends('layouts.app')

@section('content')
@if(isset($nombre))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >Tres En Raya</div>
                <input type="" id="Juego" value='{{$Juego}}' >
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h2>Selecciona un modo de juego:</h2>
                        <input type="" value='{{$id}}' id="idUsr" >

                        <h4> 
                            Multijugador 
                            <input type="radio" id="modoMP" name="modo">
                        </h4>

                        <h4>
                            Un Jugador 
                            <input type="radio" id="modoIA" name="modo"> </h4>
                        <select id="tipos">
                            <option value=""> </option>
                            <option value="facil" class="ia">Facil</option>
                            <option value="medio"class="ia">Medio</option>
                            <option value="imposible" class="ia">Imposible</option>
                            <option value="amigos" class="multi">Con Amigos</option>
                            <option value="azar" class="multi">Al azar</option>
                        </select>
                        <br><br>
                        <div id="Fallo"></div>
                        <button id="BoJu">Jugar</button>
                        <button id="BoActu">Actualizar</button>
                    
                </div>

            </div>
            <div class="card" id="Marcadores" >
                <div class="card-header">Partida</div>
                
                <div id="resultados" class="card-body" style="text-align:center;">
                    
                </div>
                <div id="tablero" class="card-body" style="text-align:center;">
                    <table border='6' width='300' style='margin: 0 auto;'>
                        <?php
                        for($i=0;$i<3;$i++){
                            echo "<tr>";
                            for($j=0;$j<3;$j++){
                                echo "<td id='$i$j' onclick='MarcarCasilla($i,$j)'></td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                <div id="resultadoPartida" class="card-body" style="text-align:center;">
                    
                </div>
            </div>
            <div class="card" id="amigosMios">
                <div class="card-header">Amigos</div>
                
                <div  class="card-body" style="text-align:center;">
                    <table id="PartidaVSAmigo" border='6' width='300' style='margin: 0 auto;'></table>
                </div>
            </div>
            <div class="card" id="PartidasIni" >
                <div class="card-header">Partidas Iniciadas</div>
                <div class="card-body" style="text-align:center;">
                    <table id="PartidasTeToca" border='6' width='300' style='margin: 0 auto;'></table>
                </div>
            </div>
            <div class="card" id="Historial" >
                <div class="card-header">Historial Partidas</div>
                <div class="card-body" style="text-align:center;">
                    <table id="PatidasAcabadas" border='6' width='300' style='margin: 0 auto;'></table>
                </div>
            </div>
            

        </div>
    </div>
</div>

@endif
@endsection