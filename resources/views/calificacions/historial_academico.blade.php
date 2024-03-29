@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/calificacions/index.css')}}">
@endsection

@section('sidebar-collapse')
@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Historial Académico</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-white">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
                    <li class="breadcrumb-item active">Historial Académico</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        {!! Form::open(['route' => 'reportes.historial_academico', 'method' => 'get', 'target' => '_blank', 'id' => 'formhistorial_academico']) !!}
                        <div class="row">
                            <input type="hidden" name="estudiante" value="{{$estudiante->id}}">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nivel:</label>
                                    {{Form::select('nivel',[
                                        'SECUNDARIA' => 'SECUNDARIA',
                                    ],null,['class'=>'form-control','id'=>'nivel','required'])}}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Grado:</label>
                                    {{Form::select('grado',[],null,['class'=>'form-control','id'=>'grado','required'])}}
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Paralelo:</label>
                                    {{Form::select('paralelo',$array_paralelos,null,['class'=>'form-control','id'=>'paralelo','required'])}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Turno:</label>
                                    {{Form::select('turno',[
                                        'MAÑANA' => 'MAÑANA',
                                        'TARDE' => 'TARDE',
                                        'NOCHE' => 'NOCHE'
                                    ],null,['class'=>'form-control','id'=>'turno','required'])}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Gestión:</label>
                                    {{Form::select('gestion',$array_gestiones,null,['class'=>'form-control','id'=>'gestion','required'])}}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">Generar Boleta</button>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    <!-- /.card-body -->
                </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
</section>

<input type="hidden" id="est" value="{{$estudiante->id}}">
<input type="hidden" id="urlNotas" value="{{route('calificacions.notas_estudiante',$estudiante->id)}}">

@endsection

@section('scripts')
<script>
    var grados = `<option value="">Seleccione...</option>
    <option value="1">1º</option>
    <option value="2">2º</option>
    <option value="3">3º</option>
    <option value="4">4º</option>
    <option value="5">5º</option>
    <option value="6">6º</option>`;

    var grados_inicial = `<option value="">Seleccione...</option>
    <option value="1">1º</option>
    <option value="2">2º</option>`;

    let nivel = $('#nivel');
    let grado = $('#grado');
    let paralelo = $('#paralelo');
    let input_paralelo = $('#input_paralelo');
    let grado_ = $('#grado_');

    $(document).ready(function () {
        carga_grados();
        nivel.change(function () {
            carga_grados();
        });
    });

    function carga_grados() {
        let valor = nivel.val();
        if (valor != 'NIVEL INICIAL') {
            grado.html(grados);
        } else {
            grado.html(grados_inicial);
        }
        grado.val(grado_.val());
    }
</script>
@endsection
