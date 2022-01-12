@extends('principal')
@section('contenido')

<template v-if="menu==0">
  <dasboard></dasboard>
</template>

<template v-if="menu==1">
  <h1>Vista Recepcion</h1>
</template>

<template v-if="menu==2">
  <h1>Vista Salida</h1>
</template>

<template v-if="menu==3">
  <habitacion></habitacion>
</template>

<template v-if="menu==4">
  <tipohabitacion></tipohabitacion>
</template>

<template v-if="menu==5">
  <piso></piso>
</template>

<template v-if="menu==6">
  <categoria></categoria>
</template>

<template v-if="menu==7">
  <subcategoria></subcategoria>
</template>

<template v-if="menu==8">
  <producto></producto>
</template>

<template v-if="menu==9">
  <h1>Vista Ventas</h1>
</template>

<template v-if="menu==10">
  <h1>Vista Clientes</h1>
</template>

<template v-if="menu==11">
  <h1>Vista Usuarios</h1>
</template>

<template v-if="menu==12">
  <h1>Vista Roles</h1>
</template>

<template v-if="menu==13">
  <h1>Vista Reporte Recepcion</h1>
</template>

<template v-if="menu==14">
  <h1>Vista Reporte Ventas</h1>
</template>
@endsection