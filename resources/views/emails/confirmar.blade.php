<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirma tu registro</title>
</head>
<body>
    <h2>Hola {{ $nombre }}</h2>
    <p>Gracias por registrarte en la plataforma <b>Siorti</b>.</p>
    <p>Para activar tu cuenta, haz clic en el botón de abajo:</p>
    <p>
        <a href="{{ $link }}" 
           style="display:inline-block; padding:10px 20px; background:#4CAF50; color:#fff; text-decoration:none; border-radius:5px;">
           Confirmar mi cuenta
        </a>
    </p>
    <p>Si no creaste esta cuenta, puedes ignorar este mensaje.</p>
</body>
</html>
