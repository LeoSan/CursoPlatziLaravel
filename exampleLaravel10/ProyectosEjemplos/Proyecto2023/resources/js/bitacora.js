//Controlador Js Bitácora

/*
 * Establecer DateRangePicker campo filtro inpfechaDesde
*/
if (document.getElementById('inpfechaDesde')) {
    new DateRangePicker('inpfechaDesde',{
        maxDate: new Date(),
    });
}
