# landing-php

Landing em PHP plano, preparada para cPanel e com suporte de execução local via Docker.

## Rodar local com Docker

Requisitos:
- Docker + Docker Compose plugin

Comandos:

```bash
docker compose up --build
```

Abrí en navegador:
- http://localhost:8080/

Para apagar:

```bash
docker compose down
```

## Notas de deploy (cPanel)

- Esta app **não depende de Docker em produção**.
- Basta subir os arquivos de `landing-php/` para o docroot.
- `.htaccess` faz:
  - rewrite para `index.php` (front controller)
  - canonicalização de rotas sem extensão para `.html` via `301`

## Formulários

- Envio direto por e-mail via PHPMailer/SMTP (sem relay remoto).
- O formulário de orçamento usa campo visual `mensagem`, mapeado internamente para `observacoes`, preservando contrato.
- Compatibilidade retroativa: backend aceita `mensagem` e `observacoes`.

## Configuração de e-mail (deploy)

Copie `includes/config.example.php` para `includes/config.php` e preencha com as credenciais SMTP do servidor:
- `smtp.*`: host, porta, usuário, senha e tipo de segurança
- `mail.from`: remetente dos e-mails
- `mail.recipients`: destinatários por tipo de formulário
- `mail.reply_to_form_email`: define se o Reply-To deve ser o e-mail do formulário

O arquivo `includes/config.php` está no `.gitignore` e não deve ser versionado.

## Limitações conhecidas

- Neste ambiente não há runner PHP CLI para executar testes/smoke local por comando automatizado.
