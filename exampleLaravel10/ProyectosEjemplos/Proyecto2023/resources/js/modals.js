const botonesAbrirModal = document.querySelectorAll('.abrir-modal');
const botonesCerrarModal = document.querySelectorAll('.modal [data-dismiss="modal"]');
const modals = document.querySelectorAll('.modal');

const modalInicial = document.querySelectorAll('.modal-init');

botonesAbrirModal.forEach(function(button) {
    button.addEventListener('click', function() {
        const target = this.getAttribute('data-target');
        abrirModal(target);
    });
});

if (modalInicial && modalInicial.length) {
    modalInicial.forEach(function(modal) {
        console.log(modal);
        const target = `#${modal.getAttribute('id')}`;
        abrirModal(target);
    });
}

botonesCerrarModal.forEach(function(button) {
    button.addEventListener('click', function() {
        const modal = this.closest('.modal');
        const overlay = document.querySelector('.modal-overlay');
        document.body.removeChild(overlay);

        modal.style.display = 'none';
        modal.classList.remove('show');
        document.body.classList.remove('modal-open');
    });
});

modals.forEach(function(modal) {
    modal.addEventListener('click', function(event) {
        if (event.target === modal) {
            const overlay = document.querySelector('.modal-overlay');
            document.body.removeChild(overlay);

            modal.style.display = 'none';
            modal.classList.remove('show');
            document.body.classList.remove('modal-open');
        }
    });
});

function abrirModal(target) {
    const modal = document.querySelector(target);
    const overlay = document.createElement('div');
    overlay.classList.add('modal-overlay', 'fade', 'show');
    document.body.appendChild(overlay);

    modal.style.display = 'block';
    modal.classList.add('show');
    document.body.classList.add('modal-open');
}
