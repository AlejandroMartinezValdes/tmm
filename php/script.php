<?php
// Configura aquí tu dirección de correo
$destinatario = "alex88mtz@gmail.com";

// Verifica que los datos llegaron por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recoge los datos y limpia entradas
    $nombre = htmlspecialchars(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST["mensaje"]));

    // Valida que no estén vacíos
    if (empty($nombre) || empty($email) || empty($mensaje)) {
        http_response_code(400);
        echo "Por favor completa todos los campos.";
        exit;
    }

    // Valida el email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "El email no es válido.";
        exit;
    }

    // Construye el mensaje
    $asunto = "Nuevo mensaje de contacto";
    $contenido = "Nombre: $nombre\n";
    $contenido .= "Email: $email\n";
    $contenido .= "Mensaje:\n$mensaje\n";
    $cabeceras = "From: $nombre <$email>";

    // Intenta enviar el correo
    if (mail($destinatario, $asunto, $contenido, $cabeceras)) {
        http_response_code(200);
        echo "Mensaje enviado correctamente.";
    } else {
        http_response_code(500);
        echo "No se pudo enviar el mensaje. Inténtalo más tarde.";
    }

} else {
    // Si no se recibe por POST
    http_response_code(403);
    echo "Método no permitido.";
}
?>
