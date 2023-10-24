@extends('layouts.app')

@section('content')

    <h1>Lista de archivos</h1>

    <form id="fileForm" action="/load-files" enctype="multipart/form-data">

        <div id="form">
            <input type="hidden" id="files_count" value="1">
            <label for="description">Descripción:</label>
            <input type="text" id="description" required><br>

            <label for="file">Archivos:</label>
            <div id="accion">Click para boton</div>

            <button type="button" onclick="addFile()">Agregar</button>
        </div>

        <div id="archivos" class=" p-5 bg-light">
            <div class="archivo-item">
                <input type="file" name="archivos_file_1" id="archivos_file_1" />
                <input type="text" name="archivos_texto_1" id="archivos_texto_1" />
            </div>
        </div>

        <div id="fileList"></div>

    </form>



    <script>

        let filesCount = document.getElementById('files_count');
        let filesCountValue = parseInt(filesCount.value);

        const accionButton = document.getElementById('accion');

        accionButton.addEventListener('click', function () {
            let archivoinput = document.getElementById(`archivos_file_${filesCountValue}`);
            archivoinput.click();
        });

        function addFile() {
            var descriptionInput = document.getElementById('description');
            var fileInput = document.getElementById(`archivos_file_${filesCountValue}`);

            var description = descriptionInput.value;
            var file = fileInput.files[0];

            if (description.trim() === '' || !file) {
                return;
            }

            var listItem = document.createElement('div');
            listItem.classList.add('file-list');

            var descriptionNode = document.createElement('span');
            descriptionNode.textContent = description;

            let descinput = document.getElementById(`archivos_texto_${filesCountValue}`);
            descinput.value = description;

            var hiddenDescriptionInput = document.createElement('input');
            hiddenDescriptionInput.type = 'hidden';
            hiddenDescriptionInput.name = 'description';
            hiddenDescriptionInput.value = description;

            var hiddenFileInput = document.createElement('input');
            hiddenFileInput.type = 'hidden';
            hiddenFileInput.name = 'file';
            hiddenFileInput.value = file.name;

            var fileNode = document.createElement('a');
            fileNode.href = URL.createObjectURL(file);
            fileNode.textContent = file.name;

            listItem.appendChild(descriptionNode);
            listItem.appendChild(hiddenDescriptionInput);
            listItem.appendChild(hiddenFileInput);
            listItem.appendChild(document.createTextNode(' - '));
            listItem.appendChild(fileNode);

            filesCount.value = filesCountValue + 1;
            filesCountValue = filesCountValue + 1;

            var archivoItem = document.createElement('div');
            archivoItem.classList.add('archivo-list');
            archivoItem.innerHTML= `<input type="file" name="documentos_archivos_codigo[]" id="documentos_archivos_codigo_${filesCountValue}" />
                <input type="text" name="documentos_textos_codigo[]" id="documentos_textos_codigo_${filesCountValue}" />`;

            document.getElementById('fileList').appendChild(listItem);

            document.getElementById('archivos').appendChild(archivoItem);


            descriptionInput.value = '';
        }
    </script>

@endsection
