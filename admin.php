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

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $admin_user = trim($_POST['username']);
    $admin_pass = $_POST['password'];
    
    if ($admin_user === 'StarFlix' && $admin_pass === 'StarFlix147') {
        $_SESSION['admin_logged'] = true;
        $_SESSION['admin_user'] = $admin_user;
        header('Location: admin.php');
        exit;
    } else {
        $error = 'Credenciais inválidas!';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}

// Check if admin is logged in
$isLoggedIn = isset($_SESSION['admin_logged']) && $_SESSION['admin_logged'] === true;

if ($isLoggedIn) {
    // Get leads from database
    try {
        $stmt = $pdo->query("
            SELECT id, name, whatsapp, device, plan_selected, plan_price, plan_value, 
                   content_interests, ip_address, status, whatsapp_message_sent, 
                   whatsapp_message_status, whatsapp_error, created_at 
            FROM leads 
            ORDER BY created_at DESC
        ");
        $leads = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        $leads = [];
        $db_error = "Erro ao carregar leads: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin MULTZ - Painel Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); }
        .gradient-text { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-button.active { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); color: white; }
        .status-indicator { width: 12px; height: 12px; border-radius: 50%; display: inline-block; margin-right: 8px; }
        .status-connected { background-color: #10B981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.6); }
        .status-waiting { background-color: #F59E0B; box-shadow: 0 0 8px rgba(245, 158, 11, 0.6); }
        .status-disconnected { background-color: #EF4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.6); }
        .animate-pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.5; } }
    </style>
</head>
<body class="bg-gray-50">

<?php if (!$isLoggedIn): ?>
    <!-- Login Form -->
    <div class="min-h-screen gradient-bg flex items-center justify-center">
        <div class="bg-white rounded-2xl p-8 shadow-2xl max-w-md w-full mx-4">
            <div class="text-center mb-8">
                <div class="gradient-bg p-3 rounded-lg inline-block mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Multz</h1>
                <p class="text-gray-600">Acesso ao painel administrativo</p>
            </div>
            
            <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Usuário
                    </label>
                    <input type="text" name="username" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                           placeholder="Digite o usuário">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Senha
                    </label>
                    <input type="password" name="password" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                           placeholder="Digite a senha">
                </div>
                
                <button type="submit" name="login" 
                        class="w-full gradient-bg text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300">
                    Entrar
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <a href="index.php" class="text-gray-600 hover:text-purple-600 flex items-center justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Voltar ao site
                </a>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- Admin Dashboard -->
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="index.php" class="text-gray-600 hover:text-purple-600 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Voltar ao site
                        </a>
                        <h1 class="text-2xl font-bold text-gray-900">Painel Administrativo</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div id="whatsapp-status" class="px-4 py-2 rounded-lg text-sm font-medium">
                            <span class="status-indicator status-disconnected"></span>
                            WhatsApp: Verificando...
                        </div>
                        <div class="gradient-bg text-white px-4 py-2 rounded-lg">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <?= count($leads) ?> Leads
                        </div>
                        <a href="?logout=1" class="text-gray-600 hover:text-red-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tabs Navigation -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="border-b border-gray-200 mb-8">
                <nav class="-mb-px flex space-x-8">
                    <button onclick="showTab('leads')" class="tab-button active py-2 px-4 border-b-2 border-transparent font-medium text-sm rounded-t-lg transition-all duration-300">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Leads (<?= count($leads) ?>)
                    </button>
                    <button onclick="showTab('whatsapp')" class="tab-button py-2 px-4 border-b-2 border-transparent font-medium text-sm rounded-t-lg transition-all duration-300">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        WhatsApp API
                    </button>
                    <button onclick="showTab('chatbot')" class="tab-button py-2 px-4 border-b-2 border-transparent font-medium text-sm rounded-t-lg transition-all duration-300">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Chatbot
                    </button>
                </nav>
            </div>

            <!-- Leads Tab -->
            <div id="leads-tab" class="tab-content active">
                <?php if (isset($db_error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <?= htmlspecialchars($db_error) ?>
                </div>
                <?php endif; ?>
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Total de Leads</p>
                                <p class="text-2xl font-semibold text-gray-900"><?= count($leads) ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Hoje</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    <?= count(array_filter($leads, function($lead) { return date('Y-m-d', strtotime($lead['created_at'])) === date('Y-m-d'); })) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-yellow-100 rounded-lg">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Receita Potencial</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    R$ <?= number_format(array_sum(array_map(function($lead) { return floatval($lead['plan_value']); }, $leads)), 2, ',', '.') ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Mensagens Enviadas</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    <?= count(array_filter($leads, function($lead) { return $lead['whatsapp_message_sent'] == 1; })) ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Leads Table -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 gradient-bg text-white">
                        <h2 class="text-xl font-bold">Leads Cadastrados</h2>
                        <p class="text-purple-100">Gerencie todos os leads capturados</p>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WhatsApp</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dispositivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plano</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interesses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data/Hora</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php if (empty($leads)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                                        </svg>
                                        <p class="text-gray-500 text-lg">Nenhum lead cadastrado ainda</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php foreach ($leads as $lead): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-medium text-gray-900"><?= htmlspecialchars($lead['name']) ?></div>
                                            <?php if (isset($lead['whatsapp_message_status'])): ?>
                                                <div class="text-xs mt-1">
                                                    <?php if ($lead['whatsapp_message_status'] === 'sent'): ?>
                                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full">✓ Mensagem enviada</span>
                                                    <?php elseif ($lead['whatsapp_message_status'] === 'failed'): ?>
                                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full">✗ Falha no envio</span>
                                                    <?php else: ?>
                                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full">⏳ Pendente</span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center text-gray-900">
                                                <svg class="w-4 h-4 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                                    <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                                </svg>
                                                <a href="https://wa.me/55<?= preg_replace('/[^0-9]/', '', $lead['whatsapp']) ?>" target="_blank" class="hover:text-green-600">
                                                    <?= htmlspecialchars($lead['whatsapp']) ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                                                <?= htmlspecialchars($lead['device']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                                                <?= htmlspecialchars($lead['plan_selected']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-green-600 font-semibold">
                                                <?= htmlspecialchars($lead['plan_price']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                <?php 
                                                $interests = json_decode($lead['content_interests'], true);
                                                if ($interests && is_array($interests)):
                                                    foreach ($interests as $interest): ?>
                                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-medium">
                                                        <?= htmlspecialchars($interest) ?>
                                                    </span>
                                                <?php endforeach;
                                                endif; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                                <?= date('d/m/Y H:i', strtotime($lead['created_at'])) ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- WhatsApp API Tab -->
            <div id="whatsapp-tab" class="tab-content">
                <!-- Status Alert -->
                <div id="whatsapp-alert" class="mb-6 hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-sm font-medium text-blue-800 mb-1">Status do Servidor WhatsApp</h3>
                                <p class="text-sm text-blue-700">Certifique-se de que o servidor Node.js está rodando na porta 3001</p>
                                <button onclick="checkNodeServer()" class="mt-2 text-sm text-blue-600 hover:text-blue-800 underline">
                                    Verificar Servidor
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Connection Status -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                Status WhatsApp
                            </h3>
                            
                            <div id="connection-status" class="mb-6">
                                <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                    <span class="status-indicator status-disconnected animate-pulse"></span>
                                    <span class="text-yellow-800 font-medium">Verificando conexão...</span>
                                </div>
                            </div>
                            
                            <div id="qr-code-section" class="text-center mb-6">
                                <button onclick="generateQRCode()" id="qr-button" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 flex items-center mx-auto">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Gerar QR Code
                                </button>
                                
                                <div id="qr-code-display" class="mt-4 hidden">
                                    <img id="qr-code-img" src="" alt="QR Code" class="mx-auto border rounded-lg shadow-lg">
                                    <p class="text-sm text-gray-600 mt-2">Escaneie com seu WhatsApp</p>
                                    <p class="text-xs text-gray-500 mt-1">O QR Code expira em 45 segundos</p>
                                </div>
                            </div>

                            <div id="connection-actions" class="space-y-2 hidden">
                                <button onclick="disconnectWhatsApp()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all duration-300">
                                    Desconectar
                                </button>
                                <button onclick="restartWhatsApp()" class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition-all duration-300">
                                    Reiniciar Conexão
                                </button>
                                <button onclick="restartWhatsApp(true)" class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300 text-sm">
                                    Reiniciar (Limpar Sessão)
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Send Individual Message -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Enviar Mensagem Individual
                            </h3>
                            
                            <form id="individual-message-form" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Número do WhatsApp
                                    </label>
                                    <input type="text" id="individual-phone" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                           placeholder="(11) 99999-9999">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Mensagem
                                    </label>
                                    <textarea id="individual-message" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                              placeholder="Digite sua mensagem..."></textarea>
                                </div>
                                
                                <button type="submit" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 flex items-center disabled:opacity-50" disabled id="send-individual-btn">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Enviar Mensagem
                                </button>
                            </form>
                        </div>
                        
                        <!-- Bulk Message -->
                        <div class="bg-white rounded-2xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                </svg>
                                Disparo em Massa
                            </h3>
                            
                            <div class="mb-4">
                                <button onclick="loadLeads()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Carregar Leads
                                </button>
                            </div>
                            
                            <div id="leads-selection" class="mb-4 hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Selecionar Leads
                                </label>
                                <div id="leads-list" class="max-h-60 overflow-y-auto border border-gray-300 rounded-lg p-4">
                                    <!-- Leads will be loaded here -->
                                </div>
                            </div>
                            
                            <form id="bulk-message-form" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        Mensagem para Disparo
                                    </label>
                                    <textarea id="bulk-message" rows="4"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                              placeholder="Digite a mensagem que será enviada para todos os selecionados..."></textarea>
                                </div>
                                
                                <button type="submit" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 flex items-center disabled:opacity-50" disabled id="send-bulk-btn">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                                    </svg>
                                    Enviar para Selecionados
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Message History -->
                <div class="mt-8 bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Histórico de Mensagens
                    </h3>
                    
                    <div id="message-history" class="space-y-3">
                        <p class="text-gray-500 text-center py-8">Carregue o histórico para ver as mensagens enviadas</p>
                    </div>
                    
                    <button onclick="loadMessageHistory()" class="mt-4 bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition-all duration-300">
                        Carregar Histórico
                    </button>
                </div>
            </div>

            <!-- Chatbot Tab -->
            <div id="chatbot-tab" class="tab-content">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Add New Response -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Adicionar Resposta Automática
                        </h3>
                        
                        <form id="chatbot-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Palavra-chave (gatilho)
                                </label>
                                <input type="text" id="trigger-word" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                       placeholder="Ex: preço, planos, suporte">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Tipo de Correspondência
                                </label>
                                <select id="match-type" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent">
                                    <option value="contains">Contém a palavra</option>
                                    <option value="exact">Palavra exata</option>
                                    <option value="starts_with">Inicia com</option>
                                    <option value="ends_with">Termina com</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Resposta Automática
                                </label>
                                <textarea id="response-message" rows="4"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                          placeholder="Digite a resposta que será enviada automaticamente..."></textarea>
                            </div>
                            
                            <button type="submit" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Salvar Resposta
                            </button>
                        </form>
                    </div>
                    
                    <!-- Current Responses -->
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Respostas Configuradas
                        </h3>
                        
                        <div id="chatbot-responses" class="space-y-3">
                            <p class="text-gray-500 text-center py-8">Carregue as respostas para gerenciar</p>
                        </div>
                        
                        <button onclick="loadChatbotResponses()" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-all duration-300">
                            Carregar Respostas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let isWhatsAppConnected = false;

        // Tab Management
        function showTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Show selected tab
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');

            // Load tab-specific data
            if (tabName === 'chatbot') {
                loadChatbotResponses();
            }
        }

        // Check Node.js server status
        function checkNodeServer() {
            fetch('http://localhost:3001/api/health')
                .then(response => response.json())
                .then(data => {
                    console.log('Servidor Node.js:', data);
                    document.getElementById('whatsapp-alert').classList.add('hidden');
                    checkWhatsAppStatus();
                })
                .catch(error => {
                    console.error('Servidor Node.js não encontrado:', error);
                    document.getElementById('whatsapp-alert').classList.remove('hidden');
                });
        }

        // Check WhatsApp connection status
        function checkWhatsAppStatus() {
            fetch('whatsapp_api.php?action=check_connection')
                .then(response => response.json())
                .then(data => {
                    updateConnectionStatus(data);
                })
                .catch(error => {
                    console.error('Erro ao verificar status:', error);
                    updateConnectionStatus({ connected: false, status: 'error' });
                });
        }

        // Update connection status display
        function updateConnectionStatus(data) {
            const statusDiv = document.getElementById('connection-status');
            const headerStatus = document.getElementById('whatsapp-status');
            const qrButton = document.getElementById('qr-button');
            const connectionActions = document.getElementById('connection-actions');
            const sendIndividualBtn = document.getElementById('send-individual-btn');
            const sendBulkBtn = document.getElementById('send-bulk-btn');

            isWhatsAppConnected = data.connected;

            if (data.connected) {
                statusDiv.innerHTML = `
                    <div class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg">
                        <span class="status-indicator status-connected"></span>
                        <div>
                            <div class="text-green-800 font-medium">Conectado</div>
                            <div class="text-green-600 text-sm">${data.phone || 'WhatsApp Web'}</div>
                        </div>
                    </div>
                `;
                
                headerStatus.innerHTML = `
                    <span class="status-indicator status-connected"></span>
                    WhatsApp: Conectado
                `;
                headerStatus.className = 'bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-medium';

                qrButton.style.display = 'none';
                connectionActions.classList.remove('hidden');
                document.getElementById('qr-code-display').classList.add('hidden');

                // Enable message buttons
                sendIndividualBtn.disabled = false;
                sendBulkBtn.disabled = false;

            } else if (data.status === 'waiting') {
                statusDiv.innerHTML = `
                    <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <span class="status-indicator status-waiting animate-pulse"></span>
                        <span class="text-yellow-800 font-medium">Aguardando QR Code...</span>
                    </div>
                `;
                
                headerStatus.innerHTML = `
                    <span class="status-indicator status-waiting animate-pulse"></span>
                    WhatsApp: Aguardando
                `;
                headerStatus.className = 'bg-yellow-100 text-yellow-800 px-4 py-2 rounded-lg text-sm font-medium';

                qrButton.style.display = 'none';
                connectionActions.classList.add('hidden');

            } else {
                statusDiv.innerHTML = `
                    <div class="flex items-center p-4 bg-red-50 border border-red-200 rounded-lg">
                        <span class="status-indicator status-disconnected"></span>
                        <span class="text-red-800 font-medium">Desconectado</span>
                    </div>
                `;
                
                headerStatus.innerHTML = `
                    <span class="status-indicator status-disconnected"></span>
                    WhatsApp: Desconectado
                `;
                headerStatus.className = 'bg-red-100 text-red-800 px-4 py-2 rounded-lg text-sm font-medium';

                qrButton.style.display = 'flex';
                connectionActions.classList.add('hidden');
                document.getElementById('qr-code-display').classList.add('hidden');

                // Disable message buttons
                sendIndividualBtn.disabled = true;
                sendBulkBtn.disabled = true;
            }
        }

        // Generate QR Code
        function generateQRCode() {
            const qrButton = document.getElementById('qr-button');
            qrButton.innerHTML = `
                <svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Gerando QR Code...
            `;
            qrButton.disabled = true;

            fetch('whatsapp_api.php?action=get_qr')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.qr_code) {
                        document.getElementById('qr-code-img').src = data.qr_code;
                        document.getElementById('qr-code-display').classList.remove('hidden');
                        
                        // Check connection status periodically
                        const interval = setInterval(() => {
                            checkWhatsAppStatus();
                            if (isWhatsAppConnected) {
                                clearInterval(interval);
                            }
                        }, 3000);

                        // Auto-hide QR code after 45 seconds
                        setTimeout(() => {
                            document.getElementById('qr-code-display').classList.add('hidden');
                            clearInterval(interval);
                            qrButton.innerHTML = `
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Gerar Novo QR Code
                            `;
                            qrButton.disabled = false;
                        }, 45000);
                        
                    } else if (data.connected) {
                        alert('WhatsApp já está conectado!');
                        checkWhatsAppStatus();
                    } else {
                        alert('Erro: ' + (data.error || 'Não foi possível gerar o QR Code'));
                    }

                    qrButton.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Gerar QR Code
                    `;
                    qrButton.disabled = false;
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao conectar com o servidor WhatsApp');
                    qrButton.innerHTML = `
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Gerar QR Code
                    `;
                    qrButton.disabled = false;
                });
        }

        // Disconnect WhatsApp
        function disconnectWhatsApp() {
            if (confirm('Deseja realmente desconectar o WhatsApp?')) {
                fetch('whatsapp_api.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=disconnect_whatsapp'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('WhatsApp desconectado com sucesso!');
                        checkWhatsAppStatus();
                    } else {
                        alert('Erro: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Restart WhatsApp
        function restartWhatsApp(clearSession = false) {
            const message = clearSession 
                ? 'Deseja reiniciar e limpar a sessão? Você precisará escanear o QR Code novamente.'
                : 'Deseja reiniciar a conexão WhatsApp?';
                
            if (confirm(message)) {
                const formData = new FormData();
                formData.append('action', 'restart_whatsapp');
                if (clearSession) formData.append('clear_session', 'true');

                fetch('whatsapp_api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('WhatsApp reiniciando...');
                        setTimeout(() => checkWhatsAppStatus(), 3000);
                    } else {
                        alert('Erro: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Individual Message
        document.getElementById('individual-message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!isWhatsAppConnected) {
                alert('WhatsApp não está conectado!');
                return;
            }
            
            const phone = document.getElementById('individual-phone').value;
            const message = document.getElementById('individual-message').value;
            
            if (!phone || !message) {
                alert('Preencha todos os campos!');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'send_message');
            formData.append('to', phone);
            formData.append('message', message);
            
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Enviando...';
            submitBtn.disabled = true;
            
            fetch('whatsapp_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Mensagem enviada com sucesso!');
                    document.getElementById('individual-message-form').reset();
                } else {
                    alert('Erro: ' + data.error);
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro de conexão');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Load Leads for Bulk
        function loadLeads() {
            fetch('whatsapp_api.php?action=get_leads')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const leadsList = document.getElementById('leads-list');
                        leadsList.innerHTML = '';
                        
                        if (data.leads.length === 0) {
                            leadsList.innerHTML = '<p class="text-gray-500 text-center">Nenhum lead encontrado</p>';
                        } else {
                            data.leads.forEach(lead => {
                                const leadDiv = document.createElement('div');
                                leadDiv.className = 'flex items-center p-2 hover:bg-gray-50 rounded';
                                leadDiv.innerHTML = `
                                    <input type="checkbox" value="${lead.whatsapp}" class="mr-3 lead-checkbox">
                                    <div class="flex-1">
                                        <div class="font-medium">${lead.name}</div>
                                        <div class="text-sm text-gray-600">${lead.whatsapp} - ${lead.plan_selected}</div>
                                    </div>
                                `;
                                leadsList.appendChild(leadDiv);
                            });
                        }
                        
                        document.getElementById('leads-selection').classList.remove('hidden');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Bulk Message
        document.getElementById('bulk-message-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!isWhatsAppConnected) {
                alert('WhatsApp não está conectado!');
                return;
            }
            
            const message = document.getElementById('bulk-message').value;
            const selectedLeads = Array.from(document.querySelectorAll('.lead-checkbox:checked')).map(cb => cb.value);
            
            if (!message || selectedLeads.length === 0) {
                alert('Selecione leads e digite uma mensagem!');
                return;
            }

            if (!confirm(`Enviar mensagem para ${selectedLeads.length} leads?`)) {
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'send_bulk');
            formData.append('numbers', JSON.stringify(selectedLeads));
            formData.append('message', message);
            
            const submitBtn = e.target.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = 'Enviando...';
            submitBtn.disabled = true;
            
            fetch('whatsapp_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Disparo concluído!\nEnviadas: ${data.sent}\nFalharam: ${data.failed}\nTotal: ${data.total}`);
                    document.getElementById('bulk-message-form').reset();
                    // Uncheck all leads
                    document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = false);
                } else {
                    alert('Erro: ' + data.error);
                }
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro de conexão');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });

        // Load Message History
        function loadMessageHistory() {
            fetch('whatsapp_api.php?action=get_message_history')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const historyDiv = document.getElementById('message-history');
                        historyDiv.innerHTML = '';
                        
                        if (data.history.length === 0) {
                            historyDiv.innerHTML = '<p class="text-gray-500 text-center py-8">Nenhuma mensagem encontrada</p>';
                        } else {
                            data.history.forEach(msg => {
                                const msgDiv = document.createElement('div');
                                msgDiv.className = 'p-4 border border-gray-200 rounded-lg';
                                msgDiv.innerHTML = `
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-medium">${msg.phone_number}</span>
                                        <span class="text-sm text-gray-500">${new Date(msg.sent_at).toLocaleString('pt-BR')}</span>
                                    </div>
                                    <div class="text-gray-700 mb-2">${msg.message_content}</div>
                                    <div class="flex justify-between">
                                        <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">${msg.message_type}</span>
                                        <span class="text-xs ${msg.status === 'sent' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'} px-2 py-1 rounded">${msg.status}</span>
                                    </div>
                                `;
                                historyDiv.appendChild(msgDiv);
                            });
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Chatbot Functions
        document.getElementById('chatbot-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const trigger = document.getElementById('trigger-word').value;
            const response = document.getElementById('response-message').value;
            const matchType = document.getElementById('match-type').value;
            
            if (!trigger || !response) {
                alert('Preencha todos os campos!');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'save_chatbot_response');
            formData.append('trigger', trigger);
            formData.append('response', response);
            formData.append('match_type', matchType);
            
            fetch('whatsapp_api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Resposta automática salva!');
                    document.getElementById('chatbot-form').reset();
                    loadChatbotResponses();
                } else {
                    alert('Erro: ' + data.error);
                }
            })
            .catch(error => console.error('Error:', error));
        });

        function loadChatbotResponses() {
            fetch('whatsapp_api.php?action=get_chatbot_responses')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const responsesDiv = document.getElementById('chatbot-responses');
                        responsesDiv.innerHTML = '';
                        
                        if (data.responses.length === 0) {
                            responsesDiv.innerHTML = '<p class="text-gray-500 text-center py-8">Nenhuma resposta configurada</p>';
                        } else {
                            data.responses.forEach(resp => {
                                const respDiv = document.createElement('div');
                                respDiv.className = 'p-4 border border-gray-200 rounded-lg';
                                respDiv.innerHTML = `
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="font-medium text-purple-600">${resp.trigger_word}</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Usada ${resp.usage_count || 0}x</span>
                                            <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded">${resp.match_type}</span>
                                            <button onclick="deleteChatbotResponse(${resp.id})" class="text-red-600 hover:text-red-800">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-gray-700 text-sm">${resp.response_message}</div>
                                    <div class="text-xs text-gray-500 mt-2">Criado em: ${new Date(resp.created_at).toLocaleString('pt-BR')}</div>
                                `;
                                responsesDiv.appendChild(respDiv);
                            });
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function deleteChatbotResponse(id) {
            if (confirm('Tem certeza que deseja remover esta resposta?')) {
                const formData = new FormData();
                formData.append('action', 'delete_chatbot_response');
                formData.append('id', id);
                
                fetch('whatsapp_api.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Resposta removida!');
                        loadChatbotResponses();
                    } else {
                        alert('Erro: ' + data.error);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            checkNodeServer();
            
            // Check status every 30 seconds
            setInterval(checkWhatsAppStatus, 30000);
        });
    </script>
<?php endif; ?>

</body>
</html>