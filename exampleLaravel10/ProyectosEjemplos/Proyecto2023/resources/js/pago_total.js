let form_pago_total = document.getElementById('form_pago_total');
if(form_pago_total) {
    form_pago_total.addEventListener('submit', function (e) {
        let total_multa = new BigNumber(document.getElementById('total_multa').value.replaceAll(',',''));
        let total_pagar = new BigNumber(document.getElementById('monto_pago_total').value.replaceAll(',',''));
        let btn_modal = document.getElementById('btnModalTotalPagoTotal');
        let btn_cancelar = document.getElementById('btnCancelarModalTotalPagoTotal');
        let parrafo_continuar = document.getElementById('parrafoContinuarPagoTotal');
        e.preventDefault();
        if (form_pago_total.checkValidity() !== false){
            if(!total_pagar.isEqualTo(total_multa) ){
                const modalTotalPago = new Modal(document.getElementById('modalTotalPagoTotal'))
                if(total_pagar.isLessThan(total_multa)){
                    btn_modal.classList.add('d-none');
                    btn_cancelar.innerHTML=`Aceptar`;
                    parrafo_continuar.innerHTML=`El capital del pago a realizar
                    <strong>(L ${lempiras(total_pagar.toFixed(2))})</strong>
                    es ${(total_pagar.isGreaterThan(total_multa))?'mayor':'menor'} al total de la multa
                    <strong>(L ${lempiras(total_multa.toFixed(2))})</strong>.`;
                }
                else{
                    btn_modal.classList.remove('d-none');
                    btn_cancelar.innerHTML=`Cancelar`;
                    parrafo_continuar.innerHTML=`El capital del pago a realizar
                    <strong>(L ${lempiras(total_pagar.toFixed(2))})</strong>
                    es ${(total_pagar.isGreaterThan(total_multa))?'mayor':'menor'} al total de la multa
                    <strong>(L ${lempiras(total_multa.toFixed(2))})</strong>
                    <br>
                    <strong class="text-gray">¿Desea continuar?</strong>`;
                }
                modalTotalPago.show();
            }else{
                form_pago_total.submit();
            }
        }

    });
    window.submitFormPagoTotal = function(){
        form_pago_total.submit();
    }
}
