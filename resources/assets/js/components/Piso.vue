<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Pisos
                        <button @click="abirModal('piso','registrar')" type="button" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" id="opcion" name="opcion">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="piso in arrayPisos" :key="piso.id">
                                    <td>
                                        <button @click="abirModal('piso','actualizar',piso)" type="button" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button type="button" @click="eliminarPisos(piso.id)" class="btn btn-danger btn-sm" >
                                          <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                    <td v-text="piso.nombre"></td>
                                    <td v-text="piso.descripcion"></td>
                                </tr>
                             
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item">
                                    <a class="page-link" href="#">Ant</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <!--Se agrega la clase bit para modal siempre sea verdadero-->
            <div class="modal fade" id="modalNuevo" tabindex="-1" :class="{'mostrar':modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 v-text="tituloModal" class="modal-title"></h4>
                            <button @click="cerrarModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Descripcion">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                             <button type="button" v-if="tipoAccion==1" @click="registrarPisos()" class="btn btn-primary">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" @click="actualizarPisos()" class="btn btn-primary">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                idpiso:0,
                nombre:'',
                descripcion:'',
                arrayPisos:[],
                modal:0,
                tituloModal:'',
                tipoAccion:1,
                errorPiso:0,
                errorMostrarMsjPiso:[],
                pagination :{
                    'total'         :0,
                    'current_page'   :0,
                    'per_page'       :0,
                    'last_page'      :0,
                    'from'           :0,
                    'to'             :0
                },
                offset:3

            }
        },
        computed:{
            isActived:function(){
                return this.pagination.current_page;
            },

            //Calcula los elementos de la paginacion
            pagesNumber:function(){
                if (!this.pagination.to) { // Es diferente del ultimo elemento de la pagina actual
                    return [];
                }
                //vamos a almacenar la resta de la pagina actual
                var from = this.pagination.current_page-this.offset;
                if(from<1)
                {
                    from=1;
                }

                var to = from + (this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }

                var pagesArray = [];
                while(from<=to  ){

                }
            }
        },
        methods:{
            listarPisos(){
                let me = this;
                axios.get('/piso').then(function (response) {
                    me.arrayPisos=response.data;
                })
                .catch(function (error) {
                    // handle error
                    console.log('No tenemos respuesta del servidor'+error);
                })
            },
            registrarPisos(){
                let me = this;
                axios.post('/piso/registrar', {
                'nombre':me.nombre,
                'descripcion':me.descripcion
                })
                .then(function (response) {
                    me.cerrarModal();
                    me.listarPisos();
                })
                .catch(function (error) {
                    console.log('No hay respuesta del servidor');
                });
            },
            actualizarPisos(){
                let me = this;
                axios.put('/piso/actualizar',{
                    'id':me.idpiso,
                    'nombre':me.nombre,
                    'descripcion':me.descripcion
                }).then(function (response) {
                   me.cerrarModal();
                   me.listarPisos();
                })
                .catch(function (error) {
                    // handle error
                    console.log("No tenemos conexion al servidor");
                })
            },
            eliminarPisos(idpiso){
                Swal.fire({
                title: '¿Estas seguro de Eliminar el Piso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Eliminar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.delete('/piso/eliminar/' + idpiso).then(function (response) {
                        me.listarPisos();                     
                        Swal.fire(
                        'Eliminado',      
                        'El piso a sido eliminado satisfactoriamente',
                        'success'
                    )
                    })
                    .catch(function (error) {
                        // handle error
                        console.log("No tenemos conexion al servidor");
                    })
                }
                })
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
            },
            abirModal(modelo,accion, data=[]){
                if(modelo=="piso"){
                    switch (accion) {
                        case 'registrar':
                        {
                            this.modal=1;
                            this.tipoAccion=1
                            this.tituloModal='Registrar Piso';
                            this.nombre='';
                            this.descripcion='';
                            break;
                        }
                        case 'actualizar':
                        {
                            this.modal=1;
                            this.tituloModal='Actualizar Piso';
                            this.tipoAccion=2;
                            this.idpiso=data['id']
                            this.nombre=data['nombre'];
                            this.descripcion=data['descripcion'];
                            break;
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarPisos();
        }
    }
</script>

<style>

    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: inherit !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;

    }
</style>