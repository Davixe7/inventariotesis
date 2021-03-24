<div class="sidebar">
  <nav class="sidebar-nav">
    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="{{url('home')}}" onclick="event.preventDefault(); document.getElementById('home-form').submit();">
          <i class="fa fa-list"></i>
          Dashboard
        </a>

        <form id="home-form" action="{{url('home')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-title">
        Menú
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('clasificacion')}}" onclick="event.preventDefault(); document.getElementById('clasificacion-form').submit();">
          <i class="fa fa-list"></i> 
          Clasificaciones
        </a>
        <form id="clasificacion-form" action="{{url('clasificacion')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('equipo')}}" onclick="event.preventDefault(); document.getElementById('equipo-form').submit();"><i class="fa fa-list"></i> Equipos</a>

        <form id="equipo-form" action="{{url('equipo')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('proveedor')}}" onclick="event.preventDefault(); document.getElementById('proveedor-form').submit();"><i class="fa fa-users"></i> Proveedores</a>
        <form id="proveedor-form" action="{{url('proveedor')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('mantenimiento.index' )}}" onclick="event.preventDefault(); document.getElementById('mantenimiento-form').submit();">
          <i class="fa fa-wrench"></i>
          Mantenimientos
        </a>
        <form id="mantenimiento-form" action="{{ route('mantenimiento.index' )}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{url('compra')}}" onclick="event.preventDefault(); document.getElementById('compra-form').submit();"><i class="fa fa-shopping-cart"></i> Compras</a>
        <form id="compra-form" action="{{url('compra')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('venta')}}" onclick="event.preventDefault(); document.getElementById('venta-form').submit();"><i class="fa fa-suitcase"></i> Ventas</a>
        <form id="venta-form" action="{{url('venta')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('cliente')}}" onclick="event.preventDefault(); document.getElementById('cliente-form').submit();"><i class="fa fa-users"></i> Clientes</a>
        <form id="cliente-form" action="{{url('cliente')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="{{url('user')}}" onclick="event.preventDefault(); document.getElementById('user-form').submit();"><i class="fa fa-user"></i> Usuarios</a>
        <form id="user-form" action="{{url('user')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{url('rol')}}" onclick="event.preventDefault(); document.getElementById('rol-form').submit();"><i class="fa fa-list"></i> Roles</a>
        <form id="rol-form" action="{{url('rol')}}" method="GET" style="display: none;">
          {{csrf_field()}}
        </form>
      </li>


    </ul>
  </nav>
  <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>