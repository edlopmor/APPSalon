<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Recuperar contraseña</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Reestablezca su password escribiendo su email a continuación</p>

<form class="formulario" action="/retrievePassword" method="POST">
    <div class="campo">
    <input data-cy="input-email" type="email"
                id="email"
                placeholder="Introduzca su email"
                name="email"/>
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>
<div class="acciones">
    <a data-cy="a-login" href="/">¿Ya tienes una cuena? Inicie sesión</a>
    <a data-cy="a-newAccount" href="/newAccount">¿Aun no tienes una cuenta?Cree una</a>
</div>