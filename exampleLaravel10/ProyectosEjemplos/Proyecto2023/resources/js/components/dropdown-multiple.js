const multiple = document.getElementsByClassName('form-select-multiple');

if (multiple.length > 0) {
    for (let elemento of multiple) {
        const tag_name = elemento.getAttribute('data-input-name');
        const dropdown = elemento.closest('.dropdown');
        const selector = dropdown.querySelector('.dropdown-toggle');

        multipleLabel(dropdown, tag_name, selector);

        elemento.addEventListener("change", function (event) {
            // Remover el siguiente IF si no se desea que se desactiven las opciones restantes cuando se checkea 'TODOS'

            if (elemento.value === 'Todos') {
                if (elemento.checked) {
                    dropdown.querySelectorAll(`input[name="${tag_name}[]"]`).forEach(function (item) {
                        if (item.value !== 'Todos') {
                            item.checked = false;
                        }
                    });
                } else {
                    dropdown.querySelectorAll(`input[name="${tag_name}[]"]`).forEach(function (item) {
                        if (item.value !== 'Todos') {
                        }
                    });
                }
            } else {
                dropdown.querySelectorAll(`input[name="${tag_name}[]"]`).forEach(function (item) {
                    if (item.value === 'Todos') {
                        item.checked = false;
                    }
                });
            }

            multipleLabel(dropdown, tag_name, selector);

        });
    }

    function multipleLabel(dropdown, tag_name, selector) {
        const multiple_values = [];
        let all_values = true;

        dropdown.querySelectorAll(`input[name="${tag_name}[]"]:checked`).forEach(function (item) {
            const tag_name_elemento = item.getAttribute('data-tag-name');
            if (tag_name_elemento !== 'Todos') {
                multiple_values.push(tag_name_elemento);
                all_values = false;
            } else {
                all_values = true;
            }
        });

        if (multiple_values.length) {
            if (multiple_values.length < 4) {
                selector.textContent = multiple_values.toString();
            } else {
                selector.textContent = `${multiple_values.length} seleccionados`;
            }
        } else {
            selector.textContent = all_values ? 'Todos' : 'Seleccione';
        }
    }
}
