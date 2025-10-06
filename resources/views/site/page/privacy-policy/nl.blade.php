@extends('site.layouts.app')

@section('page_title', 'Privacybeleid')

@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content="Privacybeleid - Exports Valley">
    <meta name="description" content="Privacybeleid van Exports Valley - digitaal B2B handelsplatform" />
    <meta name="keywords" content="privacybeleid, Exports Valley, gegevensbescherming, privacy">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Privacybeleid - Exports Valley">
    <meta itemprop="description" content="Privacybeleid van Exports Valley - digitaal B2B handelsplatform">
    <meta itemprop="image" content="{{ asset('images/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Privacybeleid - Exports Valley">
    <meta property="og:description" content="Privacybeleid van Exports Valley - digitaal B2B handelsplatform">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Privacybeleid - Exports Valley">
    <meta property="twitter:description" content="Privacybeleid van Exports Valley - digitaal B2B handelsplatform">
    <meta property="twitter:image" content="{{ asset('images/logo.png') }}">
@endsection

@section('content')
    <section class="layout-wrapper px-4 xl:px-0">
        <!-- Breadcrumb -->
        <div class="mt-8">
            <nav class="text-gray-600 text-sm" aria-label="Breadcrumb">
                <ol class="list-none p-0 flex flex-wrap md:inline-flex text-xs md:text-sm roboto-medium font-medium text-gray-10 leading-5">
                    <li class="flex items-center">
                        <svg class="-mt-1 ltr:mr-2 rtl:ml-2" width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.35643 1.89407C4.93608 2.1717 4.43485 2.59943 3.69438 3.23412L2.916 3.9013C2.0595 4.63545 1.82512 4.85827 1.69934 5.13174C1.57357 5.4052 1.55692 5.72817 1.55692 6.85625V10.1569C1.55692 10.9127 1.55857 11.4013 1.60698 11.7613C1.65237 12.099 1.72565 12.2048 1.7849 12.264C1.84416 12.3233 1.94997 12.3966 2.28759 12.442C2.64759 12.4904 3.13619 12.492 3.89206 12.492H8.56233C9.31819 12.492 9.80679 12.4904 10.1668 12.442C10.5044 12.3966 10.6102 12.3233 10.6695 12.264C10.7287 12.2048 10.802 12.099 10.8474 11.7613C10.8958 11.4013 10.8975 10.9127 10.8975 10.1569V6.85625C10.8975 5.72817 10.8808 5.4052 10.755 5.13174C10.6293 4.85827 10.3949 4.63545 9.53838 3.9013L8.76 3.23412C8.01953 2.59943 7.5183 2.1717 7.09795 1.89407C6.69581 1.62848 6.44872 1.55676 6.22719 1.55676C6.00566 1.55676 5.75857 1.62848 5.35643 1.89407ZM4.49849 0.595063C5.03749 0.239073 5.5849 0 6.22719 0C6.86948 0 7.41689 0.239073 7.95589 0.595063C8.4674 0.932894 9.04235 1.42573 9.7353 2.01972L10.5515 2.71933C10.5892 2.75162 10.6264 2.78347 10.6632 2.81492C11.3564 3.40806 11.8831 3.85873 12.1694 4.48124C12.4557 5.10375 12.4551 5.79693 12.4543 6.70926C12.4543 6.75764 12.4542 6.80662 12.4542 6.85625L12.4542 10.2081C12.4543 10.8981 12.4543 11.4927 12.3903 11.9688C12.3217 12.479 12.167 12.9681 11.7703 13.3648C11.3736 13.7615 10.8845 13.9162 10.3742 13.9848C9.89812 14.0488 9.30358 14.0488 8.61355 14.0488H3.84083C3.1508 14.0488 2.55626 14.0488 2.08015 13.9848C1.56991 13.9162 1.08082 13.7615 0.68411 13.3648C0.2874 12.9681 0.132701 12.479 0.064101 11.9688C9.07021e-05 11.4927 0.000124017 10.8981 0.000162803 10.2081L0.000164659 6.85625C0.000164659 6.80662 0.000122439 6.75763 8.07765e-05 6.70926C-0.000705247 5.79693 -0.00130245 5.10374 0.285011 4.48124C0.571324 3.85873 1.09802 3.40806 1.79122 2.81492C1.82798 2.78347 1.8652 2.75162 1.90288 2.71933L2.68126 2.05215all_categories.bladeC2.69391 2.0413 2.70652 2.03049 2.71909 2.01972C3.41204 1.42573 3.98698 0.932893 4.49849 0.595063Z" fill="#898989"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.50293 9.37853C3.50293 8.51876 4.19991 7.82178 5.05969 7.82178H7.39482C8.25459 7.82178 8.95158 8.51876 8.95158 9.37853V13.2704C8.95158 13.7003 8.60309 14.0488 8.1732 14.0488C7.74331 14.0488 7.39482 13.7003 7.39482 13.2704V9.37853H5.05969V13.2704C5.05969 13.7003 4.71119 14.0488 4.28131 14.0488C3.85142 14.0488 3.50293 13.7003 3.50293 13.2704V9.37853Z" fill="#898989"></path>
                        </svg>
                        <a href="{{ route('site.index') }}">Home</a>
                        <p class="px-2 text-gray-12">/</p>
                    </li>
                    <li class="flex items-center text-gray-12">
                        <a href="javascript: void(0)">Privacybeleid</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Hero Section -->
        <div class="py-12 bg-gradient-to-r from-blue-50 to-indigo-100 rounded-lg mb-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Privacybeleid
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto px-4">
                    Wij beschermen uw privacy en waarborgen de veiligheid van uw persoonlijke gegevens
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Inleiding</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        <p class="mb-6">
                            Bij Exports Valley (Saoedische onderneming gevestigd in Riyad) hechten wij het grootste belang aan de privacy van onze gebruikers en verbinden wij ons ertoe uw persoonlijke informatie te beschermen en het veilige en verantwoorde gebruik ervan te waarborgen.
                        </p>
                        <p class="mb-6">
                            Dit privacybeleid legt uit hoe wij uw informatie verzamelen, gebruiken en beschermen wanneer u ons digitale platform gebruikt. Het gebruik van het Exports Valley platform houdt uw instemming in met de voorwaarden en praktijken die in dit beleid zijn beschreven.
                        </p>
                        <div class="bg-blue-50 border-r-4 border-blue-500 p-4 rounded">
                            <p class="text-blue-800 font-medium">
                                Laatst bijgewerkt: augustus 2025
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Collection -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Gegevensverzameling</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Persoonlijke gegevens</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Naam en e-mailadres</li>
                                <li>• Telefoonnummer</li>
                                <li>• Bedrijfs- of organisatie-informatie</li>
                                <li>• Contact- en leveringsadressen</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Betalingsgegevens</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Creditcardgegevens</li>
                                <li>• Bankrekeninginformatie</li>
                                <li>• Versleutelde en veilige verwerking</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Gebruiksgegevens</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• IP-adres en geografische locatie</li>
                                <li>• Browsertype en besturingssysteem</li>
                                <li>• Bezochte pagina's</li>
                                <li>• Tijd en frequentie van bezoeken</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Gegevens van derden</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Informatie van geïntegreerde services</li>
                                <li>• Gegevens van marketingpartners</li>
                                <li>• Informatie van serviceproviders</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Usage -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Gegevensgebruik</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">1</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Serviceverlening</h3>
                                <p class="text-gray-700">Uw gegevens gebruiken om de benodigde services te leveren, bestellingen te verwerken en transacties uit te voeren</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">2</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Communicatie en ondersteuning</h3>
                                <p class="text-gray-700">Reageren op uw vragen en technische ondersteuning en klantenservice bieden</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">3</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Prestatieverbetering</h3>
                                <p class="text-gray-700">Gebruikspatronen analyseren om de gebruikerservaring te verbeteren en onze services te ontwikkelen</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">4</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Marketing</h3>
                                <p class="text-gray-700">Marketingberichten versturen alleen na het verkrijgen van uw voorafgaande toestemming</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Sharing -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Gegevensdeling</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800">Wij verkopen uw persoonlijke gegevens niet</h3>
                        </div>
                        <p class="text-red-700 mt-2">Wij verkopen of verhuren uw persoonlijke gegevens niet aan derden voor marketingdoeleinden</p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-3">Serviceproviders</h3>
                            <p class="text-green-700">Wij delen de benodigde informatie met vertrouwde partners om ons platform te laten functioneren</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-3">Officiële autoriteiten</h3>
                            <p class="text-yellow-700">Wanneer wij wettelijk verplicht zijn om dit te doen of om rechten en veiligheid te beschermen</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Security -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Gegevensbeveiliging</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Veilige servers</h3>
                            <p class="text-gray-600 text-sm">Beveiliging met wachtwoorden en firewalls</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Gegevensversleuteling</h3>
                            <p class="text-gray-600 text-sm">Versleuteling van gevoelige gegevens tijdens overdracht en opslag</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Beperkte toegang</h3>
                            <p class="text-gray-600 text-sm">Toegang alleen voor geautoriseerde medewerkers</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- User Rights -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Gebruikersrechten</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Recht op toegang tot uw persoonlijke gegevens</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Recht op correctie of bijwerking van informatie</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Recht op verwijdering van uw persoonlijke gegevens</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Recht op bezwaar tegen gegevensverwerking</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Recht op uitschrijving voor marketingberichten</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cookies -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Cookies</h2>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">Wij gebruiken cookies voor:</h3>
                        <ul class="text-blue-700 space-y-2">
                            <li>• Het verbeteren van de gebruikerservaring en het onthouden van uw voorkeuren</li>
                            <li>• Het analyseren van de prestaties van de website en het begrijpen van gebruikersgedrag</li>
                            <li>• Het inschakelen van de basisfunctionaliteiten van de website</li>
                            <li>• Het tonen van advertenties gerelateerd aan uw interesses</li>
                        </ul>
                        <p class="text-blue-700 mt-4">
                            U kunt cookies beheren via de instellingen van uw browser
                        </p>
                    </div>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="mb-12">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Neem contact met ons op</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Contactinformatie</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>E-mail:</strong> privacy@exportsvalley.com</p>
                                <p><strong>Telefoon:</strong> +966-11-123-4567</p>
                                <p><strong>Adres:</strong> Riyad, Saoedi-Arabië</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Werkuren</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>Zondag - Donderdag:</strong> 8:00 - 17:00</p>
                                <p><strong>Vrijdag - Zaterdag:</strong> Gesloten</p>
                                <p><strong>Tijdzone:</strong> Riyad tijd</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Note -->
            <div class="bg-gray-100 rounded-lg p-6 text-center">
                <p class="text-gray-600">
                    Als u vragen heeft over dit privacybeleid, neem dan contact met ons op via de hierboven vermelde informatie
                </p>
            </div>
        </div>
    </section>
@endsection
