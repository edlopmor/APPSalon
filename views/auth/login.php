
<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Login</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Inicia sesión con tus datos</p>
<?php include_once __DIR__ . '/../templates/alertas.php'; ?>
<form data-cy="formulario-login" class="formulario-login" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input data-cy="input-email" type="email"
                id="email"
                placeholder="Introduzca su email"
                name="email"               
                value="<?php echo sanear($auth->email); ?>"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input data-cy="input-password" type="password"
                id="password"
                placeholder="Introduzca su contraseña"
                name="password"
        />
    </div>
    <input data-cy="input-submit" type="submit" class="boton" value="Iniciar sesión">
</form>
<div class="acciones">
    <a data-cy="a-newAccount" href="/newAccount">¿Aun no tiene una cuenta?</a>
    <a data-cy="a-lostPassword" href="/lostPassword">Olvido su contraseña</a>
</div>
