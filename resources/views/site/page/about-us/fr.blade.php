@extends('site.layouts.app')

<x-seo :seo="$seo" />

@section('content')
    <section class="layout-wrapper px-4 xl:px-0">
        <div class="mt-8">
            <nav class="text-gray-600 text-sm" aria-label="Breadcrumb">
                <ol
                    class="list-none p-0 flex flex-wrap md:inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10 leading-5">
                    <li class="flex items-center">
                        <svg class="-mt-1 ltr:mr-2 rtl:ml-2" width="13"
                            height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215all_categories.bladeC2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z"
                                fill="#898989"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z"
                                fill="#898989"></path>
                        </svg>
                        <a href="{{ route('site.index') }}">{{ __('Home') }}</a>
                        <p class="px-2 text-gray-12">/</p>
                    </li>
                    <li class="flex items-center text-gray-12">
                        <a href="javascript: void(0)">{{ __('About Us') }}</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- About Us Hero Section -->
        <div class="py-12 bg-gradient-to-r from-blue-50 to-indigo-100 rounded-lg mb-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Exports Valley
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto px-4">
                    {{ __('Your trusted B2B digital platform connecting Saudi manufacturers with global buyers') }}
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Who We Are Section -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">{{ __('Who We Are') }}</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        <p class="mb-6">
                            Exports Valley est une plateforme numérique spécialisée dans le domaine du commerce entre entreprises (B2B), basée dans la ville de Riyad, en Arabie Saoudite. La plateforme travaille à connecter les fabricants saoudiens avec les acheteurs mondiaux grâce à des interfaces électroniques personnalisées et des algorithmes d'intelligence artificielle avancés pour faire correspondre les produits saoudiens avec les besoins des acheteurs du monde entier.
                        </p>
                        <p class="mb-6">
                            Exports Valley fournit également des outils de marketing numérique innovants et un support intégré pour les services logistiques et les opérations d'exportation, facilitant l'accès des fabricants locaux aux marchés internationaux rapidement et en douceur. La plateforme permet aux usines d'exposer leurs produits, de communiquer directement avec les acheteurs et de conclure des accords facilement et en toute transparence dans un environnement électronique fiable et sécurisé.
                        </p>
                        <p class="mb-6">
                            Exports Valley se concentre sur la localisation des solutions numériques pour l'industrie saoudienne, où notre plateforme est spécialement conçue pour répondre aux besoins du secteur industriel national en arabe et plusieurs langues mondiales pour faciliter la communication avec les importateurs du monde entier conformément aux exigences du marché local.
                        </p>
                        <p>
                            En s'appuyant sur les dernières technologies d'intelligence artificielle et de transformation numérique, nous cherchons à améliorer la compétitivité des usines saoudiennes et à leur permettre de s'étendre mondialement. À la lumière de la Vision 2030, qui vise à diversifier l'économie et à augmenter les exportations non pétrolières, Exports Valley s'engage à jouer un rôle efficace dans le soutien de cette vision en permettant aux industries nationales avec des outils numériques innovants et intégrés qui garantissent l'efficacité et la transparence à toutes les étapes du processus d'exportation.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Mission and Vision Grid -->
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Mission Section -->
                <section class="bg-white rounded-lg shadow-lg p-8">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Our Mission') }}</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-center">
                        Notre mission est de permettre aux usines saoudiennes d'atteindre les marchés mondiaux facilement et en toute transparence grâce à une plateforme numérique intégrée. Nous fournissons des solutions numériques locales innovantes soutenues par l'intelligence artificielle pour simplifier les processus de communication, de négociation et de contractualisation, et améliorer l'efficacité du marketing et de l'exportation d'une manière qui soutient la croissance durable du secteur industriel national et s'aligne avec les objectifs de la Vision 2030.
                    </p>
                </section>

                <!-- Vision Section -->
                <section class="bg-white rounded-lg shadow-lg p-8">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Our Vision') }}</h3>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-center">
                        Notre vision est d'être la plateforme d'exportation numérique leader en Arabie Saoudite, en menant l'innovation technique et en adoptant les technologies d'intelligence artificielle pour connecter les produits saoudiens aux marchés mondiaux avec une flexibilité et une efficacité élevées. Nous cherchons à établir la position du Royaume comme centre industriel mondial leader en permettant aux entreprises et usines nationales avec les meilleures solutions numériques, et en contribuant à l'augmentation du pourcentage d'exportations non pétrolières et à la réalisation du développement économique durable.
                    </p>
                </section>
            </div>

            <!-- Key Features Section -->
            <section class="bg-white rounded-lg shadow-lg p-8 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 text-center">{{ __('Why Choose Us') }}</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('AI-Powered Matching') }}</h3>
                        <p class="text-gray-600 text-sm">{{ __('Advanced AI algorithms to match Saudi products with global buyers') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('Global Reach') }}</h3>
                        <p class="text-gray-600 text-sm">{{ __('Connect Saudi manufacturers with buyers worldwide') }}</p>
                    </div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('Secure & Transparent') }}</h3>
                        <p class="text-gray-600 text-sm">{{ __('Trusted platform with secure transactions and transparent processes') }}</p>
                    </div>
                </div>
            </section>

            <!-- Vision 2030 Alignment -->
            <section class="bg-gradient-to-r from-green-50 to-blue-50 rounded-lg p-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('Supporting Vision 2030') }}</h2>
                <p class="text-gray-700 leading-relaxed max-w-3xl mx-auto">
                    Nous croyons que l'innovation technique et la transformation numérique sont la clé de la prospérité mondiale du secteur industriel saoudien, c'est pourquoi nous nous efforçons de fournir une plateforme fiable qui élève l'expérience d'exportation et contribue à établir la position du Royaume comme centre industriel mondial.
                </p>
            </section>
        </div>
        
        
    </section>
@endsection
