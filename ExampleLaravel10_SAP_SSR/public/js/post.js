const form1 = document.getElementById('form_1');

if (form1){
     form1.addEventListener("submit", async function(e){
        e.preventDefault();
        //Obtengo valor del formulario 
        var obj = {};
        var formData1 = new FormData(form1);
    
        //Genero Matriz para los datos de cada formulario
        for (var key of formData1.keys()) {
            obj[key] = formData1.get(key);
        }
        const ruta = 'http://localhost/ExmapleDev/public/post/store/ajax';
        const result = await sendPostAjax(obj, ruta);
        //console.log('Result-> ', result);
        if (result.estatus == 201){
            document.getElementById('dato_post').innerText = result.id;
            abrirModal('exampleModal');
            form1.reset();
        }
    });
} 

window.formaFuncionesGlobales = async function (e){
    console.log(e)
    e.preventDefault();
    alert('Soy una prueba');
}


const sendPostAjax = async  (datos, ruta)=>{
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let result = await fetch(ruta, {
        method: 'POST',
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json, text-plain, */*",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-TOKEN": token
            },
        body: JSON.stringify(datos)
    })
    .then(res => res.json())
    .then(res=> {
        return (res);
    });

    return result;
}

const abrirModal=(idNombreModal)=>{
    const modal_confirm = new bootstrap.Modal(document.getElementById(idNombreModal), {
        keyboard: false 
    });
    modal_confirm.show();
}

