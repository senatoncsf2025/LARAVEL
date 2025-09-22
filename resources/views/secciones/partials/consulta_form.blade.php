<div class="card p-4 d-none" id="formConsulta">
    <h4 class="mb-3">Consulta de {{ ucfirst($rol) }}</h4>
    <form method="POST" action="{{ route($rol.'.movimiento') }}">
        @csrf
        <div class="mb-3">
            <label for="cedula" class="form-label">Documento <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('cedula') is-invalid @enderror"
                   id="cedula" name="cedula" value="{{ old('cedula') }}" required>
            @error('cedula') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Movimiento <span class="text-danger">*</span></label>
            <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                <option value="">Seleccione...</option>
                <option value="ingreso" {{ old('tipo')=='ingreso' ? 'selected' : '' }}>Ingreso</option>
                <option value="salida" {{ old('tipo')=='salida' ? 'selected' : '' }}>Salida</option>
            </select>
            @error('tipo') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones (opcional)</label>
            <textarea name="observaciones" id="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Movimiento</button>
    </form>
</div>
