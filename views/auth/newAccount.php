<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Crear cuenta</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Rellene el siguiente formularío para crear una cuenta</p>

<form class="formulario" method="POST" action="/newAccount">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input data-cy="input-nombre" type="text"
               id="nombre"
               name="nombre"
               placeholder="Introduzca su nombre"/>
    </div>
    <div class="campo">
        <label for="apellido">Apellido</label>
        <input data-cy="input-apellido"type="text"
               id="apellido"
               name="apellido"
               placeholder="Introduzca su apellido"/>
    </div>
    <div class="campo">
        <label for="telefono">Telefono</label>
        <input data-cy="input-telefono"type="tel"
               id="telefono"
               name="telefono"
               placeholder="Introduzca su telefono"/>
    </div>
    <div class="campo">
    <label for="email">Email</label>
        <input data-cy="input-email" type="email"
                id="email"
                placeholder="Introduzca su email"
                name="email"/>
    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input data-cy="input-password" type="password"
                id="password"
                placeholder="Introduzca su password"
                name="password"/>
    </div>
    <input data-cy="input-submit" class="boton" type="submit" value="Crear cuenta"/>
</form>

<div class="acciones">
    <a data-cy="a-login" href="/">¿Ya tienes una cuena? Inicie sesión</a>
    <a data-cy="a-retrievePassword" href="/retrievePassword">Olvido su contraseña</a>
</div>