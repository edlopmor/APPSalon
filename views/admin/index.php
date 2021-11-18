<h1 class="nombre-pagina">Panel de administración</h1>
<?php include_once __DIR__ . '/../templates/barra.php' ?>
<h2>Buscar citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input 
                type="date"
                id="fecha"
                name="fecha">
        </div>
    </form>
</div>
<div id = "citas-admin">
    <ul class="citas">
        <?php 
        $idCita = 0;
        
        foreach ( $listaCitas as $key=> $cita):
            
            if($idCita !== $cita->id):
                //Inicia en 0 cada vez que cambia de cita. 
            $precioTotal =0;                                
        ?>    
        <li>
            <p>ID: <span><?php echo $cita->id;?></span></p>
            <p>Hora: <span><?php echo $cita->hora;?></span></p>
            <p>Cliente: <span><?php echo $cita->cliente;?></span></p>
            <p>E-mail: <span><?php echo $cita->email;?></span></p>
            <h3>Servicios</h3>       
            <?php 
            $idCita = $cita->id;
            endif ?>
            
        <?php
          
        ?>        
        </li>  
        <p class="servicio">Servicio: <?php echo $cita->servicio . " " . $cita->precio;?></p>
        <?php
            $precioTotal += $cita->precio;
            $actual = $cita->id;
            //Forma de identificar cual es el ultimo registro
            $proximo = $listaCitas[$key + 1]->id ?? null;
            if(esUltimo($actual,$proximo)) : ?>
                <p class="total">Total : <span> <?php echo $precioTotal?> €<span></p>
            <?php endif ?>
        
        <?php endforeach  ?>
             
    </ul>
     
</div>
