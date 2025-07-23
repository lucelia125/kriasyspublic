<?php
session_start();

// Verificar se admin está logado
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    header('HTTP/1.1 401 Unauthorized');
    exit(json_encode(['error' => 'Não autorizado']));
}

// Database configuration
$host = 'localhost';
$dbname = 'star_starflix';
$username = 'star_starflix';
$password = '@Professor147';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die(json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]));
}

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? '';

// URL do servidor Node.js WhatsApp
$nodeServerUrl = 'http://localhost:3001/api';

switch($action) {
    case 'get_qr':
        echo json_encode(getQRCode($nodeServerUrl));
        break;
        
    case 'check_connection':
        echo json_encode(checkWhatsAppStatus($nodeServerUrl));
        break;
        
    case 'send_message':
        $to = $_POST['to'] ?? '';
        $message = $_POST['message'] ?? '';
        $leadId = $_POST['lead_id'] ?? null;
        echo json_encode(sendWhatsAppMessage($nodeServerUrl, $pdo, $to, $message, $leadId));
        break;
        
    case 'send_bulk':
        $numbers = json_decode($_POST['numbers'] ?? '[]', true);
        $message = $_POST['message'] ?? '';
        echo json_encode(sendBulkMessages($nodeServerUrl, $pdo, $numbers, $message));
        break;
        
    case 'get_leads':
        echo json_encode(getLeadsForBulk($pdo));
        break;
        
    case 'save_chatbot_response':
        $trigger = $_POST['trigger'] ?? '';
        $response = $_POST['response'] ?? '';
        $matchType = $_POST['match_type'] ?? 'contains';
        echo json_encode(saveChatbotResponse($pdo, $trigger, $response, $matchType));
        break;
        
    case 'get_chatbot_responses':
        echo json_encode(getChatbotResponses($pdo));
        break;
        
    case 'delete_chatbot_response':
        $id = $_POST['id'] ?? '';
        echo json_encode(deleteChatbotResponse($pdo, $id));
        break;
        
    case 'get_message_history':
        echo json_encode(getMessageHistory($pdo));
        break;
        
    case 'disconnect_whatsapp':
        echo json_encode(disconnectWhatsApp($nodeServerUrl));
        break;
        
    case 'restart_whatsapp':
        $clearSession = isset($_POST['clear_session']) && $_POST['clear_session'] === 'true';
        echo json_encode(restartWhatsApp($nodeServerUrl, $clearSession));
        break;
        
    default:
        echo json_encode(['error' => 'Ação não encontrada']);
}

