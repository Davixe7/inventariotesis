<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
  protected $fillable = [
    'fecha_vencimiento',
    'frecuencia',
    'equipo_id',
    'proveedor_id',
    'status',
    'tipo',
  ];

  protected $appends = ['due', 'ultima_aplicacion'];

  public function aplicaciones(){
    return $this->hasMany('App\Aplicacion');
  }

  public function equipo(){
    return $this->belongsTo('App\Equipo');
  }

  public function proveedor(){
    return $this->belongsTo('App\Proveedor');
  }

  public function scopeOfMonth($query){
    return $query
           ->whereBetween('fecha_vencimiento', [now()->startOfMonth(), now()->endOfMonth()])
           ->orWhereHas('aplicaciones', function($query){
             return $query->whereBetween('fecha_aplicacion', [now()->startOfMonth(), now()->endOfMonth()]);
           });
  }

  public function scopePending($query){
    return $query->where('fecha_aplicacion', '<', now()->startOfMonth())->orWhere('fecha_aplicacion', null);
  }

  public function getDueAttribute(){
    $days = \Carbon\Carbon::now()->diffInDays( \Carbon\Carbon::now()->endOfMonth() );
    if( $this->fecha_vencimiento > \Carbon\Carbon::now()->endOfMonth() ){
      return 'success';
    }
    if( $days < 8 ){
      return 'danger';
    }
    return 'warning';
  }

  public function getUltimaAplicacionAttribute(){
    return $this->aplicaciones()->orderBy('created_at', 'DESC')->first();
  }
}
