@foreach ($notificaciones as $notificacion)
    <a href="{{route("desempeno_estudiantes.index")}}" class="dropdown-item">
        <i class="fas fa-bell mr-2"></i> {{$notificacion->desempeno}}
        <span class="float-right text-muted text-sm">{{$notificacion->created_at->diffForHumans()}}</span>
    </a>
    <div class="dropdown-divider"></div>
@endforeach
