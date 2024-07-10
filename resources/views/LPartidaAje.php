<div class="modal fade" id="LPartidaAje">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
               <h4 align="center">Partidas Ajedrez</h4>
            </div> 
            <div class="modal-body" id="PartidasTotales1">
              <?php
                require_once( "../resources/php/BaseDatos.php");
                $a=new BaseDato();
                $datos=$a->PartidasAje();

                echo "<table class='table'>";
                for ($i=0; $i < count($datos["id"]) ; $i++) { 
                    echo "<tr>";
                    echo "<td>".$datos["nombres1"][$i]." vs ".$datos["nombres2"][$i]."<td>";
                    echo "<td><button class='btn btn-danger' onclick=EliminarPA(\"".$datos["id"][$i]."\")>Eliminar</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
              ?>
            </div>
            <div class="modal-footer">
                <a href="../resources/php/ListadoAjedrez.php"><button class='btn btn-primary'> Descargar Pdf</button></a>
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>
        </div>
    </div>
</div>