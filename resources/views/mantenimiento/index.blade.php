@extends('principal')
@section('contenido')
<main class="main">
  <!-- Breadcrumb -->
  <ol class="breadcrumb">
    <li class="breadcrumb-item active"><a href="/">BACKEND - SISTEMA DE COMPRAS - VENTAS</a></li>
  </ol>
  <div id="app" class="container-fluid">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <h2>
          Mantenimientos Agendados
        </h2>
        <a class="btn btn-primary btn-lg ml-auto" href="{{ route('mantenimiento.create') }}">
          <i class="fa fa-plus mr-2"></i>
          Agendar Mantenimiento
        </a>
      </div>
      <div class="card-body">
        @if( $mantenimientos->count() )
          <table class="table table-bordered table-striped" id="mantenimientos-table">
            <thead>
              <tr class="bg-primary">
                <th>
                  Tipo
                </th>
                <th>
                  Equipo
                </th>
                <th>
                  Serie
                </th>
                <th>
                  Proveedor
                </th>
                <th>
                  Fecha Correspondiente
                </th>
                <th>
                  Estado
                </th>
                <th>
                  Acciones
                </th>
              </tr>
            </thead>
            <tbody>
              @foreach( $mantenimientos as $mantenimiento )
                <tr class="bg-{{ $mantenimiento->due }}">
                  <td>
                    {{ $mantenimiento->tipo }}
                  </td>
                  <td>
                    {{ $mantenimiento->equipo->nombre }}
                  </td>
                  <td>
                    {{ $mantenimiento->equipo->activo_fijo }}
                  </td>
                  <td>
                    {{ $mantenimiento->proveedor->nombre }}
                  </td>
                  <td>
                    {{ $mantenimiento->fecha_vencimiento }}
                  </td>
                  <td>
                    @if( $mantenimiento->fecha_aplicacion )
                      Aplicado el
                      {{ $mantenimiento->fecha_aplicacion }}
                    @else
                      Pendiente
                    @endif
                  </td>
                  <td>
                      @if( $mantenimiento->due != 'success')
                      <btn-aplicar-servicio
                        :service="{{ $mantenimiento->id }}"
                        @servicesetup="openModal"
                      />
                      @else
                        <button href="#">
                          Descargar PDF
                        </button>
                      @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="alert alert-info">
            No hay mantenimientos disponibles para mostrar
          </div>
        @endif
      </div>
    </div>
    <modal-apply-service
      :service="service"
      @serviceUpdated="service=null"
    />
  </div>
</main>
@endsection

@section('script')
<link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"></link>
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function(){
    $('#mantenimientos-table').DataTable({
      language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    })
  })
</script>

<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
  Vue.component('btn-aplicar-servicio', {
    template:`
    <button
      @click="setupService()"
      >
      Aplicar
    </button>
    `,
    props: ['service'],
    methods:{
      setupService(){
        this.$emit('servicesetup', this.service)
      }
    }
  })

  Vue.component('modal-apply-service', {
    props: ['service'],
    data(){return {
      disabledBy: null
    }},
    template: `
    <div class="modal" id="applyServiceModal">
      <div class="modal-dialog">
        <div class="modal-content">

          <div class="modal-header">
            <h4 class="modal-title">Aplicar Mantenimiento</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <form ref="applyServiceForm">
              <div class="form-group">
                <label>Tiempo Parado el Equipo por Mantenimiento</label>
                <input type="number" class="form-control" v-model="disabledBy" required/>
              </div>
              <div class="form-group">
              <button v-if="service" @click="applyService" class="btn btn-secondary">
                Aplicar
              </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    `,
    methods:{
      applyService(){
        if( !this.$refs.applyServiceForm.reportValidity() ){ return }
        let data = {
          '_method': 'PUT',
          'tiempo_parado_mantenimiento': this.disabledBy
        }
        axios.post(`mantenimiento/${this.service}`, data).then(data=>{
          this.$emit('serviceUpdated')
          $("#applyServiceModal").modal('hide')
        })
      }
    }
  })

  const app = new Vue({
    el: '#app',
    data(){return{
      service: null
    }},
    methods:{
      openModal(service){
        if( !service ){ return }
        this.service = service
        $("#applyServiceModal").modal()
      }
    }
  })
</script>
@endsection