<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    
    protected $fillable = [
      'nombre',
      'marca',
      'modelo',
      'activo_fijo',
      'ubicacion',
      'piso',
      'clasificacion_id',
      'fecha_entrega_servicio',
      'motivo_baja',
      'fecha_baja',
      'imagen',
      'proveedor',
      'ubicacion',
      'piso',
      'motivo_baja',
      'fecha_baja',
      'fecha_entrega_servicio'
    ];

    public function mantenimientos(){
      return $this->hasMany('App\Mantenimiento');
    }
    
    public function clasificacion(){
      return $this->belongsTo('App\Clasificacion');
    }
}
