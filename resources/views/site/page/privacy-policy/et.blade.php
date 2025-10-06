@extends('site.layouts.app')

@section('page_title', 'Privaatsuspoliitika')

@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content="Privaatsuspoliitika - Exports Valley">
    <meta name="description" content="Exports Valley privaatsuspoliitika - digitaalne B2B kaubandusplatvorm" />
    <meta name="keywords" content="privaatsuspoliitika, Exports Valley, andmete kaitse, privaatsus">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Privaatsuspoliitika - Exports Valley">
    <meta itemprop="description" content="Exports Valley privaatsuspoliitika - digitaalne B2B kaubandusplatvorm">
    <meta itemprop="image" content="{{ asset('images/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Privaatsuspoliitika - Exports Valley">
    <meta property="og:description" content="Exports Valley privaatsuspoliitika - digitaalne B2B kaubandusplatvorm">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Privaatsuspoliitika - Exports Valley">
    <meta property="twitter:description" content="Exports Valley privaatsuspoliitika - digitaalne B2B kaubandusplatvorm">
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
                        <a href="{{ route('site.index') }}">Avaleht</a>
                        <p class="px-2 text-gray-12">/</p>
                    </li>
                    <li class="flex items-center text-gray-12">
                        <a href="javascript: void(0)">Privaatsuspoliitika</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Hero Section -->
        <div class="py-12 bg-gradient-to-r from-blue-50 to-indigo-100 rounded-lg mb-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                    Privaatsuspoliitika
                </h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto px-4">
                    Kaitstame teie privaatsust ja tagame teie isikuandmete turvalisuse
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <!-- Introduction -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Sissejuhatus</h2>
                    <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                        <p class="mb-6">
                            Exports Valley'is (Saudi ettevõte, mille peakorter asub Riadis) anname meie kasutajate privaatsusele kõrgeimat tähtsust ja kohustume kaitsma teie isikuandmeid ja tagama nende turvalise ja vastutustundliku kasutamise.
                        </p>
                        <p class="mb-6">
                            See privaatsuspoliitika selgitab, kuidas me kogume, kasutame ja kaitseme teie teavet meie digitaalse platvormi kasutamisel. Exports Valley platvormi kasutamine tähendab teie nõusolekut selle poliitikas kirjeldatud tingimuste ja tavadega.
                        </p>
                        <div class="bg-blue-50 border-r-4 border-blue-500 p-4 rounded">
                            <p class="text-blue-800 font-medium">
                                Viimati uuendatud: august 2025
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Collection -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Andmete kogumine</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Isikuandmed</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Nimi ja e-posti aadress</li>
                                <li>• Telefoninumber</li>
                                <li>• Ettevõtte või organisatsiooni teave</li>
                                <li>• Kontakt- ja tarneaadressid</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Makseandmed</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Krediitkaardi andmed</li>
                                <li>• Pangakonto teave</li>
                                <li>• Krüpteeritud ja turvaline töötlemine</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Kasutuse andmed</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• IP-aadress ja geograafiline asukoht</li>
                                <li>• Brauseri tüüp ja operatsioonisüsteem</li>
                                <li>• Külastatud lehed</li>
                                <li>• Külastuste aeg ja sagedus</li>
                            </ul>
                        </div>
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Kolmandate osapoolte andmed</h3>
                            <ul class="text-gray-700 space-y-2">
                                <li>• Teave integreeritud teenustelt</li>
                                <li>• Andmed turunduspartneritelt</li>
                                <li>• Teave teenusepakkujatelt</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Usage -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Andmete kasutamine</h2>
                    <div class="space-y-6">
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">1</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Teenuste osutamine</h3>
                                <p class="text-gray-700">Teie andmete kasutamine vajalike teenuste osutamiseks, tellimuste töötlemiseks ja tehingute tegemiseks</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">2</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Suhtlus ja tugi</h3>
                                <p class="text-gray-700">Teie küsimustele vastamine ja tehnilise toe ning klienditeeninduse osutamine</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">3</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Jõudluse parandamine</h3>
                                <p class="text-gray-700">Kasutamise mustrite analüüsimine kasutajakogemuse parandamiseks ja meie teenuste arendamiseks</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4 rtl:space-x-reverse">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600 font-bold">4</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Turundus</h3>
                                <p class="text-gray-700">Turundussõnumite saatmine ainult pärast teie eelneva nõusoleku saamist</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Sharing -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Andmete jagamine</h2>
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-red-800">Me ei müü teie isikuandmeid</h3>
                        </div>
                        <p class="text-red-700 mt-2">Me ei müü ega üüri teie isikuandmeid kolmandatele osapooltele turunduseesmärkidel</p>
                    </div>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-green-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-green-800 mb-3">Teenusepakkujad</h3>
                            <p class="text-green-700">Jagame vajalikku teavet usaldusväärsete partneritega meie platvormi toimimiseks</p>
                        </div>
                        <div class="bg-yellow-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-3">Ametlikud asutused</h3>
                            <p class="text-yellow-700">Kui oleme seaduslikult kohustatud seda tegema või õiguste ja turvalisuse kaitsmiseks</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Data Security -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Andmete kaitse</h2>
                    <div class="grid md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Turvalised serverid</h3>
                            <p class="text-gray-600 text-sm">Kaitse paroolide ja tulemüüridega</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Andmete krüpteerimine</h3>
                            <p class="text-gray-600 text-sm">Tundlike andmete krüpteerimine edastamise ja salvestamise ajal</p>
                        </div>
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Piiratud juurdepääs</h3>
                            <p class="text-gray-600 text-sm">Juurdepääs ainult volitatud töötajatele</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- User Rights -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Kasutaja õigused</h2>
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Õigus juurdepääsule teie isikuandmetele</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Õigus teabe parandamisele või uuendamisele</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Õigus teie isikuandmete kustutamisele</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Õigus vastuolule andmete töötlemisega</span>
                        </div>
                        <div class="flex items-center space-x-3 rtl:space-x-reverse">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Õigus turundussõnumitelt loobumisele</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Cookies -->
            <section class="mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Küpsised (Cookies)</h2>
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-3">Kasutame küpsiseid:</h3>
                        <ul class="text-blue-700 space-y-2">
                            <li>• Kasutajakogemuse parandamiseks ja teie eelistuste meeldejätmiseks</li>
                            <li>• Veebisaidi jõudluse analüüsimiseks ja kasutajate käitumise mõistmiseks</li>
                            <li>• Veebisaidi põhifunktsioonide lubamiseks</li>
                            <li>• Teie huvidega seotud reklaamide kuvamiseks</li>
                        </ul>
                        <p class="text-blue-700 mt-4">
                            Saate küpsiseid kontrollida oma brauseri seadete kaudu
                        </p>
                    </div>
                </div>
            </section>

            <!-- Contact Information -->
            <section class="mb-12">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Võtke meiega ühendust</h2>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Kontaktteave</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>E-post:</strong> privacy@exportsvalley.com</p>
                                <p><strong>Telefon:</strong> +966-11-123-4567</p>
                                <p><strong>Aadress:</strong> Riad, Saudi Araabia</p>
                            </div>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Tööaeg</h3>
                            <div class="space-y-2 text-gray-700">
                                <p><strong>Pühapäev - Neljapäev:</strong> 8:00 - 17:00</p>
                                <p><strong>Reede - Laupäev:</strong> Suletud</p>
                                <p><strong>Ajavöönd:</strong> Riaadi aeg</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Footer Note -->
            <div class="bg-gray-100 rounded-lg p-6 text-center">
                <p class="text-gray-600">
                    Kui teil on küsimusi selle privaatsuspoliitika kohta, palun võtke meiega ühendust ülalpool esitatud teabe kaudu
                </p>
            </div>
        </div>
    </section>
@endsection
