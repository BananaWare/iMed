@extends('layouts.default')
@section('title', 'Inicio')
@section('section')
<!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Bienvenido</h1>
        <p>iMed es un servicio que te permite mantener todos los datos de tu consulta médica en un solo lugar. Administra tus pacientes, sus citaciones, sus fichas médicas y al personal que trabaja contigo de una manera profesional, fácil y rápida.</p>
        <p><a class="btn btn-primary btn-lg" role="button">Leer más &raquo;</a></p>
      </div>
    </div>

        <div class="col-md-4">
          <h2>Pacientes</h2>
          <p>Manten todo el historial clínico de tus pacientes en un solo lugar. Cada vez que uno de tus pacientes accede a tu consulta, podrás crear recetas y fichas médicas para accederlas en cualquier momento. </p>
          <p><a class="btn btn-primary" href="#" role="button">Ver detalles &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Colaboradores</h2>
          <p>Asigna colaboradores, como por ejemplo, una secretaria, para que se encargue de administrar tu agenda, asignar horas para tus pacientes y atender tus consultas. </p>
          <p><a class="btn btn-primary" href="#" role="button">Ver detalles &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Recetas</h2>
          <p>Prescribe e imprime recetas médicas, seleccionando cada medicamento desde nuestra base de datos. En ella encontraras información detallada de los medicamentos como su nombre comercial y composición.</p>
          <p><a class="btn btn-primary" href="#" role="button">Ver detalles &raquo;</a></p>
        </div>
@stop()