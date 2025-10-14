<?php
/**
 * Recebe os dados do formulário de contato via POST.
 * Precisa ser hospedado em um servidor com suporte a PHP.
 */

// Substitua contact@example.com pelo SEU ENDEREÇO DE E-MAIL
$recipient_email = "rafita.limagames2@gmail.com";

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Sanitiza e obtém os dados do formulário
    // A função trim() remove espaços em branco no início e no fim
    // A função strip_tags() remove tags HTML e PHP para segurança
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Validação básica dos campos
    if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Se algum campo estiver vazio ou o e-mail for inválido, envia um erro.
        http_response_code(400);
        echo "Por favor, preencha todos os campos do formulário corretamente.";
        exit;
    }

    // Monta o conteúdo do e-mail
    $email_content = "Nome: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Assunto: $subject\n\n";
    $email_content .= "Mensagem:\n$message\n";

    // Monta o cabeçalho do e-mail
    $email_headers = "From: $name <$email>\r\n";
    $email_headers .= "Reply-To: $email\r\n";
    $email_headers .= "X-Mailer: PHP/" . phpversion();

    // Envia o e-mail
    // A função mail() depende da configuração do servidor
    if (mail($recipient_email, $subject, $email_content, $email_headers)) {
        // E-mail enviado com sucesso
        http_response_code(200);
        echo "Sua mensagem foi enviada com sucesso! Obrigado por confiar em nós!";
    } else {
        // Falha no envio
        http_response_code(500);
        echo "Ocorreu um problema e não foi possível enviar sua mensagem. Tente novamente mais tarde.";
    }

} else {
    // Se não for uma requisição POST, retorna erro.
    http_response_code(403);
    echo "Houve um problema com o envio, por favor, tente novamente.";
}
?>