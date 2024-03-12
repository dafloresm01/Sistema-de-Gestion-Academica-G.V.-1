@if (count($mensajes) > 0)
    @foreach ($mensajes as $mensaje)
        @include('chat_desempeno.parcial.mensaje')
    @endforeach
@else
    <div class="row vacio">
        <div class="col-md-12 text-center"><i class="text-white">SIN MENSAJES</i></div>
    </div>
@endif
