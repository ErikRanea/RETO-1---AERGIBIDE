<div class="listaUsers">
    <p>
        LISTA USUARIOS
    </p>
    <?php if (isset($listaUsuarios) && count($listaUsuarios) > 0): ?>
        <ul>
            <?php foreach ($listaUsuarios as $user): ?>
                <?php if ($user->id != $_SESSION["user_data"]["id"] ): ?>
                    <div class="user" id="contenedorUsuario<?php echo $user->id; ?>">
                        <li>
                            <?php echo $user->username; ?>
                            <?php if ($user->rol != "admin" && $user->rol != "gestor" ): ?>
                            <span>
                                <button class="botonEditar" onclick="editarUsuario(<?php echo $user->id; ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16" color="#4DBAD9">
                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/></svg><path d="..."></path></svg>
                                </button>

                                <button class="botonEditar" onclick="deleteUsuario(<?php echo $user->id; ?>)" ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-dash-fill" viewBox="0 0 16 16" color="red">
                                    <path fill-rule="evenodd" d="M11 7.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5"/>
                                    <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/></svg>
                                    </button>
                            </span>
                            <?php endif; ?>
                        </li>
                    </div>
                <?php endif; ?>

            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay usuarios disponibles.</p>
    <?php endif; ?>
</div>
<!--
<script src="assets/js/datosUsuario.js"></script>
-->