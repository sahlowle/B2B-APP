@extends('site.layouts.app')

<x-seo :seo="$seo" />

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
                        <a href="javascript: void(0)">Terms and Conditions for Buyers</a>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    Terms and Conditions for Buyers
                </h1>
                <div class="text-center mb-8">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        Exports Valley Platform
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Introduction
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        <strong>Exports Valley</strong> (a Saudi company headquartered in Riyadh) is an innovative digital platform that acts as a technical intermediary connecting Saudi factories (exporters) with international buyers. The platform does not play any role in direct buying or selling operations and does not interfere in contract formulation, payment collection, or determining supply terms. Instead, it provides digital services to facilitate communication and business connectivity.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        By using the platform as a "buyer/importer," you agree to fully comply with these terms and conditions and the relevant privacy policy. Your continued use of the platform constitutes an acknowledgment from you of acceptance.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article One: Definitions
                </h2>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>Platform/We:</strong> Refers to Exports Valley company and its affiliated electronic platform.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>User/You:</strong> Refers to any person who uses the platform as a buyer, seller, or visitor.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>Buyer/Importer:</strong> Refers to any person, company, or commercial entity that registers on the platform to communicate with sellers and Saudi factories to purchase their products.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>Seller/Manufacturer:</strong> Refers to the Saudi factory or company that displays its products through the platform to communicate with buyers.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>Agreement:</strong> Refers to these terms and conditions, privacy policy, and any future amendments thereto.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Two: Buyer Registration Requirements
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">The buyer must have legal and regulatory capacity according to the regulations in force in their country.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">The buyer is committed to providing accurate and complete data during registration and is solely responsible for updating it when any change occurs.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">The buyer acknowledges that their account is personal or belongs to their commercial entity and bears full responsibility for any use made through it.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">The platform reserves the right to reject, suspend, or delete any account that does not comply with these terms.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Three: Platform Nature and Disclaimer
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">The platform's role is limited to technical coordination and digital mediation between the seller and buyer, and is not considered a party to any sale contract or supply agreement.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">All commercial understandings and terms (such as prices, quantities, product quality, shipping schedules, payment methods) are conducted directly between the seller and buyer.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">The platform disclaims responsibility for:</p>
                    </div>
                    <div class="ml-12 space-y-2">
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-orange-400 rounded-full mt-2 mr-3"></span>
                            <p class="text-gray-700 leading-relaxed">Any dispute or failure in fulfilling contractual obligations.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-orange-400 rounded-full mt-2 mr-3"></span>
                            <p class="text-gray-700 leading-relaxed">Product quality or compliance with specifications.</p>
                        </div>
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-2 h-2 bg-orange-400 rounded-full mt-2 mr-3"></span>
                            <p class="text-gray-700 leading-relaxed">Any financial, material, or moral damages or losses arising from dealings between users.</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">In case of a dispute, recourse should be to direct resolution between the seller and buyer or to the competent judicial authorities.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Four: Platform Rights
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">The platform reserves its right to modify, delete, or disable any content or account that violates regulations or misuses the platform.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">The platform has the right to stop or modify the digital services provided without prior notice.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">The platform may provide official authorities with necessary information if requested to do so by law.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Five: Buyer Obligations
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">The buyer is committed to using the platform only for legitimate commercial purposes and not exploiting it for any illegal activities.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">The buyer bears responsibility for verifying the accuracy and validity of information provided by the seller before entering into any commercial transaction.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">Any financial, legal, or commercial obligations resulting from agreement with the seller fall on the buyer alone.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">The buyer is committed to complying with the regulations in force in their country related to import, customs, and taxes.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Six: Third Parties
                </h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">The platform may use technical service providers (such as data hosting, analytics, or marketing). The platform bears no responsibility for any errors or failures from these entities, and users should review their independent policies.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Seven: Intellectual Property
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">All platform rights including name, logo, designs, software, and databases are exclusively owned by Exports Valley company.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">The buyer has no right to copy or reuse any part of the platform's content without prior written permission.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Eight: Applicable Law
                </h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">This agreement is subject to the regulations of the Kingdom of Saudi Arabia, and any dispute arising from it shall be referred to the competent judicial authorities in the Kingdom.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    Article Nine: General Provisions
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">The platform has the right to modify these terms from time to time, and your continued use of the platform after modifications constitutes implicit agreement from you.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">In case of conflict between the Arabic text and any translation, the Arabic text is authoritative.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">Your continued use of the platform means your complete acceptance of all the terms contained herein.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
