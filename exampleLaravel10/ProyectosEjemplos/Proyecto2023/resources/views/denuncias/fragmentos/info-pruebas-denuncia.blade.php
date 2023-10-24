<div class="@isset($col){{$col}} @else {{$col}} @endisset   bg-white sub-titulo-red">
<div class="bg-border mb-3"></div>
    Pruebas
</div>
<div class=" ">
    <div class="row bg-white">
        @forelse($doc_list as $key => $item)
            @include('denuncias.fragmentos.documento', ['item' => $item])
        @empty
            <p>Dato no proporcionado.</p>
        @endforelse
    </div>

</div>

