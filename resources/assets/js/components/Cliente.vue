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
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="apellidos_nombre">Nombre</option>
                                      <option value="num_documento">Documento</option>
                                      <option value="email">Email</option>
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Número</th>
                                    <!-- <th>Departamento</th>
                                    <th>Provincia</th>
                                    <th>Distrito</th> -->
                                    <th>Dirección</th>
                                    <th>Sexo</th>
                                    <th>celular</th>
                                    <th>Email</th>
                                    <th>Empresa</th>
                                    <th>Motivo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                    </td>
                                    <td v-text="persona.apellidos_nombre"></td>
                                    <td v-text="persona.tipo_documento"></td>
                                     <td v-text="persona.numero_documento"></td>
                                    <!-- <td v-text="persona.departamento"></td>
                                    <td v-text="persona.provincia"></td>
                                    <td v-text="persona.distrito"></td> -->
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.sexo"></td>
                                    <td v-text="persona.celular"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.nombre_empresa"></td>
                                    <td v-text="persona.motivo_hospedaje"></td>
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
                               <div class="container">
                                   <div class="row">

                                     <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Apellidos y Nombres(*)</label>
                                            <input type="text" v-model="apellidos_nombre" style="text-transform:uppercase;" class="form-control" placeholder="Apellidos y nombres" required>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Tipo Documento(*)</label>
                                            <select v-model="tipo_documento" class="form-control">
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="PASAPORTE">PASAPORTE</option>
                                        </select>
                                        </div>
                                    </div>

                                      <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Numero Documento(*)</label>
                                            <input type="text" v-model="numero_documento" class="form-control" placeholder="Numero documento">
                                        </div>
                                    </div>

                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-4 form-control-label" for="text-input">Departamento(*)</label>
                                            <select v-model="id_departamento" @change="selectProvincia" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="depa in arrayDepartamentos" :key="depa.id" :value="depa.id" v-text="depa.departamento"></option>
                                        </select>
                                        </div>
                                    </div>

                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-4 form-control-label" for="text-input">Provincia(*)</label>
                                            <select v-model="id_provincia" @change="selectDistrito" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="prov in arrayProvincia" :key="prov.id" :value="prov.id" v-text="prov.provincia"></option>
                                            
                                        </select>
                                        </div>
                                    </div>

                                     <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-4 form-control-label" for="text-input">Distrito(*)</label>
                                            <select v-model="id_distrito" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="dis in arrayDistrito" :key="dis.id" :value="dis.id" v-text="dis.distrito"></option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Dirección(*)</label>
                                            <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-4 form-control-label" for="text-input">Sexo(*)</label>
                                            <select v-model="sexo" class="form-control">
                                            <option value="">Seleccione</option>
                                            <option value="M">MASCULINO</option>
                                            <option value="F">FEMENINO</option>
                                            <option value="O">OTRO</option>
                                        </select>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Celular(*)</label>
                                            <input type="text" v-model="celular" class="form-control" placeholder="Celular">
                                        </div>
                                    </div>

                                     <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Correo(*)</label>
                                            <input type="text" v-model="email" class="form-control" placeholder="Example@gmail.com">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-6 form-control-label" for="text-input">Empresa(*)</label>
                                            <input type="text" v-model="nombre_empresa" class="form-control" placeholder="Nombre empresa">
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-md-12 form-control-label" for="text-input">Motivo Hospedaje(*)</label>
                                            <input  type="text" v-model="motivo_hospedaje" class="form-control" placeholder="Motivo Hospedaje">
                                        </div>
                                    </div>

                                  </div>
                               
                               </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCliente()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()">Actualizar</button>
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
    export default {
        props : ['ruta'],
        data (){
            return {
                persona_id: 0,
                apellidos_nombre: '',
                tipo_documento : 'DNI',
                numero_documento : '',

                id_departamento:0,
                arrayDepartamentos:[],

                id_provincia:0,
                arrayProvincia:[],
                
                id_distrito:0,
                arrayDistrito:[],

                direccion:'',
                sexo:'',
                celular:'',
                email : '',
                nombre_empresa:'',
                motivo_hospedaje:'',
                arrayPersona : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorPersona : 0,
                errorMostrarMsjPersona : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'apellidos_nombre',
                buscar : ''
            }
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
            listarPersona (page,buscar,criterio){
                let me=this;
                var url= '/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
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
                me.listarPersona(page,buscar,criterio);
            },
             selectDepartamento(){
                let me=this;
                var url='/departamento/selectDepartamento';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayDepartamentos = respuesta.departamentos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            selectProvincia(){
                let me=this;
                var url='/provincia/SelectProvincia'
                axios.get(url,{params:{id_departamento:this.id_departamento}}).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProvincia = respuesta.provincias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            selectDistrito(){
                let me=this;
                var url='/distrito/SelectDistrito';
                axios.get(url,{params:{id_provincia:this.id_provincia}}).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayDistrito = respuesta.distritos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            registrarCliente(){
                // if (this.validarPersona()){
                //     return;
                // }
                console.log('Estoy dentro del metodo registrar');
                let me = this;

                axios.post('/cliente/registrar',{
                    'id_departamento': this.id_departamento,
                    'id_provincia': this.id_provincia,
                    'id_distrito' : this.id_distrito,
                    'apellidos_nombre' : this.apellidos_nombre,
                    'tipo_documento' : this.tipo_documento,
                    'numero_documento' : this.numero_documento,
                    'direccion' : this.direccion,
                    'sexo' : this.sexo,
                    'celular':this.celular,
                    'email':this.email,
                    'nombre_empresa':this.nombre_empresa,
                    'motivo_hospedaje':this.motivo_hospedaje
                }).then(function (response) {
                    console.log(response);
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarCliente(){
            //    if (this.validarPersona()){
            //         return;
            //     }
                
                let me = this;

                axios.put('/cliente/actualizar',{
                   'id_departamento': this.id_departamento,
                    'id_provincia': this.id_provincia,
                    'id_distrito' : this.id_distrito,
                    'apellidos_nombre' : this.apellidos_nombre,
                    'tipo_documento' : this.tipo_documento,
                    'numero_documento' : this.numero_documento,
                    'direccion' : this.direccion,
                    'sexo' : this.sexo,
                    'celular':this.celular,
                    'email':this.email,
                    'nombre_empresa':this.nombre_empresa,
                    'motivo_hospedaje':this.motivo_hospedaje,
                    'id': this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la persona no puede estar vacío.");

                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='DNI';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.errorPersona=0;

            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cliente';
                                this.apellidos_nombre= '';
                                this.tipo_documento='DNI';
                                this.numero_documento='';
                                this.id_departamento=0;
                                this.departamento='';
                                this.id_provincia=0;
                                this.provincia='';
                                this.id_distrito=0;
                                this.distrito='';
                                this.direccion='';
                                this.sexo='';
                                this.celular='';
                                this.email='';
                                this.nombre_empresa='';
                                this.motivo_hospedaje='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Cliente';
                                this.tipoAccion=2;
                                this.apellidos_nombre= data['apellidos_nombre'];
                                this.tipo_documento=data['tipo_documento'];
                                this.numero_documento=data['numero_documento'];
                                this.id_departamento=data['id_departamento'];
                                this.id_provincia=data['id_provincia'];
                                this.id_distrito=data['id_distrito'];
                                this.direccion=data['direccion'];
                                this.sexo=data['sexo'];
                                this.celular=data['celular'];
                                this.email=data['email'];
                                this.nombre_empresa=data['nombre_empresa'];
                                this.motivo_hospedaje=data['motivo_hospedaje'];
                                this.persona_id=data['id'];
                                break;
                            
                            }
                        }
                    }
                }

                this.selectDepartamento();
                this.selectProvincia();
                this.selectDistrito();
                
            }
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
