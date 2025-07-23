<?php
// Habilitar logs de erro para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log da requisição recebida
error_log("Chatbot processor chamado: " . file_get_contents('php://input'));

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
    error_log("Erro de conexão com banco: " . $e->getMessage());
    echo json_encode(['error' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

// Receber dados do Node.js
$input = json_decode(file_get_contents('php://input'), true);
$phone = $input['phone'] ?? '';
$message = $input['message'] ?? '';

// Log dos dados recebidos
error_log("Dados recebidos - Phone: $phone, Message: $message");
if (empty($phone) || empty($message)) {
    error_log("Dados vazios - Phone ou Message não fornecidos");
    echo json_encode(['response' => '']);
    exit;
}

// Limpar número de telefone
$cleanPhone = preg_replace('/[^0-9]/', '', str_replace('@c.us', '', $phone));

// Log do número limpo
error_log("Número limpo: $cleanPhone");
// Buscar resposta automática
$response = findChatbotResponse($pdo, $message);

// Log da resposta encontrada
if ($response) {
    error_log("Resposta encontrada: " . $response['response_message']);
} else {
    error_log("Nenhuma resposta encontrada para: $message");
}
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
        
        error_log("Histórico salvo com sucesso");
        
    } catch(Exception $e) {
        error_log("Erro ao atualizar chatbot: " . $e->getMessage());
    }
}

// Log da resposta final
$finalResponse = $response ? $response['response_message'] : '';
error_log("Resposta final enviada: $finalResponse");
echo json_encode(['response' => $finalResponse]);

function findChatbotResponse($pdo, $message) {
    try {
        error_log("Buscando resposta para mensagem: $message");
        
        // Buscar todas as respostas ativas
        $stmt = $pdo->query("
            SELECT id, trigger_word, response_message, match_type 
            FROM chatbot_responses 
            WHERE is_active = 1 
            ORDER BY LENGTH(trigger_word) DESC
        ");
        $responses = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Total de respostas ativas encontradas: " . count($responses));
        
        $message = strtolower(trim($message));
        error_log("Mensagem normalizada: '$message'");
        
        foreach ($responses as $response) {
            $trigger = strtolower(trim($response['trigger_word']));
            $matchType = $response['match_type'] ?? 'contains';
            
            error_log("Testando trigger: '$trigger' com tipo: $matchType");
            
            $matched = false;
            
            switch ($matchType) {
                case 'exact':
                    $matched = ($message === $trigger);
                    error_log("Teste exact: '$message' === '$trigger' = " . ($matched ? 'true' : 'false'));
                    break;
                case 'starts_with':
                    $matched = (strpos($message, $trigger) === 0);
                    error_log("Teste starts_with: strpos('$message', '$trigger') === 0 = " . ($matched ? 'true' : 'false'));
                    break;
                case 'ends_with':
                    $matched = (substr($message, -strlen($trigger)) === $trigger);
                    error_log("Teste ends_with: substr('$message', -" . strlen($trigger) . ") === '$trigger' = " . ($matched ? 'true' : 'false'));
                    break;
                case 'contains':
                default:
                    $matched = (strpos($message, $trigger) !== false);
                    error_log("Teste contains: strpos('$message', '$trigger') !== false = " . ($matched ? 'true' : 'false'));
                    break;
            }
            
            if ($matched) {
                error_log("MATCH ENCONTRADO! Retornando resposta: " . $response['response_message']);
                return $response;
            }
        }
        
        error_log("Nenhum match encontrado");
        return null;
        
    } catch(Exception $e) {
        error_log("Erro ao buscar resposta do chatbot: " . $e->getMessage());
        return null;
    }
}
?>
