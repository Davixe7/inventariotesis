<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $comprasmes = \App\Compra::select(['fecha_compra'])
              ->selectRaw("SUM(total) as total_mes")
              ->where('estado','Registrado')
              ->groupBy('fecha_compra')
              ->get();

    $mantenimientos_mes = \App\Mantenimiento::selectRaw('monthname(fecha_vencimiento) as mes')
                                            ->selectRaw('count(*) as total')
                                            ->groupBy('mes')
                                            ->whereBetween('fecha_vencimiento', [\Carbon\Carbon::now()->firstOfMonth()->addMonths(-6), \Carbon\Carbon::now()->lastOfMonth()])
                                            ->get();

    $meses = $mantenimientos_mes->pluck('mes')->toArray();
    $total = $mantenimientos_mes->pluck('total')->toArray();

    $chart = [
      'type' => 'bar',
      'data' => [
        'labels' => $meses,
        'datasets' => [
          [
            'label' => 'Completados por Mes',
            'data'  => $total,
            'maxBarThickness' => 5,
            'barThickness'  => 5,
            'minBarLength'  => 0,
            'barPercentage' => 1,
            'backgroundColor' => [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
            ],
            'borderWidth' => 1
          ]
        ]
      ],
      'options' => [
        'scales' => [
          'xAxes' => [
            [
              'barPercentage' => 0.4
            ]
          ],
          'yAxes' => [
            [
              'ticks' => [
                'beginAtZero' => true
              ]
            ]
          ]
        ]
      ]
    ];
    
    //dd( $chart );

    //$comprasmes = DB::select('SELECT monthname(c.fecha_compra) as mes, sum(c.total) as totalmes from compras c where c.estado="Registrado" group by monthname(c.fecha_compra) order by month(c.fecha_compra) desc limit 12');

    $equiposvendidos  = DB::select('SELECT p.nombre as equipo, sum(dv.cantidad) as cantidad from equipos p inner join detalle_ventas dv on p.id=dv.equipo_id inner join ventas v on dv.venta_id=v.id where v.estado="Registrado" and year(v.fecha_venta)=year(curdate()) group by p.nombre order by sum(dv.cantidad) desc limit 10');
    $avg_tiempo_respuesta = \App\Mantenimiento::selectRaw('fecha_aplicacion - fecha_vencimiento as tiempo_respuesta')->get()->avg('tiempo_respuesta');

    //$totales = DB::select('SELECT (select ifnull(sum(c.total),0) from compras c where DATE(c.fecha_compra)=curdate() and c.estado="Registrado") as totalcompra, (select ifnull(sum(v.total),0) from ventas v where DATE(v.fecha_venta)=curdate() and v.estado="Registrado") as totalventa');
    $totales = [];
    return view('home', [
      "comprasmes"        => $comprasmes,
      "equiposvendidos" => $equiposvendidos,
      "totales" => $totales,
      "chart"   => $chart,
      "avg_tiempo_respuesta" => $avg_tiempo_respuesta
    ]);
  }
}
