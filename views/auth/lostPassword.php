<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Olvido su password</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Reestablezca su password escribiendo su email a continuación</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" action="/lostPassword" method="POST">
    <div class="campo">
    <input data-cy="input-email" type="email"
                id="email"
                placeholder="Introduzca su email"
                name="email"/>
    </div>
    <input type="submit" class="boton" value="Enviar instrucciones">
</form>
<div class="acciones">
    <a data-cy="a-login" href="/">¿Ya tiene una cuenta? Inicie sesión</a>
    <a data-cy="a-newAccount" href="/newAccount">¿Aun no tiene una cuenta? Cree una</a>
</div>