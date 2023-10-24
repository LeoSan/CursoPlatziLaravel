if (document.getElementById('usuario')) {
    new TomSelect("#usuario",{
        create: false,
        render: {
            no_results:function(data,escape){
                return '<div class="no-results">Sin resultados</div>';
            },
        },
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
}

if (document.getElementById('motivo')) {
    new TomSelect("#motivo",{
        create: false,
        render: {
            no_results:function(data,escape){
                return '<div class="no-results">Sin resultados</div>';
            },
        },
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
}

