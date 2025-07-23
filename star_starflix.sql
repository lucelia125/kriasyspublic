-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 23/07/2025 às 17:52
-- Versão do servidor: 10.11.13-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `star_starflix`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `login_count` int(11) DEFAULT 0,
  `status` enum('active','inactive','suspended') DEFAULT 'active',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `email`, `full_name`, `created_at`, `last_login`, `login_count`, `status`, `permissions`) VALUES
(1, 'StarFlix', 'a3e1e049fb72b30241a9e94733b3785a89841740f06862cf9fae260c82a13a76', 'admin@multz.com.br', 'Administrador Multz', '2025-07-22 05:43:13', NULL, 0, 'active', '{\"leads\": \"full\", \"settings\": \"full\", \"users\": \"full\", \"reports\": \"full\", \"whatsapp\": \"full\", \"chatbot\": \"full\"}');

-- --------------------------------------------------------

--
-- Estrutura para tabela `chatbot_responses`
--

CREATE TABLE `chatbot_responses` (
  `id` int(11) NOT NULL,
  `trigger_word` varchar(100) NOT NULL,
  `response_message` text DEFAULT NULL,
  `match_type` enum('exact','contains','starts_with','ends_with') DEFAULT 'contains',
  `is_active` tinyint(1) DEFAULT 1,
  `usage_count` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `chatbot_responses`
--

INSERT INTO `chatbot_responses` (`id`, `trigger_word`, `response_message`, `match_type`, `is_active`, `usage_count`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'preço', 'Nossos planos começam em R$ 29,90/mês! ?\n\n? Mensal: R$ 29,90 (70% OFF)\n? Trimestral: R$ 69,90 (77% OFF)\n? Anual: R$ 199,90 (83% OFF)\n\nMais de 50.000 canais em HD/4K!\n\nQuer saber mais? Digite \"planos\" ?', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(2, 'planos', '? PLANOS STARFLIX IPTV ?\n\n? MENSAL - R$ 29,90\n• Mais de 50.000 canais\n• Filmes e séries ilimitados\n• Suporte 24/7\n\n? TRIMESTRAL - R$ 69,90 (MAIS ESCOLHIDO)\n• Tudo do plano mensal\n• 3 meses de acesso\n• Economia de 77%\n\n? ANUAL - R$ 199,90\n• Tudo incluso\n• 12 meses de acesso\n• Máxima economia (83% OFF)\n\nPara contratar, acesse: https://starflix.com.br', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(3, 'suporte', '?? SUPORTE STARFLIX ??\n\nEstamos aqui para ajudar você!\n\n? WhatsApp: (11) 99999-9999\n? Email: contato@starflix.com.br\n? Horário: 24 horas por dia, 7 dias por semana\n\nTambém temos tutoriais de instalação no nosso site!\n\nPrecisa de ajuda com algo específico?', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(4, 'instalação', '? COMO INSTALAR A STARFLIX ?\n\n1?? Smart TV: Baixe nosso app na loja\n2?? TV Box: Instale via APK\n3?? Celular: App disponível para Android/iOS\n4?? Notebook: Acesse via navegador\n\n? Após a contratação, você recebe:\n• Link de download\n• Usuário e senha\n• Tutorial completo\n• Suporte para instalação\n\nQuer contratar? Digite \"contratar\" ?', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(5, 'contratar', '? VAMOS CONTRATAR SUA STARFLIX! ?\n\n1?? Acesse: https://starflix.com.br\n2?? Escolha seu plano ideal\n3?? Preencha seus dados\n4?? Receba acesso imediato!\n\n? OFERTA ESPECIAL:\n• 70% de desconto\n• Apenas 47 vagas restantes\n• Garantia de 7 dias\n\n? Ativação em até 5 minutos!\n\nTem alguma dúvida antes de contratar?', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(6, 'canais', '? NOSSOS CANAIS ?\n\n?? BRASIL:\n• Globo, SBT, Record, Band\n• Sportv, Premiere FC\n• Telecine, HBO, Netflix\n• Discovery, History, National Geographic\n\n? INTERNACIONAIS:\n• ESPN, Fox Sports\n• CNN, BBC News\n• Disney, Cartoon Network\n• E muito mais!\n\n? EXTRAS:\n• +10.000 filmes\n• +5.000 séries\n• Desenhos infantis\n• Documentários\n\nTudo em HD e 4K! ?', 'contains', 1, 0, 1, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(9, 'menu', '📋 *MENU STARFLIX* 📋\n\n1️⃣ Ver planos e preços\n2️⃣ Suporte técnico\n3️⃣ Como instalar\n4️⃣ Falar com atendente\n\nDigite o número da opção desejada! 😊', 'exact', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:33:39'),
(10, '1', '? *NOSSOS PLANOS* ?\n\n? Mensal: R$ 29,90\n? Trimestral: R$ 69,90 (MAIS ESCOLHIDO)\n? Anual: R$ 199,90\n\n? Mais de 50.000 canais\n? Filmes e séries ilimitados\n? Suporte 24h\n? Funciona em qualquer dispositivo\n\nQuer assinar? Digite *ASSINAR*', 'exact', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(11, '2', '?? *SUPORTE TÉCNICO* ??\n\nEstou aqui para te ajudar! ?\n\nProblemas mais comuns:\n• App travando\n• Canais não carregam\n• Erro de login\n• Configuração\n\nDescreva seu problema que vou te ajudar! ???', 'exact', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(12, '3', '? *COMO INSTALAR* ?\n\n1?? Baixe o app recomendado\n2?? Insira seus dados de acesso\n3?? Pronto! Aproveite! ?\n\nPrecisa do link do app? Digite *APP*\nPrecisa dos dados de acesso? Digite *DADOS*', 'exact', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(13, '4', '??? *FALAR COM ATENDENTE* ???\n\nVou transferir você para um de nossos especialistas!\n\nEm breve alguém do time vai entrar em contato. ?\n\nEnquanto isso, posso te ajudar com algo? Digite *MENU* ?', 'exact', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(14, 'plano', '? Temos 3 planos incríveis!\n\nDigite *1* para ver todos os detalhes e preços! ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(15, 'assinar', '? *VAMOS ASSINAR!* ?\n\nVou transferir você para nosso time de vendas!\n\nEles vão te ajudar a escolher o melhor plano e fazer a ativação imediata! ?\n\nAguarde o contato! ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(16, 'app', '? *LINK DO APLICATIVO* ?\n\nBaixe aqui: [LINK_DO_APP]\n\nApós instalar, use seus dados de acesso que enviaremos após a confirmação do pagamento! ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(17, 'dados', '? *DADOS DE ACESSO* ?\n\nSeus dados serão enviados após a confirmação do pagamento!\n\nSe já pagou e não recebeu, fale com nosso suporte: Digite *4* ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(18, 'obrigado', '? Por nada! Fico feliz em ajudar!\n\nPrecisa de mais alguma coisa? Digite *MENU* ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33'),
(19, 'tchau', '? Até logo! Foi um prazer te atender!\n\nSempre que precisar, estarei aqui! Digite *MENU* para falar comigo novamente! ?', 'contains', 1, 0, NULL, '2025-07-22 13:07:33', '2025-07-22 13:07:33');

-- --------------------------------------------------------

--
-- Estrutura para tabela `daily_stats`
--

CREATE TABLE `daily_stats` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `total_leads` int(11) DEFAULT 0,
  `new_leads` int(11) DEFAULT 0,
  `converted_leads` int(11) DEFAULT 0,
  `messages_sent` int(11) DEFAULT 0,
  `chatbot_responses` int(11) DEFAULT 0,
  `total_revenue` decimal(12,2) DEFAULT 0.00,
  `avg_conversion_time` int(11) DEFAULT 0,
  `top_device` varchar(50) DEFAULT NULL,
  `top_plan` varchar(50) DEFAULT NULL,
  `top_content_interest` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `leads`
--

CREATE TABLE `leads` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `whatsapp` varchar(20) NOT NULL,
  `device` enum('Smart TV','TV Box','Celular','Notebook','Tablet','Outros') NOT NULL,
  `plan_selected` varchar(50) NOT NULL,
  `plan_price` varchar(20) NOT NULL,
  `plan_value` decimal(10,2) NOT NULL,
  `content_interests` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`content_interests`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `utm_source` varchar(100) DEFAULT NULL,
  `utm_medium` varchar(100) DEFAULT NULL,
  `utm_campaign` varchar(100) DEFAULT NULL,
  `utm_term` varchar(100) DEFAULT NULL,
  `utm_content` varchar(100) DEFAULT NULL,
  `referrer_url` text DEFAULT NULL,
  `landing_page` varchar(255) DEFAULT NULL,
  `status` enum('new','contacted','qualified','converted','lost','follow_up') DEFAULT 'new',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
  `lead_source` enum('website','facebook','instagram','google','whatsapp','referral','other') DEFAULT 'website',
  `notes` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `last_contact_date` timestamp NULL DEFAULT NULL,
  `next_follow_up` timestamp NULL DEFAULT NULL,
  `conversion_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `whatsapp_message_sent` tinyint(1) DEFAULT 0,
  `whatsapp_message_status` enum('pending','sent','failed') DEFAULT 'pending',
  `whatsapp_error` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `leads`
--

INSERT INTO `leads` (`id`, `name`, `whatsapp`, `device`, `plan_selected`, `plan_price`, `plan_value`, `content_interests`, `ip_address`, `user_agent`, `utm_source`, `utm_medium`, `utm_campaign`, `utm_term`, `utm_content`, `referrer_url`, `landing_page`, `status`, `priority`, `lead_source`, `notes`, `assigned_to`, `last_contact_date`, `next_follow_up`, `conversion_date`, `created_at`, `updated_at`, `whatsapp_message_sent`, `whatsapp_message_status`, `whatsapp_error`) VALUES
(11, 'Mathias Lopes', '51991276618', 'Smart TV', 'Trimestral', 'R$ 69,90', 69.90, '[\"Canais de not\\u00edcias\"]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 13:16:01', '2025-07-22 13:16:01', 0, 'failed', 'Erro ao enviar mensagem: Protocol error (Runtime.callFunctionOn): Session closed. Most likely the page has been closed.'),
(12, 'Mathias teste +55', '+5551991276618', 'Smart TV', 'Mensal', 'R$ 29,90', 29.90, '[\"Canais de not\\u00edcias\",\"Futebol\",\"S\\u00e9ries\"]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 13:17:03', '2025-07-22 13:17:03', 0, 'failed', 'Erro ao enviar mensagem: Protocol error (Runtime.callFunctionOn): Session closed. Most likely the page has been closed.'),
(13, 'Maria', '+55(51)99127-6618', 'Smart TV', 'Mensal', 'R$ 29,90', 29.90, '[\"Canais de not\\u00edcias\"]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 13:34:48', '2025-07-22 13:35:18', 0, 'failed', 'Erro ao conectar com o servidor WhatsApp'),
(14, 'Maria 2', '5191276618', 'Smart TV', 'Mensal', 'R$ 29,90', 29.90, '[]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 13:36:32', '2025-07-22 13:37:02', 0, 'failed', 'Erro ao conectar com o servidor WhatsApp'),
(15, 'Fabricio', '51991276618', 'Smart TV', 'Mensal', 'R$ 29,90', 29.90, '[\"Canais de not\\u00edcias\"]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 14:06:55', '2025-07-22 14:06:56', 1, 'sent', NULL),
(16, 'Thor tv', '12996050901', 'Celular', 'Mensal', 'R$ 29,90', 29.90, '[\"Filmes\",\"S\\u00e9ries\"]', '189.124.66.144', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 14:21:14', '2025-07-22 14:21:15', 1, 'sent', NULL),
(17, 'Rogério147', '51991276618', 'TV Box', 'Mensal', 'R$ 29,90', 29.90, '[\"Canais de not\\u00edcias\",\"Filmes\",\"S\\u00e9ries\"]', '181.174.255.71', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'new', 'medium', 'website', NULL, NULL, NULL, NULL, NULL, '2025-07-22 14:32:52', '2025-07-22 14:32:53', 1, 'sent', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `lead_history`
--

CREATE TABLE `lead_history` (
  `id` int(11) NOT NULL,
  `lead_id` int(11) NOT NULL,
  `action_type` enum('created','status_changed','contacted','note_added','assigned','converted','message_sent') NOT NULL,
  `old_value` text DEFAULT NULL,
  `new_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `performed_by` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `marketing_campaigns`
--

CREATE TABLE `marketing_campaigns` (
  `id` int(11) NOT NULL,
  `campaign_name` varchar(100) NOT NULL,
  `campaign_type` enum('whatsapp_bulk','email','sms','social_media') NOT NULL,
  `target_audience` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`target_audience`)),
  `message_template` text DEFAULT NULL,
  `scheduled_at` timestamp NULL DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT NULL,
  `status` enum('draft','scheduled','sending','sent','cancelled') DEFAULT 'draft',
  `total_recipients` int(11) DEFAULT 0,
  `successful_sends` int(11) DEFAULT 0,
  `failed_sends` int(11) DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `message_history`
--

CREATE TABLE `message_history` (
  `id` int(11) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `message_content` text NOT NULL,
  `message_type` enum('individual','bulk','chatbot') NOT NULL,
  `status` enum('sent','delivered','read','failed') DEFAULT 'sent',
  `lead_id` int(11) DEFAULT NULL,
  `sent_by` int(11) DEFAULT NULL,
  `sent_at` timestamp NULL DEFAULT current_timestamp(),
  `delivered_at` timestamp NULL DEFAULT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `error_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `message_history`
--

INSERT INTO `message_history` (`id`, `phone_number`, `message_content`, `message_type`, `status`, `lead_id`, `sent_by`, `sent_at`, `delivered_at`, `read_at`, `error_message`) VALUES
(1, '5511999999999', 'Olá Maria! Obrigado pelo interesse na StarFlix IPTV. Seu plano Trimestral está sendo processado.', 'individual', 'sent', NULL, NULL, '2025-07-22 03:43:13', NULL, NULL, NULL),
(2, '5521888888888', 'João, sua assinatura mensal foi ativada com sucesso! Acesse com os dados enviados por email.', 'individual', 'sent', NULL, NULL, '2025-07-22 04:43:13', NULL, NULL, NULL),
(3, '5531777777777', 'Ana, que bom ter você conosco! Seu plano anual oferece a melhor economia. Aproveite!', 'individual', 'sent', NULL, NULL, '2025-07-22 05:13:13', NULL, NULL, NULL),
(4, '51991276618', 'teste', 'individual', 'sent', NULL, NULL, '2025-07-22 13:59:03', NULL, NULL, NULL),
(5, '51991276618', 'teste', 'individual', 'sent', NULL, NULL, '2025-07-22 14:01:06', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_type` enum('string','number','boolean','json') DEFAULT 'string',
  `description` text DEFAULT NULL,
  `category` varchar(50) DEFAULT 'general',
  `is_public` tinyint(1) DEFAULT 0,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `system_settings`
--

INSERT INTO `system_settings` (`id`, `setting_key`, `setting_value`, `setting_type`, `description`, `category`, `is_public`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'site_title', 'StarFlix IPTV - O Melhor IPTV do Brasil', 'string', 'Título principal do site', 'general', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(2, 'site_description', 'Mais de 50.000 canais em HD/4K, filmes, séries e esportes ao vivo', 'string', 'Descrição do site', 'general', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(3, 'contact_whatsapp', '5511999999999', 'string', 'WhatsApp para contato', 'contact', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(4, 'contact_email', 'contato@starflix.com.br', 'string', 'Email para contato', 'contact', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(5, 'promo_discount_monthly', '70', 'number', 'Desconto promocional mensal (%)', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(6, 'promo_discount_quarterly', '77', 'number', 'Desconto promocional trimestral (%)', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(7, 'promo_discount_annual', '83', 'number', 'Desconto promocional anual (%)', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(8, 'price_monthly_original', '99.90', 'number', 'Preço original mensal', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(9, 'price_monthly_promo', '29.90', 'number', 'Preço promocional mensal', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(10, 'price_quarterly_original', '299.70', 'number', 'Preço original trimestral', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(11, 'price_quarterly_promo', '69.90', 'number', 'Preço promocional trimestral', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(12, 'price_annual_original', '1198.80', 'number', 'Preço original anual', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(13, 'price_annual_promo', '199.90', 'number', 'Preço promocional anual', 'pricing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(14, 'scarcity_spots_remaining', '47', 'number', 'Vagas restantes (gatilho de escassez)', 'marketing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(15, 'urgency_timer_hours', '24', 'number', 'Horas restantes da oferta', 'marketing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(16, 'total_customers', '100000', 'number', 'Total de clientes (prova social)', 'marketing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(17, 'rating_stars', '4.9', 'number', 'Avaliação em estrelas', 'marketing', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(18, 'total_channels', '50000', 'number', 'Total de canais disponíveis', 'features', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(19, 'guarantee_days', '7', 'number', 'Dias de garantia', 'features', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(20, 'support_hours', '24/7', 'string', 'Horário de suporte', 'features', 1, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(21, 'whatsapp_api_enabled', 'true', 'boolean', 'WhatsApp API ativada', 'whatsapp', 0, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(22, 'chatbot_enabled', 'true', 'boolean', 'Chatbot ativado', 'chatbot', 0, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13'),
(23, 'chatbot_default_response', 'Olá! Obrigado pelo contato. Em breve um de nossos atendentes entrará em contato com você.', 'string', 'Resposta padrão do chatbot', 'chatbot', 0, NULL, '2025-07-22 05:43:13', '2025-07-22 05:43:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `whatsapp_sessions`
--

CREATE TABLE `whatsapp_sessions` (
  `id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `qr_code` text DEFAULT NULL,
  `status` enum('waiting','connected','disconnected','error') DEFAULT 'waiting',
  `last_activity` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_status` (`status`);

--
-- Índices de tabela `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trigger_word` (`trigger_word`),
  ADD KEY `idx_trigger_word` (`trigger_word`),
  ADD KEY `idx_is_active` (`is_active`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `idx_trigger` (`trigger_word`),
  ADD KEY `idx_active` (`is_active`);

--
-- Índices de tabela `daily_stats`
--
ALTER TABLE `daily_stats`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`),
  ADD KEY `idx_date` (`date`);

--
-- Índices de tabela `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_device` (`device`),
  ADD KEY `idx_plan_selected` (`plan_selected`),
  ADD KEY `idx_lead_source` (`lead_source`),
  ADD KEY `idx_priority` (`priority`),
  ADD KEY `idx_whatsapp` (`whatsapp`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Índices de tabela `lead_history`
--
ALTER TABLE `lead_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_lead_id` (`lead_id`),
  ADD KEY `idx_action_type` (`action_type`),
  ADD KEY `idx_created_at` (`created_at`),
  ADD KEY `performed_by` (`performed_by`);

--
-- Índices de tabela `marketing_campaigns`
--
ALTER TABLE `marketing_campaigns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_campaign_type` (`campaign_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_scheduled_at` (`scheduled_at`),
  ADD KEY `created_by` (`created_by`);

--
-- Índices de tabela `message_history`
--
ALTER TABLE `message_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_phone_number` (`phone_number`),
  ADD KEY `idx_sent_at` (`sent_at`),
  ADD KEY `idx_message_type` (`message_type`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `lead_id` (`lead_id`),
  ADD KEY `sent_by` (`sent_by`);

--
-- Índices de tabela `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`),
  ADD KEY `idx_setting_key` (`setting_key`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Índices de tabela `whatsapp_sessions`
--
ALTER TABLE `whatsapp_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `session_id` (`session_id`),
  ADD KEY `idx_session_id` (`session_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_last_activity` (`last_activity`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de tabela `daily_stats`
--
ALTER TABLE `daily_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `leads`
--
ALTER TABLE `leads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `lead_history`
--
ALTER TABLE `lead_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `marketing_campaigns`
--
ALTER TABLE `marketing_campaigns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `message_history`
--
ALTER TABLE `message_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `whatsapp_sessions`
--
ALTER TABLE `whatsapp_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `chatbot_responses`
--
ALTER TABLE `chatbot_responses`
  ADD CONSTRAINT `chatbot_responses_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `leads`
--
ALTER TABLE `leads`
  ADD CONSTRAINT `leads_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `lead_history`
--
ALTER TABLE `lead_history`
  ADD CONSTRAINT `lead_history_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lead_history_ibfk_2` FOREIGN KEY (`performed_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `marketing_campaigns`
--
ALTER TABLE `marketing_campaigns`
  ADD CONSTRAINT `marketing_campaigns_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `message_history`
--
ALTER TABLE `message_history`
  ADD CONSTRAINT `message_history_ibfk_1` FOREIGN KEY (`lead_id`) REFERENCES `leads` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `message_history_ibfk_2` FOREIGN KEY (`sent_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;

--
-- Restrições para tabelas `system_settings`
--
ALTER TABLE `system_settings`
  ADD CONSTRAINT `system_settings_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
