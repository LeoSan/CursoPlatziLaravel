document.addEventListener('DOMContentLoaded', function() {
    window.cargaSimple = function(e){
        const papa = e.closest('.componente-carga-archivo');
        const identificador = e.dataset.type;
        papa.querySelector('#'+identificador).click();
    }

    window.inputSimple = function(e){
        const papa = e.closest('.componente-carga-archivo');
        const codigo = e.dataset.type;
        const mensajeError = papa.querySelector(`#mensaje_error_simple_${codigo}`);
        mensajeError.style.display = 'none';
        const file = e.files[0];
        var maxSize = 5 * 1024 * 1024; // Tamaño máximo permitido en bytes (5MB en este caso)
        if (file) {
            const extensionesPermitidas = e.accept.split(',').map(ext => ext.trim());
            const nombreArchivo = file.name;
            const extensionArchivo = nombreArchivo.split('.').pop().toLowerCase();
            if ( ! extensionesPermitidas.includes('.' + extensionArchivo)) {
                mensajeError.innerHTML = `El tipo de archivo seleccionado es inválido, únicamente se aceptan archivos ${extensionesPermitidas}.`;
                mensajeError.style.display = 'block';
            } else if(file.size > maxSize){
                e.value = ''; // Limpiar el campo de archivo
                mensajeError.innerHTML = 'El archivo seleccionado excede el tamaño máximo permitido.';
                mensajeError.style.display = 'block';
            } else {
                let required = papa.querySelector(`#${codigo}`).required;
                papa.querySelector(`#simple_${codigo}_nombre`).textContent = file.name;
                papa.querySelector(`#simple_${codigo}_peso`).textContent = formatFileSize(file.size);
                papa.querySelector(`#simple_${codigo}_check`).innerHTML= `
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-success me-2" height="1em" viewBox="0 0 512 512">
                                <style>svg{fill:#05a660}</style>
                                <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                            </svg>`;
                papa.querySelector(`#simple_${codigo}_accion`).innerHTML= `
                            <a href="#!" class="accion-boton-limpiar text-decoration-none" data-type="${codigo}" data-required="${required}" onclick="limpiarSimple(this)">
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                                    <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                    <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"
                                          fill="currentColor" />
                                </svg>
                            </a>`;
            }

        } else {
            papa.querySelector(`#simple_${codigo}_nombre`).textContent = 'Cargar archivo';
            papa.querySelector(`#simple_${codigo}_peso`).textContent = '(Máximo 5 MB)';
            papa.querySelector(`#simple_${codigo}_check`).innerHTML= '';
            papa.querySelector(`#simple_${codigo}_accion`).innerHTML= `
                    <a href="#!" class="accion-boton-carga-simple text-decoration-none" data-type="${codigo}" onclick="cargaSimple(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"
                                  fill="currentColor" />
                        </svg>
                    </a>`;
        }
    }

    window.limpiarSimple = function(e){
        const papa = e.closest('.componente-carga-archivo');
        const codigo = e.dataset.type;
        const inputArchivo = papa.querySelector('#'+codigo);
        inputArchivo.value = null;
        inputArchivo.required = e.dataset.required==='true';
        papa.querySelector(`#simple_${codigo}_nombre`).textContent = 'Cargar archivo';
        papa.querySelector(`#simple_${codigo}_peso`).textContent = '(Máximo 5 MB)';
        papa.querySelector(`#simple_${codigo}_check`).innerHTML= '';
        papa.querySelector(`#simple_${codigo}_accion`).innerHTML= `
                    <a href="#!" class="accion-boton-carga-simple text-decoration-none position-absolute w-100 h-100 start-0 top-0 mt-1" data-type="${codigo}" onclick="cargaSimple(this)">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" class="position-absolute end-0 me-3 top-0 mt-3">
                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M288 109.3V352c0 17.7-14.3 32-32 32s-32-14.3-32-32V109.3l-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352H192c0 35.3 28.7 64 64 64s64-28.7 64-64H448c35.3 0 64 28.7 64 64v32c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V416c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"
                                  fill="currentColor" />
                        </svg>
                    </a>`;
    }

    /* Múltiples */

    const botonCarga = document.querySelectorAll('.accion-boton-carga');

    botonCarga.forEach(function (elemento) {
        elemento.addEventListener('click', function () {
            const codigo = this.dataset.type;

            let archivosContador = document.getElementById(`conteo_archivos_${codigo}`);
            let archivosContadosValor = parseInt(archivosContador.value);

            let archivoinput = document.getElementById(`documentos_archivos_${codigo}_${archivosContadosValor}`);

            archivoinput.click();
        });
    });

    archivoInput();

    function archivoInput() {
        const archivoInput = document.querySelectorAll('.archivo-input');

        archivoInput.forEach(function (elemento) {
            elemento.addEventListener('change', function () {
                const codigo = this.dataset.type;
                const file = elemento.files[0];

                const mensajeError = document.getElementById(`mensaje_error_multiple_${codigo}`);
                mensajeError.style.display = 'none';

                const mensajeSeleccion = document.getElementById(`mensaje_seleccion_multiple_${codigo}`);

                var maxSize = 5 * 1024 * 1024; // Tamaño máximo permitido en bytes (5MB en este caso)

                if (file) {

                    const extensionesPermitidas = elemento.accept.split(',').map(ext => ext.trim());
                    const nombreArchivo = file.name;
                    const extensionArchivo = nombreArchivo.split('.').pop().toLowerCase();
                    if ( ! extensionesPermitidas.includes('.' + extensionArchivo)) {
                        mensajeError.innerHTML = `El tipo de archivo seleccionado es inválido, únicamente se aceptan archivos ${extensionesPermitidas}.`;
                        mensajeError.style.display = 'block';
                    } else if(file.size > maxSize) {
                        elemento.value = ''; // Limpiar el campo de archivo
                        mensajeError.innerHTML = 'El archivo seleccionado excede el tamaño máximo permitido.';
                        mensajeError.style.display = 'block';
                    } else {
                        document.getElementById(`boton_carga_${codigo}`).classList.remove('invalido');
                        document.getElementById(`multiple_${codigo}_nombre`).textContent = file.name;
                        document.getElementById(`multiple_${codigo}_peso`).textContent = formatFileSize(file.size);
                        document.getElementById(`multiple_${codigo}_check`).innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <style>svg{fill:#05a660}</style>
                            <path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/>
                        </svg>`;
                        mensajeError.style.display = 'nome';
                    }

                } else {
                    document.getElementById(`multiple_${codigo}_nombre`).textContent = 'Cargar archivo';
                    document.getElementById(`multiple_${codigo}_peso`).textContent = '(Máximo 5 MB)';
                    document.getElementById(`multiple_${codigo}_check`).innerHTML = '';
                }
            });
        });
    }

    function limpiarElementoCarga(codigo) {
        document.getElementById(`archivo_descripcion_${codigo}`).value = '';
        document.getElementById(`multiple_${codigo}_nombre`).textContent = 'Seleccionar archivo';
        document.getElementById(`multiple_${codigo}_peso`).textContent = '(Máximo 5 MB)';
        document.getElementById(`multiple_${codigo}_check`).innerHTML = '';

    }

    function formatFileSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }


    // Obtener el botón ".accion-boton-nuevo" y la lista "#lista_archivos"
    const botonNuevo = document.querySelectorAll('.accion-boton-nuevo');


    // Función para agregar un nuevo elemento a la lista

    botonNuevo.forEach(function (elemento) {
        elemento.addEventListener('click', function () {
            const codigo = this.dataset.type;
            let errorDescripcionCaracteres = document.getElementById(`mensaje_contador_caracter_${codigo}`);
            errorDescripcionCaracteres.innerHTML = '';
            let archivosContador = document.getElementById(`conteo_archivos_${codigo}`);
            let archivosContadosValor = parseInt(archivosContador.value);
            let archivosAccept = document.getElementById(`accept_archivos_${codigo}`).value;

            let errorSeleccion = document.getElementById(`mensaje_seleccion_multiple_${codigo}`);
            let boton_carga = document.getElementById(`boton_carga_${codigo}`);
            let inputDescripcion = document.getElementById(`archivo_descripcion_${codigo}`);
            let errorDescripcion = document.getElementById(`mensaje_descripcion_archivo_${codigo}`);

            // Obtener el valor de la descripción del archivo
            const descripcion = document.getElementById(`archivo_descripcion_${codigo}`).value;
            const achivoInput = document.getElementById(`documentos_archivos_${codigo}_${archivosContadosValor}`);

            achivoInput.classList.remove('archivo-input');
            const archivoCargado = achivoInput.files[0];

            errorSeleccion.style.display='none';
            boton_carga.classList.remove('invalido');
            errorDescripcion.style.display='none';
            inputDescripcion.classList.remove('invalido');

            if(!archivoCargado){
                errorSeleccion.style.display='block';
                boton_carga.classList.add('invalido');
            }
            if(descripcion.trim() === ''){
                errorDescripcion.style.display='block';
                inputDescripcion.classList.add('invalido');
            }

            if (descripcion.trim() === '' || !archivoCargado) {
                inputDescripcion.focus();
                const seccion_carga_multiple = document.getElementById('seccion_carga_multiple');
                setTimeout(function () {
                   seccion_carga_multiple.scrollIntoView({
                       behavior: "smooth",
                       block: "start",
                   });
              }, 10);
            return;
            }

            const rutaArchivo = URL.createObjectURL(archivoCargado);

            document.getElementById(`documentos_textos_${codigo}_${archivosContadosValor}`).value = descripcion;
            document.getElementById(`documentos_textos_${codigo}_${archivosContadosValor}`).value = descripcion;

            // Crear el nuevo elemento de la lista
            const nuevoElemento = document.createElement('li');
            nuevoElemento.classList.add('documento_item', 'd-flex', 'justify-content-between', 'align-items-center', 'px-3', 'py-2','lista-archivos');
            nuevoElemento.setAttribute('id', `documento_item_${codigo}_${archivosContadosValor}`);
            nuevoElemento.innerHTML = `
                <div>
                  <div class="fw-bold"><u>${descripcion}</u></div>
                  <div class="">
                    <small>${archivoCargado.name}</small>
                    <small class="text-graylight">(${formatFileSize(archivoCargado.size)})</small>
                </div>
                </div>
                <div class="opciones py-1 d-flex flex-row">
                <div>
                  <a href="${rutaArchivo}" target="_blank" class="opcion documento-ver d-flex align-items-center text-gray d-inline pe-4" data-type="${codigo}" data-counter="${archivosContadosValor}">
                    <img src="`+base_url +`/images/icons/icon-eye.svg" class="mx-1 mt-1">
                  </a>
                  </div
                <div>
                  <a href="#!" class="opcion documento-eliminar d-flex align-items-center text-danger d-inline" data-type="${codigo}" data-counter="${archivosContadosValor}">
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                      <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                      <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"
                      fill="currentColor" />
                    </svg>
                  </a>
                  </div>

                </div>
              `;

            document.getElementById(`minimo_${codigo}`).value=archivosContador.value;
            // Aumentar valor de formulario
            archivosContador.value = archivosContadosValor + 1;
            archivosContadosValor = archivosContadosValor + 1;

            // Crear nuevo elemento con inputs guardables
            const nuevosInputs = document.createElement('div');
            nuevosInputs.setAttribute('id', `archivo_item_${codigo}_${archivosContadosValor}`);
            nuevosInputs.classList.add('archivo-item');
            nuevosInputs.innerHTML= `
                <input type="file" class="archivo-input" data-type="${codigo}"
                        name="documentos_archivos_${codigo}[${archivosContadosValor}]"
                        id="documentos_archivos_${codigo}_${archivosContadosValor}" accept="${archivosAccept}"  />
                <input type="text" name="documentos_textos_${codigo}[${archivosContadosValor}]" id="documentos_textos_${codigo}_${archivosContadosValor}" />`;

            document.getElementById(`archivos_${codigo}`).appendChild(nuevosInputs);

            // Agregar el nuevo elemento a la lista
            const listaArchivos = document.getElementById(`lista_archivos_${codigo}`);
            listaArchivos.appendChild(nuevoElemento);

            const listadoVacio = document.getElementById(`lista_archivos_vacio_${codigo}`);
            listadoVacio.classList.remove('d-flex');
            listadoVacio.classList.add('d-none');

            limpiarElementoCarga(codigo);
            archivoInput();
            borrarArchivo();
            inputDescripcion.focus();
                const seccion_carga_multiple = document.getElementById('seccion_carga_multiple');
                setTimeout(function () {
                   seccion_carga_multiple.scrollIntoView({
                       behavior: "smooth",
                       block: "start",
                   });
              }, 10);
            return;

        });
    });

    function borrarArchivo() {
        const botonBorrar = document.querySelectorAll('.documento-eliminar');

        botonBorrar.forEach(function (elemento) {
            elemento.addEventListener('click', function () {
                const codigo = this.dataset.type;
                const archivosContadosValor = this.dataset.counter;
                const archivo =

                document.getElementById(`minimo_${codigo}`).value = archivosContadosValor - 1;
                document.getElementById(`archivo_item_${codigo}_${archivosContadosValor}`).remove();
                document.getElementById(`documento_item_${codigo}_${archivosContadosValor}`).remove();

                const elementosCargados = document.querySelectorAll('.documento_item');
                if (!elementosCargados.length) {
                    const listadoVacio = document.getElementById(`lista_archivos_vacio_${codigo}`);
                    listadoVacio.classList.remove('d-none');
                    listadoVacio.classList.add('d-flex');
                }

            });
        });
    }


});
window.eliminarArchivo = function(el,id){
    if(id && parseInt(id)){
        var url = base_url +'/archivos/eliminar';
        var token = document.head.querySelector('meta[name="csrf-token"]');
        axios.post(url, {
            _token: token.content,
            archivo_id: id
        }).catch(e => {
            console.error(e);
        });
    }
    limpiarSimple(el);
}
window.contadorCaracteres = function(e){
    const codigo = e.dataset.type;
    var total=200;
    setTimeout(function(){
    const descripcion = document.getElementById(`archivo_descripcion_${codigo}`).value;
    let errorDescripcion = document.getElementById(`mensaje_contador_caracter_${codigo}`);
    var cantidad=descripcion.length;
    errorDescripcion.innerHTML = '<small>'+cantidad + ' caracter(es) de ' +total+'</small>';

    if(cantidad>total){
        errorDescripcion.style.color = "red";
    }
    else {
        errorDescripcion.style.color = "black";
    }
    },10);

}

window.activarCargaArchivos = function(e) {
    var componenteTabla = e.closest('tr');
    var componenteArchivo = componenteTabla.querySelector('.componente-carga-archivo');
    //console.log(componenteArchivo);
    var inputFile =componenteArchivo.querySelector(`input[type="file"]`);
    var inputNumExp =componenteArchivo.querySelector('.num-expediente');    if(e.checked){
        componenteArchivo.style.opacity = '50%';
        limpiarSimple(inputFile);
        inputFile.value=null;
        inputNumExp.value='';
        inputFile.setAttribute("disabled","true");
        inputNumExp.setAttribute("disabled","true");
    }else{
        componenteArchivo.style.opacity = '100%';
        inputFile.removeAttribute("disabled");
        inputNumExp.removeAttribute("disabled");
        inputFile.setAttribute("required","true");    }
}

