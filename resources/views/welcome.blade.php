<x-layout title="Welcome">
    <div class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
        <!-- Hero Section -->
        <section class="relative min-h-screen geometric-bg overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/10 dark:bg-blue-600/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-500/10 dark:bg-blue-700/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s"></div>
            </div>

            <!-- Main Content -->
            <div class="container mx-auto px-4 pt-32 pb-20">
                <div class="max-w-7xl mx-auto">
                    <!-- Hero Content -->
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Left Column -->
                        <div class="text-right order-2 lg:order-1">
                            <div class="fade-in" style="animation-delay: 0.2s">
                                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                                    حوّل <span class="text-blue-600">أفكارك</span> إلى
                                    <br />مشاريع <span class="text-blue-600">ناجحة</span>
                                </h1>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                                    منصة ستارت بوكس تجمع بين رواد الأعمال والمستثمرين في مكان واحد. نساعدك في تحويل أفكارك إلى واقع ملموس من خلال الدعم والتوجيه والتمويل.
                                </p>
                                <div class="flex gap-4 justify-end">
                                    <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-3 rounded-full bg-blue-600 text-white font-semibold hover:bg-blue-700 transform hover:scale-105 transition-all duration-300">
                                        ابدأ رحلتك
                                        <svg class="w-5 h-5 ml-2 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('about') }}" class="inline-flex items-center px-8 py-3 rounded-full bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white font-semibold hover:bg-gray-300 dark:hover:bg-gray-700 transition-all duration-300">
                                        تعرف علينا
                                    </a>
                                </div>
                            </div>

                            <!-- Statistics -->
                            <div class="grid grid-cols-3 gap-8 mt-16 fade-in" style="animation-delay: 0.4s">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">+1000</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">رائد أعمال</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">+500</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">مستثمر</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">+200</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">مشروع ناجح</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Animated Illustration -->
                        <div class="order-1 lg:order-2 fade-in" style="animation-delay: 0.6s">
                            <div class="relative">
                                <!-- Main Circle -->
                                <div class="absolute inset-0 bg-blue-100 dark:bg-blue-900/20 rounded-full blur-2xl"></div>
                                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transform hover:-translate-y-2 transition-all duration-300">
                                    <!-- Animated SVG Illustration -->
                                    <div class="aspect-square">
                                        <svg class="w-full h-full" viewBox="0 0 400 400" fill="none">
                                            <!-- Animated Circles -->
                                            <circle cx="200" cy="200" r="160" class="stroke-blue-600 dark:stroke-blue-400" stroke-width="2" stroke-dasharray="1000" stroke-dashoffset="1000">
                                                <animate attributeName="stroke-dashoffset" to="0" dur="2s" fill="freeze" />
                                            </circle>
                                            <circle cx="200" cy="200" r="120" class="stroke-blue-400 dark:stroke-blue-600" stroke-width="2" stroke-dasharray="800" stroke-dashoffset="800">
                                                <animate attributeName="stroke-dashoffset" to="0" dur="2s" fill="freeze" begin="0.5s" />
                                            </circle>
                                            <circle cx="200" cy="200" r="80" class="stroke-blue-300 dark:stroke-blue-700" stroke-width="2" stroke-dasharray="600" stroke-dashoffset="600">
                                                <animate attributeName="stroke-dashoffset" to="0" dur="2s" fill="freeze" begin="1s" />
                                            </circle>

                                            <!-- Animated Icons -->
                                            <g class="opacity-0" style="animation: fadeIn 0.5s 1.5s forwards">
                                                <!-- Lightbulb -->
                                                <path d="M180 100h40M200 80v40M170 120a40 40 0 1 0 60 0" stroke="currentColor" stroke-width="2" class="text-blue-600 dark:text-blue-400">
                                                    <animate attributeName="d" dur="3s" repeatCount="indefinite"
                                                        values="M170 120a40 40 0 1 0 60 0;M165 115a45 45 0 1 0 70 0;M170 120a40 40 0 1 0 60 0" />
                                                </path>
                                            </g>

                                            <g class="opacity-0" style="animation: fadeIn 0.5s 2s forwards">
                                                <!-- Rocket -->
                                                <path d="M280 200l20-20-20-20-20 20z" class="fill-blue-600 dark:fill-blue-400">
                                                    <animateTransform attributeName="transform" type="rotate" from="0 280 200" to="360 280 200" dur="4s" repeatCount="indefinite" />
                                                </path>
                                            </g>

                                            <g class="opacity-0" style="animation: fadeIn 0.5s 2.5s forwards">
                                                <!-- Chart -->
                                                <path d="M100 300v-40l20-20 20 20 20-40 20 40" class="stroke-blue-600 dark:stroke-blue-400" stroke-width="2" fill="none">
                                                    <animate attributeName="d" dur="3s" repeatCount="indefinite"
                                                        values="M100 300v-40l20-20 20 20 20-40 20 40;M100 300v-30l20-30 20 30 20-30 20 30;M100 300v-40l20-20 20 20 20-40 20 40" />
                                                </path>
                                            </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features Section -->
                    <div class="mt-32">
                        <div class="text-center mb-16 fade-in" style="animation-delay: 0.8s">
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-6">
                                لماذا تختار ستارت بوكس؟
                            </h2>
                            <div class="w-20 h-1 bg-blue-600 mx-auto rounded-full"></div>
                        </div>

                        <div class="grid md:grid-cols-3 gap-8 fade-in" style="animation-delay: 1s">
                            <!-- Feature 1 -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">تطوير الأفكار</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    نساعدك في تحويل أفكارك إلى خطط عمل قابلة للتنفيذ من خلال خبراء متخصصين
                                </p>
                            </div>

                            <!-- Feature 2 -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">شبكة علاقات قوية</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    نربطك بشبكة من المستثمرين والخبراء والشركاء الاستراتيجيين
                                </p>
                            </div>

                            <!-- Feature 3 -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 transform hover:-translate-y-2 transition-all duration-300">
                                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center mb-6">
                                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">فرص تمويل</h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    نوفر فرص تمويل متنوعة تناسب احتياجات مشروعك في مختلف مراحل النمو
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Wave Shape -->
            <div class="wave-shape">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="fill-blue-600/10 dark:fill-blue-900/20">
                    <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
                </svg>
            </div>
        </section>
    </div>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
        }

        .geometric-bg {
            background-image: radial-gradient(circle at 1px 1px, #3b82f6 1px, transparent 0);
            background-size: 40px 40px;
        }

        .wave-shape {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-shape svg {
            position: relative;
            display: block;
            width: calc(100% + 1.3px);
            height: 150px;
        }
    </style>
</x-layout>
