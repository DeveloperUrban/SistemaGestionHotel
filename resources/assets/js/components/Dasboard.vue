<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
             <div class="container-fluid">
                 <div class="row">
                <!-- Ejemplo de tabla Listado -->
                 <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Habitaciones
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-primary" id="habitacionesdisponibles">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Habitaciones Disponibles
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-primary" id="habitacionesdisponibles">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Habitaciones Ocupados
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-primary" id="habitacionesdisponibles">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Habitaciones Limpieza
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-primary" id="habitacionesdisponibles">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-box fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
             </div>
            
        </main>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
