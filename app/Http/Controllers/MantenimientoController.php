<?php

namespace App\Http\Controllers;

use App\Mantenimiento;
use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('mantenimiento.index', [
        'mantenimientos' => Mantenimiento::ofMonth()->get()
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $equipos = \App\Equipo::all();
      $proveedores = \App\Proveedor::all();
      return view('mantenimiento.create', compact('equipos','proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
      if( $request->mes_vencimiento >= now()->format('m') ){
        $fecha_vencimiento = now()->startOfYear()->addMonths( $request->mes_vencimiento - 1 );  
      }else{
        $fecha_vencimiento = now()->startOfYear()->addMonths( $request->rate );
      }
      
      Mantenimiento::create([
        'proveedor_id'      => $request->proveedor_id,
        'equipo_id'         => $request->equipo_id,
        'fecha_vencimiento' => $fecha_vencimiento,
        'frecuencia'        => $request->rate,
        'tipo'              => $request->tipo
      ]);

      return redirect()->route('mantenimiento.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mantenimiento  $matenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
      $mantenimiento->update([
        'fecha_aplicacion' => now(),
        'tiempo_parado_mantenimiento' => $request->tiempo_parado_mantenimiento
      ]);
      return response()->json(['data' => $mantenimiento]);
    }
}