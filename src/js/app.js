
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

    nombreCliente();

    seleccionarFecha();
    seleccionarHora();

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
        mostrarResumen();
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
    
}
//Obtiene el nombre del cliente 
function nombreCliente(){
    //obtenes el nombre del input.
    const nombre = document.querySelector('#nombre').value ;
    //Agregarlo a cita
    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector('#fecha');
    inputFecha.addEventListener('input', function (e){
        //Get utcDay retorna los dias del 0 al 6. Siendo el domingo 0 y el sabado 6. 
        const dia = new Date(e.target.value).getUTCDay();
        //Si el dia es 6-domingo o 0sabado
        if( [6, 0].includes(dia) ){
            e.target.value = '';
            mostrarAlerta('Sabados y domingo no abrimos','error','.formulario');        
        }else{
            cita.fecha = e.target.value;
        }   
        
    });
}
//Añade la hora 
function seleccionarHora(){
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function(e){
        const horaCita =e.target.value;
        const hora = horaCita.split(":")[0];
        //TODO Obtener este horario desde administrador.
        if(hora > 9 && hora < 14){
            //Turno de mañana
            cita.hora= e.target.value
        }else if (hora > 15 && hora < 20) {
            //Turno de tarde
            cita.hora= e.target.value
        }else{
            mostrarAlerta('Fuera de horario laboral','error','.formulario')
        }
    })
}
function mostrarAlerta(mensaje, tipo, elemento,desaparece=true){
    const alertaPrevia = document.querySelector('.alerta');
    if(alertaPrevia) {
        alertaPrevia.remove();
    }; 
        //Creamos la alerta   
        const alerta = document.createElement('DIV');
        //Añadimos el mensaje
        alerta.textContent= mensaje;
        //Añadimos la clase 
        alerta.classList.add('alerta') 

        alerta.classList.add(tipo)

        const referencia = document.querySelector(elemento);
        referencia.appendChild(alerta);
        if(desaparece){ 
        setTimeout(()=>{alerta.remove();}
        ,3000);
        }
        
}
//Formatea la fecha, haciendola mas legible para el usuario 
function formatearFecha(fecha){
    const fechaObject = new Date(fecha);
    const dia = fechaObject.getDate();
    const mes = fechaObject.getMonth();  
    const year = fechaObject.getFullYear();

    const fechaUTC = new Date(Date.UTC(year,mes,dia));
    const opciones = { weekday :'long',day:'numeric',month:'long',year:'numeric'}
    const fechaFormateada = fechaUTC.toLocaleDateString('es-ES',opciones);
    return fechaFormateada;
}
//Muestra el resumen de la cita. 
function mostrarResumen(){
    const resumen = document.querySelector('.contenido-resumen');
    //Destructuring al objeto
    const {nombre,fecha,hora,servicios} = cita;
    //Limpiar el contenido de resumen 
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }    
    if( Object.values(cita).includes('') || cita.servicios.length === 0){       
        mostrarAlerta('Faltan datos de servicios, fecha u hora','error','.contenido-resumen',false);
        return;
    }
    //Creamos el heading
    crearHeadingResumen(resumen);       
    //Añadimos en el orden que deseamos que aparezcan los datos.
    crearContenidoResumenCita(resumen,cita); 
    //Variable para calcular el precio total 
    let precioTotal = 0;
    servicios.forEach(servicio =>{  
        //Destructuring al objeto 
        const {id, precio, nombre} = servicio;
        //Sumatorio del precio total 
        precioTotal += parseInt( precio);   

        const contenedorServicio = document.createElement('DIV');
            contenedorServicio.classList.add('contenedor-servicio');
        const textoServicio = document.createElement('P');
            textoServicio.textContent = nombre;      
        const precioServicio = document.createElement('DIV');
            precioServicio.innerHTML = `<span> Precio: </span> ${precio} €`;
            contenedorServicio.appendChild(textoServicio);
            contenedorServicio.appendChild(precioServicio);
        resumen.appendChild(contenedorServicio);
    });
    
    const totalTexto = document.createElement('H2');
    totalTexto.innerHTML = `<span> Total: </span> ${precioTotal} €`;
    resumen.appendChild(totalTexto);   

    //Crear boton
    
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = "Reservar cita";
    botonReservar.onclick = reservarCita;
    
    resumen.appendChild(botonReservar);
    
}
async function reservarCita(){
    const datos = new FormData();
    datos.append('nombre','Juan');
    //Peticion hacia la api 
    const url = 'http://localhost:3000/api/citas';
    const respuesta = await fetch(url ,{
        method: 'POST'
    });
    console.log(respuesta);



    
    
}
function crearHeadingResumen(resumen){
    const headingCita = document.createElement('H2');
        headingCita.textContent = 'Resumen cita';
        resumen.appendChild(headingCita);
}
function crearContenidoResumenCita(resumen,cita){
    const {nombre,fecha,hora} = cita;
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre : </span>${nombre}`;
    resumen.appendChild(nombreCliente);
fechaFormateada = formatearFecha(fecha);
const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha : </span>${fechaFormateada}`;
    resumen.appendChild(fechaCita);
const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora : </span>${hora}`;
    resumen.appendChild(horaCita);
}
