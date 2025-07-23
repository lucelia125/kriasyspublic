<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obrigado - MULTZ IPTV</title>
    <meta name="description" content="Cadastro realizado com sucesso! Nossa equipe entrará em contato em até 15 minutos via WhatsApp." />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        purple: {
                            600: '#8B5CF6',
                            700: '#7C3AED',
                            800: '#6D28D9',
                            900: '#5B21B6'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .gradient-bg { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); }
        .gradient-text { background: linear-gradient(135deg, #8B5CF6 0%, #3B82F6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: .5; } }
        .animate-bounce { animation: bounce 1s infinite; }
        @keyframes bounce { 0%, 100% { transform: translateY(-25%); animation-timing-function: cubic-bezier(0.8,0,1,1); } 50% { transform: none; animation-timing-function: cubic-bezier(0,0,0.2,1); } }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-2">
                    <div class="gradient-bg p-2 rounded-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold gradient-text">MULTZ</span>
                </div>
                
                <a href="../" class="flex items-center text-gray-600 hover:text-purple-600 font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Voltar ao Site
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex items-center justify-center min-h-[calc(100vh-80px)] py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Message -->
            <div class="text-center mb-12">
                <div class="flex justify-center mb-6">
                    <div class="bg-gradient-to-r from-green-400 to-green-600 p-4 rounded-full shadow-lg animate-pulse">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    <span class="gradient-text">Parabéns!</span>
                    <br />
                    Cadastro realizado com sucesso
                </h1>
                
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Agradecemos seu interesse na <strong class="text-purple-600">MULTZ IPTV</strong>. 
                    Sua solicitação foi recebida e já está sendo processada pela nossa equipe.
                </p>
            </div>

            <!-- Status Cards -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Contact Timeline -->
                <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="gradient-bg p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12,6 12,12 16,14"></polyline>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 ml-4">Próximo Passo</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Cadastro confirmado</p>
                                <p class="text-gray-600 text-sm">Seus dados foram recebidos com segurança</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-4 animate-pulse">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12,6 12,12 16,14"></polyline>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">
                                    Contato em até <span class="text-purple-600">15 minutos</span>
                                </p>
                                <p class="text-gray-600 text-sm">
                                    Nossa equipe especializada entrará em contato via WhatsApp
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Ativação imediata</p>
                                <p class="text-gray-600 text-sm">
                                    Após a confirmação, seu acesso será liberado instantaneamente
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- What to Expect -->
                <div class="gradient-bg rounded-2xl p-8 text-white shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div class="bg-white/20 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold ml-4">O que esperar</h3>
                    </div>
                    
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Confirmação do seu plano escolhido</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Instruções de instalação personalizadas</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Dados de acesso e configuração</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Suporte técnico completo</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-2xl p-8 shadow-lg border border-gray-100 text-center">
                <div class="flex items-center justify-center mb-6">
                    <div class="gradient-bg p-3 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                
                <h3 class="text-2xl font-bold text-gray-900 mb-4">
                    Precisa de ajuda imediata?
                </h3>
                
                <p class="text-gray-600 mb-6">
                    Nossa equipe de suporte está disponível 24 horas por dia para te ajudar
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/5521980172779" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        WhatsApp Direto
                    </a>
                    
                    <a href="tel:+5521980172779"
                       class="border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        (21) 98017-2779
                    </a>
                </div>
            </div>

            <!-- Footer Message -->
            <div class="text-center mt-12">
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-black px-6 py-3 rounded-full inline-flex items-center font-bold text-lg shadow-lg animate-bounce">
                    🎉 Bem-vindo à família MULTZ!
                </div>
                
                <p class="text-gray-600 mt-4 text-sm">
                    Mantenha seu WhatsApp por perto. Nossa equipe entrará em contato em breve!
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center space-x-2">
                        <div class="gradient-bg p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            </svg>
                        </div>
                        <span class="text-xl font-bold gradient-text">MULTZ</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        A melhor plataforma de IPTV do Brasil. Mais de 1.000 canais, 
                        filmes e séries para toda família.
                    </p>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Suporte</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Central de Ajuda</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Como Instalar</a></li>
                        <li><a href="#" class="hover:text-purple-400 transition-colors">Problemas Técnicos</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="font-semibold text-lg mb-4">Contato</h3>
                    <div class="space-y-3 text-gray-300">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <span class="text-sm">+55(21)98017-2779</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">contato@MULTZ.com.br</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2025 MULTZ. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>