<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnConsulta = document.getElementById('btnConsulta');
    const btnRegistro = document.getElementById('btnRegistro');
    const formConsulta = document.getElementById('formConsulta');
    const formRegistro = document.getElementById('formRegistro');

    if (btnConsulta) {
        btnConsulta.addEventListener('click', () => {
            formConsulta.classList.remove('d-none');
            formRegistro.classList.add('d-none');
        });
    }

    if (btnRegistro) {
        btnRegistro.addEventListener('click', () => {
            formRegistro.classList.remove('d-none');
            formConsulta.classList.add('d-none');
        });
    }
});
</script>
