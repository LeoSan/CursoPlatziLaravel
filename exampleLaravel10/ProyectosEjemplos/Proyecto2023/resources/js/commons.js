var numericos = document.querySelectorAll('.numeric');
Array.prototype.slice.call(numericos)
    .forEach(function(n){
        n.addEventListener('keyup',function(e){
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        }) ;
        n.addEventListener('change',function(e){
            this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        });
    });

var telefonos = document.querySelectorAll('.telefono');
var optionsTel = {
    mask: '00000000'
};
Array.prototype.slice.call(telefonos)
    .forEach(function(n){
        imask(n, optionsTel);
    });

var identificaciones = document.querySelectorAll('.identificacion');
var optionsId = {
    mask: '0000000000000'
};
Array.prototype.slice.call(identificaciones)
    .forEach(function(n){
        imask(n, optionsId);
    });

var cp = document.querySelectorAll('.cp');
var optionsCP = {
    mask: '00000'
};
Array.prototype.slice.call(cp)
    .forEach(function(n){
        imask(n, optionsCP);
    });

var lempiraInputs = document.querySelectorAll('.lempiras');
Array.prototype.slice.call(lempiraInputs)
    .forEach(function(n){
        n.addEventListener('keyup',function(e){
            let valor = this.value;
            this.value = lempiras(valor);
        });
    });


//Metodo: Permite teclear los caracteres que se necesitan en un campo
window.validaCampos = function (e, tipo, campo){
    let string = e.value;
    let out = '';
    //Se añaden las letras validas
    let filtro = [
            {nombre:'alphanumerico', regla:'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890-.'},
            {nombre:'numeros',       regla:'1234567890'},
            {nombre:'letras',        regla:'abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ'},
            {nombre:'prorroga',      regla:'12345'},
        ];
    const result = filtro.find( ({ nombre }) => nombre === tipo );
    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
    for (var i=0; i<string.length; i++)
       if (result.regla.indexOf(string.charAt(i)) != -1)
        //Se añaden a la salida los caracteres validos
        out += string.charAt(i);

    document.getElementById(campo).value = out;
}
//Método para convertir una cadena de texto a lempiras
window.lempiras = function (value){
    value = value.replace('.', '').replaceAll(',', '').replace(/\D/g, '');
    // Utiliza BigNumber para manejar la precisión
    const bigValue = new BigNumber(value);
    const options = { minimumFractionDigits: 2 }
    const result = new Intl.NumberFormat('es-HN', options).format(
        bigValue.dividedBy(100)
    )
    value = result ==="NaN" ? '' : result;
    return value;
}


window.tipoValidacion = function(inputInvalido,msgDefault) {
    if (inputInvalido.validity.valueMissing){
        return msgDefault ?? 'Dato obligatorio';
    }
    if (inputInvalido.validity.tooLong){
        return "El límite de caracteres debe ser menor o igual a "+inputInvalido.maxlength;
    }
    if (inputInvalido.validity.tooShort){
        return "El mínimo de caracteres es de "+inputInvalido.minLength;
    }
     if (inputInvalido.validity.rangeOverflow){
         if (inputInvalido.type === 'date')
             return "La fecha debe ser igual o anterior a la actual";
         if (inputInvalido.type === 'number'){
             return msgDefault??"Este debe ser menor a "+inputInvalido.max;
         }
    }
    if (inputInvalido.validity.rangeUnderflow){
        if (inputInvalido.type === 'date'){
            if(inputInvalido.min == '1970-01-01'){
                return "La fecha debe ser posterior a 01/01/1970";
            }else{
                return "La fecha debe ser posterior a la actual";
            }

        }
    }
    if (inputInvalido.validity.typeMismatch) {
        if (inputInvalido.type === 'email')
            return 'Correo electrónico inválido';
        if (inputInvalido.type === 'date')
            return 'Fecha inválida';
        if (inputInvalido.type === 'time')
            return 'Hora inválida';
        return 'Tipo de dato incorrecto';
    }
    if(inputInvalido.validity.pattern){
        if (inputInvalido.type === 'text')
            return 'Campo inválido';

    }
    return 'Campo inválido';



}

window.validarFormulario = function (event){
    let alertError = document.getElementById('alert-error');
    let textAlertError = document.getElementById('textErrorAlert');
    alertError.style.display = 'none';
    let form = event.target;
    
    if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
        var inputsInvalidos = form.querySelectorAll(':invalid');
        inputsInvalidos.forEach(function (inputInvalido) {
            //inputInvalido.closest('.form-group').classList.add('input-invalido');
            var invalidFeedbacks = inputInvalido.closest('.form-group').querySelectorAll('.invalid-feedback');
            invalidFeedbacks.forEach(function(el){
                el.textContent = tipoValidacion(inputInvalido,el.dataset.default);
                el.style.removeProperty('display');
            });
        });
    }else{
        let size = 0;
        const fd = new FormData(form)
        for(let pair of fd.entries()) {
            if (pair[1] instanceof Blob)
              size += pair[1].size
            else
              size += pair[1].length
        }

        let post_servidor = return_bytes(post_size);
        if(size > post_servidor ){
        alertError.style.display = 'block';
        textAlertError.innerHTML = "<strong class='fw-semibold'>¡Error! </strong>Los archivos a cargar exceden en conjunto el tamaño máximo permitido por petición que es de " +post_size+"B.";
        var input_files = form.querySelectorAll('input[type="file"]');
        console.log(input_files);
                event.preventDefault();
                event.stopPropagation();
        }

    }

    form.classList.add('validado');
}

function formatFileSize(bytes) {
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes == 0) return '0 Byte';
    const i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2);
}
function return_bytes(val) {
    val = val.trim();
    let last = (val[val.length-1]).toLowerCase();
    val = parseFloat(val);
    switch(last) {
        case 'g':
            val *= (1024 * 1024 * 1024); //1073741824
            break;
        case 'm':
            val *= (1024 * 1024); //1048576
            break;
        case 'k':
            val *= 1024;
            break;
    }
    return val;
}


var forms = document.querySelectorAll('.necesita-validacion');
Array.prototype.slice.call(forms)
    .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            validarFormulario(event);
        }, false);
    });

//Obtención de días inhábiles
window.diasInhabiles = [];
if (window.location.pathname !== '/login')
    axios.post('/getDiasInhabiles').then(function (response) {
        if(response.data)
            window.diasInhabiles = response.data.inhabiles;
    });

window.validaFechaInhabil = function(e){
    let fecha = e.value ? e.value : null;
    let alerta = e.closest(".form-group").querySelector(".invalid-feedback");
    if(fecha && diasInhabiles.includes(fecha)){
        let date = moment(e.value);
        e.value="";
        alerta.innerHTML="La fecha "+date.format('DD/MM/YYYY')+" es inhábil.";
        alerta.style.display = 'block';
    } else {
        alerta.style.display = 'none';
    }
}

window.addEventListener('actualiza_bandeja_casos', event => {
    document.getElementById('enlace_casos').setAttribute('href',event.detail.url)
})

