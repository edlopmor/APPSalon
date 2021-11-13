<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Reestablecer su contraseña</h1>


<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<?php if($error) return null; ?>
<form class="formulario" method="POST">
    <div class="campo">
    <label for="password">Password</label>    
    <input data-cy="input-password" type="password"
                id="password"
                placeholder="Introduzca su password"
                name="password"/>
    </div>
    <input type="submit" class="boton" value="Guardar nuevo password">
</form>
<div class="acciones">
    <a data-cy="a-login" href="/">¿Ya tiene una cuenta? Inicie sesión</a>
    <a data-cy="a-newAccount" href="/newAccount">¿Aun no tiene una cuenta? Cree una</a>
</div>