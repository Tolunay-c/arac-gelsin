<?php

declare(strict_types=1);

/** Route: POST /lead-submit — handles every "Kurumsal Teklif Al" form on the site. */

use App\Models\LeadRequest;

header('Content-Type: application/json; charset=utf-8');

if (!is_string($_POST['csrf_token'] ?? null) || !hash_equals($_SESSION['csrf_token'] ?? '', (string) $_POST['csrf_token'])) {
    http_response_code(419);
    echo json_encode(['ok' => false, 'error' => 'invalid_csrf']);
    return;
}

$companyName = post('company_name');
$contactName = post('contact_name');
$phone       = post('phone');
$email       = post('email');
$message     = post('message');
$sourcePage  = post('source_page', 'unknown');

$errors = [];
if ($companyName === '') {
    $errors['company_name'] = 'Şirket adı zorunludur.';
}
if ($contactName === '') {
    $errors['contact_name'] = 'Yetkili ad soyad zorunludur.';
}
if ($phone === '') {
    $errors['phone'] = 'Telefon numarası zorunludur.';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Geçerli bir e-posta adresi giriniz.';
}

if ($errors !== []) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'errors' => $errors]);
    return;
}

LeadRequest::create([
    'company_name' => $companyName,
    'contact_name' => $contactName,
    'phone'        => $phone,
    'email'        => $email,
    'message'      => $message !== '' ? $message : null,
    'source_page'  => $sourcePage !== '' ? $sourcePage : null,
    'status'       => LeadRequest::STATUS_NEW,
]);

echo json_encode(['ok' => true, 'message' => 'Talebiniz alındı. Ekibimiz en kısa sürede sizinle iletişime geçecek.']);
