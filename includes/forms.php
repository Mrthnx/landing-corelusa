<?php

declare(strict_types=1);

function csrf_token(): string
{
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }

    return $_SESSION['csrf_token'];
}

function form_feedback_key(string $path): string
{
    return 'feedback:' . $path;
}

function set_feedback(string $path, string $status, string $message): void
{
    $_SESSION[form_feedback_key($path)] = ['status' => $status, 'message' => $message];
}

function consume_feedback(string $path): ?array
{
    $key = form_feedback_key($path);
    if (!isset($_SESSION[$key])) {
        return null;
    }
    $feedback = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $feedback;
}

function redirect_back(string $path): void
{
    header('Location: ' . $path, true, 303);
    exit;
}

function validate_common_form(array $post): ?string
{
    if (($post['_hp'] ?? '') !== '') {
        return 'Form validation failed.';
    }
    if (!hash_equals((string) ($_SESSION['csrf_token'] ?? ''), (string) ($post['_csrf'] ?? ''))) {
        return 'Invalid session. Reload the page and try again.';
    }
    if (trim((string) ($post['captcha'] ?? '')) !== '7') {
        return 'Invalid captcha. Please answer 3 + 4 correctly.';
    }
    return null;
}

function handle_orcamento(array $post): array
{
    $error = validate_common_form($post);
    if ($error !== null) {
        return ['ok' => false, 'message' => $error];
    }

    $email = filter_var((string) ($post['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        return ['ok' => false, 'message' => 'Please provide a valid email address.'];
    }

    return send_lead_mail('orcamento', $post);
}

function handle_contato(array $post): array
{
    $error = validate_common_form($post);
    if ($error !== null) {
        return ['ok' => false, 'message' => $error];
    }

    $email = filter_var((string) ($post['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    if ($email === false) {
        return ['ok' => false, 'message' => 'Please provide a valid email address.'];
    }

    if (trim((string) ($post['mensagem'] ?? '')) === '') {
        return ['ok' => false, 'message' => 'Message is required.'];
    }

    return send_lead_mail('contato', $post);
}
