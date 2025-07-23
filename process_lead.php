<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'star_starflix';
$username = 'star_starflix';
$password = '@Professor147';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar dados do formulário
    $name = trim($_POST['name'] ?? '');
    $whatsapp = trim($_POST['whatsapp'] ?? '');
    $device = $_POST['device'] ?? '';
    $plan = $_POST['plan'] ?? '';
    $price = $_POST['price'] ?? '';
    $value = $_POST['value'] ?? '';
    $content = $_POST['content'] ?? [];
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? '';
    
    // Validar dados obrigatórios
    if (empty($name) || empty($whatsapp) || empty($device) || empty($plan)) {
        $_SESSION['error'] = 'Todos os campos obrigatórios devem ser preenchidos.';
        header('Location: index.php');
        exit;
    }
    
    try {
        // Inserir lead no banco de dados
        $stmt = $pdo->prepare("
            INSERT INTO leads (name, whatsapp, device, plan_selected, plan_price, plan_value, content_interests, ip_address, status, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'new', NOW())
        ");
        
        $content_json = json_encode($content);
        $stmt->execute([$name, $whatsapp, $device, $plan, $price, $value, $content_json, $ip_address]);
        
        $leadId = $pdo->lastInsertId();
        
        // Enviar mensagem de boas-vindas via WhatsApp
        $welcomeMessage = "👋 Olá! Seja bem-vindo à StarFlix 🚀\nRecebemos seu cadastro com sucesso! 💫\nEm breve, alguém do nosso time vai entrar em contato com você.\nMas se quiser um atendimento mais rápido, é só digitar Menu e falar com nossa IA 🤖✨";
        
        $messageResult = sendWelcomeMessage($whatsapp, $welcomeMessage, $leadId, $pdo);
        
        // Salvar resultado do envio da mensagem
        if ($messageResult['success']) {
            // Atualizar status do lead para indicar que a mensagem foi enviada
            $stmt = $pdo->prepare("UPDATE leads SET whatsapp_message_sent = 1, whatsapp_message_status = 'sent' WHERE id = ?");
            $stmt->execute([$leadId]);
        } else {
            // Marcar que a mensagem falhou
            $stmt = $pdo->prepare("UPDATE leads SET whatsapp_message_sent = 0, whatsapp_message_status = 'failed', whatsapp_error = ? WHERE id = ?");
            $stmt->execute([$messageResult['error'], $leadId]);
        }
        
        // Redirecionar para página de obrigado
        header('Location: obrigado.php');
        exit;
        
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Erro ao processar cadastro: ' . $e->getMessage();
        header('Location: index.php');
        exit;
    }
} else {
    header('Location: obrigado.php');
    exit;
}

function sendWelcomeMessage($whatsapp, $message, $leadId, $pdo) {
    // URL do servidor Node.js WhatsApp
    $nodeServerUrl = 'http://localhost:3001/api';
    
    // Limpar número de telefone
    $cleanNumber = preg_replace('/[^0-9]/', '', $whatsapp);
    
    // Preparar dados para envio
    $postData = json_encode([
        'to' => $cleanNumber,
        'message' => $message
    ]);
    
    // Configurar contexto para requisição HTTP
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n",
            'content' => $postData,
            'timeout' => 30
        ]
    ]);
    
    try {
        // Fazer requisição para o servidor Node.js
        $response = @file_get_contents("$nodeServerUrl/send-message", false, $context);
        
        if ($response === false) {
            return [
                'success' => false,
                'error' => 'Erro ao conectar com o servidor WhatsApp'
            ];
        }
        
        $result = json_decode($response, true);
        
        if ($result && $result['success']) {
            // Salvar no histórico de mensagens
            try {
                $stmt = $pdo->prepare("
                    INSERT INTO message_history (phone_number, message_content, message_type, status, lead_id, sent_at) 
                    VALUES (?, ?, 'welcome', 'sent', ?, NOW())
                ");
                $stmt->execute([$cleanNumber, $message, $leadId]);
            } catch(Exception $e) {
                error_log("Erro ao salvar histórico de mensagem: " . $e->getMessage());
            }
            
            return [
                'success' => true,
                'message' => 'Mensagem de boas-vindas enviada com sucesso!'
            ];
        } else {
            return [
                'success' => false,
                'error' => $result['error'] ?? 'Erro desconhecido ao enviar mensagem'
            ];
        }
        
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => 'Erro na comunicação: ' . $e->getMessage()
        ];
    }
}
?>