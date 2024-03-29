@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Desempeño académico estudiantes</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                        <li class="breadcrumb-item active">Desempeño académico estudiantes</li>
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
                        @if (Auth::user()->tipo == 'PROFESOR')
                            <div class="card-header">
                                {{-- <h3 class="card-title"></h3> --}}
                                <a href="{{ route('desempeno_estudiantes.create') }}" class="btn btn-info"><i
                                        class="fa fa-plus"></i> Nuevo</a>
                            </div>
                        @endif
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table data-table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Materia</th>
                                        <th>Estudiante</th>
                                        <th>Desempeño actividad</th>
                                        <th>Valoración</th>
                                        <th>Fecha</th>
                                        <th>Observaciones</th>
                                        <th>Fecha de registro</th>
                                        @if (Auth::user()->tipo == 'PROFESOR' || Auth::user()->tipo == 'TUTOR')
                                            <th>Opciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 1;
                                    @endphp
                                    @foreach ($desempeno_estudiantes as $desempeno_estudiante)
                                        <tr>
                                            <td>{{ $desempeno_estudiante->materia->nombre }}</td>
                                            <td>{{ $desempeno_estudiante->estudiante->full_name }}</td>
                                            <td>{{ $desempeno_estudiante->desempeno }}</td>
                                            <td>{{ $desempeno_estudiante->valoracion }}</td>
                                            <td>{{ $desempeno_estudiante->fecha }}</td>
                                            <td>{{ $desempeno_estudiante->observacion }}</td>
                                            <td>{{ $desempeno_estudiante->fecha_registro }}</td>
                                            @if (Auth::user()->tipo == 'PROFESOR' || Auth::user()->tipo == 'TUTOR')
                                                <td class="btns-opciones">
                                                    @if (Auth::user()->tipo == 'PROFESOR' || Auth::user()->tipo == 'TUTOR')
                                                        <a href="{{ route('chat_desempeno.index', $desempeno_estudiante->id) }}"
                                                            class="ir-evaluacion"><i class="fa fa-comments"
                                                                data-toggle="tooltip" data-placement="left"
                                                                title="Chat"></i></a>
                                                    @endif
                                                    @if (Auth::user()->tipo == 'PROFESOR')
                                                        <a href="{{ route('desempeno_estudiantes.edit', $desempeno_estudiante->id) }}"
                                                            class="modificar"><i class="fa fa-edit" data-toggle="tooltip"
                                                                data-placement="left" title="Modificar"></i></a>
                                                        <a href="#"
                                                            data-url="{{ route('desempeno_estudiantes.destroy', $desempeno_estudiante->id) }}"
                                                            data-toggle="modal" data-target="#modal-eliminar"
                                                            class="eliminar"><i class="fa fa-trash" data-toggle="tooltip"
                                                                data-placement="left" title="Eliminar"></i></a>
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

    @include('modal.eliminar')

@section('scripts')
    <script>
        @if (session('bien'))
            mensajeNotificacion('{{ session('bien') }}', 'success');
        @endif

        @if (session('info'))
            mensajeNotificacion('{{ session('info') }}', 'info');
        @endif

        @if (session('error'))
            mensajeNotificacion('{{ session('error') }}', 'error');
        @endif


        @if (Auth::user()->tipo == 'PROFESOR' || Auth::user()->tipo == 'TUTOR')
            $('table.data-table').DataTable({
                columns: [null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    {
                        width: "10%"
                    },
                ],
                scrollCollapse: true,
                language: lenguaje,
                pageLength: 25
            });
        @else
            $('table.data-table').DataTable({
                columns: [null,
                    null,
                    null,
                    null,
                    null,
                    null,
                    null,
                ],
                scrollCollapse: true,
                language: lenguaje,
                pageLength: 25
            });
        @endif


        // ELIMINAR
        $(document).on('click', 'table tbody tr td.btns-opciones a.eliminar', function(e) {
            e.preventDefault();
            let desempeno_estudiante = $(this).parents('tr').children('td').eq(2).text();
            $('#mensajeEliminar').html(`¿Está seguro(a) de eliminar el registro <b>${desempeno_estudiante}</b>?`);
            let url = $(this).attr('data-url');
            console.log($(this).attr('data-url'));
            $('#formEliminar').prop('action', url);
        });

        $('#btnEliminar').click(function() {
            $('#formEliminar').submit();
        });
    </script>
@endsection
@endsection
