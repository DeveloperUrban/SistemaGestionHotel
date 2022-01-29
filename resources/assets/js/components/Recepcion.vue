<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reservacion
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterioA">
                                      <option value="numero_documento">Número Documento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRecepcion(1,buscar,criterioA)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarRecepcion(1,buscar,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Documento</th>
                                        <th>Cliente</th>
                                        <th>N° Habitacion</th>
                                        <th>Habitacion</th>
                                        <th>Precio</th>
                                        <th>N° Noches</th>
                                        <th>Total</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Fecha Salida</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="recepcion in arrayRecepcion" :key="recepcion.id">
                                        <td>
                                            <button type="button" @click="verRecepcion(recepcion.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <!-- <button type="button" @click="pdfVenta(venta.id)" class="btn btn-info btn-sm">
                                            <i class="icon-doc"></i>
                                            </button> &nbsp; -->
                                            <template v-if="recepcion.estado=='Registrado'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarRecepcion(recepcion.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <!-- <td v-text="venta.usuario"></td> -->
                                        <td v-text="recepcion.numero_documento"></td>
                                        <td v-text="recepcion.apellidos_nombre"></td>
                                        <td v-text="recepcion.numero"></td>
                                        <td v-text="recepcion.detalle"></td>
                                        <td v-text="recepcion.precio"></td>
                                        <td v-text="recepcion.numero_noches"></td>
                                        <td v-text="recepcion.total_recepcion"></td>
                                        <td v-text="recepcion.fecha_ingreso"></td>
                                        <td v-text="recepcion.fecha_salida"></td>
                                        <td v-text="recepcion.estado"></td>

                                     
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">

                        <div class="form-group border">
                                   <div class="row col-md-12">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                        <div class="col-md-12 espacio-arriba">
                                            <h5>Detalle Habitacion</h5>
                                        </div>
                                    </div>
                                    </div>
                               
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                             <label class="col-md-6 form-control-label" for="text-input">Numero(*)</label>
                                             <div class="input-group">
                                                <input type="text" v-model="numero" class="form-control" id="txtdocumento" placeholder="Numero Habitacion">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" id="btnbuscar" type="button" @click="abrirModal()">Buscar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Detalle(*)</label>
                                            <input type="text" v-model="detalle"  class="form-control" placeholder="Detalle Habitacion" disabled>
                                        </div>
                                    </div>

                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Categoria(*)</label>
                                            <input type="text" v-model="nombre_tipohabitacion" class="form-control" placeholder="Categoria Habitacion" disabled>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Piso(*)</label>
                                            <input  type="text" v-model="nombre_piso" class="form-control" placeholder="Piso Habitacion" disabled>
                                        </div>
                                    </div>

                                  </div>
                               
                        </div>

                        <div class="form-group border">
                                   <div class="row col-md">

                                    <div class="col-sm-6" >
                                        <div class="form-group">
                                            <div class="col-md-6 espacio-arriba">
                                              <h5>Datos Cliente</h5>
                                            </div>
                                        </div>

                                       <div class="form-group">
                                        <label for="">Cliente(*)</label>
                                        <v-select
                                            @search="selectCliente"
                                            label="apellidos_nombre"
                                            :options="arrayCliente"
                                            placeholder="Buscar Clientes..."
                                            @input="getDatosCliente" 
                                        >
                                         </v-select>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Numero Documento(*)</label>
                                            <input type="text" v-model="numero_documento" class="form-control" placeholder="Numero Documento" disabled>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Tipo Documento(*)</label>
                                            <input type="text" v-model="tipo_documento" class="form-control" placeholder="Numero Documento" disabled>
                                        </div>
                                     
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Correo(*)</label>
                                            <input type="text" v-model="email" class="form-control" placeholder="Ejemplo@ejemplo.com" disabled>
                                        </div>
                                    </div>

                                    <div class="row col-sm-6">
                                        <div class="form-group col-sm-12">
                                            <div class="espacio-arriba">
                                              <h5>Detalle Reservacion</h5>
                                            </div>
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class=" form-control-label" for="text-input">Fecha Entrada(*)</label>
                                            <input type="date" v-model="fecha_ingreso" class="form-control" placeholder="Detalle Habitacion">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label class="form-control-label" for="text-input">Fecha Salida(*)</label>
                                            <input type="date" v-model="fecha_salida" class="form-control" placeholder="Detalle Habitacion">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class=" form-control-label" for="text-input">Precio(*)</label>
                                            <input type="text" v-model="precio" class="form-control" placeholder="Precio Habitacion" disabled>
                                        </div>

                                         <div class="form-group col-sm-6">
                                            <label class="form-control-label" for="text-input">N° Noches(*)</label>
                                            <input type="number" v-model="numero_noches" class="form-control" placeholder="0">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class=" form-control-label" for="text-input">Total a Pagar(*)</label>
                                            <span v-text="total_recepcion=precio*numero_noches" class="form-control" style="background-color:#c2cfd6;"></span>
                                        </div>

                                          <div class="form-group col-sm-6">
                                            <label class="form-control-label" for="text-input">Tipo Pago(*)</label>
                                             <select class="form-control" v-model="tipo_pago">
                                                <option value="">Seleccione</option>
                                                <option value="EFECTIVO">EFECTIVO</option>
                                                <option value="TARJETA">TARJETA</option>
                                              </select>
                                        </div>

                                         <div class="form-group col-sm-6">
                                            <label class="form-control-label" for="text-input">Adultos(*)</label>
                                            <input type="number" v-model="numero_adultos" class="form-control" placeholder="0">
                                        </div>

                                        <div class="form-group col-sm-6">
                                            <label class="form-control-label" for="text-input">Niños(*)</label>
                                            <input type="number"  v-model="numero_ninos" class="form-control" placeholder="0">
                                        </div>
                                      
                                    </div>

                                    </div>
                        </div>

                       <div class="form-group row end">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarRecepcion()">Reservar</button>
                            </div>
                        </div>
                 
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    
                    <!-- Ver Recepcion -->
                    <template v-else-if="listado==2">
                    
                    <div class="card-body">
                        <div class="card border-secondary mb-3">
                            <div class="card-cabecera">Detalle Habitación</div>
                            <div class="card-body row align-items-center">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Numero</label>
                                        <p class="form-text" v-text="numero"></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Detalle</label>
                                        <p  class="form-text" v-text="detalle"></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-text font-weight-bold mb-0">Categoria</label>
                                    <p class="form-text" v-text="nombre_tipohabitacion"></p>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-text font-weight-bold mb-0">Piso</label>
                                    <p class="form-text" v-text="nombre_piso"></p>
                                </div>
                            </div>
                        </div>

                        <div class="card border-secondary mb-3">
                            <div class="card-cabecera">Detalle Cliente</div>
                            <div class="card-body row align-items-center">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Tipo Documento</label>
                                        <p class="form-text" v-text="tipo_documento"></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Numero Documento</label>
                                        <p class="form-text" v-text="numero_documento"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Apellidos y Nombres</label>
                                        <p  class="form-text" v-text="apellidos_nombre"></p>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Correo</label>
                                        <p  class="form-text" v-text="email"></p>
                                    </div>
                                </div>
                                
                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Celular</label>
                                        <p  class="form-text" v-text="celular"></p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card border-secondary mb-3">
                            <div class="card-cabecera">Detalle Reservación</div>
                            <div class="card-body row align-items-center">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Fecha Ingreso</label>
                                        <p class="form-text" v-text="fecha_ingreso"></p>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Fecha Salida</label>
                                        <p class="form-text" v-text="fecha_salida"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">N° Adultos</label>
                                        <p  class="form-text" v-text="numero_adultos"></p>
                                    </div>
                                </div>

                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">N° Niños</label>
                                        <p  class="form-text" v-text="numero_ninos"></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Tipo Pago</label>
                                        <p  class="form-text" v-text="tipo_pago"></p>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Precio</label>
                                        <p  class="form-control" v-text="precio"></p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">N° Noches</label>
                                        <p  class="form-control" v-text="numero_noches"></p>
                                    </div>
                                </div>

                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="form-text font-weight-bold mb-0">Total Reservacion</label>
                                        <p  class="form-control" v-text="total_recepcion"></p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                            </div>
                         </div>
                    </div>

                 

                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterio">
                                        <option value="numero">Numero</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarHabitacion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarHabitacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Numero</th>
                                            <th>Detalle</th>
                                            <th>Precio</th>
                                            <th>Categoria</th>
                                            <th>Piso</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="habitacion in arrayHabitacion" :key="habitacion.id">
                                            <td>
                                                <button type="button" @click="agregarDetalle(habitacion)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="habitacion.numero"></td>
                                            <td v-text="habitacion.detalle"></td>
                                            <td v-text="habitacion.precio"></td>
                                            <td v-text="habitacion.nombre_tipohabitacion"></td>
                                            <td v-text="habitacion.nombre_piso"></td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        props : ['ruta'],
        data (){
            return {
                id_habitacion: 0,
                arrayHabitacion : [],

                id_cliente:0,
                arrayCliente: [],

                recepcion_id:0,
                apellidos_nombre:'',
                tipo_documento:'',
                numero_documento:'',
                email:'',
                celular:'',
                numero:'',
                detalle:'',
                nombre_tipohabitacion:'',
                nombre_piso:'',

                precio:'',
                numero_noches:1,
                total_recepcion:0,
                tipo_pago:'',
                fecha_ingreso:'',
                fecha_salida:'',
                numero_adultos:0,
                numero_ninos:0,
                
                arrayRecepcion:[],

                
                arrayDetalle : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorVenta : 0,
                errorMostrarMsjVenta : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'numero',
                buscar : '',
                criterioA:'numero_documento',
                buscarA:'',
                   
                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad:0,
                descuento: 0,
                stock:0
            }
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
        },
        methods : {
            listarHabitacion (page,buscar,criterio){
                let me=this;
                var url='/habitacion?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayHabitacion = respuesta.habitaciones.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarRecepcion (page,buscarA,criterioA){
                let me=this;
                var url='/recepcion?page=' + page + '&buscar='+ buscarA + '&criterio='+ criterioA;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRecepcion = respuesta.recepciones.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente(search,loading){
                let me=this;
                loading(true)
                var url='/cliente/selectCliente?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            }, 
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.id_cliente = val1.id;
                me.numero_documento=val1.numero_documento;
                me.tipo_documento=val1.tipo_documento;
                me.email=val1.email;
            },
            // pdfVenta(id){
            //     window.open('/venta/pdf/'+ id + ',' + '_blank');
            // },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarRecepcion(page,buscar,criterio);
            },

            agregarDetalle(data=[]){
                    let me = this;
                    this.id_habitacion=data['id'];
                    this.nombre_piso=data['nombre_piso'];
                    this.nombre_tipohabitacion=data['nombre_tipohabitacion'];
                    this.numero=data['numero'];
                    this.detalle = data['detalle'];
                    this.precio=data['precio'];
                    this.modal=0;
            },
   
            registrarRecepcion(){
                // if (this.validarVenta()){
                //     return;
                // }
                
                let me = this;

                axios.post('/recepcion/registrar',{
                    'id_habitacion': this.id_habitacion,
                    'id_cliente': this.id_cliente,
                    'fecha_ingreso' : this.fecha_ingreso,
                    'fecha_salida' : this.fecha_salida,
                    'numero_noches' : this.numero_noches,
                    'total_recepcion' : this.total_recepcion,
                    'tipo_pago' : this.tipo_pago,
                    'numero_adultos': this.numero_adultos,
                    'numero_ninos' : this.numero_ninos
                }).then(function (response) {
                    me.listado=1;
                    me.listarRecepcion(1,'','numero_documento');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarVenta(){
                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
                var art;
                
                me.arrayDetalle.map(function(x){
                    if (x.cantidad>x.stock){
                        art=x.articulo + " con stock insuficiente";
                        me.errorMostrarMsjVenta.push(art);
                    }
                });

                if (me.idcliente==0) me.errorMostrarMsjVenta.push("Seleccione un Cliente");
                if (me.tipo_comprobante==0) me.errorMostrarMsjVenta.push("Seleccione el comprobante");
                if (!me.num_comprobante) me.errorMostrarMsjVenta.push("Ingrese el número de comprobante");
                if (!me.impuesto) me.errorMostrarMsjVenta.push("Ingrese el impuesto de compra");
                if (me.arrayDetalle.length<=0) me.errorMostrarMsjVenta.push("Ingrese detalles");

                if (me.errorMostrarMsjVenta.length) me.errorVenta = 1;

                return me.errorVenta;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;
                me.recepcion_id=0;
                me.apellidos_nombre='';
                me.tipo_documento='';
                me.numero_documento='';   
                me.email='';
                me.celular='';
                me.numero='';
                me.detalle='';
                me.nombre_tipohabitacion='';
                me.nombre_piso='';
               
                me.precio='';
                me.numero_noches=0;
                me.total_recepcion=0;
                me.tipo_pago='';
                me.fecha_ingreso='';
                me.fecha_salida='';
                me.numero_adultos=0;
                me.numero_ninos=0;
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verRecepcion(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayRecepcionT=[];
                var url= '/recepcion/obtenerRecepcion?id=' + id;
                console.log(url)
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayRecepcionT = respuesta.recepciones;

                    me.apellidos_nombre=arrayRecepcionT[0]['apellidos_nombre'];
                    me.tipo_documento = arrayRecepcionT[0]['tipo_documento'];
                    me.numero_documento=arrayRecepcionT[0]['numero_documento'];
                    me.email = arrayRecepcionT[0]['email'];
                    me.celular = arrayRecepcionT[0]['celular'];
                    me.numero = arrayRecepcionT[0]['numero'];
                    me.detalle = arrayRecepcionT[0]['detalle'];
                    me.nombre_tipohabitacion = arrayRecepcionT[0]['categoria'];
                    me.nombre_piso = arrayRecepcionT[0]['piso'];
                    me.precio = arrayRecepcionT[0]['precio'];
                    me.numero_noches = arrayRecepcionT[0]['numero_noches'];
                    me.total_recepcion = arrayRecepcionT[0]['total_recepcion'];
                    me.tipo_pago = arrayRecepcionT[0]['tipo_pago'];
                    me.fecha_ingreso = arrayRecepcionT[0]['fecha_ingreso'];
                    me.fecha_salida = arrayRecepcionT[0]['fecha_salida'];
                    me.numero_adultos = arrayRecepcionT[0]['numero_adultos'];
                    me.numero_ninos = arrayRecepcionT[0]['numero_ninos'];

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){               
                this.arrayArticulo=[];
                this.listarHabitacion(1,this.buscar,this.criterio);
                this.modal = 1;
                this.tituloModal = 'Seleccione Habitacion';
            },
            desactivarRecepcion(id){
                Swal.fire({
                title: '¿Estas seguro de desactivar la venta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Desactivar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/recepcion/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarRecepcion(1,'','numero_documento');
                        swal(
                        'Anulado!',
                        'La venta ha sido anulada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });

                   }
                })
            },
         
        },
      
        mounted(){
     
         this.listarRecepcion(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
