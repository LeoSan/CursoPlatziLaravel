<div>
    <div class="py-2">
        <label class="form-label font-regular-size mb-0">Filtrar</label>
        @include('livewire.partials.filtros_tablero')
    </div>
    <div class="py-2">
        <div class="border-bottom"></div>
    </div>
    <div class="my-2 w-100 d-flex justify-content-end align-items-center text-gray">
        @if(isset($rango) && count($rango)==2)
            <h5 class="font-regular-size m-0 py-0 px-2 fw-semibold">Mostrando datos de:</h5>
            <div class="font-regular-size">
                    {{ $rango[0] }} - {{ $rango[1] }}
            </div>
        @endif
    </div>

    <div class="row mb-2">
        <div class="col-12">
            <div class="tablero-cards d-flex flex-column flex-md-row justify-content-between gap-4 mb-2">
                <div class="w-100 card card-small bg-white border-0">
                    <div class="card-body d-flex gap-4">
                        <div class="icon icon-circle icon-danger">
                            <div>
                                <div><i class="fa-solid fa-dollar-sign"></i></div>
                            </div>
                        </div>
                        <div class="data">
                            <div class="fw-bold fs-3">L {{ simplificarNumero($dataView['deuda']) }}</div>
                            <div class="text-graylight mb-1 font-small-size">
                                <small>
                                    L {{ lempiras($dataView['deuda']) }}
                                </small>
                            </div>
                            <div class="text-gray font-regular-size">
                                <small>
                                    Suma de las multas
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-100 card card-large bg-white border-0">
                    <div class="card-body d-flex flex-wrap align-items-center gap-3 gap-lg-4">
                        <div class="d-flex align-items-center gap-4">
                            <div class="icon icon-circle icon-success">
                                <div>
                                    <div><i class="fa-solid fa-dollar-sign"></i></div>
                                </div>
                            </div>
                            <div class="data">
                                <div class="fw-bold fs-3">L {{ simplificarNumero($dataView['total_pagos_intereses']) }}</div>
                                <div class="text-graylight mb-1 font-small-size">
                                    <small>
                                        L {{ lempiras($dataView['total_pagos_intereses']) }}
                                    </small>
                                </div>
                                <div class="text-gray font-regular-size">
                                    <small>
                                        Monto total cobrado
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="data-small ps-lg-4 d-flex flex-column flex-lg-row gap-4">
                            <div class="item">
                                <div class="number fs-5 fw-semibold">L {{ simplificarNumero($dataView['total_pagos']) }}</div>
                                <div class="number mb-1 font-small-size text-graylight">
                                    <small>
                                        L {{ lempiras($dataView['total_pagos']) }}
                                    </small>
                                </div>
                                <div class="label font-small-size">Total sin intereses</div>
                            </div>
                            <div class="item">
                                <div class="number fs-5 fw-semibold">L {{ simplificarNumero($dataView['total_intereses']) }}</div>
                                <div class="number mb-1 font-small-size text-graylight">
                                    <small>
                                        L {{ lempiras($dataView['total_intereses']) }}
                                    </small>
                                </div>
                                <div class="label font-small-size">Intereses</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex mb-2">
        <div class="w-100 card bg-white border-0">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h5 class="fw-semibold mb-2">Pagos realizados ({{ $dataView['total_conteo_pagos'] }})</h5>
                    </div>
                    <div class="col-12">
                        <div class="tipos-pagos">
                            <div class="item d-flex flex-column flex-md-row flex-wrap flex-md-nowrap py-2 w-100">
                                <div class="info d-flex border-md-end border-gray align-items-center">
                                    <div
                                        class="icon rounded d-flex align-items-center justify-content-center text-white p-1 bg-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 384 512">
                                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM64 80c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16zm128 72c8.8 0 16 7.2 16 16v17.3c8.5 1.2 16.7 3.1 24.1 5.1c8.5 2.3 13.6 11 11.3 19.6s-11 13.6-19.6 11.3c-11.1-3-22-5.2-32.1-5.3c-8.4-.1-17.4 1.8-23.6 5.5c-5.7 3.4-8.1 7.3-8.1 12.8c0 3.7 1.3 6.5 7.3 10.1c6.9 4.1 16.6 7.1 29.2 10.9l.5 .1 0 0 0 0c11.3 3.4 25.3 7.6 36.3 14.6c12.1 7.6 22.4 19.7 22.7 38.2c.3 19.3-9.6 33.3-22.9 41.6c-7.7 4.8-16.4 7.6-25.1 9.1V440c0 8.8-7.2 16-16 16s-16-7.2-16-16V422.2c-11.2-2.1-21.7-5.7-30.9-8.9l0 0c-2.1-.7-4.2-1.4-6.2-2.1c-8.4-2.8-12.9-11.9-10.1-20.2s11.9-12.9 20.2-10.1c2.5 .8 4.8 1.6 7.1 2.4l0 0 0 0 0 0c13.6 4.6 24.6 8.4 36.3 8.7c9.1 .3 17.9-1.7 23.7-5.3c5.1-3.2 7.9-7.3 7.8-14c-.1-4.6-1.8-7.8-7.7-11.6c-6.8-4.3-16.5-7.4-29-11.2l-1.6-.5 0 0c-11-3.3-24.3-7.3-34.8-13.7c-12-7.2-22.6-18.9-22.7-37.3c-.1-19.4 10.8-32.8 23.8-40.5c7.5-4.4 15.8-7.2 24.1-8.7V232c0-8.8 7.2-16 16-16z"
                                                fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div class="data px-3 border-end border-gray">
                                        <h4 class="number m-0 p-0 fw-semibold">{{ $dataView['pagos_extrajudiciales'] }}</h4>
                                        <div class="label font-small-size">Extrajudiciales</div>
                                    </div>
                                    <div class="data-alt text-center px-0">
                                        <h4 class="number m-0 p-0 fw-light">{{ round($dataView['total_conteo_pagos'] && bccomp($dataView['total_conteo_pagos'],"0")>0 ? $dataView['pagos_extrajudiciales'] * 100 / $dataView['total_conteo_pagos'] : 0, 1) }}
                                            %</h4>
                                    </div>
                                </div>
                                <div class="simple-chart pt-3 pt-md-2 ps-0 ps-md-4 align-items-center w-100">
                                    <div class="d-flex align-items-center w-100 position-relative">
                                        <div
                                            class="bar py-3 px-2 d-block d-md-none bg-default-gray rounded-3 w-100"></div>
                                        <div class="bar py-3 px-2 d-none d-md-block bg-white rounded-3 w-100"></div>
                                        <div
                                            class="bar py-3 px-2 bg-primary rounded-3 position-absolute right-0 top-0 h-100"
                                            style="width: {{ $dataView['total_conteo_pagos'] && bccomp($dataView['total_conteo_pagos'],"0")>0 ? $dataView['pagos_extrajudiciales'] * 100 / $dataView['total_conteo_pagos'] : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <hr class="d-block d-md-none my-2 border-gray">
                            <div class="item d-flex flex-column flex-md-row flex-wrap flex-md-nowrap py-2 w-100">
                                <div class="info d-flex border-md-end border-gray align-items-center">
                                    <div
                                        class="icon rounded d-flex align-items-center justify-content-center text-white p-1 bg-tertiary">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="1.8em" viewBox="0 0 512 512">
                                            <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M318.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-120 120c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l4-4L325.4 293.4l-4 4c-12.5 12.5-12.5 32.8 0 45.3l16 16c12.5 12.5 32.8 12.5 45.3 0l120-120c12.5-12.5 12.5-32.8 0-45.3l-16-16c-12.5-12.5-32.8-12.5-45.3 0l-4 4L330.6 74.6l4-4c12.5-12.5 12.5-32.8 0-45.3l-16-16zm-152 288c-12.5-12.5-32.8-12.5-45.3 0l-112 112c-12.5 12.5-12.5 32.8 0 45.3l48 48c12.5 12.5 32.8 12.5 45.3 0l112-112c12.5-12.5 12.5-32.8 0-45.3l-1.4-1.4L272 285.3 226.7 240 168 298.7l-1.4-1.4z"
                                                fill="currentColor"/>
                                        </svg>
                                    </div>
                                    <div class="data px-3 border-end border-gray">
                                        <h4 class="number m-0 p-0 fw-semibold">{{ $dataView['pagos_judiciales'] }}</h4>
                                        <div class="label font-small-size">Judiciales</div>
                                    </div>
                                    <div class="data-alt text-center px-0">
                                        <h4 class="number m-0 p-0 fw-light">{{ round($dataView['total_conteo_pagos'] && bccomp($dataView['total_conteo_pagos'],"0")>0 ? $dataView['pagos_judiciales'] * 100 / $dataView['total_conteo_pagos'] : 0, 1) }}
                                            %</h4>
                                    </div>
                                </div>
                                <div class="simple-chart pt-3 pt-md-2 ps-0 ps-md-4 align-items-center w-100">
                                    <div class="d-flex align-items-center w-100 position-relative">
                                        <div
                                            class="bar py-3 px-2 d-block d-md-none bg-default-gray rounded-3 w-100"></div>
                                        <div class="bar py-3 px-2 d-none d-md-block bg-white rounded-3 w-100"></div>
                                        <div
                                            class="bar py-3 px-2 bg-tertiary rounded-3 position-absolute right-0 top-0 h-100"
                                            style="width: {{ $dataView['total_conteo_pagos'] && bccomp($dataView['total_conteo_pagos'],"0")>0 ? $dataView['pagos_judiciales'] * 100 / $dataView['total_conteo_pagos'] : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
