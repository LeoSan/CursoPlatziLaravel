var editores = document.querySelectorAll('.editor');
if(editores){
    tinyMCE.baseURL = `${base_url}/js/tinymce`;
    tinyMCE.init({
        selector: '.editor',
        menubar: false,
        setup:function (editor) {
            editor.on('change', function () {
                editor.save();
                let max = parseInt(editor.maxlength);
                let numChars = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();
                let alerta = document.getElementById(editor.id+'_maxchar');
                let longitud = document.getElementsByName(editor.getElement().name+'_longitud')[0];
                if(numChars > max){
                    alerta.style.display='block';
                    alerta.innerHTML=`El límite permitido debe ser menor o igual a ${max}.`;
                }
                if(numChars <= max){
                    alerta.style.display='none';
                    alerta.innerHTML="";
                }
                longitud.value=numChars;
            });
        },
        theme_url: `${base_url}/js/tinymce/themes/silver/theme.min.js`,
        language_url : `${base_url}/js/tinymce/langs/es.js`,
        language: 'es',
        plugins: [
            'lists',
            'link',
            'searchreplace',
            'autolink',
            'charmap',
            'code',
            'table',
            'paste',
            'wordcount',
            'insertdatetime',
            'visualblocks',
            'advlist'
        ],
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print media | forecolor backcolor | table',
        init_instance_callback: function (editor) {
            //Crea elemento para enviar el número de caracteres del textarea
            let textarea = editor.getElement();
            let maxlength = textarea.dataset.maxlength??"1700";
            let input_longitud = document.createElement("input");
            let invalid_feedback = document.createElement("div");
            let form_group = document.createElement("div");
            let numChars = tinymce.activeEditor.plugins.wordcount.body.getCharacterCount();
            invalid_feedback.classList.add('invalid-feedback');
            invalid_feedback.id=editor.id+'_maxchar';
            input_longitud.type='number';
            input_longitud.classList.add('d-none');
            input_longitud.name=textarea.name+'_longitud';
            input_longitud.value=numChars??"0";
            input_longitud.max=maxlength;
            editor.maxlength=maxlength;
            if(textarea.required)
                invalid_feedback.setAttribute('data-default',`Este campo es obligatorio y permite máximo ${maxlength} caracteres.`);
            else
                invalid_feedback.setAttribute('data-default',`Este campo permite máximo ${maxlength} caracteres.`);
            //Agrega elementos al dom (seguido del textarea)
            let context = editor.getContainer();
            context.parentElement.append(form_group);
            form_group.append(input_longitud);
            form_group.append(invalid_feedback);
            let btn = textarea.parentElement.querySelector('button.tox-statusbar__wordcount');
            btn.click();
        }
    });
}

var editoresSinLimite = document.querySelectorAll('.editor-sin-limite');
if(editoresSinLimite){
    tinyMCE.baseURL = `${base_url}/js/tinymce`;
    tinyMCE.init({
        height : "40vh",
        selector: '.editor-sin-limite',
        menubar: false,
        setup:function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        theme_url: `${base_url}/js/tinymce/themes/silver/theme.min.js`,
        language_url : `${base_url}/js/tinymce/langs/es.js`,
        language: 'es',
        plugins: [
            'lists',
            'link',
            'searchreplace',
            'autolink',
            'charmap',
            'code',
            'table',
            'paste',
            'wordcount',
            'insertdatetime',
            'visualblocks',
            'advlist'
        ],
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print media | forecolor backcolor | table',
        init_instance_callback: function (editor) {
            let btn = editor.getElement().parentElement.querySelector('button.tox-statusbar__wordcount');
            btn.click();
        }
    });
}
