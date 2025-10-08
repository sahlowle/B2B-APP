@extends('site.layouts.app')

@section('page_title', 'الشروط و الأحكام الخاصة بالبائع')

@section('seo')
    <meta name="robots" content="index, follow">
    <meta name="title" content=" الشروط والأحكام الخاصة بالبائع - إكسبورتس فالي">
    <meta name="description" content=" الشروط والأحكام الخاصة بالبائع لشركة إكسبورتس فالي - منصة التجارة الرقمية بين الشركات" />
    <meta name="keywords" content=" الشروط والأحكام الخاصة بالبائع, إكسبورتس فالي, حماية البيانات, الخصوصية, الشروط والأحكام">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content=" الشروط والأحكام الخاصة بالبائع - إكسبورتس فالي">
    <meta itemprop="description" content=" الشروط والأحكام الخاصة بالبائع لشركة إكسبورتس فالي - منصة التجارة الرقمية بين الشركات">
    <meta itemprop="image" content="{{ asset('images/logo.png') }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content=" الشروط والأحكام الخاصة بالبائع - إكسبورتس فالي">
    <meta property="og:description" content=" الشروط والأحكام الخاصة بالبائع لشركة إكسبورتس فالي - منصة التجارة الرقمية بين الشركات">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content=" الشروط والأحكام الخاصة بالبائع - إكسبورتس فالي">
    <meta property="twitter:description" content=" الشروط والأحكام الخاصة بالبائع لشركة إكسبورتس فالي - منصة التجارة الرقمية بين الشركات">
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
                        <a href="{{ route('site.index') }}">الرئيسية</a>
                        <p class="px-2 text-gray-12">/</p>
                    </li>
                    <li class="flex items-center text-gray-12">
                        <a href="javascript: void(0)"> الشروط والأحكام الخاصة بالبائع</a>
                    </li>
                </ol>
            </nav>
        </div>


        <!-- Main Content -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-8 text-center">
                    الشروط والأحكام الخاصة بالبائع
                </h1>
                <div class="text-center mb-8">
                    <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        منصة اكسبورتس فالي
                    </span>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    تمهيد
                </h2>
                <div class="prose prose-lg max-w-none">
                    <p class="text-gray-700 leading-relaxed mb-4">
                        تُعد منصة <strong>اكسبورتس فالي</strong> (شركة سعودية مقرها الرياض) منصة رقمية متخصصة في الربط بين المصانع السعودية (المصدّرين) والمستوردين الدوليين. لا تقوم المنصة بعمليات البيع أو الشراء المباشر ولا تتدخل في تفاصيل التعاقد أو الدفع بين الأطراف، وإنما تقدم خدمات الوساطة التقنية والربط الذكي عبر واجهة إلكترونية تعتمد على الذكاء الاصطناعي لتسهيل التواصل.
                    </p>
                    <p class="text-gray-700 leading-relaxed">
                        إن استخدامك للمنصة بصفة "بائع/مصنّع" يعني موافقتك الكاملة على هذه الشروط والأحكام، بالإضافة إلى سياسة الخصوصية المعتمدة. ويُعتبر استمرارك باستخدام المنصة إقرارًا منك بأنك قرأت هذه الأحكام وفهمتها وقبلتها.
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الأولى: التعريفات
                </h2>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>المنصة/نحن:</strong> يقصد بها شركة اكسبورتس فالي والمنصة الإلكترونية التابعة لها.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>المستخدم/أنت:</strong> يقصد بها أي شخص يقوم باستخدام المنصة بصفته بائعًا أو مشتريًا أو زائرًا.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>البائع/المُصنّع:</strong> يقصد به أي منشأة أو شركة صناعية سعودية قامت بالتسجيل في المنصة بهدف عرض منتجاتها والتواصل مع المشترين الدوليين.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>المشتري/المستورد:</strong> يقصد به أي طرف دولي أو محلي يستخدم المنصة بهدف البحث عن المنتجات والتواصل مع البائعين لإبرام صفقات خارج المنصة.</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-700"><strong>الاتفاقية:</strong> يقصد بها هذه الشروط والأحكام وسياسة الخصوصية وأي تعديلات مستقبلية عليها.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الثانية: شروط التسجيل للبائع
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">يجب أن يكون البائع مسجلاً بشكل نظامي في المملكة العربية السعودية، وأن يقدم المستندات النظامية المطلوبة مثل السجل التجاري ورقم ضريبة القيمة المضافة.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">يلتزم البائع باستخدام بيانات صحيحة ومطابقة للواقع، ويكون مسؤولًا وحده عن تحديثها بشكل دوري.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">تحتفظ المنصة بحق رفض أي طلب تسجيل أو إيقاف أي حساب في حال ثبوت وجود بيانات غير صحيحة أو مخالفة للأنظمة.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">البائع وحده مسؤول عن الحفاظ على سرية بيانات الدخول لحسابه، وأي استخدام يتم عبر حسابه يعتبر صادرًا عنه.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الثالثة: طبيعة عمل المنصة وإخلاء المسؤولية
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">دور المنصة يقتصر على <strong>توفير قناة رقمية للتواصل</strong> بين البائع والمشتري، ولا تُعتبر طرفًا في أي عقد بيع أو توريد أو تصدير يتم بينهما.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">جميع الاتفاقيات التجارية (بما في ذلك الأسعار، الكميات، مواصفات المنتجات، الشحن، الدفع، الضمانات) تتم مباشرة بين البائع والمشتري <strong>دون تدخل المنصة</strong>، وتُخلي المنصة مسؤوليتها عن أي التزامات أو نزاعات تنشأ بينهم.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">المنصة غير مسؤولة عن جودة المنتجات، أو التزام الأطراف بتنفيذ العقود، أو أي أضرار أو خسائر قد تنتج عن التعامل بين المستخدمين.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">في حال نشوء نزاع بين البائع والمشتري، فإن تسويته تكون مسؤولية الطرفين حصراً، ويحق لأي طرف اللجوء إلى الجهات المختصة وفق الأنظمة المرعية في المملكة أو بلد المشتري.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الرابعة: حقوق المنصة
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">يحق للمنصة حذف أو تعديل أو إيقاف أي حساب أو محتوى يخالف الأنظمة أو الشروط أو يضر بسمعة المنصة أو يعرضها للمساءلة.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">تحتفظ المنصة بحقها في تعديل أو إيقاف بعض الخدمات بشكل جزئي أو كلي في أي وقت دون إشعار مسبق.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">يحق للمنصة التعاون مع الجهات المختصة وتزويدها بالمعلومات عند الحاجة أو بطلب رسمي.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الخامسة: التزامات البائع
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">يلتزم البائع بعدم نشر أي محتوى أو منتجات مخالفة للأنظمة المعمول بها في المملكة أو القوانين الدولية ذات الصلة بالتصدير.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">يتعهد البائع بالالتزام بحقوق الملكية الفكرية وعدم نشر منتجات أو محتويات منتهكة لحقوق الغير.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">يتحمل البائع كامل المسؤولية عن صحة البيانات والمواصفات المنشورة عن منتجاته.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 text-red-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">4</span>
                        <p class="text-gray-700 leading-relaxed">أي مطالبات أو تعويضات أو نزاعات تنشأ بسبب منتجات البائع أو تعاملاته تقع مسؤوليته القانونية وحده دون أي مسؤولية على المنصة.</p>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة السادسة: الأطراف الثالثة
                </h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">قد تستعين المنصة بمزودي خدمات خارجيين (مثل خدمات الاستضافة أو الحوسبة السحابية أو أدوات التحليل أو التسويق الرقمي). يوافق البائع على أن المنصة لا تتحمل أي مسؤولية عن تقصير أو خطأ من هذه الأطراف، وأن استخدامها يتم وفق سياسات مستقلة.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة السابعة: الملكية الفكرية
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">جميع الحقوق المتعلقة باسم وشعار وتصميم المنصة والمحتوى التقني الخاص بها هي ملك حصري لشركة اكسبورتس فالي.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">لا يحق للبائع استخدام أي جزء من محتويات المنصة أو إعادة نشرها أو استغلالها إلا بموافقة خطية مسبقة من الشركة.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">عند رفع البائع لأي محتوى على المنصة، فإنه يمنحنا ترخيصًا غير حصري لاستخدامه لأغراض تشغيل المنصة والتسويق لمنتجاته.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة الثامنة: القانون واجب التطبيق
                </h2>
                <div class="bg-gray-50 p-6 rounded-lg">
                    <p class="text-gray-700 leading-relaxed">تخضع هذه الاتفاقية وأي نزاع ينشأ عنها أو يتعلق بها للأنظمة والقوانين المعمول بها في المملكة العربية السعودية.</p>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b border-gray-200 pb-3">
                    المادة التاسعة: أحكام عامة
                </h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">1</span>
                        <p class="text-gray-700 leading-relaxed">يحق للمنصة تعديل هذه الشروط والأحكام في أي وقت، وتكون سارية من تاريخ نشرها على الموقع.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">2</span>
                        <p class="text-gray-700 leading-relaxed">استمرار البائع في استخدام المنصة بعد نشر التعديلات يُعد موافقة ضمنية عليها.</p>
                    </div>
                    <div class="flex items-start">
                        <span class="flex-shrink-0 w-8 h-8 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-sm font-bold mr-4 mt-1">3</span>
                        <p class="text-gray-700 leading-relaxed">في حال تعارض النسخ المترجمة لهذه الاتفاقية مع النص العربي، فإن النسخة العربية هي النسخة المعتمدة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
