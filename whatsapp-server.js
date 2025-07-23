const { Client, LocalAuth, MessageMedia } = require('whatsapp-web.js');
const qrcode = require('qrcode');
const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const fs = require('fs-extra');
const path = require('path');

const app = express();
const PORT = 3001;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Variáveis globais
let client;
let qrString = '';
let isConnected = false;
let connectedNumber = '';
let sessionStatus = 'disconnected';

// Garantir que o diretório de sessão existe
const sessionDir = './whatsapp-session';
fs.ensureDirSync(sessionDir);

// Inicializar cliente WhatsApp
function initializeWhatsApp() {
    client = new Client({
        authStrategy: new LocalAuth({
            clientId: 'starflix-whatsapp',
            dataPath: sessionDir
        }),
        puppeteer: {
            headless: true,
            args: [
                '--no-sandbox',
                '--disable-setuid-sandbox',
                '--disable-dev-shm-usage',
                '--disable-accelerated-2d-canvas',
                '--no-first-run',
                '--no-zygote',
                '--single-process',
                '--disable-gpu'
            ]
        }
    });

    // Evento: QR Code recebido
    client.on('qr', async (qr) => {
        console.log('📱 QR Code recebido, gerando imagem...');
        try {
            qrString = await qrcode.toDataURL(qr);
            sessionStatus = 'waiting';
            console.log('✅ QR Code gerado com sucesso');
            
            // Salvar QR Code como arquivo temporário também
            const qrPath = path.join(__dirname, 'qr-code.png');
            await qrcode.toFile(qrPath, qr);
            console.log(`💾 QR Code salvo em: ${qrPath}`);
        } catch (error) {
            console.error('❌ Erro ao gerar QR Code:', error);
            sessionStatus = 'error';
        }
    });

    // Evento: Cliente pronto (conectado)
    client.on('ready', () => {
        console.log('🟢 WhatsApp Web conectado com sucesso!');
        isConnected = true;
        sessionStatus = 'connected';
        connectedNumber = client.info.wid.user;
        console.log(`📞 Número conectado: +${connectedNumber}`);
        qrString = ''; // Limpar QR Code após conexão
    });

    // Evento: Cliente desconectado
    client.on('disconnected', (reason) => {
        console.log('🔴 WhatsApp Web desconectado:', reason);
        isConnected = false;
        sessionStatus = 'disconnected';
        connectedNumber = '';
        qrString = '';
        
        // Tentar reconectar após 10 segundos
        setTimeout(() => {
            console.log('🔄 Tentando reconectar...');
            initializeWhatsApp();
        }, 10000);
    });

    // Evento: Mensagem recebida (para chatbot)
    client.on('message', async (message) => {
        if (!message.body || message.fromMe) return;
        
        console.log(`📨 Mensagem recebida de ${message.from}: ${message.body}`);
        
        try {
            // Processar com chatbot (fazer requisição para PHP)
            const response = await processChatbotResponse(message.from, message.body);
            if (response && response.trim()) {
                await client.sendMessage(message.from, response);
                console.log(`🤖 Resposta automática enviada para ${message.from}`);
            }
        } catch (error) {
            console.error('❌ Erro no processamento do chatbot:', error);
        }
    });

    // Evento: Erro de autenticação
    client.on('auth_failure', (msg) => {
        console.error('❌ Falha na autenticação:', msg);
        sessionStatus = 'auth_failure';
        
        // Limpar sessão e tentar novamente
        setTimeout(async () => {
            console.log('🗑️ Limpando sessão e reiniciando...');
            await fs.remove(sessionDir);
            setTimeout(() => initializeWhatsApp(), 5000);
        }, 2000);
    });

    // Inicializar cliente
    client.initialize();
}

// Função para processar resposta do chatbot
async function processChatbotResponse(phone, message) {
    try {
        // Fazer requisição para o PHP processar o chatbot
        const response = await fetch('http://localhost/starflix/chatbot_processor.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ phone: phone, message: message })
        });
        
        if (response.ok) {
            const data = await response.json();
            return data.response || '';
        }
    } catch (error) {
        console.error('Erro ao processar chatbot:', error);
    }
    return '';
}

// Função para formatar número de telefone
function formatPhoneNumber(phone) {
    // Remove todos os caracteres não numéricos
    let cleaned = phone.replace(/\D/g, '');
    
    // Se começar com 0, remove o 0
    if (cleaned.startsWith('0')) {
        cleaned = cleaned.substring(1);
    }
    
    // Se não começar com código do país, adiciona 55 (Brasil)
    if (!cleaned.startsWith('55')) {
        cleaned = '55' + cleaned;
    }
    
    // Se for número de São Paulo e não tiver o 9, adiciona
    if (cleaned.startsWith('5511') && cleaned.length === 12) {
        cleaned = cleaned.substring(0, 4) + '9' + cleaned.substring(4);
    }
    
    return cleaned + '@c.us';
}

// Rotas da API

