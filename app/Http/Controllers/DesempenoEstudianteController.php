<?php

namespace App\Http\Controllers;

use App\Campo;
use App\DesempenoEstudiante;
use App\DesempenoNotificacion;
use App\Estudiante;
use App\Inscripcion;
use App\ProfesorMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DesempenoEstudianteController extends Controller
{
    public function index(Request $request)
    {
        $desempeno_estudiantes = DesempenoEstudiante::all();
        if (isset($request->id)) {
            if (Auth::user()->tipo == 'PROFESOR') {
                $desempeno_estudiantes = DesempenoEstudiante::where("user_id", $request->id)->get();
            }
        }
        if (Auth::user()->tipo == 'TUTOR') {
            if (Auth::user()->user_tutor) {
                $estudiante = Estudiante::where("user_tutor_id", Auth::user()->id)->get()->first();
            }
            if (Auth::user()->user_madre) {
                $estudiante = Estudiante::where("user_madre_id", Auth::user()->id)->get()->first();
            }
            Auth::user()->desempeno_notificacions()->update(["visto" => 1]);
            $desempeno_estudiantes = DesempenoEstudiante::where("estudiante_id", $estudiante->id)->get();
        }
        return view('desempeno_estudiantes.index', compact('desempeno_estudiantes'));
    }

    public function create()
    {
        $gestion = date("Y");
        $profesor_materias = ProfesorMateria::where("profesor_id", Auth::user()->profesor->id)
            ->where("gestion", $gestion)
            ->get();
        $array_profesor_materias[''] = 'Seleccione...';
        foreach ($profesor_materias as $value) {
            $array_profesor_materias[$value->id] = $value->materia->nombre;
        }
        return view('desempeno_estudiantes.create', compact('array_profesor_materias', "gestion"));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $inscripcion = Inscripcion::find($request->inscripcion_id);
            $request["user_id"] = Auth::user()->id;
            $request["fecha_registro"] = date("Y-m-d");
            $request["estudiante_id"] = $inscripcion->estudiante_id;
            $desempeno_estudiante = DesempenoEstudiante::create(array_map('mb_strtoupper', $request->all()));
            $estudiante = Estudiante::find($desempeno_estudiante->estudiante_id);
            // registrar notificaciones
            if ($estudiante->user_tutor) {
                DesempenoNotificacion::create([
                    "desempeno_id" => $desempeno_estudiante->id,
                    "fecha" => date("Y-m-d"),
                    "hora" => date("H:i"),
                    "desempeno" => $desempeno_estudiante->desempeno,
                    "valoracion" => $desempeno_estudiante->valoracion,
                    "fecha_registro" => date("Y-m-d"),
                    "user_id" => $estudiante->user_tutor->id,
                    "visto" => 0
                ]);
            }
            if ($estudiante->user_madre) {
                DesempenoNotificacion::create([
                    "desempeno_id" => $desempeno_estudiante->id,
                    "fecha" => date("Y-m-d"),
                    "hora" => date("H:i"),
                    "desempeno" => $desempeno_estudiante->desempeno,
                    "valoracion" => $desempeno_estudiante->valoracion,
                    "fecha_registro" => date("Y-m-d"),
                    "user_id" => $estudiante->user_madre->id,
                    "visto" => 0
                ]);
            }
            DB::commit();
            return redirect()->route('desempeno_estudiantes.index', ["id" => Auth::user()->id])->with('bien', 'Registro realizado con éxito');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error durante el registro');
        }
    }

    public function edit(DesempenoEstudiante $desempeno_estudiante)
    {
        $gestion = date("Y");
        $profesor_materias = ProfesorMateria::where("profesor_id", Auth::user()->profesor->id)
            ->where("gestion", $gestion)
            ->get();
        $array_profesor_materias[''] = 'Seleccione...';
        foreach ($profesor_materias as $value) {
            $array_profesor_materias[$value->id] = $value->materia->nombre;
        }
        return view('desempeno_estudiantes.edit', compact('desempeno_estudiante', 'array_profesor_materias', 'gestion'));
    }

    public function update(DesempenoEstudiante $desempeno_estudiante, Request $request)
    {

        DB::beginTransaction();
        try {
            $desempeno_estudiante->update(array_map('mb_strtoupper', $request->all()));

            // registrar notificaciones
            if ($desempeno_estudiante->estudiante->user_tutor) {
                $exisnte_notificacion = DesempenoNotificacion::where("desempeno_id", $desempeno_estudiante->id)
                    ->where("user_id", $desempeno_estudiante->estudiante->user_tutor->id)
                    ->get()->first();
                if ($exisnte_notificacion) {
                    $exisnte_notificacion->update([
                        "desempeno" => $desempeno_estudiante->desempeno,
                        "valoracion" => $desempeno_estudiante->valoracion,
                    ]);
                } else {
                    DesempenoNotificacion::create([
                        "desempeno" => $desempeno_estudiante->desempeno,
                        "valoracion" => $desempeno_estudiante->valoracion,
                        "fecha_registro" => date("Y-m-d"),
                        "user_id" => $desempeno_estudiante->estudiante->user_tutor->id,
                        "visto" => 0
                    ]);
                }
            }
            if ($desempeno_estudiante->estudiante->user_madre) {
                $exisnte_notificacion = DesempenoNotificacion::where("desempeno_id", $desempeno_estudiante->id)
                    ->where("user_id", $desempeno_estudiante->estudiante->user_madre->id)
                    ->get()->first();
                if ($exisnte_notificacion) {
                    $exisnte_notificacion->update([
                        "desempeno" => $desempeno_estudiante->desempeno,
                        "valoracion" => $desempeno_estudiante->valoracion,
                    ]);
                } else {
                    DesempenoNotificacion::create([
                        "desempeno" => $desempeno_estudiante->desempeno,
                        "valoracion" => $desempeno_estudiante->valoracion,
                        "fecha_registro" => date("Y-m-d"),
                        "user_id" => $desempeno_estudiante->estudiante->user_madre->id,
                        "visto" => 0
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('desempeno_estudiantes.index', ["id" => Auth::user()->id])->with('bien', 'Registro modificado con éxito');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error durante el registro');
        }
    }

    public function show(DesempenoEstudiante $desempeno_estudiante)
    {
        return 'mostrar cargo';
    }

    public function destroy(DesempenoEstudiante $desempeno_estudiante)
    {
        $desempeno_estudiante->desempeno_notificacions()->delete();
        $desempeno_estudiante->delete();
        return redirect()->route('desempeno_estudiantes.index', ["id" => Auth::user()->id])->with('bien', 'Registro eliminado correctamente');
    }

    public function getNotificaciones(Request $request)
    {
        $ultimo_id = $request->ultimo_id;
        $no_vistos = count(DesempenoNotificacion::where("user_id", Auth::user()->id)->where("visto", 0)->get());
        $total = count(DesempenoNotificacion::where("user_id", Auth::user()->id)->get());
        $notificaciones = DesempenoNotificacion::where("user_id", Auth::user()->id)->where("visto", 0)->orderBy("created_at", "desc")->get();
        if ($ultimo_id != 0) {
            $notificaciones = DesempenoNotificacion::where("user_id", Auth::user()->id)->where("visto", 0)->where("id", ">", $ultimo_id)->orderBy("created_at", "desc")->get();
        }

        $html = "";
        $ultimo_id = 0;
        if (count($notificaciones) > 0) {
            $ultimo_id = $notificaciones[0]->id;
            $html = view("desempeno_estudiantes.parcial.notificaciones", compact("notificaciones"))->render();
        }
        if ($total > 0) {
            $ultimo_id = DesempenoNotificacion::where("user_id", Auth::user()->id)->get()->last()->id;
        }

        return response()->JSON([
            "no_vistos" => $no_vistos,
            "html" => $html,
            "ultimo_id" => $ultimo_id
        ]);
    }
}
