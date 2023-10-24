
let tooltipVisible = false;

window.showTooltip = function(id_tool_card){
  if (!tooltipVisible) {
    const tooltip = document.getElementById(id_tool_card);
    tooltip.style.opacity = 1;
    tooltipVisible = true;
  }
}

window.showTooltipClick = function(id_tool_card, nom_campo=null, contiene_clase=null){
    if (!tooltipVisible) {
    const input1 = document.getElementById(nom_campo);
    if ( input1.classList.contains(contiene_clase) ){
        const tooltip = document.getElementById(id_tool_card);
        tooltip.style.opacity = 1;
        tooltipVisible = true;
    }
  }
}
window.showTooltipClickAnioMulta = function(id_tool_card, id_tabla=null, contiene_clase=null){
    if (!tooltipVisible) {
        let tabla = document.getElementById(id_tabla);
        let filas = tabla.getElementsByTagName("tr");
        let multas = 0;
        // Recorre las filas y valido si tiene multas
        for (var i = filas.length - 1; i >= 0; i--) {
            if (filas[i].classList.contains(contiene_clase)) {
                multas ++;
            }
        }
        if (multas > 0){
            const tooltip = document.getElementById(id_tool_card);
            tooltip.style.opacity = 1;
            tooltipVisible = true;
        }
  }
}

window.showTooltipMonto = function(id_tool_card, nom_input_validar, contiene_clase){

    if (!tooltipVisible) {

        const input1 = document.getElementById(nom_input_validar);
        if (input1.classList.contains(contiene_clase) && parseInt(input1.value) > 0){
            const tooltip = document.getElementById(id_tool_card);
            tooltip.style.opacity = 1;
            tooltipVisible = true;
        }

    }
  }

window.hideTooltip = function(id_tool_card){
    const tooltip = document.getElementById(id_tool_card);
    tooltip.style.opacity = 0;
    tooltipVisible = false;
}