// Rota: Gerar QR Code
app.get('/api/qr', (req, res) => {
    if (isConnected) {
        return res.json({
            success: false,
            error: 'WhatsApp já está conectado',
            connected: true,
            phone: `+${connectedNumber}`
        });
    }
    
    if (!qrString) {
        return res.json({
            success: false,
            error: 'QR Code ainda não foi gerado. Tente novamente em alguns segundos.',
            status: sessionStatus
        });
    }
    
    res.json({
        success: true,
        qr_code: qrString,
        status: sessionStatus
    });
});

// Rota: Verificar status da conexão
app.get('/api/status', (req, res) => {
    res.json({
        connected: isConnected,
        status: sessionStatus,
        phone: connectedNumber ? `+${connectedNumber}` : null,
        client_info: isConnected ? client.info : null
    });
});

// Rota: Enviar mensagem individual
app.post('/api/send-message', async (req, res) => {
    if (!isConnected) {
        return res.json({
            success: false,
            error: 'WhatsApp não está conectado'
        });
    }
    
    const { to, message } = req.body;
    
    if (!to || !message) {
        return res.json({
            success: false,
            error: 'Número e mensagem são obrigatórios'
        });
    }
    
    try {
        const formattedNumber = formatPhoneNumber(to);
        const chatId = await client.getNumberId(formattedNumber.replace('@c.us', ''));
        
        if (!chatId) {
            return res.json({
                success: false,
                error: 'Número do WhatsApp não encontrado ou inválido'
            });
        }
        
        await client.sendMessage(chatId._serialized, message);
        
        console.log(`✅ Mensagem enviada para ${to}: ${message.substring(0, 50)}...`);
        
        res.json({
            success: true,
            message: 'Mensagem enviada com sucesso!',
            to: to,
            chatId: chatId._serialized
        });
    } catch (error) {
        console.error('❌ Erro ao enviar mensagem:', error);
        res.json({
            success: false,
            error: 'Erro ao enviar mensagem: ' + error.message
        });
    }
});

// Rota: Enviar mensagem em massa
app.post('/api/send-bulk', async (req, res) => {
    if (!isConnected) {
        return res.json({
            success: false,
            error: 'WhatsApp não está conectado'
        });
    }
    
    const { numbers, message } = req.body;
    
    if (!numbers || !Array.isArray(numbers) || !message) {
        return res.json({
            success: false,
            error: 'Lista de números e mensagem são obrigatórios'
        });
    }
    
    let sent = 0;
    let failed = 0;
    const results = [];
    
    for (const number of numbers) {
        try {
            const formattedNumber = formatPhoneNumber(number);
            const chatId = await client.getNumberId(formattedNumber.replace('@c.us', ''));
            
            if (chatId) {
                await client.sendMessage(chatId._serialized, message);
                sent++;
                results.push({ number, status: 'sent' });
                console.log(`✅ Mensagem enviada para ${number}`);
            } else {
                failed++;
                results.push({ number, status: 'invalid_number' });
                console.log(`❌ Número inválido: ${number}`);
            }
            
            // Delay entre mensagens para evitar bloqueio
            await new Promise(resolve => setTimeout(resolve, 2000));
            
        } catch (error) {
            failed++;
            results.push({ number, status: 'failed', error: error.message });
            console.error(`❌ Erro ao enviar para ${number}:`, error);
        }
    }
    
    res.json({
        success: true,
        sent,
        failed,
        total: numbers.length,
        results
    });
});

// Rota: Desconectar WhatsApp
app.post('/api/disconnect', async (req, res) => {
    try {
        if (client) {
            await client.destroy();
        }
        isConnected = false;
        sessionStatus = 'disconnected';
        connectedNumber = '';
        qrString = '';
        
        res.json({
            success: true,
            message: 'WhatsApp desconectado com sucesso'
        });
    } catch (error) {
        res.json({
            success: false,
            error: error.message
        });
    }
});

// Rota: Reiniciar conexão
app.post('/api/restart', async (req, res) => {
    try {
        if (client) {
            await client.destroy();
        }
        
        // Limpar sessão se solicitado
        if (req.body.clearSession) {
            await fs.remove(sessionDir);
        }
        
        setTimeout(() => {
            initializeWhatsApp();
        }, 2000);
        
        res.json({
            success: true,
            message: 'Reiniciando conexão WhatsApp...'
        });
    } catch (error) {
        res.json({
            success: false,
            error: error.message
        });
    }
});

// Rota: Health check
app.get('/api/health', (req, res) => {
    res.json({
        status: 'running',
        uptime: process.uptime(),
        whatsapp_connected: isConnected,
        whatsapp_status: sessionStatus
    });
});

// Inicializar servidor
app.listen(PORT, () => {
    console.log(`🚀 Servidor WhatsApp API rodando na porta ${PORT}`);
    console.log(`🔗 API disponível em: http://localhost:${PORT}`);
    console.log(`📊 Status: http://localhost:${PORT}/api/health`);
    
    // Inicializar WhatsApp
    console.log('🔄 Inicializando WhatsApp Web...');
    initializeWhatsApp();
});

// Tratamento de erros
process.on('uncaughtException', (error) => {
    console.error('❌ Erro não capturado:', error);
});

process.on('unhandledRejection', (reason, promise) => {
    console.error('❌ Promise rejeitada não tratada:', reason);
});