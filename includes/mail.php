<?php

declare(strict_types=1);

require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';
require_once __DIR__ . '/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

function load_mail_config(): array
{
    $configPath = __DIR__ . '/config.php';
    if (!file_exists($configPath)) {
        return [];
    }
    $config = require $configPath;
    if (!is_array($config)) {
        return [];
    }
    return $config;
}

function build_phpmailer(array $config): PHPMailer
{
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $config['smtp']['host'] ?? 'localhost';
    $mail->Port       = (int) ($config['smtp']['port'] ?? 587);
    $mail->Username   = $config['smtp']['username'] ?? '';
    $mail->Password   = $config['smtp']['password'] ?? '';
    $mail->SMTPSecure = $config['smtp']['secure'] ?? 'tls';
    $mail->SMTPAuth   = true;
    $mail->CharSet    = PHPMailer::CHARSET_UTF8;

    $fromAddress = $config['mail']['from']['address'] ?? '';
    $fromName    = $config['mail']['from']['name'] ?? '';
    if ($fromAddress !== '') {
        $mail->setFrom($fromAddress, $fromName);
    }

    return $mail;
}

function send_lead_mail(string $formType, array $data): array
{
    $config = load_mail_config();
    if (empty($config)) {
        error_log('Mail config missing or empty');
        return ['ok' => false, 'message' => 'We could not confirm message delivery.'];
    }

    $recipient = $config['mail']['recipients'][$formType] ?? '';
    if ($recipient === '') {
        error_log("Mail recipient missing for form type: {$formType}");
        return ['ok' => false, 'message' => 'We could not confirm message delivery.'];
    }

    try {
        $mail = build_phpmailer($config);
        $mail->addAddress($recipient);

        $nome  = trim((string) ($data['nome'] ?? ''));
        $email = filter_var((string) ($data['email'] ?? ''), FILTER_VALIDATE_EMAIL);

        if (($config['mail']['reply_to_form_email'] ?? true) && $email !== false) {
            $mail->addReplyTo($email, $nome);
        }

        if ($formType === 'orcamento') {
            $subject = 'Website quote request - ' . $nome;
            $body    = build_orcamento_body($data);
        } else {
            $assunto = trim((string) ($data['assunto'] ?? ''));
            $subject = ($assunto !== '' ? $assunto : 'Website contact') . ' - ' . $nome;
            $body    = build_contato_body($data);
        }

        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->isHTML(true);

        $mail->send();
        return ['ok' => true, 'message' => 'Request sent successfully.'];
    } catch (PHPMailerException $e) {
        error_log('PHPMailer error: ' . $e->getMessage());
        return ['ok' => false, 'message' => 'We could not confirm message delivery.'];
    } catch (\Exception $e) {
        error_log('Mail error: ' . $e->getMessage());
        return ['ok' => false, 'message' => 'We could not confirm message delivery.'];
    }
}

function build_orcamento_body(array $data): string
{
    $nome        = htmlspecialchars(trim((string) ($data['nome'] ?? '')), ENT_QUOTES, 'UTF-8');
    $endereco    = htmlspecialchars(trim((string) ($data['endereco'] ?? '')), ENT_QUOTES, 'UTF-8');
    $cidade      = htmlspecialchars(trim((string) ($data['cidade'] ?? '')), ENT_QUOTES, 'UTF-8');
    $email       = htmlspecialchars(trim((string) ($data['email'] ?? '')), ENT_QUOTES, 'UTF-8');
    $telefone    = htmlspecialchars(trim((string) ($data['telefone'] ?? '')), ENT_QUOTES, 'UTF-8');
    $servico     = htmlspecialchars(trim((string) ($data['servico'] ?? '')), ENT_QUOTES, 'UTF-8');
    $observacoes = htmlspecialchars(trim((string) ($data['mensagem'] ?? $data['observacoes'] ?? '')), ENT_QUOTES, 'UTF-8');

    return <<<HTML
<p><strong>Full Name:</strong> {$nome}</p>
<p><strong>Address:</strong> {$endereco}</p>
<p><strong>City and State:</strong> {$cidade}</p>
<p><strong>E-mail:</strong> {$email}</p>
<p><strong>Phone:</strong> {$telefone}</p>
<p><strong>Service:</strong> {$servico}</p>
<p><strong>Notes:</strong> {$observacoes}</p>
HTML;
}

function build_contato_body(array $data): string
{
    $nome     = htmlspecialchars(trim((string) ($data['nome'] ?? '')), ENT_QUOTES, 'UTF-8');
    $telefone = htmlspecialchars(trim((string) ($data['telefone'] ?? '')), ENT_QUOTES, 'UTF-8');
    $email    = htmlspecialchars(trim((string) ($data['email'] ?? '')), ENT_QUOTES, 'UTF-8');
    $assunto  = htmlspecialchars(trim((string) ($data['assunto'] ?? '')), ENT_QUOTES, 'UTF-8');
    $mensagem = htmlspecialchars(trim((string) ($data['mensagem'] ?? '')), ENT_QUOTES, 'UTF-8');

    return <<<HTML
<p><strong>Name:</strong> {$nome}</p>
<p><strong>Phone:</strong> {$telefone}</p>
<p><strong>Email:</strong> {$email}</p>
<p><strong>Subject:</strong> {$assunto}</p>
<p><strong>Message:</strong> {$mensagem}</p>
HTML;
}
