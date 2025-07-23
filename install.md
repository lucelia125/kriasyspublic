# 📱 Instalação do Sistema WhatsApp StarFlix

## Pré-requisitos

Antes de começar, certifique-se de ter:

- **Node.js** (versão 16 ou superior)
- **npm** (gerenciador de pacotes do Node.js)
- **PHP** (versão 7.4 ou superior)
- **MySQL/MariaDB**
- **Servidor web** (Apache/Nginx com suporte ao PHP)

## 🚀 Passo a Passo da Instalação

### 1. Preparar o Banco de Dados
1. Acesse seu phpMyAdmin ou terminal MySQL
2. Execute o script SQL completo (`20250722035456_turquoise_spire.sql`)
3. Verifique se todas as tabelas foram criadas corretamente

### 2. Configurar os Arquivos PHP
1. Coloque todos os arquivos PHP na pasta do seu servidor web
2. Verifique as configurações de banco de dados nos arquivos:
   - `admin.php`
   - `whatsapp_api.php` 
   - `chatbot_processor.php`
   - `process_lead.php`

### 3. Instalar Dependências Node.js
```bash
# Navegue até a pasta do projeto
cd /caminho/para/seu/projeto

# Instalar dependências
npm install
```

### 4. Iniciar o Servidor WhatsApp
```bash
# Iniciar o servidor Node.js
npm start

# Ou para desenvolvimento (com auto-reload)
npm run dev
```

### 5. Verificar a Instalação
1. Acesse `http://localhost/seu-projeto/admin.php`
2. Faça login com:
   - **Usuário**: StarFlix
   - **Senha**: StarFlix147
3. Vá para a aba "WhatsApp API"
4. Clique em "Gerar QR Code"
5. Escaneie com seu WhatsApp

## 🔧 Configurações Importantes

### Portas Utilizadas
- **Node.js Server**: 3001
- **Servidor Web**: 80/443 (Apache/Nginx)

### Arquivos de Configuração
- `package.json`: Dependências do Node.js
- `whatsapp-server.js`: Servidor principal do WhatsApp
- `whatsapp_api.php`: Interface PHP para comunicação
- `chatbot_processor.php`: Processador de respostas automáticas

## 📱 Como Usar

### Conectar WhatsApp
1. No painel admin, vá para "WhatsApp API"
2. Clique em "Gerar QR Code"
3. Abra seu WhatsApp > Menu > WhatsApp Web
4. Escaneie o QR Code que apareceu na tela
5. Aguarde a conexão (status ficará "Conectado")

### Enviar Mensagens
1. **Individual**: Digite o número e mensagem, clique em enviar
2. **Em Massa**: Carregue os leads, selecione os desejados, digite a mensagem e envie

### Configurar Chatbot
1. Vá para a aba "Chatbot"
2. Adicione palavras-chave e suas respostas
3. O sistema responderá automaticamente quando alguém enviar mensagens com essas palavras

## 🐛 Solução de Problemas

### Erro: "Servidor Node.js não encontrado"
```bash
# Verifique se o servidor está rodando
npm start

# Se houver erro, instale as dependências novamente
npm install
```

### Erro: "QR Code inválido"
1. Pare o servidor Node.js (Ctrl+C)
2. No painel admin, clique em "Reiniciar (Limpar Sessão)"
3. Inicie o servidor novamente: `npm start`
4. Gere um novo QR Code

### Erro: "WhatsApp não conecta"
1. Certifique-se de que o servidor Node.js está rodando na porta 3001
2. Verifique se não há firewall bloqueando a porta
3. Tente reiniciar com limpeza de sessão

### Erro de Permissões de Arquivo
```bash
# Linux/Mac - dar permissão para criar arquivos de sessão
chmod 755 ./
chmod 777 ./whatsapp-session
```

## 🔒 Segurança

### Credenciais Padrão (ALTERE!)
- **Admin**: StarFlix / StarFlix147
- **Banco**: root / (sem senha)

### Recomendações
1. Altere as credenciais de administrador
2. Configure senha para o banco de dados
3. Use HTTPS em produção
4. Mantenha o servidor Node.js em rede privada

## 📊 Recursos Implementados

✅ **Captura de Leads**: Formulário completo com validação
✅ **WhatsApp Real**: Conexão via whatsapp-web.js
✅ **QR Code Válido**: Geração real para escaneamento
✅ **Envio Individual**: Mensagens para números específicos
✅ **Disparo em Massa**: Para múltiplos leads selecionados
✅ **Chatbot Inteligente**: Respostas automáticas personalizáveis
✅ **Histórico Completo**: Todas as mensagens são registradas
✅ **Painel Admin**: Interface completa de gerenciamento
✅ **Banco de Dados**: Estrutura completa com relatórios

## 🚨 Importante

Este sistema utiliza **whatsapp-web.js**, que simula um navegador real do WhatsApp Web. É importante:

1. **Manter o servidor sempre ativo** para receber mensagens
2. **Não usar o WhatsApp Web em outros dispositivos** simultaneamente
3. **Fazer backup regular** da pasta `whatsapp-session`
4. **Monitorar os logs** para verificar possíveis problemas

## 📞 Suporte

Se encontrar problemas:

1. Verifique os logs do Node.js no terminal
2. Confira se todas as dependências estão instaladas
3. Certifique-se de que as portas estão liberadas
4. Teste a conectividade entre PHP e Node.js

O sistema está pronto para produção e pode ser facilmente escalado conforme suas necessidades!