function makeNodeRequest($url, $method = 'GET', $data = null) {
    $context = stream_context_create([
        'http' => [
            'method' => $method,
            'header' => "Content-Type: application/json\r\n",
            'content' => $data ? json_encode($data) : null,
            'timeout' => 30
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    
    if ($response === false) {
        return ['success' => false, 'error' => 'Erro ao conectar com o servidor WhatsApp'];
    }
    
    return json_decode($response, true) ?: ['success' => false, 'error' => 'Resposta inválida do servidor'];
}

function getQRCode($nodeServerUrl) {
    $response = makeNodeRequest("$nodeServerUrl/qr");
    
    if (!$response['success'] && isset($response['connected']) && $response['connected']) {
        return [
            'success' => false,
            'error' => 'WhatsApp já está conectado',
            'connected' => true,
            'phone' => $response['phone']
        ];
    }
    
    return $response;
}

function checkWhatsAppStatus($nodeServerUrl) {
    return makeNodeRequest("$nodeServerUrl/status");
}

function sendWhatsAppMessage($nodeServerUrl, $pdo, $to, $message, $leadId = null) {
    // Validar dados
    if (empty($to) || empty($message)) {
        return ['success' => false, 'error' => 'Número e mensagem são obrigatórios'];
    }
    
    // Limpar número de telefone
    $cleanNumber = preg_replace('/[^0-9]/', '', $to);
    
    // Enviar mensagem via Node.js
    $response = makeNodeRequest("$nodeServerUrl/send-message", 'POST', [
        'to' => $cleanNumber,
        'message' => $message
    ]);
    
    // Salvar no histórico se enviou com sucesso
    if ($response['success']) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO message_history (phone_number, message_content, message_type, status, lead_id, sent_at) 
                VALUES (?, ?, 'individual', 'sent', ?, NOW())
            ");
            $stmt->execute([$cleanNumber, $message, $leadId]);
        } catch(Exception $e) {
            // Log error but don't fail the request
            error_log("Erro ao salvar histórico de mensagem: " . $e->getMessage());
        }
    }
    
    return $response;
}

function sendBulkMessages($nodeServerUrl, $pdo, $numbers, $message) {
    if (empty($numbers) || empty($message)) {
        return ['success' => false, 'error' => 'Números e mensagem são obrigatórios'];
    }
    
    // Limpar números de telefone
    $cleanNumbers = array_map(function($number) {
        return preg_replace('/[^0-9]/', '', $number);
    }, $numbers);
    
    // Enviar mensagens via Node.js
    $response = makeNodeRequest("$nodeServerUrl/send-bulk", 'POST', [
        'numbers' => $cleanNumbers,
        'message' => $message
    ]);
    
    // Salvar no histórico
    if ($response['success'] && isset($response['results'])) {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO message_history (phone_number, message_content, message_type, status, sent_at) 
                VALUES (?, ?, 'bulk', ?, NOW())
            ");
            
            foreach ($response['results'] as $result) {
                $status = $result['status'] === 'sent' ? 'sent' : 'failed';
                $stmt->execute([$result['number'], $message, $status]);
            }
        } catch(Exception $e) {
            error_log("Erro ao salvar histórico de mensagens em massa: " . $e->getMessage());
        }
    }
    
    return $response;
}

function getLeadsForBulk($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT id, name, whatsapp, plan_selected, plan_price, created_at 
            FROM leads 
            ORDER BY created_at DESC
        ");
        $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'success' => true,
            'leads' => $leads
        ];
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function saveChatbotResponse($pdo, $trigger, $response, $matchType) {
    try {
        $stmt = $pdo->prepare("
            INSERT INTO chatbot_responses (trigger_word, response_message, match_type, created_at) 
            VALUES (?, ?, ?, NOW())
            ON DUPLICATE KEY UPDATE 
            response_message = VALUES(response_message),
            match_type = VALUES(match_type),
            updated_at = NOW()
        ");
        $stmt->execute([$trigger, $response, $matchType]);
        
        return [
            'success' => true,
            'message' => 'Resposta automática salva com sucesso!'
        ];
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function getChatbotResponses($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT id, trigger_word, response_message, match_type, usage_count, is_active, created_at 
            FROM chatbot_responses 
            ORDER BY created_at DESC
        ");
        $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'success' => true,
            'responses' => $responses
        ];
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function deleteChatbotResponse($pdo, $id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM chatbot_responses WHERE id = ?");
        $stmt->execute([$id]);
        
        return [
            'success' => true,
            'message' => 'Resposta automática removida!'
        ];
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function getMessageHistory($pdo) {
    try {
        $stmt = $pdo->query("
            SELECT phone_number, message_content, message_type, status, sent_at 
            FROM message_history 
            ORDER BY sent_at DESC 
            LIMIT 100
        ");
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return [
            'success' => true,
            'history' => $history
        ];
    } catch(Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage()
        ];
    }
}

function disconnectWhatsApp($nodeServerUrl) {
    return makeNodeRequest("$nodeServerUrl/disconnect", 'POST');
}

function restartWhatsApp($nodeServerUrl, $clearSession = false) {
    return makeNodeRequest("$nodeServerUrl/restart", 'POST', [
        'clearSession' => $clearSession
    ]);
}
?>