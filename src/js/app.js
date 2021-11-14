
//Para cargar servicios como primera opcion
let paso = 1;
//Identificados el final y el inicial 
let pasoInicial = 1;
let pasoFinal = 3;
const cita = {
    nombre='',
    fecha='',
    hora='',
    servicios = []
}
document.addEventListener("DOMContentLoaded", function(){
    iniciarApp();

});

function iniciarApp(){
    mostrarSeccion(paso);
    //Cambia la seccion reaccionando al evento clik 
    tabs(); 
    //Agrega o quita los botones paginador
    botonesPaginador();
    paginaSiguiente();
    paginaAnterior();
    //Consultar la api en el backend php
    consultarAPI();
}
function mostrarSeccion(){
    //Ocultar la seccion que tenga la clase de mostrar 
    const seccionAnterior = document.querySelector('.mostrar');
    //Comprobamos que haya una seccion anterior para evitar un null pointer exception
    if (seccionAnterior){
        seccionAnterior.classList.remove('mostrar');               
    }
    //Seleccionar la seccion con el paso     
    const seleccion = document.querySelector(`#paso-${paso}`);
    seleccion.classList.add('mostrar');
    //Resaltar el tab actual 
    const tabAnterior = document.querySelector('.actual');
    if(tabAnterior){
        tabAnterior.classList.remove('actual');
    }
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add('actual');
}
function tabs(){
    //Cargamos los botones que se encuentran dentro de la clase tabs
    const botones = document.querySelectorAll('.tabs button');
    
    botones.forEach( boton => {
        boton.addEventListener('click',function(event) {
            paso = parseInt(event.target.dataset.paso)
            mostrarSeccion();

            botonesPaginador();
            
        })
    });
    
}
function botonesPaginador(){
    const buttonPaginaSiguiente = document.querySelector('#siguiente');
    const buttonPaginaAnterior = document.querySelector('#anterior');
    if(paso===1){
        buttonPaginaAnterior.classList.add('ocultar');
        buttonPaginaSiguiente.classList.remove('ocultar');
    }
    else if(paso===3){
        buttonPaginaAnterior.classList.remove('ocultar');
        buttonPaginaSiguiente.classList.add('ocultar');
    }else{
        buttonPaginaAnterior.classList.remove('ocultar');
        buttonPaginaSiguiente.classList.remove('ocultar');
    }
    mostrarSeccion();
}
function paginaAnterior(){
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function(){
        if (paso <= pasoInicial) return;
        paso--;      
        botonesPaginador();
    })
}
function paginaSiguiente(){
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function(){
        if(paso>= pasoFinal) return;
        paso++;
        botonesPaginador();
    })
}
/* Permite que se ejecuten otras funciones mientras esta funcion sigue ejecutandose
await tiene que ir junto a asyn. 
*/
async function consultarAPI(){
    try {
        const url= "http://localhost:3000/api/servicios";
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);

        
    } catch (error) {
        console.log(error);
    }
}
function mostrarServicios(servicios){
    servicios.forEach(servicio => {
        //Destructuring , extra el valor y crea la variable 
        const {id,nombre,precio} = servicio;
        //Scripting , creamos lo que se vera en el html 
        //<p class="nombre-servicio">nombre</p>
        const nombreServicio = document.createElement('P');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent= nombre;
        //<p class="precio-servicio">precio</p>
        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent=` ${precio} €`;
        //<div class="servicio" data-id-servicio="1">
        const servicioDIV = document.createElement('DIV');
        servicioDIV.classList.add('servicio');
        servicioDIV.dataset.idServicio = id;

        servicioDIV.onclick = function(){
            seleccionarServicio(servicio)
        }

        servicioDIV.appendChild(nombreServicio);
        servicioDIV.appendChild(precioServicio);
        //Utilizamos el selector del index.php que hace referencia al div servicios y injectamos el formato anterior 
        document.querySelector('#servicios').appendChild(servicioDIV);
        /* Dejando como resultado la estructura inferior

        <div id="servicios" class="listado-servicios">
            <div class="servicio" data-id-servicio="1">
                <p class="nombre-servicio">Corte de Cabello Mujer</p>
                <p class="precio-servicio"> 90.00 €</p>
            </div>
        </div>  
        */           
    });
}
function seleccionarServicio(servicio){
    //Extrar el id del servicio
    const {id} = servicio;
    //Extraer el array de servicios de cita. 
    const {servicios} = cita; 
    //Utilizar el id de servicio para identificarlo en html 
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
    /*Comprobar si un servicio ya ha sido agregado
    agregado es lo que se encuentra en memoria y servicio es lo que estamos obteniendo
    */ 
    if(servicios.some(agregado => agregado.id === id)){
        //Eliminarlo del array
        cita.servicios = servicios.filter(agregado=> agregado.id!==id)
        //Eliminar la clase en el html 
        divServicio.classList.remove('seleccionado');        
    }else{
        //Tomar una copia del array de servicios , mediante ... y agregarle el servicio. 
        cita.servicios = [...servicios,servicio];
        //Agregar la clase al html 
        divServicio.classList.add('seleccionado');
    }      
    console.log(cita);
}