
<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Login</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Inicia sesión con tus datos</p>

<form data-cy="formulario-login" class="formulario-login" method="POST" action="/">
    <div class="campo">
        <label for="email">Email</label>
        <input data-cy="input-email" type="email"
                id="email"
                placeholder="Introduce tu email"
                name="email"
        />
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input data-cy="input-password" type="password"
                id="password"
                placeholder="Introduce tu password"
                name="password"
        />
    </div>
    <input data-cy="input-submit" type="submit" class="boton" value="Iniciar sesión">
</form>
<div class="acciones">
    <a data-cy="a-newAccount" href="/newAccount">¿Aun no tienes una cuenta?</a>
    <a data-cy="a-retrievePassword" href="/retrievePassword">Olvidaste tu contraseña</a>
</div>
