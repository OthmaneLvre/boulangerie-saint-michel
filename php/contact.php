<?php

// Vérifie que la requête est en POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo "Méthode non autorisée.";
    exit;
}

// Nettoyage des données
function clean_input($data) {
    return htmlspecialchars(trim($data));
}

$name = clean_input($_POST["name"] ?? "");
$email = clean_input($_POST["email"] ?? "");
$message = clean_input($_POST["message"] ?? "");

// Validtion simple
$errors = [];

if (empty($name)) {
    $errors[] = "Le nom est requis.";
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email invalide.";
}

if (!empty($message)) {
    $errors[] = "Le message est requis.";
}

// Si erreurs
if (!empty($errors)) {
    echo implode("<br>", $errors);
    exit;
}

// Configuration email
$to = "contact@boulangerie-saint-michel.fr";
$subject = "Nouveau message depuis le site";
$headers = "From: $email\r\n";

$body = "Nom : $name\n";
$body .= "Email : $email\n\n";
$body .= "Message :\n$message";

// Envoi du mail
if (mail($to, $subject, $body, $headers)) {
    echo "Message envoyé avec succès.";
} else {
    echo "Erreur lors de l'envoi.";
}
