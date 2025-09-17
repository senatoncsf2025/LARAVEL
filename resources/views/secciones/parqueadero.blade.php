@extends('layouts.app')

@section('title', 'Consulta y Registro')

@section('content')
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="container py-5">
  <h2 class="text-center mb-4">PARQUEADERO</h2>

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
      <!-- DATOS DE LA PERSONA QUE INGRESA -->
      <h5 class="text-primary mb-3">Datos del visitante</h5>
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
        <label for="cedula" class="form-label">Cédula <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="cedula" name="cedula" pattern="\d{6,10}"
               placeholder="Solo números" required>
      </div>
      <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono <span class="text-danger">*</span></label>
        <input type="tel" class="form-control" id="telefono" name="telefono" pattern="\d{10}"
               placeholder="10 dígitos" required>
      </div>
      <div class="mb-3">
        <label for="serial_pc" class="form-label">Código Portátil (opcional)</label>
        <input type="text" class="form-control" id="serial_pc" name="serial_pc" maxlength="4"
               pattern="\d{4}" placeholder="Últimos 4 del serial">
      </div>
      <div class="mb-3">
        <label for="direccion" class="form-label">Dirección (opcional)</label>
        <input type="text" class="form-control" id="direccion" name="direccion">
      </div>

      <!-- DATOS DEL VEHÍCULO -->
      <h5 class="text-success mt-4 mb-3">Datos del vehículo</h5>
      <div class="mb-3">
        <label for="cedula_propietario" class="form-label">Cédula del propietario del vehículo <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="cedula_propietario" name="cedula_propietario" pattern="\d{6,10}"
               placeholder="Solo números" required>
      </div>
      <div class="mb-3">
        <label for="placa" class="form-label">Placa del vehículo <span class="text-danger">*</span></label>
        <input type="text" class="form-control text-uppercase" id="placa" name="placa"
               placeholder="Ej: ABC123 (carro) o ABC12 / ABC12D (moto)"
               pattern="^([A-Z]{3}\d{3}|[A-Z]{3}\d{2}[A-Z]?)$"
               title="Carros: ABC123. Motos: ABC12 o ABC12D."
               maxlength="6" required oninput="this.value = this.value.toUpperCase()">
        <div class="form-text">
          Carros: tres letras seguidas de tres números (Ej: <code>ABC123</code>).<br>
          Motos: tres letras, dos números y una letra opcional (Ej: <code>ABC12</code> o <code>ABC12D</code>).<br>
          Use únicamente letras mayúsculas y números, sin espacios ni guiones.
        </div>
      </div>
      <div class="mb-3">
        <label for="marca" class="form-label">Marca <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="marca" name="marca" required>
      </div>
      <div class="mb-3">
        <label for="color" class="form-label">Color <span class="text-danger">*</span></label>
        <input type="text" class="form-control" id="color" name="color" required>
      </div>

      <button type="submit" class="btn btn-success mt-3">Registrar</button>
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

  // Validación extra de placa
  const formReg = formRegistro.querySelector('form');
  formReg.addEventListener('submit', (e) => {
    const placa = document.getElementById('placa').value.trim().toUpperCase();
    const regex = /^([A-Z]{3}\d{3}|[A-Z]{3}\d{2}[A-Z]?)$/;
    if (!regex.test(placa)) {
      e.preventDefault();
      alert('La placa no cumple con el formato colombiano: ABC123 para carro o ABC12/ABC12D para moto.');
    }
  });
});
</script>
@endpush
