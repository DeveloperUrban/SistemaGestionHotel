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
                        <i class="fa fa-align-justify"></i> Productos
                        <button type="button" @click="abrirModal('producto','registrar')" class="btn btn-secondary">
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
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                     <th>Categoría</th>
                                    <th>Subcategoria</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Precio Venta</th>
                                    <th>Stock</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in arrayProducto" :key="producto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="producto.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProducto(producto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProducto(producto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="producto.nombre_categoria"></td>
                                    <td v-text="producto.nombre_subcategoria"></td>
                                    <td v-text="producto.codigo"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.precio_venta"></td>
                                    <td v-text="producto.stock"></td>
                                    <td v-text="producto.descripcion"></td>
                                    <td>
                                        <div v-if="producto.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Sub Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idsubcategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="subcategoria in arraySubcategoria" :key="subcategoria.id" :value="subcategoria.id" v-text="subcategoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigo" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigo" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precio_venta" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stock" class="form-control" placeholder="">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>
                                <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Actualizar</button>
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
    import VueBarcode from 'vue-barcode';
    export default {
        props : ['ruta'],
        data (){
            return {
                producto_id: 0,
                idcategoria : 0,
                idsubcategoria:0,
                nombre_categoria : '',
                nombre_subcategoria:'',
                codigo : '',
                nombre : '',
                precio_venta : 0,
                stock : 0,
                descripcion : '',
                arrayProducto : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
                errorMostrarMsjProducto : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayCategoria :[],
                arraySubcategoria:[]
            }
        },
        components: {
        'barcode': VueBarcode
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
            listarProducto (page,buscar,criterio){
                let me=this;
                var url='/producto?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            // cargarPdf(){
            //     window.open(this.ruta + '/articulo/listarPdf','_blank');
            // },
            selectCategoria(){
                let me=this;
                var url='/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectSubcategoria(){
                let me=this;
                var url='/subcategoria/selectSubcategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraySubcategoria = respuesta.subcategorias;
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
                me.listarProducto(page,buscar,criterio);
            },
            registrarProducto(){
                if (this.validarProducto()){
                    return;
                }
                
                let me = this;

                axios.post('/producto/registrar',{
                    'idcategoria': this.idcategoria,
                    'idsubcategoria':this.idsubcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarProducto(){
            //    if (this.validarProducto()){
            //         return;
            //     }
                
                let me = this;

                axios.put('/producto/actualizar',{
                    'idcategoria': this.idcategoria,
                    'idsubcategoria':this.idsubcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'precio_venta': this.precio_venta,
                    'stock': this.stock,
                    'descripcion': this.descripcion,
                    'id': this.producto_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarProducto(id){
               Swal.fire({
                title: '¿Desactivar Producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Desactivar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/producto/desactivar',{
                        'id':id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
                        Swal.fire(
                        'Desactivado',
                        'La Producto ha sido desactivado satisfactoriamente',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                }
                })
            },
            activarProducto(id){
               Swal.fire({
                title: '¿Activar Producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Activar'
                }).then((result) => {
                if (result.isConfirmed) {
                    let me = this;
                    axios.put('/producto/activar',{
                        'id':id
                    }).then(function (response) {
                        me.listarProducto(1,'','nombre');
                        Swal.fire(
                        'Activado',
                        'La Producto ha sido activado satisfactoriamente',
                        'success'
                    )
                    }).catch(function (error) {
                        console.log('No tenemos respuesta del servidor');
                        console.log(error);
                    });
                    
                }
                })
            },
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto =[];

                if (this.idcategoria==0) this.errorMostrarMsjProducto.push("Seleccione una categoría.");
                if(this.idsubcategoria==0) this.errorMostrarMsjProducto.push("Seleccione una subcategoria");
                if(!this.codigo) this.errorMostrarMsjProducto.push("El Codigo de producto no puede estar vacío");
                if (!this.nombre) this.errorMostrarMsjProducto.push("El nombre del producto no puede estar vacío.");
                if (!this.precio_venta) this.errorMostrarMsjProducto.push("El precio venta del producto debe ser un número y no puede estar vacío.");
                if (!this.stock) this.errorMostrarMsjProducto.push("El stock del producto debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

                return this.errorProducto;
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
                    case "producto":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Producto';
                                this.idcategoria=0;
                                this.idsubcategoria=0;
                                this.nombre_categoria='';
                                this.nombre_subcategoria='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio_venta=0;
                                this.stock=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Producto';
                                this.tipoAccion=2;
                                this.producto_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.idsubcategoria=data['idsubcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.precio_venta=data['precio_venta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
               this.selectCategoria();
               this.selectSubcategoria();
            }
        },
        mounted() {
            this.listarProducto(1,this.buscar,this.criterio);
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
