<?php
// Database configuration
$host = 'localhost';
$dbname = 'star_starflix';
$username = 'star_starflix';
$password = '@Professor147';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

// Receber dados do Node.js
$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$message = $input['message'] ?? '';

if (empty($phone) || empty($message)) {
    echo json_encode(['response' => '']);
    exit;
}

// Limpar número de telefone
$cleanPhone = preg_replace('/[^0-9]/', '', str_replace('@c.us', '', $phone));

// Buscar resposta automática
$response = findChatbotResponse($pdo, $message);

// Se encontrou resposta, incrementar contador de uso
if ($response) {
    try {
        $stmt = $pdo->prepare("UPDATE chatbot_responses SET usage_count = usage_count + 1 WHERE id = ?");
        $stmt->execute([$response['id']]);
        
        // Salvar no histórico
        $stmt = $pdo->prepare("
            INSERT INTO message_history (phone_number, message_content, message_type, status, sent_at) 
            VALUES (?, ?, 'chatbot', 'sent', NOW())
        ");
        $stmt->execute([$cleanPhone, $response['response_message']]);
        
    } catch(Exception $e) {
        error_log("Erro ao atualizar chatbot: " . $e->getMessage());
    }
}

echo json_encode(['response' => $response ? $response['response_message'] : '']);

function findChatbotResponse($pdo, $message) {
    try {
        // Buscar todas as respostas ativas
        $stmt = $pdo->query("
            SELECT id, trigger_word, response_message, match_type 
            FROM chatbot_responses 
            WHERE is_active = 1 
            ORDER BY LENGTH(trigger_word) DESC
        ");
        $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $message = strtolower(trim($message));
        
        foreach ($responses as $response) {
            $trigger = strtolower(trim($response['trigger_word']));
            $matchType = $response['match_type'] ?? 'contains';
            
            $matched = false;
            
            switch ($matchType) {
                case 'exact':
                    $matched = ($message === $trigger);
                    break;
                case 'starts_with':
                    $matched = (strpos($message, $trigger) === 0);
                    break;
                case 'ends_with':
                    $matched = (substr($message, -strlen($trigger)) === $trigger);
                    break;
                case 'contains':
                default:
                    $matched = (strpos($message, $trigger) !== false);
                    break;
            }
            
            if ($matched) {
                return $response;
            }
        }
        
        return null;
        
    } catch(Exception $e) {
        error_log("Erro ao buscar resposta do chatbot: " . $e->getMessage());
        return null;
    }
}
?>