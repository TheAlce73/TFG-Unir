<html>
<head></head>
<body>
<div class="modal fade" id="LPartidaTres">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
               <h4 align="center">Partidas Tres Raya</h4>
            </div> 
            <div class="modal-body" id="PartidasTotales">
              <?php
                require_once( "BaseDatos.php");
                $a=new BaseDato();
                $datos=$a->PartidasTres();

                echo "<table class='table'>";
                for ($i=0; $i < count($datos["id"]) ; $i++) { 
                    echo "<tr>";
                    echo "<td>".$datos["nombres1"][$i]." vs ".$datos["nombres2"][$i]."<td>";
                     echo "<td>".$datos["tablero"][$i]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
              ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>