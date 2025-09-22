@extends('layouts.app')

@section('title', 'Sección Visitantes')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Módulo de Visitantes</h2>

    <div class="text-center mb-4">
        <button class="btn btn-primary mx-2" id="btnConsulta">Consulta</button>
        <button class="btn btn-success mx-2" id="btnRegistro">Registro Visitante</button>
    </div>

    @include('secciones.partials.consulta_form', ['rol' => 'visitantes'])
    @include('secciones.partials.registro_form', ['rol' => 'visitantes'])
</div>
@endsection

@push('scripts')
@include('secciones.partials.toggle_forms')
@endpush
