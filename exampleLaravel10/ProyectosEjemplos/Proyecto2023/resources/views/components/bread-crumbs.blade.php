<nav aria-label="breadcrumb" class="px-2 py-1">
    <ol class="breadcrumb">
        @foreach($itemsbread as $item)
            <li class="breadcrumb-item {{ $item['value'] }} font-small-size">
                @if($item['value'] != 'active')
                    <a href="{{$item['ruta']}}"> {{$item['nombreComponente']}} </a>
                @else
                    {{ $item['nombreComponente'] }}
                @endif
            </li>
        @endforeach
    </ol>
 </nav>
