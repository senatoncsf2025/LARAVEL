<div class="card p-4 d-none mt-4" id="formRegistro">
    <h4 class="mb-3">Registrar Nuevo {{ ucfirst(Str::singular($rol)) }}</h4>
    <form method="POST" action="{{ route($rol.'.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre') }}" required>
                @error('nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                       value="{{ old('apellido') }}">
                @error('apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Cédula</label>
                <input type="text" name="cedula" class="form-control @error('cedula') is-invalid @enderror"
                       value="{{ old('cedula') }}" required>
                @error('cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                       value="{{ old('telefono') }}">
                @error('telefono') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                   value="{{ old('direccion') }}">
            @error('direccion') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        {{-- Vehículo --}}
        <h5 class="mt-4">Vehículo</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae vehículo?</label>
            <select name="trae_vehiculo" id="trae_vehiculo" class="form-control">
                <option value="0" {{ old('trae_vehiculo')==0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_vehiculo')==1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="vehiculoFields" style="{{ old('trae_vehiculo') ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-3 mb-3"><input type="text" name="placa" placeholder="Placa" class="form-control" value="{{ old('placa') }}"></div>
                <div class="col-md-3 mb-3"><input type="text" name="marca" placeholder="Marca" class="form-control" value="{{ old('marca') }}"></div>
                <div class="col-md-3 mb-3"><input type="text" name="modelo" placeholder="Modelo" class="form-control" value="{{ old('modelo') }}"></div>
                <div class="col-md-3 mb-3"><input type="text" name="color" placeholder="Color" class="form-control" value="{{ old('color') }}"></div>
            </div>
        </div>

        {{-- PC --}}
        <h5 class="mt-4">Computador</h5>
        <div class="mb-3">
            <label class="form-label">¿Trae PC?</label>
            <select name="trae_pc" id="trae_pc" class="form-control">
                <option value="0" {{ old('trae_pc')==0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ old('trae_pc')==1 ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="pcFields" style="{{ old('trae_pc') ? 'display:block;' : 'display:none;' }}">
            <div class="row">
                <div class="col-md-6 mb-3"><input type="text" name="serial" placeholder="Serial" class="form-control" value="{{ old('serial') }}"></div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Registrar {{ ucfirst(Str::singular($rol)) }}</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const vehiculo = document.getElementById('trae_vehiculo');
    const vehiculoFields = document.getElementById('vehiculoFields');
    if (vehiculo) vehiculo.addEventListener('change', () => {
        vehiculoFields.style.display = vehiculo.value == '1' ? 'block' : 'none';
    });

    const pc = document.getElementById('trae_pc');
    const pcFields = document.getElementById('pcFields');
    if (pc) pc.addEventListener('change', () => {
        pcFields.style.display = pc.value == '1' ? 'block' : 'none';
    });
});
</script>
