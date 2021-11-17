<h1 data-cy="heading-nombre-pagina" 
    class="nombre-pagina">Crear nueva cita</h1>
<p  data-cy="heading-descripcion-pagina" 
    class="descripcion-pagina">Elige tus servicios y coloque sus datos</p>

<div id="app">
    <nav class="tabs">
        <!--Puedes crear tus propios atributos agregando data- -->
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Sus datos y cita</h2>
        <p class="text-center">Coloque sus datos y fecha de su cita</p>
        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                      id="nombre"
                      type="text"
                      placeholder="Su nombre"
                      value="<?php echo $nombre;  ?>"
                      disabled
                      />
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input 
                      id="fecha"
                      type="date"
                      min="<?php echo date('Y-m-d',strtotime(('+1 day')));?>"
                      />
            </div>
            
            <div class="campo">
                <label for="hora">hora</label>
                <input 
                      id="hora"
                      type="time"
                      />
            </div>
            <input type="hidden" id="id" value="<?php echo $id?>">
        </form>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que su información se correcta</p>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>    
<?php 
    $script = "
        <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
    ";
    ?>