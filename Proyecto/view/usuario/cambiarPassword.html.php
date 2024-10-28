<div class="paginaPassword">
    <div class="formPassword">
        <h1>Cambiar contraseña</h1>
        <br>
        <form action="index.php?controller=usuario&action=updatePassword" method="post" id="UsuarioPassword">
            <table class="estiloTabla">
                <tr>
                    <td>
                        Contraseña actual:
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="actualPassword" id="actualPassword" value="">
                    </td>
                </tr>
                <tr>
                    <td>
                        Nueva contraseña:
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="actualPassword" id="actualPassword" value="">
                    </td>
                </tr>
            </table>
            <br>
            <div>
                <button type="submit" id="guardarPassword" class="diseñoBoton">Guardar</button>
                <button type="submit" id="cancelarPassword" class="diseñoBoton">Cancelar</button>
            </div>
        </form>
    </div>
</div>