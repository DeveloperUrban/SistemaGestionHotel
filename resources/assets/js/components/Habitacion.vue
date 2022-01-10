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
                        <i class="fa fa-align-justify"></i> Habitaciones
                        <button type="button" @click="abrirModal('habitacion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <!-- <button type="button" @click="cargarPdf()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp;Reporte
                        </button> -->
                    </div>
                    <div class="card-body">
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
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Numero</th>
                                    <th>Detalle</th>
                                    <th>Precio</th>
                                    <th>Categoria</th>
                                    <th>Piso</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="habitacion in arrayHabitacion" :key="habitacion.id">
                                    <td>
                                        <button type="button" @click="abrirModal('habitacion','actualizar',habitacion)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="habitacion.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarHabitacion(habitacion.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarHabitacion(habitacion.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="habitacion.numero"></td>
                                    <td v-text="habitacion.detalle"></td>
                                    <td v-text="habitacion.precio"></td>
                                    <td v-text="habitacion.nombre_tipohabitacion"></td>
                                    <td v-text="habitacion.nombre_piso"></td>
                                    <td>
                                        <div v-if="habitacion.estado">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Numero</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="numero" class="form-control" placeholder="Numero Habitacion">                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Detalle</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="detalle" class="form-control" placeholder="Detalle Habitacion">                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio" class="form-control" placeholder="Precio Habitacion">                                        
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Piso</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idpiso">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="piso in arrayPiso" :key="piso.id" :value="piso.id" v-text="piso.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Habitacion</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idtipohabitacion">
                                            <option value="0" disabled>Seleccione</option>                             
                                            <option v-for="tipohabitacion in arrayTipohabitacion" :key="tipohabitacion.id" :value="tipohabitacion.id" v-text="tipohabitacion.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                <div v-show="errorHabitacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjHabitacion" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarHabitacion()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarHabitacion()">Actualizar</button>
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
    // import VueBarcode from 'vue-barcode';
    export default {
        props : ['ruta'],
        data (){
            return {
                habitacion_id: 0,
                idpiso : 0,
                idtipohabitacion:0,
                nombre_piso : '',
                nombre_tipohabitacion : '',
                numero : '',
                detalle : '',
                precio : 0,
                arrayHabitacion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorHabitacion : 0,
                errorMostrarMsjHabitacion : [],
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
                arrayPiso :[],
                arrayTipohabitacion:[]
            }
        },
        components: {
        // 'barcode': VueBarcode
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

            }
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
            // cargarPdf(){
            //     window.open(this.ruta + '/articulo/listarPdf','_blank');
            // },
            seleccionarPiso(){
                let me=this;
                var url= '/piso/selectPiso';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayPiso = respuesta.pisos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            seleccionarTipohabitacion(){
                let me=this;
                var url= '/tipohabitacion/selectTipohabitacion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayTipohabitacion = respuesta.tipohabitaciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarHabitacion(page,buscar,criterio);
            },
            registrarHabitacion(){
                // if (this.validarHabitacion()){
                //     return;
                // }
                
                let me = this;

                axios.post('/habitacion/registrar',{
                    'idpiso':this.idpiso,
                    'idtipohabitacion':this.idtipohabitacion,
                    'numero':this.numero,
                    'detalle':this.detalle,
                    'precio':this.precio
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarHabitacion(1,'','numero');

                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarHabitacion(){
            //    if (this.validarArticulo()){
            //         return;
            //     }
                
                let me = this;
                axios.put('/habitacion/actualizar',{
                    'idpiso': this.idpiso,
                    'idtipohabitacion': this.idtipohabitacion,
                    'numero': this.numero,
                    'detalle':this.detalle,
                    'precio': this.precio,
                    'id':this.habitacion_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHabitacion(1,'','numero');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarHabitacion(id){
                Swal.fire({
                title: '¿Desactivar Habitacion?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Desactivar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/habitacion/desactivar',{
                        'id':id
                    }).then(function (response) {
                        me.listarHabitacion(1,'','numero');
                        Swal.fire(
                        'Desactivado',
                        'La Habitacion ha sido desactivado satisfactoriamente',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                }
                })
            },
            activarHabitacion(id){
              Swal.fire({
                title: '¿Activar Habitacion?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Activar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/habitacion/activar',{
                        'id':id
                    }).then(function (response) {
                        me.listarHabitacion(1,'','numero');
                        Swal.fire(
                        'Activado',
                        'La Habitacion ha sido activado satisfactoriamente',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log('No tenemos respuesta del servidor');
                        console.log(error);
                    });
                    
                }
                })
            },
            validarArticulo(){
                this.errorArticulo=0;
                this.errorMostrarMsjArticulo =[];

                if (this.idcategoria==0) this.errorMostrarMsjArticulo.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjArticulo.push("El nombre del artículo no puede estar vacío.");
                if (!this.stock) this.errorMostrarMsjArticulo.push("El stock del artículo debe ser un número y no puede estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjArticulo.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;

                return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.idcategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
		        this.errorArticulo=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "habitacion":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Habitacion';
                                this.idpiso=0;
                                this.idtipohabitacion=0;
                                this.nombre_piso='';
                                this.nombre_tipohabitacion='';
                                this.numero='';
                                this.detalle= '';
                                this.precio=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Habitacion';
                                this.tipoAccion=2;
                                this.habitacion_id=data['id'];
                                this.idpiso=data['idpiso'];
                                this.idtipohabitacion=data['idtipohabitacion'];
                                this.numero=data['numero'];
                                this.detalle = data['detalle'];
                                this.precio=data['precio'];
                                break;
                            }
                        }
                    }
                }
                this.seleccionarPiso();
                this.seleccionarTipohabitacion();
            }
        },
        mounted() {
            this.listarHabitacion(1,this.buscar,this.criterio);
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
</style>
