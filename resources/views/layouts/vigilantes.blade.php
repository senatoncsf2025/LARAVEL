@extends('layouts.app')

@section('title', 'Consulta y Registro')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Bienvenido</h2>

    <!-- Botones principales -->
    <div class="text-center mb-4">
        <button class="btn btn-primary mx-2" id="btnConsulta">Consulta</button>
        <button class="btn btn-success mx-2" id="btnRegistro">Registro</button>
    </div>

    <!-- Formulario de Consulta -->
    <div id="formConsulta" class="card p-4 d-none">
        <h4 class="mb-3">Consulta</h4>
        <form>
            <div class="mb-3">
                <label for="documento" class="form-label">Documento <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="documento" name="documento" required>
            </div>
            <div class="mb-3">
                <label for="codigo_pc" class="form-label">Código del PC (opcional)</label>
                <input type="text" class="form-control" id="codigo_pc" name="codigo_pc">
            </div>
            <button type="submit" class="btn btn-primary">Consultar</button>
        </form>
    </div>

    <!-- Formulario de Registro -->
    <div id="formRegistro" class="card p-4 d-none mt-4">
        <h4 class="mb-3">Registro</h4>
        <form>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="mb-3">
                <label for="codigo_portatil" class="form-label">Código Portátil (últimos 4 del serial) <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="codigo_portatil" name="codigo_portatil" maxlength="4" pattern="\d{4}" placeholder="Ej: 1234" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
                <input type="tel" class="form-control" id="telefono" name="telefono" pattern="\d{10}" placeholder="10 dígitos" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <button type="submit" class="btn btn-success">Registrar</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnConsulta = document.getElementById('btnConsulta');
    const btnRegistro = document.getElementById('btnRegistro');
    const formConsulta = document.getElementById('formConsulta');
    const formRegistro = document.getElementById('formRegistro');

    btnConsulta.addEventListener('click', () => {
        formConsulta.classList.remove('d-none');
        formRegistro.classList.add('d-none');
    });

    btnRegistro.addEventListener('click', () => {
        formRegistro.classList.remove('d-none');
        formConsulta.classList.add('d-none');
    });
});
</script>
@endpush
