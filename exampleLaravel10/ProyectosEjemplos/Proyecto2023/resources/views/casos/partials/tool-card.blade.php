<div id="{{$tool_card}}" class="tool-card {{$tipo}}">
    <div class="marco">
      <div class="marco-header">
        <div >Cerrar
          <span class="btnCerrarToolCard" onclick="hideTooltip('{{$tool_card}}')">
            <svg width="10" height="10" viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
              <defs>
                  <path d="M9.746 1.592a.6.6 0 0 1 0 .849l-2.52 2.518 2.52 2.522a.6.6 0 0 1 0 .848L8.329 9.746a.6.6 0 0 1-.848 0L4.96 7.224 2.44 9.746a.6.6 0 0 1-.849 0L.176 8.329a.6.6 0 0 1 0-.848l2.52-2.522-2.52-2.518a.6.6 0 0 1 0-.849L1.592.176a.6.6 0 0 1 .849 0l2.52 2.519L7.48.175a.6.6 0 0 1 .848 0l1.417 1.417z" id="ge0y245ica"/>
              </defs>
              <use fill="#FFF" xlink:href="#ge0y245ica" fill-rule="evenodd"/>
            </svg>
          </span>
        </div>
      </div>
      <div class="marco-body">
        <p>
            <strong> {!!$mensaje !!}  </strong>
        </p>
      </div>
    </div>
    <div id="center-flecha">
      <div id="flecha-inferior"></div>
    </div>
</div>
