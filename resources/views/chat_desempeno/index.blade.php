@extends('layouts.app')

@section('css')
    <style>
        .contenedor_chat {
            height: auto;
            position: relative;
        }

        .contenedor_chat .cargando {
            position: absolute;
            background: rgba(0, 0, 0, 0.774);
            color: gray;
            font-size: 2rem;
            min-height: 65px;
            width: 100%;
            top: 0;
            left: 0;
            border-radius: 10px;
            max-height: 30vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .contendor_mensajes {
            background: rgb(44, 44, 44);
            overflow: auto;
            height: auto;
            min-height: 40px;
            max-height: 30vh;
            padding: 20px;
            width: 100%;
            border: solid 1px gray;
            border-radius: 10px;
        }

        .contendor_mensajes .mensaje {
            position: relative;
            border-radius: 5px;
            max-width: 50%;
            display: flex;
            vertical-align: middle;
            margin-bottom: 8px;
        }

        .contendor_mensajes .derecha {
            margin-left: auto;
        }

        .contendor_mensajes .mensaje .texto {
            border-radius: 5px;
            width: 100%;
            padding: 5px;
            background: rgb(224, 225, 255, 1);
            border: solid 1px gray;
            margin-left: 5px;
        }

        .contendor_mensajes .derecha .texto {
            background: rgb(191, 255, 193, 1);
        }

        .contendor_mensajes .mensaje .texto .usuario {
            font-weight: bold;
        }

        .contendor_mensajes .mensaje .texto p {
            margin-bottom: 5px;
        }

        .contendor_mensajes .mensaje .texto .fecha {
            color: gray;
            font-size: 0.8em;
        }

        .contendor_mensajes .derecha .texto {
            margin-left: 0px;
            margin-right: 5px;
        }

        .contendor_mensajes .mensaje .foto {
            display: flex;
        }

        .contendor_mensajes .mensaje.derech .foto {
            right: -10px;
        }

        .contendor_mensajes .mensaje .foto img {
            margin: auto;
            height: 25px;
            border-radius: 50%;
        }

        #mensaje_txt {
            overflow: auto;
        }
    </style>
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
                        <li class="breadcrumb-item"><a href="{{ route('desempeno_estudiantes.index') }}">Desempeño académico
                                estudiantes</a></li>
                        <li class="breadcrumb-item active">Chat</li>
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
                        <div class="card-header">
                            <p><b>Estudiante: </b> {{ $desempeno_estudiante->estudiante->full_name }}</p>
                            <p><b>Materia: </b> {{ $desempeno_estudiante->materia->nombre }}</p>
                            <p><b>Desempeño: </b> {{ $desempeno_estudiante->desempeno }}</p>
                            <p><b>Valoración: </b> {{ $desempeno_estudiante->valoración }}</p>
                            <p><b>Fecha: </b> {{ $desempeno_estudiante->fecha }}</p>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Chat Profesor - Tutor(es)</h4>
                                </div>
                                @if (Auth::user()->tipo == 'PROFESOR')
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Seleccione tutor</label>
                                            <select name="select_receptor" id="select_receptor" class="form-control">
                                                {!! $options !!}
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" id="select_receptor" value="{{ $desempeno_estudiante->user_id }}">
                                @endif
                                <div class="col-md-12">
                                    <div class="contenedor_chat">
                                        <div class="cargando oculto" id="cargando_chat">
                                            <i class="fa fa-spinner fa-spin"></i>
                                        </div>
                                        <div class="contendor_mensajes" id="contendor_mensajes">

                                        </div>
                                        <div class="contenedor_input mt-2">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea name="mensaje_txt" id="mensaje_txt" placeholder="Enviar mensaje...." class="form-control"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="btn btn-success" id="btnEnviar"><i class="fa fa-paper-plane"></i>
                                                Enviar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <input type="hidden" value="{{ route('chat_desempeno.getMensajes') }}" id="urlGetMensajes">
    <input type="hidden" value="{{ route('chat_desempeno.getNuevosMensajes') }}" id="urlGetNuevosMensajes">
    <input type="hidden" value="{{ route('chat_desempeno.store', $desempeno_estudiante->id) }}" id="urlStoreMensajes">
