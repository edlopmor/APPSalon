let paso=1,pasoInicial=1,pasoFinal=3;const cita={nombre:nombre="",fecha:fecha="",hora:hora="",servicios:servicios=[]};function iniciarApp(){mostrarSeccion(paso),tabs(),botonesPaginador(),paginaSiguiente(),paginaAnterior(),consultarAPI(),nombreCliente(),seleccionarFecha(),seleccionarHora()}function mostrarSeccion(){const e=document.querySelector(".mostrar");e&&e.classList.remove("mostrar");document.querySelector("#paso-"+paso).classList.add("mostrar");const t=document.querySelector(".actual");t&&t.classList.remove("actual");document.querySelector(`[data-paso="${paso}"]`).classList.add("actual")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()}))})}function botonesPaginador(){const e=document.querySelector("#siguiente"),t=document.querySelector("#anterior");1===paso?(t.classList.add("ocultar"),e.classList.remove("ocultar")):3===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar"),mostrarResumen()):(t.classList.remove("ocultar"),e.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=pasoInicial||(paso--,botonesPaginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=pasoFinal||(paso++,botonesPaginador())}))}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:o,precio:a}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=o;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent=` ${a} €`;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{id:t}=e,{servicios:o}=cita,a=document.querySelector(`[data-id-servicio="${t}"]`);o.some(e=>e.id===t)?(cita.servicios=o.filter(e=>e.id!==t),a.classList.remove("seleccionado")):(cita.servicios=[...o,e],a.classList.add("seleccionado"))}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function seleccionarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[6,0].includes(t)?(e.target.value="",mostrarAlerta("Sabados y domingo no abrimos","error",".formulario")):cita.fecha=e.target.value}))}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t>9&&t<14||t>15&&t<20?cita.hora=e.target.value:mostrarAlerta("Fuera de horario laboral","error",".formulario")}))}function mostrarAlerta(e,t,o,a=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.createElement("DIV");c.textContent=e,c.classList.add("alerta"),c.classList.add(t);document.querySelector(o).appendChild(c),a&&setTimeout(()=>{c.remove()},3e3)}function formatearFecha(e){const t=new Date(e),o=t.getDate(),a=t.getMonth(),n=t.getFullYear();return new Date(Date.UTC(n,a,o)).toLocaleDateString("es-ES",{weekday:"long",day:"numeric",month:"long",year:"numeric"})}function mostrarResumen(){const e=document.querySelector(".contenido-resumen"),{nombre:t,fecha:o,hora:a,servicios:n}=cita;for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mostrarAlerta("Faltan datos de servicios, fecha u hora","error",".contenido-resumen",!1);crearHeadingResumen(e),crearContenidoResumenCita(e,cita);let c=0;n.forEach(t=>{const{id:o,precio:a,nombre:n}=t;c+=parseInt(a);const r=document.createElement("DIV");r.classList.add("contenedor-servicio");const i=document.createElement("P");i.textContent=n;const s=document.createElement("DIV");s.innerHTML=`<span> Precio: </span> ${a} €`,r.appendChild(i),r.appendChild(s),e.appendChild(r)});const r=document.createElement("H2");r.innerHTML=`<span> Total: </span> ${c} €`,e.appendChild(r);const i=document.createElement("BUTTON");i.classList.add("boton"),i.textContent="Reservar cita",i.onclick=reservarCita,e.appendChild(i)}async function reservarCita(){(new FormData).append("nombre","Juan");const e=await fetch("http://localhost:3000/api/citas",{method:"POST"});console.log(e)}function crearHeadingResumen(e){const t=document.createElement("H2");t.textContent="Resumen cita",e.appendChild(t)}function crearContenidoResumenCita(e,t){const{nombre:o,fecha:a,hora:n}=t,c=document.createElement("P");c.innerHTML="<span>Nombre : </span>"+o,e.appendChild(c),fechaFormateada=formatearFecha(a);const r=document.createElement("P");r.innerHTML="<span>Fecha : </span>"+fechaFormateada,e.appendChild(r);const i=document.createElement("P");i.innerHTML="<span>Hora : </span>"+n,e.appendChild(i)}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));