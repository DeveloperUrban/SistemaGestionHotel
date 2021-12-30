@extends('principal')
@section('contenido')

<template v-if="menu==0">
  <example-component></example-component>
</template>

<template v-if="menu==1">
  <h1>Vista Recepcion</h1>
</template>

<template v-if="menu==2">
  <h1>Vista Salida</h1>
</template>

<template v-if="menu==3">
  <h1>Vista Habitaciones</h1>
</template>

<template v-if="menu==4">
  <h1>Vista Tipo Habitacion</h1>
</template>

<template v-if="menu==5">
  <h1>Vista Pisos</h1>
</template>

<template v-if="menu==6">
  <h1>Vista Categorias</h1>
</template>

<template v-if="menu==7">
  <h1>Vista Productos</h1>
</template>

<template v-if="menu==8">
  <h1>Vista Ventas</h1>
</template>

<template v-if="menu==9">
  <h1>Vista Clientes</h1>
</template>

<template v-if="menu==10">
  <h1>Vista Usuarios</h1>
</template>

<template v-if="menu==11">
  <h1>Vista Roles</h1>
</template>

<template v-if="menu==12">
  <h1>Vista Reporte Recepcion</h1>
</template>

<template v-if="menu==13">
  <h1>Vista Reporte Ventas</h1>
</template>
@endsection