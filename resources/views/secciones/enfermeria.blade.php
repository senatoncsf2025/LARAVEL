@extends('layouts.app')

@section('title', 'Sección Enfermería')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Módulo de Enfermería</h2>

    <div class="text-center mb-4">
        <button class="btn btn-primary mx-2" id="btnConsulta">Consulta</button>
        <button class="btn btn-success mx-2" id="btnRegistro">Registro Enfermería</button>
    </div>

    @include('secciones.partials.consulta_form', ['rol' => 'enfermeria'])
    @include('secciones.partials.registro_form', ['rol' => 'enfermeria'])
</div>
@endsection

@push('scripts')
@include('secciones.partials.toggle_forms')
@endpush
