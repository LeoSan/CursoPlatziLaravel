let botones = document.querySelectorAll("#btnSidebar,#btnNavbar");
if(botones){
    Array.prototype.slice.call(botones)
        .forEach(function(e){
            e.addEventListener("click",function(el){
                let e = document.querySelector('.sidebar');
                e.classList.toggle('toggled');
            });
        });
}


const btnCollapseSidebar = document.getElementById('btnSidebar');
if (btnCollapseSidebar) {
    btnCollapseSidebar.addEventListener('click', function () {
        const nuevoEstado = document.getElementById('sidebar').classList.contains('toggled');
        if (document.getElementById('sidebar').classList.contains('toggled')) {
            document.getElementById('sidebar').querySelectorAll('.collapse').forEach(function(collapseElement) {
                collapseElement.classList.remove('show');
                console.log(collapseElement.querySelectorAll('.collapse-item'));
                collapseElement.querySelectorAll('.collapse-item').forEach(function(collapseSubElement) {
                collapseSubElement.classList.remove('px-5');
                collapseSubElement.classList.add('px-3');
            });
            });
        } else {
            document.getElementById('sidebar').querySelectorAll('.collapse').forEach(function(collapseElement) {
                collapseElement.classList.add('show');
                collapseElement.querySelectorAll('.collapse-item').forEach(function(collapseSubElement) {
                collapseSubElement.classList.remove('px-3');
                collapseSubElement.classList.add('px-5');
                });

            });
        }
        
        axios.post('/sidebar-collapse', { nuevoEstado: nuevoEstado })
            .then(function (response) {

            })
            .catch(function (error) {
                console.error(error);
            });
    });
}
