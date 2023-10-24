@forelse($array_doc as $key => $doc)

    @include('denuncias.fragmentos.documento', ['item' => $doc])

@empty
    <p>Dato no proporcionado.</p>
@endforelse
