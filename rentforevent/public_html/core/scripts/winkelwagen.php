<?php
header('Access-Control-Allow-Origin: *');
session_start();

$errors = [];
$data = [];

if (empty($_POST['aantal'])) {
    $errors['aantal'] = 'Er is geen aantal ingevoerd.';
}

if (empty($_POST['artikelId'])) {
    $errors['artikelId'] = 'Onbekend artikel.';
}

if (!empty($errors)) {
    $data['success'] = false;
    $data['errors'] = $errors;
} else {
    $data['success'] = true;
    $data['message'] = 'Toegevoegd aan winkelwagen';

    $_SESSION['cart'][$_POST['artikelId']] = $_POST['aantal'];
}

echo json_encode($data);