@endsection
@section('scripts')
    <script>
        let valor_ultimo_id = 0;
        let contendor_mensajes = $("#contendor_mensajes");
        let select_receptor = $("#select_receptor");
        let cargando_chat = $("#cargando_chat");
        let mensaje_txt = $("#mensaje_txt");
        let btnEnviar = $("#btnEnviar");
        let intervaloNuevos = null;
        let mensajes_actuales = null;
        let contador_tiempo = 0;
        $(document).ready(function() {
            getMensajes();
            select_receptor.change(getMensajes);
            mensaje_txt.keypress(function(e) {
                if (e.charCode == 13) {
                    if (!e.shiftKey) {
                        enviarMensaje();
                    }
                }
                autoHeightTextArea();
            });
            btnEnviar.click(enviarMensaje);
        });

        function autoHeightTextArea() {
            mensaje_txt[0].style.height = 'auto';
            mensaje_txt[0].style.height = (mensaje_txt[0].scrollHeight) + 'px';
        }

        function posicionarScroll() {
            let altoScroll = contendor_mensajes.prop("scrollHeight");
            contendor_mensajes.scrollTop(altoScroll);
        }

        function getMensajes() {
            cargando_chat.removeClass("oculto");
            if (select_receptor.val() != "") {
                contendor_mensajes.html("Cargando...");
                $.ajax({
                    type: "GET",
                    url: $("#urlGetMensajes").val(),
                    data: {
                        receptor_id: select_receptor.val()
                    },
                    dataType: "json",
                    success: function(response) {
                        contendor_mensajes.html(response.html);
                        ultimo_mensaje = contendor_mensajes.children(".mensaje:last-child");
                        if (ultimo_mensaje) {
                            valor_ultimo_id = ultimo_mensaje.attr("data-id");
                        }
                        setTimeout(() => {
                            posicionarScroll();
                            intervaloNuevos = setInterval(getNuevosMensajes, 1500);
                        }, 100);
                        cargando_chat.addClass("oculto");
                        if (response.sw) {
                            quitaSinMensajes();
                        } else {
                            valor_ultimo_id = 0;
                        }
                    }
                });
            } else {
                contendor_mensajes.html("Seleccione un tutor para el chat");
                cargando_chat.addClass("oculto");
            }
        }

        function getNuevosMensajes() {
            $.ajax({
                type: "GET",
                url: $("#urlGetNuevosMensajes").val() + '?ultimo_id=' + valor_ultimo_id,
                data: {
                    receptor_id: select_receptor.val()
                },
                dataType: "json",
                success: function(response) {
                    contador_tiempo++;
                    if (response.existen_mensajes == 1) {
                        contendor_mensajes.append(response.html);
                    }
                    if (response.existen_mensajes == 0) {
                        let vacio = contendor_mensajes.children(".vacio");
                        if (vacio.length == 0) {
                            contendor_mensajes.append(response.html);
                        }
                    }
                    ultimo_mensaje = contendor_mensajes.children(".mensaje:last-child");
                    let aux_scroll = valor_ultimo_id;
                    if (ultimo_mensaje.length > 0) {
                        valor_ultimo_id = ultimo_mensaje.attr("data-id");
                    }
                    if (aux_scroll != valor_ultimo_id) {
                        setTimeout(() => {
                            posicionarScroll();
                        }, 100);
                    }
                    if (valor_ultimo_id != 0) {
                        quitaSinMensajes();
                    }
                    if (response.mensajes_actuales.length > 0) {
                        mensajes_actuales = response.mensajes_actuales;
                        if (contador_tiempo == 60) {
                            actualizaHoras();
                            contador_tiempo = 0;
                        }
                    }
                    // eliminar duplicados
                    eliminaDuplicados();
                }
            });
        }

        function actualizaHoras() {
            mensajes_actuales.forEach(elem => {
                let mensaje = contendor_mensajes.find('.mensaje[data-id="' + elem.id + '"]');
                if (mensaje.length > 0) {
                    mensaje.find(".fecha").text(elem.hace);
                }
            });
        }

        function enviarMensaje() {
            clearInterval(intervaloNuevos);
            if (select_receptor.val() != "") {
                if (mensaje_txt.val().trim() != "") {
                    $.ajax({
                        headers: {
                            'x-csrf-token': $('#token').val()
                        },
                        type: "POST",
                        url: $("#urlStoreMensajes").val(),
                        data: {
                            receptor_id: select_receptor.val(),
                            mensaje: mensaje_txt.val(),
                        },
                        dataType: "json",
                        success: function(response) {
                            mensaje_txt.val("");
                            valor_ultimo_id = response.mensaje.id;
                            contendor_mensajes.append(response.html_mensaje);
                            // eliminar duplicados
                            eliminaDuplicados();
                            setTimeout(() => {
                                posicionarScroll();
                            }, 100);
                            setTimeout(function() {
                                intervaloNuevos = setInterval(getNuevosMensajes, 1500);
                            }, 1500)
                        }
                    });
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        function quitaSinMensajes() {
            let vacio = contendor_mensajes.children(".vacio");
            if (vacio)
                vacio.remove();
        }

        function eliminaDuplicados() {
            let mensajes = contendor_mensajes.children(".mensaje");
            mensajes.each(function() {
                let data_id = $(this).attr("data-id");
                let total_iguales = contendor_mensajes.children('.mensaje[data-id="' + data_id + '"]');
                if (total_iguales.length > 1) {
                    total_iguales[0].remove();
                    console.log("ELIMINO UN DUPLICADO " + data_id);
                }
            })
        }
    </script>
@endsection
