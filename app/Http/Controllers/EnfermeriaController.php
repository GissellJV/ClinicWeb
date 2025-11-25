<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class EnfermeriaController extends Controller
{

    public function principal()
    {/*
        return view('inventario.principal');
*/

    }

    public function rolTurno(Request $request)
    {
        // Mes y año actual o enviados desde navegación
        $mes = $request->mes ?? Carbon::now()->month;
        $anio = $request->anio ?? Carbon::now()->year;

        // Nombre del mes
        $mesNombre = Carbon::createFromDate($anio, $mes, 1)->monthName;

        // Crear calendario
        $primerDiaMes = Carbon::createFromDate($anio, $mes, 1);
        $diaSemanaInicio = $primerDiaMes->dayOfWeek; // 0 = domingo
        $diasDelMes = $primerDiaMes->daysInMonth;

        // Llenar calendario (matriz)
        $calendario = [];
        $semana = [];

        // Espacios vacíos antes del día 1
        for ($i = 0; $i < $diaSemanaInicio; $i++) {
            $semana[] = 0;
        }

        // Llenar días del mes
        for ($dia = 1; $dia <= $diasDelMes; $dia++) {
            $semana[] = $dia;

            if (count($semana) == 7) {
                $calendario[] = $semana;
                $semana = [];
            }
        }

        // Completar la última semana
        if (count($semana) > 0) {
            while (count($semana) < 7) {
                $semana[] = 0;
            }
            $calendario[] = $semana;
        }

        // Obtener turnos del mes
        $turnos = TurnoEnfermeria::whereYear('fecha', $anio)
            ->whereMonth('fecha', $mes)
            ->get()
            ->map(function ($t) {
                return (object)[
                    'dia' => Carbon::parse($t->fecha)->day,
                    'enfermera_nombre' => $t->enfermera_nombre,
                    'tipo_turno' => $t->tipo_turno,
                ];
            });

        // Mes siguiente y anterior
        $mesSiguiente = $mes == 12 ? 1 : $mes + 1;
        $anioSiguiente = $mes == 12 ? $anio + 1 : $anio;

        $mesAnterior = $mes == 1 ? 12 : $mes - 1;
        $anioAnterior = $mes == 1 ? $anio - 1 : $anio;

        return view('enfermeria.turno_enfermero', compact(
            'calendario',
            'mes',
            'anio',
            'mesNombre',
            'mesAnterior',
            'mesSiguiente',
            'anioAnterior',
            'anioSiguiente',
            'turnos'
        ));
    }
}
