<div class="modal fade" id="LUsuarios">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
               <h4 align="center">Usuarios</h4>
            </div> 
            <div class="modal-body" id="UsuariosTotales">
              <?php
                require_once( "../resources/php/BaseDatos.php");
                $a=new BaseDato();
                $usuarios=$a->UsuariosT();
                echo "<table class='table'>";
                for ($i=0; $i < count($usuarios["nombres"]) ; $i++) { 
                    echo "<tr>";
                    echo "<td>".$usuarios["nombres"][$i]."<td>";
                    echo "<td><button class='btn btn-danger' onclick=Eliminar(\"".$usuarios["id"][$i]."\")>Eliminar</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
              ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="close" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>
        </div>
    </div>
</div>