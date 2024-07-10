@extends('layouts.app')

@section('content')
@if(isset($nombre))
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" >Ajedrez</div>
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

                        <select id="tipos">
                            <option value="" class="multi"></option>
                            <option value="amigos" class="multi">Con Amigos</option>
                            <option value="azar" class="multi">Al azar</option>
                        </select>
                        <br><br>
                        <button id="BoJu">Jugar</button>
                    
                </div>

            </div>
            <div class="card" id="Partida" >
                <div class="card-header">Partida</div>
                
                <div id="Titulo" class="card-body" style="text-align:center;">
                    
                </div>
                <div id="Consejos" class="card-body" style="text-align:center;">
                    
                </div>
                <div id="tablero" class="card-body" style="text-align:center;">
                    <table border='6' width='400' height='400' style='margin: 0 auto;'>
                        <?php
                        for($i=0; $i<8; $i++){
                            echo "<tr>";
                            for($j=0; $j<8; $j++){
                                $color = ($i + $j) % 2 == 0 ? 'white' : 'black';
                                echo "<td id='$i$j' class='$color' onclick='MobimientoAjedrez($i, $j)'>-</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
                <div id="+" class="card-body" style="text-align:center;">
                    
                </div>
            </div>
            <div class="card" id="PartidasIni" >
                <div class="card-header">Partidas Iniciadas</div>
                <div class="card-body" style="text-align:center;">
                    <table id="PartidasTeToca" border='6' width='300' style='margin: 0 auto;'></table>
                </div>
            </div>
            
            

        </div>
    </div>
</div>

@endif
@endsection