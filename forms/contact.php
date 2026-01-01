<?php

if ($_SERVER["REQUEST_METHOD"] != "POST") {
  http_response_code(403);
  exit;
}

$name    = strip_tags(trim($_POST["name"]));
$email   = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
$subject = strip_tags(trim($_POST["subject"]));
$message = trim($_POST["message"]);

if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo "Datos inválidos";
  exit;
}

$to = "contacto@webpront.com";
$headers = "From: Webpront <contacto@webpront.com>\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8";

$email_content = "Nombre: $name\n";
$email_content .= "Email: $email\n\n";
$email_content .= "Mensaje:\n$message\n";

if (mail($to, $subject, $email_content, $headers)) {
  echo "OK";
} else {
  http_response_code(500);
  echo "Error al enviar el mensaje";
}

?>
