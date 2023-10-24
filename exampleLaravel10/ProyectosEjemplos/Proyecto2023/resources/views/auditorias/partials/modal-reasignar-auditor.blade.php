    <!-- Modal -->
    <div class="modal fade" id="reasignarModal" tabindex="-1" aria-labelledby="reasignarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('auditorias.ejecucion.reasignacion') }}" method="post" class="modal-content">
                @csrf
                <input type="hidden" name="ejecucion_id" id="reasignacion_ejecucion_id" value="">
                <div class="modal-header bg-success text-white px-3 py-3">
                    <h5 class="modal-title fs-6 fw-semibold" id="reasignarModalLabel">Reasignar auditor</h5>
                    <button type="button" class="text-white" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group col-md-12 mb-3">
                        <label for="auditor_asignado_id" class="form-label">Auditor *</label>
                        <select id="reasignacion_auditor_asignado_id" name="auditor_asignado_id" class="form-select input-regular-height bg-white"
                                aria-label="Seleccione">
                            <option value="">Seleccione</option>
                            @foreach($auditores as $auditor)
                                <option value="{{ $auditor->id }}">{{ $auditor->complete_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback fw-regular" data-default="Dato obligatorio"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary input-regular-height" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success input-regular-height">Guardar</button>
                </div>
            </form>
        </div>
    </div>
