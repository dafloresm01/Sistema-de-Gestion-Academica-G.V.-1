<input type="hidden" value="{{ $gestion }}" id="gestion">
<input type="hidden" value="{{ isset($desempeno_estudiante) ? $desempeno_estudiante->materia_id : '' }}" id="materia_id"
    name="materia_id">
<input type="hidden" value="{{ isset($desempeno_estudiante) ? $desempeno_estudiante->inscripcion_id : '' }}"
    id="txt_inscripcion_id">
<div class="row">
    <div class="col-md-12">
        <h5>Gestión {{ $gestion }}</h5>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Seleccionar materia*</label>
            {{ Form::select('materia_profesor', $array_profesor_materias, null, ['class' => 'form-control', 'id' => 'materia_profesor', 'required']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Seleccionar estudiante*</label>
            {{ Form::select('inscripcion_id', [], null, ['class' => 'form-control', 'id' => 'inscripcion_id', 'required']) }}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Desempeño de Actividad*</label>
            {{ Form::textarea('desempeno', null, ['class' => 'form-control', 'rows' => '3', 'required']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Valoración*</label>
            {{ Form::select('valoracion', ['' => 'Seleccione...', 'EXCELENTE' => 'Excelente', 'BUENA' => 'Buena', 'REGULAR' => 'Regular', 'MALA' => 'Mala', 'NO PRESENTO' => 'No Presento'], null, ['class' => 'form-control', 'required']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Fecha*</label>
            {{ Form::date('fecha', isset($desempeno_estudiante) ? $desempeno_estudiante->fecha : date('Y-m-d'), ['class' => 'form-control', 'required']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Observaciones</label>
            {{ Form::textarea('observacion', null, ['class' => 'form-control', 'rows' => '2']) }}
        </div>
    </div>
</div>
