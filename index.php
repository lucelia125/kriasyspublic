<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MULTZ - O Melhor IPTV do Brasil</title>
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
    </style>
</head>
<body class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
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
                
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#inicio" class="text-gray-700 hover:text-purple-600 font-medium">Início</a>
                    <a href="#recursos" class="text-gray-700 hover:text-purple-600 font-medium">Recursos</a>
                    <a href="#precos" class="text-gray-700 hover:text-purple-600 font-medium">Preços</a>
                    <a href="#contato" class="text-gray-700 hover:text-purple-600 font-medium">Contato</a>
                </nav>

                <div class="flex items-center space-x-4">
                    <a href="admin.php" class="text-gray-500 hover:text-purple-600 text-sm">Admin</a>
                    <a href="#assinar" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-all duration-300 shadow-lg">
                        Assinar Agora
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section id="inicio" class="relative gradient-bg text-white overflow-hidden">
        <div class="absolute inset-0 bg-black/20"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-8">
                    <div class="inline-flex items-center bg-red-600 text-white px-4 py-2 rounded-full text-sm font-semibold animate-pulse">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12,6 12,12 16,14"></polyline>
                        </svg>
                        OFERTA LIMITADA - Apenas 24h!
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
                        O Melhor
                        <span class="block text-yellow-400">IPTV do Brasil</span>
                    </h1>
                    
                    <p class="text-xl lg:text-2xl text-purple-100 leading-relaxed">
                        Mais de <strong class="text-yellow-400">1.000 canais</strong> em HD/4K, 
                        filmes, séries e esportes ao vivo. Sem travamentos, sem limites!
                    </p>
                    
                    <div class="flex items-center space-x-6 text-purple-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span>4.9/5 estrelas</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <span>+100k clientes</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#precos" class="bg-gradient-to-r from-yellow-500 to-orange-600 text-black px-8 py-4 rounded-lg font-bold text-lg hover:from-yellow-400 hover:to-orange-500 transition-all duration-300 shadow-2xl transform hover:scale-105 text-center">
                            QUERO ASSINAR AGORA
                        </a>
                        <button class="border-2 border-white/30 text-white px-8 py-4 rounded-lg font-semibold hover:bg-white/10 transition-all duration-300 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <polygon points="5,3 19,12 5,21 5,3"></polygon>
                            </svg>
                            Ver Demonstração
                        </button>
                    </div>
                    
                    <div class="bg-red-600/20 border border-red-400 rounded-lg p-4">
                        <p class="text-red-200 font-semibold">
                            ⚠️ ATENÇÃO: Restam apenas <span class="text-yellow-400">47 vagas</span> com desconto de 70%!
                        </p>
                    </div>
                </div>
                
                <div class="relative">
                    <div class="relative z-10">
                        <img src="https://images.pexels.com/photos/1201996/pexels-photo-1201996.jpeg" alt="Streaming Technology" class="rounded-2xl shadow-2xl">
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/50 to-transparent rounded-2xl"></div>
                    </div>
                    <div class="absolute -top-4 -right-4 bg-yellow-400 text-black px-4 py-2 rounded-full font-bold animate-bounce">
                        70% OFF
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="recursos" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Por que escolher a <span class="gradient-text">MULTZ?</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    A melhor experiência de streaming com tecnologia de ponta e conteúdo ilimitado
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $features = [
                    ['icon' => 'tv', 'title' => 'Mais de 1.000 Canais', 'desc' => 'Canais do Brasil e do mundo inteiro em HD e 4K'],
                    ['icon' => 'smartphone', 'title' => 'Funciona em Qualquer Dispositivo', 'desc' => 'Smart TV, TV Box, celular, notebook e tablets'],
                    ['icon' => 'wifi', 'title' => 'Sem Travamentos', 'desc' => 'Servidores de alta velocidade para streaming perfeito'],
                    ['icon' => 'shield', 'title' => '100% Seguro', 'desc' => 'Conexão criptografada e dados protegidos'],
                    ['icon' => 'clock', 'title' => 'Suporte 24/7', 'desc' => 'Atendimento especializado todos os dias'],
                    ['icon' => 'globe', 'title' => 'Conteúdo Mundial', 'desc' => 'Filmes, séries e esportes de todos os países']
                ];
                
                foreach($features as $feature): ?>
                <div class="bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:transform hover:scale-105 border border-gray-100">
                    <div class="gradient-bg w-16 h-16 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if($feature['icon'] == 'tv'): ?>
                                <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                <line x1="8" y1="21" x2="16" y2="21"></line>
                                <line x1="12" y1="17" x2="12" y2="21"></line>
                            <?php elseif($feature['icon'] == 'smartphone'): ?>
                                <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                <line x1="12" y1="18" x2="12.01" y2="18"></line>
                            <?php elseif($feature['icon'] == 'wifi'): ?>
                                <path d="M5 12.55a11 11 0 0 1 14.08 0"></path>
                                <path d="M1.42 9a16 16 0 0 1 21.16 0"></path>
                                <path d="M8.53 16.11a6 6 0 0 1 6.95 0"></path>
                                <line x1="12" y1="20" x2="12.01" y2="20"></line>
                            <?php elseif($feature['icon'] == 'shield'): ?>
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <?php elseif($feature['icon'] == 'clock'): ?>
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12,6 12,12 16,14"></polyline>
                            <?php else: ?>
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="2" y1="12" x2="22" y2="12"></line>
                                <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                            <?php endif; ?>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?= $feature['title'] ?></h3>
                    <p class="text-gray-600 leading-relaxed"><?= $feature['desc'] ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    O que nossos <span class="gradient-text">clientes dizem</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Mais de 100.000 clientes satisfeitos em todo o Brasil
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <?php
                $testimonials = [
                    ['name' => 'Carlos Oliveira', 'location' => 'São Paulo, SP', 'text' => 'Incrível! Cancelei minha TV por assinatura e economizo R$ 200 por mês. A qualidade é perfeita e nunca trava.', 'avatar' => 'https://images.pexels.com/photos/1043474/pexels-photo-1043474.jpeg?w=100&h=100&fit=crop&crop=face'],
                    ['name' => 'Ana Costa', 'location' => 'Rio de Janeiro, RJ', 'text' => 'Melhor investimento que fiz! Assisto todos os jogos do meu time em 4K. Recomendo para todos os amigos.', 'avatar' => 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?w=100&h=100&fit=crop&crop=face'],
                    ['name' => 'Roberto Santos', 'location' => 'Belo Horizonte, MG', 'text' => 'Funciona perfeitamente na minha Smart TV. Milhares de filmes e séries, muito melhor que Netflix!', 'avatar' => 'https://images.pexels.com/photos/1065084/pexels-photo-1065084.jpeg?w=100&h=100&fit=crop&crop=face']
                ];
                
                foreach($testimonials as $testimonial): ?>
                <div class="bg-gray-50 rounded-2xl p-8 relative hover:shadow-lg transition-all duration-300">
                    <svg class="w-8 h-8 text-purple-600 mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    
                    <div class="flex items-center mb-4">
                        <?php for($i = 0; $i < 5; $i++): ?>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        <?php endfor; ?>
                    </div>
                    
                    <p class="text-gray-700 mb-6 leading-relaxed text-lg">
                        "<?= $testimonial['text'] ?>"
                    </p>
                    
                    <div class="flex items-center">
                        <img src="<?= $testimonial['avatar'] ?>" alt="<?= $testimonial['name'] ?>" class="w-12 h-12 rounded-full object-cover mr-4">
                        <div>
                            <h4 class="font-semibold text-gray-900"><?= $testimonial['name'] ?></h4>
                            <p class="text-gray-600 text-sm"><?= $testimonial['location'] ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="precos" class="py-20 gradient-bg text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold mb-4">
                    Escolha seu <span class="text-yellow-400">plano ideal</span>
                </h2>
                <p class="text-xl text-purple-100 mb-8">
                    Oferta limitada - Desconto de até 83% apenas hoje!
                </p>
                
                <div class="bg-red-600 text-white px-6 py-3 rounded-full inline-flex items-center font-bold text-lg animate-pulse">
                    🔥 ÚLTIMAS 47 VAGAS COM DESCONTO!
                </div>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <?php
                $plans = [
                    ['name' => 'Mensal', 'original' => 'R$ 99,90', 'price' => 'R$ 29,90', 'period' => '/mês', 'discount' => '70%', 'popular' => false, 'value' => '29.90'],
                    ['name' => 'Trimestral', 'original' => 'R$ 299,70', 'price' => 'R$ 69,90', 'period' => '/3 meses', 'discount' => '77%', 'popular' => true, 'value' => '69.90'],
                    ['name' => 'Anual', 'original' => 'R$ 1.198,80', 'price' => 'R$ 199,90', 'period' => '/ano', 'discount' => '83%', 'popular' => false, 'value' => '199.90']
                ];
                
                foreach($plans as $plan): ?>
                <div class="relative rounded-2xl p-8 <?= $plan['popular'] ? 'bg-gradient-to-b from-yellow-400 to-orange-500 text-black transform scale-105 shadow-2xl' : 'bg-white/10 backdrop-blur-lg border border-white/20' ?>">
                    <?php if($plan['popular']): ?>
                    <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                        <div class="bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3l14 9-14 9V3z"></path>
                            </svg>
                            MAIS ESCOLHIDO
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold mb-4 <?= $plan['popular'] ? 'text-black' : 'text-white' ?>">
                            <?= $plan['name'] ?>
                        </h3>
                        
                        <div class="mb-4">
                            <span class="text-lg line-through <?= $plan['popular'] ? 'text-gray-700' : 'text-gray-400' ?>">
                                <?= $plan['original'] ?>
                            </span>
                            <div class="bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold inline-block ml-2">
                                -<?= $plan['discount'] ?>
                            </div>
                        </div>
                        
                        <div class="text-5xl font-bold mb-2 <?= $plan['popular'] ? 'text-black' : 'text-white' ?>">
                            <?= $plan['price'] ?>
                        </div>
                        <span class="text-lg <?= $plan['popular'] ? 'text-gray-700' : 'text-gray-300' ?>">
                            <?= $plan['period'] ?>
                        </span>
                    </div>
                    
                    <button onclick="selectPlan('<?= $plan['name'] ?>', '<?= $plan['price'] ?>', '<?= $plan['value'] ?>')" 
                            class="w-full py-4 rounded-lg font-bold text-lg transition-all duration-300 flex items-center justify-center <?= $plan['popular'] ? 'bg-black text-white hover:bg-gray-800' : 'bg-gradient-to-r from-purple-600 to-blue-600 text-white hover:from-purple-700 hover:to-blue-700' ?>">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <polygon points="13,2 3,14 12,14 11,22 21,10 12,10 13,2"></polygon>
                        </svg>
                        ESCOLHER PLANO
                    </button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Lead Form Modal -->
    <div id="leadFormModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-screen overflow-y-auto">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-3xl font-bold text-gray-900">
                            Finalize sua <span class="gradient-text">assinatura</span>
                        </h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div id="selectedPlanInfo" class="bg-gradient-to-r from-purple-100 to-blue-100 rounded-lg p-4 mb-6">
                        <!-- Plan info will be inserted here -->
                    </div>
                    
                    <form action="process_lead.php" method="POST" class="space-y-6">
                        <input type="hidden" id="selectedPlan" name="plan" value="">
                        <input type="hidden" id="selectedPrice" name="price" value="">
                        <input type="hidden" id="selectedValue" name="value" value="">
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nome Completo *
                                </label>
                                <input type="text" name="name" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                       placeholder="Digite seu nome completo">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    WhatsApp *
                                </label>
                                <input type="tel" name="whatsapp" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-600 focus:border-transparent"
                                       placeholder="(21) 98017-2779">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-4">
                                Onde você quer instalar a MULTZ? *
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <?php
                                $devices = [
                                    ['value' => 'Smart TV', 'label' => 'Smart TV'],
                                    ['value' => 'TV Box', 'label' => 'TV Box'],
                                    ['value' => 'Celular', 'label' => 'Celular'],
                                    ['value' => 'Notebook', 'label' => 'Notebook'],
                                    ['value' => 'Tablet', 'label' => 'Tablet'],
                                    ['value' => 'Outros', 'label' => 'Outros']
                                ];
                                
                                foreach($devices as $device): ?>
                                <label class="flex flex-col items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-400 transition-all duration-300 device-option">
                                    <svg class="w-8 h-8 mb-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <?php if($device['value'] == 'Smart TV' || $device['value'] == 'TV Box'): ?>
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        <?php elseif($device['value'] == 'Celular'): ?>
                                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                            <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                        <?php elseif($device['value'] == 'Notebook'): ?>
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        <?php elseif($device['value'] == 'Tablet'): ?>
                                            <rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect>
                                            <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                        <?php else: ?>
                                            <circle cx="12" cy="12" r="3"></circle>
                                            <path d="M12 1v6m0 6v6m11-7h-6m-6 0H1"></path>
                                        <?php endif; ?>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700"><?= $device['label'] ?></span>
                                    <input type="radio" name="device" value="<?= $device['value'] ?>" required class="sr-only">
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-4">
                                O que você mais precisa? (Selecione um ou mais) *
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <?php
                                $contentTypes = ['Canais de notícias', 'Futebol', 'Filmes', 'Séries', 'Novelas', 'Tudo'];
                                
                                foreach($contentTypes as $content): ?>
                                <label class="flex items-center p-4 border-2 border-gray-300 rounded-lg cursor-pointer hover:border-purple-400 transition-all duration-300 content-option">
                                    <input type="checkbox" name="content[]" value="<?= $content ?>" class="sr-only">
                                    <span class="text-sm font-medium text-gray-700"><?= $content ?></span>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="bg-gradient-to-r from-yellow-500 to-orange-600 text-black px-12 py-4 rounded-lg font-bold text-xl hover:from-yellow-400 hover:to-orange-500 transition-all duration-300 shadow-2xl transform hover:scale-105 flex items-center justify-center mx-auto">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <line x1="22" y1="2" x2="11" y2="13"></line>
                                    <polygon points="22,2 15,22 11,13 2,9 22,2"></polygon>
                                </svg>
                                GARANTIR MINHA VAGA AGORA!
                            </button>
                            
                            <p class="text-gray-600 text-sm mt-4">
                                * Campos obrigatórios. Seus dados estão 100% seguros conosco.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-4 gap-8">
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
                    <h3 class="font-semibold text-lg mb-4">Links Rápidos</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#inicio" class="hover:text-purple-400 transition-colors">Início</a></li>
                        <li><a href="#recursos" class="hover:text-purple-400 transition-colors">Recursos</a></li>
                        <li><a href="#precos" class="hover:text-purple-400 transition-colors">Preços</a></li>
                    </ul>
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
                            <span class="text-sm">(21) 98017-2779</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm">contato@MULTZ.online</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2025 MULTZ. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </footer>

    <script>
        function selectPlan(planName, planPrice, planValue) {
            document.getElementById('selectedPlan').value = planName;
            document.getElementById('selectedPrice').value = planPrice;
            document.getElementById('selectedValue').value = planValue;
            
            document.getElementById('selectedPlanInfo').innerHTML = `
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Plano Selecionado: ${planName}</h3>
                        <p class="text-gray-600">Valor: ${planPrice}</p>
                    </div>
                    <div class="bg-green-500 text-white px-4 py-2 rounded-full text-sm font-bold">
                        ✓ SELECIONADO
                    </div>
                </div>
            `;
            
            document.getElementById('leadFormModal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('leadFormModal').classList.add('hidden');
        }
        
        // Handle device selection
        document.addEventListener('DOMContentLoaded', function() {
            const deviceOptions = document.querySelectorAll('.device-option');
            deviceOptions.forEach(option => {
                option.addEventListener('click', function() {
                    deviceOptions.forEach(opt => {
                        opt.classList.remove('border-purple-600', 'bg-purple-50');
                        opt.classList.add('border-gray-300');
                        opt.querySelector('svg').classList.remove('text-purple-600');
                        opt.querySelector('svg').classList.add('text-gray-600');
                        opt.querySelector('span').classList.remove('text-purple-600');
                        opt.querySelector('span').classList.add('text-gray-700');
                    });
                    
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-purple-600', 'bg-purple-50');
                    this.querySelector('svg').classList.remove('text-gray-600');
                    this.querySelector('svg').classList.add('text-purple-600');
                    this.querySelector('span').classList.remove('text-gray-700');
                    this.querySelector('span').classList.add('text-purple-600');
                    this.querySelector('input').checked = true;
                });
            });
            
            // Handle content selection
            const contentOptions = document.querySelectorAll('.content-option');
            contentOptions.forEach(option => {
                option.addEventListener('click', function() {
                    const checkbox = this.querySelector('input');
                    checkbox.checked = !checkbox.checked;
                    
                    if (checkbox.checked) {
                        this.classList.remove('border-gray-300');
                        this.classList.add('border-purple-600', 'bg-purple-50');
                        this.querySelector('span').classList.remove('text-gray-700');
                        this.querySelector('span').classList.add('text-purple-600');
                    } else {
                        this.classList.remove('border-purple-600', 'bg-purple-50');
                        this.classList.add('border-gray-300');
                        this.querySelector('span').classList.remove('text-purple-600');
                        this.querySelector('span').classList.add('text-gray-700');
                    }
                });
            });
        });
        
        // Close modal when clicking outside
        document.getElementById('leadFormModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>