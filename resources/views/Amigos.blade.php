<div class="modal fade" id="Amigos">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <h4 align="center">Amigos</h4>
                <?php
                require_once("../resources/php/BaseDatos.php");
                $a=new BaseDato();
                $array12=$a->IdJuego($id);
                echo "<p>Tu id es: ".$array12[0]."</p>";
                ?>
            </div>
            <div class="modal-body">
                <div id='TablaAmigosConectados'>
                <?php
                    $a=new BaseDato();
                    $amigos=$a->Amigos($id);

                    if (count($amigos)>0) {
                        echo "<h4>Amigos</h4>";
                        echo "<table class='table' >";
                        echo "<tr><td>Amigos</td><td>Conectados</td></tr>";
                        for ($i=0; $i < count($amigos); $i++) { 
                            echo "<tr align='center'><td>".$amigos[$i]."</td><td>Proximamente</td></tr>";
                        }
                        echo "</table>";
                    }
                ?>
                </div>
                <div id="TablaSolicitudes">
                <?php
                    $a=new BaseDato();
                    $Solicitudes=$a->Solicitudes($id);
                    if (count($Solicitudes)>0) {
                        echo "<h4>Solicitudes</h4>";
                        ?>
                        <?php
                        echo "<table class='table' id='solicitudesN' id='UsuariosEliminados' value=".count($Solicitudes).">";
                        echo "<tr ><td colspan='2' align='center'>Solicitudes</td></tr>";
                        for ($i=0; $i < count($Solicitudes); $i++) { 
                            echo "<tr><td align='center' >".$Solicitudes[$i]."</td>";
                            
                           echo "<td><button type='submit' id='000' onclick='Amigos(\"".$Solicitudes[$i]."\",\"".$id."\")'> Aceptar</button></td></tr>";
                            
                        }
                        
                        echo "</table>";
                        echo "<input type='submit' value='Aceptar'>";
                    }  
                ?>
                </div>
            </div>
            <div class="modal-footer">
                Introduce Id De tu Amigo<input type="text" id="NuevoAmigo">
                <?php
                echo "<button class='btn btn-secondary' onclick='AnadirAmigo(\"".$id."\")'> Agregar Amigo</button>";
                ?>
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>
        </div>
    </div>
</div>