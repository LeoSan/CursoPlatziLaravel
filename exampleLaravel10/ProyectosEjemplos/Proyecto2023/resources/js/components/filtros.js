let today = new Date();
let currentYear = today.getFullYear();
let currentMonth = today.getMonth();
let currentDay = today.getDate();
let form = document.getElementById('form_busqueda_casos');
if(form){
    let btn = document.getElementById('btn_reset_busqueda');
    if(btn)
        btn.addEventListener('click',function(){
            let busqueda = document.getElementById('busqueda');
            busqueda.value="";
            form.submit();
        })
}
let filtrosFecha = document.querySelectorAll('.filtro-fecha');
Array.prototype.slice.call(filtrosFecha).forEach(function(e){
    e.addEventListener('focus',function(){
        this.type='date';
    });
    e.addEventListener('blur',function(){
        if(this.value==="")
            this.type='text';
    });
});


//Metodo: Permitelimpiar los filtros
window.btnLimpiarBusqueda = function (e, ruta){
    location.replace(base_url+ruta);
}
