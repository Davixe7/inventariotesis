<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
  protected $fillable = [
    'fecha_vencimiento',
    'fecha_aplicacion',
    'frecuencia',
    'equipo_id',
    'proveedor_id',
    'status',
    'tipo',
  ];

  protected $appends = ['due'];

  public function equipo(){
    return $this->belongsTo('App\Equipo');
  }

  public function proveedor(){
    return $this->belongsTo('App\Proveedor');
  }

  public function scopeOfMonth($query){
    return $query->whereBetween('fecha_vencimiento', [now()->startOfMonth(), now()->endOfMonth()]);
  }

  public function scopePending($query){
    return $query->where('fecha_aplicacion', '<', now()->startOfMonth())->orWhere('fecha_aplicacion', null);
  }

  public function getDueAttribute(){
    $days = \Carbon\Carbon::now()->diffInDays( \Carbon\Carbon::now()->endOfMonth() );
    if( $this->fecha_aplicacion > \Carbon\Carbon::now()->startOfMonth() ){
      return 'success';
    }
    if( $days < 8 ){
      return 'danger';
    }
    return 'warning';
  }
}
