<?php

namespace Modules\MenuBuilder\Database\Seeders\versions\v2_4_0;

use Illuminate\Database\Seeder;
use Modules\MenuBuilder\Http\Models\MenuItems;

class MenuItemsTableSeeder extends Seeder
{
    /**
     * Update language
     *
     * @param  string  $label
     * @param  string  $translatedLabel
     * @return void
     */
    private function updateLanguage($label, $translatedLabel)
    {
        MenuItems::where('label', $label)->update(['label' => $translatedLabel]);

    }

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        addMenuItem('admin', 'General Settings', [
            'parent' => 'Configurations',
            'link' => 'general-setting',
            'params' => '{"permission":"App\\\\Http\\\\Controllers\\\\CompanySettingController@index","route_name":["preferences.index", "companyDetails.setting", "maintenance.enable", "language.translation", "language.index", "currency.convert", "withdrawalSetting.index", "external-codes.index", "address.setting.index", "language.import", "api-keys.index", "api-settings"]}',
            'sort' => 49,
        ]);

        addMenuItem('admin', 'Authentication Layout', [
            'parent' => 'Website Setup',
            'link' => 'auth/layouts',
            'params' => '{"permission":"Modules\\\\CMS\\\\Http\\\\Controllers\\\\AuthLayoutController@index","route_name":["auth.layout.index"]}',
            'sort' => 50,
        ]);

        $this->updateLanguage('Dashboard', '{"en": "Dashboard","bn": "ড্যাশবোর্ড","fr": "Tableau de bord","zh": "仪表板","ar": "لوحة القيادة","be": "Панэль прыбораў","bg": "Табло","ca": "Tauler de control","et": "Armatuurlaud","nl": "Dashboard"}');
        $this->updateLanguage('Add User', '{"en":"Add User","bn":"ব্যবহারকারী যোগ করুন","fr":"Ajouter un utilisateur","zh":"添加用户","ar":"إضافة مستخدم","be":"Дадаць карыстальніка","bg":"Добавяне на потребител","ca":"Afegeix usuari","et":"Lisa kasutaja","nl":"Gebruiker toevoegen"}');
        $this->updateLanguage('Add Product', '{"en":"Add Product","bn":"পণ্য যোগ করুন","fr":"Ajouter un produit","zh":"添加产品","ar":"إضافة منتج","be":"Дадаць прадукт","bg":"Добавяне на продукт","ca":"Afegeix producte","et":"Lisa toode","nl":"Product toevoegen"}');
        $this->updateLanguage('categories', '{"en":"Categories","bn":"বিভাগ","fr":"Catégories","zh":"类别","ar":"فئات","be":"Катэгорыі","bg":"Категории","ca":"Categories","et":"Kategooriad","nl":"Categorieën"}');
        $this->updateLanguage('Brands', '{"en":"Brands","bn":"ব্র্যান্ড","fr":"Marques","zh":"品牌","ar":"العلامات التجارية","be":"Брэнды","bg":"Марки","ca":"Marques","et":"Brändid","nl":"Merken"}');
        $this->updateLanguage('attributes', '{"en":"Attributes","bn":"গুণগুলি","fr":"Attributs","zh":"属性","ar":"السمات","be":"Атрыбуты","bg":"Атрибути","ca":"Atributs","et":"Atribuudid","nl":"Eigenschappen"}');
        $this->updateLanguage('All Users', '{"en":"All Users","bn":"সমস্ত ব্যবহারকারী","fr":"Tous les utilisateurs","zh":"所有用户","ar":"جميع المستخدمين","be":"Усе карыстальнікі","bg":"Всички потребители","ca":"Tots els usuaris","et":"Kõik kasutajad","nl":"Alle gebruikers"}');
        $this->updateLanguage('Reviews', '{"en":"Reviews","bn":"পর্যালোচনা","fr":"Avis","zh":"评论","ar":"التعليقات","be":"Водгукі","bg":"Отзиви","ca":"Reseñas","et":"Arvustused","nl":"Beoordelingen"}');
        $this->updateLanguage('All Products', '{"en":"All Products","bn":"সমস্ত পণ্য","fr":"Tous les produits","zh":"所有产品","ar":"جميع المنتجات","be":"Усе прадукты","bg":"Всички продукти","ca":"Tots els productes","et":"Kõik tooted","nl":"Alle producten"}');
        $this->updateLanguage('Pending Products', '{"en":"Pending Products","bn":"মুলতুবি পণ্য","fr":"Produits en attente","zh":"待处理产品","ar":"المنتجات المعلقة","be":"Ачакуюцца прадукты","bg":"Изчакващи продукти","ca":"Productes pendents","et":"Ootel tooted","nl":"In afwachting producten"}');
        $this->updateLanguage('Add vendor', '{"en":"Add Vendor","bn":"বিক্রেতা যোগ করুন","fr":"Ajouter un fournisseur","zh":"添加供应商","ar":"إضافة بائع","be":"Дадаць прадаўца","bg":"Добавяне на доставчик","ca":"Afegir proveïdor","et":"Lisa müüja","nl":"Leverancier toevoegen"}');
        $this->updateLanguage('All vendors', '{"en":"All Vendors","bn":"সমস্ত বিক্রেতা","fr":"Tous les fournisseurs","zh":"所有供应商","ar":"جميع البائعين","be":"Усе прадаўцы","bg":"Всички доставчици","ca":"Tots els proveïdors","et":"Kõik müüjad","nl":"Alle leveranciers"}');
        $this->updateLanguage('Addon Manager', '{"en":"Addon Manager","bn":"অ্যাড-অন ম্যানেজার","fr":"Gestionnaire d\'extension","zh":"附加组件管理器","ar":"مدير الإضافات","be":"Мэнэджэр дадаткаў","bg":"Мениджър на добавки","ca":"Gestor d\'add-ons","et":"Lisamooduli haldur","nl":"Add-on manager"}');
        $this->updateLanguage('Menus', '{"en":"Menus","bn":"মেনু","fr":"Menus","zh":"菜单","ar":"القوائم","be":"Меню","bg":"Менюта","ca":"Menús","et":"Menüüd","nl":"Menu\'s"}');
        $this->updateLanguage('General Settings', '{"en":"General Settings","bn":"সাধারণ সেটিংস","fr":"Paramètres généraux","zh":"常规设置","ar":"الإعدادات العامة","be":"Агульныя налады","bg":"Общи настройки","ca":"Configuració general","et":"Üldised seaded","nl":"Algemene instellingen"}');
        $this->updateLanguage('Products', '{"en":"Products","bn":"পণ্য","fr":"Produits","zh":"产品","ar":"منتجات","be":"Тавары","bg":"Продукти","ca":"Productes","et":"Tooted","nl":"Producten"}');
        $this->updateLanguage('Customers', '{"en":"Customers","bn":"গ্রাহকদের","fr":"Clients","zh":"客户","ar":"العملاء","be":"Кліенты","bg":"Клиенти","ca":"Clients","et":"Kliendid","nl":"Klanten"}');
        $this->updateLanguage('Personnel', '{"en":"Personnel","bn":"কর্মকর্তা","fr":"Personnel","zh":"人员","ar":"الموظفين","be":"Персонал","bg":"Персонал","ca":"Personal","et":"Personaal","nl":"Personeel"}');
        $this->updateLanguage('Vendors', '{"en":"Vendors","bn":"বিক্রেতাদের","fr":"Fournisseurs","zh":"供应商","ar":"البائعين","be":"Прадаўцы","bg":"Доставчици","ca":"Proveïdors","et":"Müüjad","nl":"Leveranciers"}');
        $this->updateLanguage('Configurations', '{"en":"Configurations","bn":"কনফিগারেশন","fr":"Configurations","zh":"配置","ar":"التكوينات","be":"Канфігурацыі","bg":"Конфигурации","ca":"Configuracions","et":"Seadistused","nl":"Configuraties"}');
        $this->updateLanguage('Orders', '{"en":"Orders","bn":"অর্ডার","fr":"Commandes","zh":"订单","ar":"الطلبات","be":"Замовы","bg":"Поръчки","ca":"Comandes","et":"Tellimused","nl":"Bestellingen"}');
        $this->updateLanguage('Wishlist', '{"en":"Wishlist","bn":"ইচ্ছার তালিকা","fr":"Liste de souhaits","zh":"愿望清单","ar":"قائمة الرغبات","be":"Спіс жаданняў","bg":"Списък с желания","ca":"Llista de desitjos","et":"Soovinimekiri","nl":"Verlanglijstje"}');
        $this->updateLanguage('Reviews', '{"en":"Reviews","bn":"পর্যালোচনা","fr":"Commentaires","zh":"评论","ar":"التقييمات","be":"Водгукі","bg":"Отзиви","ca":"Reseñas","et":"Arvustused","nl":"Recensies"}');
        $this->updateLanguage('My Profile', '{"en":"My Profile","bn":"আমার প্রোফাইল","fr":"Mon profil","zh":"我的个人资料","ar":"ملفي الشخصي","be":"Мой прафіль","bg":"Моят профил","ca":"El meu perfil","et":"Minu profiil","nl":"Mijn profiel"}');
        $this->updateLanguage('Address Books', '{"en":"Address Books","bn":"ঠিকানা বই","fr":"Carnets d\'adresses","zh":"地址簿","ar":"دفاتر العناوين","be":"Адрасныя кнігі","bg":"Адресни книги","ca":"Agendes d\'adreces","et":"Aadressiraamatud","nl":"Adresboeken"}');
        $this->updateLanguage('Settings', '{"en":"Settings","bn":"সেটিংস","fr":"Paramètres","zh":"设置","ar":"الإعدادات","be":"Налады","bg":"Настройки","ca":"Configuració","et":"Sätted","nl":"Instellingen"}');
        $this->updateLanguage('Logout', '{"en":"Logout","bn":"লগআউট","fr":"Déconnexion","zh":"登出","ar":"تسجيل الخروج","be":"Выйсці","bg":"Изход","ca":"Desconnexió","et":"Logi välja","nl":"Uitloggen"}');
        $this->updateLanguage('All Orders', '{"en":"All Orders","bn":"সমস্ত অর্ডার","fr":"Toutes les commandes","zh":"所有订单","ar":"جميع الطلبات","be":"Усе замовы","bg":"Всички поръчки","ca":"Totes les comandes","et":"Kõik tellimused","nl":"Alle bestellingen"}');
        $this->updateLanguage('Orders', '{"en":"Orders","bn":"অর্ডার","fr":"Commandes","zh":"订单","ar":"الطلبات","be":"Замовы","bg":"Поръчки","ca":"Comandes","et":"Tellimused","nl":"Bestellingen"}');
        $this->updateLanguage('shipping', '{"en":"Shipping","bn":"শিপিং","fr":"Livraison","zh":"运输","ar":"الشحن","be":"Доставка","bg":"Доставка","ca":"Enviament","et":"Kohaletoimetamine","nl":"Verzending"}');
        $this->updateLanguage('Orders', '{"en":"Orders","bn":"অর্ডার","fr":"Commandes","zh":"订单","ar":"الطلبات","be":"Заказы","bg":"Поръчки","ca":"Comandes","et":"Tellimused","nl":"Bestellingen"}');
        $this->updateLanguage('Transactions', '{"en":"Transactions","bn":"লেনদেন","fr":"Transactions","zh":"交易","ar":"المعاملات","be":"Транзакцыі","bg":"Транзакции","ca":"Transaccions","et":"Tehingud","nl":"Transacties"}');
        $this->updateLanguage('Geo Locale', '{"en":"Geo Locale","bn":"জিও লোকেল","fr":"Géo Localisation","zh":"地理位置","ar":"الموقع الجغرافي","be":"Геалакаль","bg":"Гео локация","ca":"Geolocalització","et":"Geo lokaalne","nl":"Geo-locatie"}');
        $this->updateLanguage('Refunds', '{"en":"Refunds","bn":"ফেরৎ","fr":"Remboursements","zh":"退款","ar":"المبالغ المستردة","be":"Вяртанні кошту","bg":"Възстановявания","ca":"Reemborsaments","et":"Tagastused","nl":"Terugbetalingen"}');
        $this->updateLanguage('Add Post', '{"en":"Add Post","bn":"পোস্ট যোগ করুন","fr":"Ajouter une publication","zh":"添加帖子","ar":"إضافة مشاركة","be":"Дадаць паведамленне","bg":"Добавяне на публикация","ca":"Afegir publicació","et":"Lisa postitus","nl":"Bericht toevoegen"}');
        $this->updateLanguage('Blogs', '{"en":"Blogs","bn":"ব্লগ","fr":"Blogs","zh":"博客","ar":"المدونات","be":"Блогі","bg":"Блогове","ca":"Blogs","et":"Blogid","nl":"Blogs"}');
        $this->updateLanguage('Website Setup', '{"en":"Website Setup","bn":"ওয়েবসাইট সেটআপ","fr":"Configuration du site web","zh":"网站设置","ar":"إعداد الموقع الإلكتروني","be":"Налада сайту","bg":"Настройка на уебсайта","ca":"Configuració del lloc web","et":"Veebisaidi seadistamine","nl":"Website-instellingen"}');
        $this->updateLanguage('All Sliders', '{"en":"All Sliders","bn":"সমস্ত স্লাইডার","fr":"Tous les curseurs","zh":"所有幻灯片","ar":"جميع المنزلقات","be":"Усе слайдеры","bg":"Всички слайдшоу","ca":"Tots els sliders","et":"Kõik liugureid","nl":"Alle sliders"}');
        $this->updateLanguage('All Posts', '{"en":"All Posts","bn":"সমস্ত পোস্ট","fr":"Tous les articles","zh":"所有帖子","ar":"جميع المشاركات","be":"Усе паведамленні","bg":"Всички публикации","ca":"Totes les publicacions","et":"Kõik postitused","nl":"Alle berichten"}');
        $this->updateLanguage('Pages', '{"en":"Pages","bn":"পৃষ্ঠা","fr":"Pages","zh":"页面","ar":"الصفحات","be":"Старонкі","bg":"Страници","ca":"Pàgines","et":"Leheküljed","nl":"Pagina\'s"}');
        $this->updateLanguage('Media Manager', '{"en":"Media Manager","bn":"মিডিয়া ম্যানেজার","fr":"Gestionnaire de médias","zh":"媒体管理器","ar":"مدير الوسائط","be":"Медыя-менеджэр","bg":"Медиен мениджър","ca":"Gestor de mitjans","et":"Meediumihaldur","nl":"Media-manager"}');
        $this->updateLanguage('Reports', '{"en":"Reports","bn":"রিপোর্ট","fr":"Rapports","zh":"报告","ar":"تقارير","be":"Справаздачы","bg":"Доклади","ca":"Informes","et":"Aruanded","nl":"Rapporten"}');
        $this->updateLanguage('All popups', '{"en":"All Popups","bn":"সমস্ত পপআপ","fr":"Tous les popups","zh":"所有弹出窗口","ar":"جميع النوافذ المنبثقة","be":"Усе выплывальныя акно","bg":"Всички изскачащи прозорци","ca":"Tots els popups","et":"Kõik hüpikaknad","nl":"Alle pop-ups"}');
        $this->updateLanguage('Withdrawals', '{"en":"Withdrawals","bn":"উত্তোলন","fr":"Retraits","zh":"提款","ar":"السحب","be":"Вывядзенні","bg":"Тегления","ca":"Retirs","et":"Väljamaksed","nl":"Opnames"}');
        $this->updateLanguage('Forms', '{"en":"Forms","bn":"ফর্ম","fr":"Formulaires","zh":"表单","ar":"نماذج","be":"Фармы","bg":"Формуляри","ca":"Formularis","et":"Vormid","nl":"Formulieren"}');
        $this->updateLanguage('All Forms', '{"en":"All Forms","bn":"সমস্ত ফর্ম","fr":"Tous les formulaires","zh":"所有表单","ar":"جميع النماذج","be":"Усе формы","bg":"Всички форми","ca":"Tots els formularis","et":"Kõik vormid","nl":"Alle formulieren"}');
        $this->updateLanguage('All Submissions', '{"en":"All Submissions","bn":"সমস্ত জমা","fr":"Toutes les soumissions","zh":"所有提交","ar":"جميع الإرسالات","be":"Усе дасылкі","bg":"Всички подавания","ca":"Totes les presentacions","et":"Kõik esitused","nl":"Alle inzendingen"}');
        $this->updateLanguage('KYC', '{"en":"KYC","bn":"আইডি প্রমাণিত করুন","fr":"KYC","zh":"KYC","ar":"KYC","be":"KYC","bg":"KYC","ca":"KYC","et":"KYC","nl":"KYC"}');
        $this->updateLanguage('Add coupon', '{"en":"Add Coupon","bn":"কুপন যোগ করুন","fr":"Ajouter un coupon","zh":"添加优惠券","ar":"إضافة كوبون","be":"Дадаць купон","bg":"Добавяне на купон","ca":"Afegir un cupó","et":"Lisa kupon","nl":"Coupon toevoegen"}');
        $this->updateLanguage('Marketing', '{"en":"Marketing","bn":"মার্কেটিং","fr":"Marketing","zh":"营销","ar":"تسويق","be":"Маркетынг","bg":"Маркетинг","ca":"Màrqueting","et":"Turundus","nl":"Marketing"}');
        $this->updateLanguage('Coupons', '{"en":"Coupons","bn":"কুপন","fr":"Coupons","zh":"优惠券","ar":"كوبونات","be":"Купоны","bg":"Купони","ca":"Cupons","et":"Kupongid","nl":"Coupons"}');
        $this->updateLanguage('Add Popup', '{"en":"Add Popup","bn":"পপআপ যোগ করুন","fr":"Ajouter un popup","zh":"添加弹出窗口","ar":"إضافة نافذة منبثقة","be":"Дадаць выплывальнае акно","bg":"Добавяне на изскачащ прозорец","ca":"Afegir un popup","et":"Lisa hüpikaken","nl":"Pop-up toevoegen"}');
        $this->updateLanguage('All Subscribers', '{"en":"All Subscribers","bn":"সমস্ত গ্রাহক","fr":"Tous les abonnés","zh":"所有订阅者","ar":"جميع المشتركين","be":"Усе падпісчыкі","bg":"Всички абонати","ca":"Tots els subscriptors","et":"Kõik tellijad","nl":"Alle abonnees"}');
        $this->updateLanguage('Taxes', '{"en":"Taxes","bn":"কর","fr":"Taxes","zh":"税收","ar":"الضرائب","be":"Падаткі","bg":"Данъци","ca":"Impostos","et":"Maksud","nl":"Belastingen"}');
        $this->updateLanguage('Be a seller', '{"en":"Be a seller","bn":"একটি বিক্রেতা হন","fr":"Devenir vendeur","zh":"成为卖家","ar":"كن بائعًا","be":"Станьце продавцом","bg":"Станете продавач","ca":"Ser un venedor","et":"Ole müüja","nl":"Word een verkoper"}');
        $this->updateLanguage('Support Tickets', '{"en":"Support Tickets","bn":"সমর্থন টিকেট","fr":"Tickets de support","zh":"支持票","ar":"تذاكر الدعم","be":"Квіткі падтрымкі","bg":"Билети за поддръжка","ca":"Tiquets de suport","et":"Toetuse piletid","nl":"Ondersteuningstickets"}');
        $this->updateLanguage('Appearance', '{"en":"Appearance","bn":"চেহারা","fr":"Apparence","zh":"外观","ar":"مظهر","be":"Знешні выгляд","bg":"Изглед","ca":"Aparença","et":"Välimus","nl":"Uiterlijk"}');
        $this->updateLanguage('Home Pages', '{"en":"Home Pages","bn":"হোম পেজ","fr":"Pages d\'accueil","zh":"主页","ar":"الصفحات الرئيسية","be":"Дамашнія старонкі","bg":"Начални страници","ca":"Pàgines d\'inici","et":"Avalehed","nl":"Startpagina\'s"}');
        $this->updateLanguage('Orders', '{"en":"Orders","bn":"অর্ডার","fr":"Commandes","zh":"订单","ar":"الطلبات","be":"Заказы","bg":"Поръчки","ca":"Comandes","et":"Tellimused","nl":"Bestellingen"}');
        $this->updateLanguage('Accounts', '{"en":"Accounts","bn":"অ্যাকাউন্ট","fr":"Comptes","zh":"账户","ar":"الحسابات","be":"Рахункі","bg":"Сметки","ca":"Comptes","et":"Kontod","nl":"Accounts"}       ');
        $this->updateLanguage('Emails', '{"en":"Emails","bn":"ইমেইল","fr":"Emails","zh":"电子邮件","ar":"البريد الإلكتروني","be":"Электронная пошта","bg":"Имейли","ca":"Correus electrònics","et":"E-kirjad","nl":"E-mails"}');
        $this->updateLanguage('Add Ticket', '{"en":"Add Ticket","bn":"টিকেট যোগ করুন","fr":"Ajouter un ticket","zh":"添加工单","ar":"إضافة تذكرة","be":"Дадаць квіток","bg":"Добавяне на билет","ca":"Afegir un tiquet","et":"Lisa pilet","nl":"Ticket toevoegen"}');
        $this->updateLanguage('All Tickets', '{"en":"All Tickets","bn":"সমস্ত টিকিট","fr":"Tous les tickets","zh":"所有工单","ar":"جميع التذاكر","be":"Усе квіткі","bg":"Всички билети","ca":"Tots els tiquets","et":"Kõik piletid","nl":"Alle tickets"}');
        $this->updateLanguage('All Coupons', '{"en":"All Coupons","bn":"সমস্ত কুপন","fr":"Tous les coupons","zh":"所有优惠券","ar":"جميع الكوبونات","be":"Усе купоны","bg":"Всички купони","ca":"Tots els cupons","et":"Kõik kupongid","nl":"Alle coupons"}');
        $this->updateLanguage('Coupon Redeems', '{"en":"Coupon Redeems","bn":"কুপন পুনঃপ্রাপ্ত","fr":"Utilisations des coupons","zh":"优惠券兑换","ar":"استرداد الكوبون","be":"Выкарыстанне купонаў","bg":"Откупени купони","ca":"Cupons redimits","et":"Kupongi lunastused","nl":"Couponinlossingen"}');
        $this->updateLanguage('Download', '{"en":"Download","bn":"ডাউনলোড","fr":"Télécharger","zh":"下载","ar":"تحميل","be":"Спампаваць","bg":"Изтегляне","ca":"Descarregar","et":"Laadi alla","nl":"Downloaden"}');
        $this->updateLanguage('Login Activities', '{"en":"Login Activities","bn":"লগইন কার্যকলাপ","fr":"Activités de connexion","zh":"登录活动","ar":"أنشطة تسجيل الدخول","be":"Актыўнасць уваходу","bg":"Дейности при влизане в системата","ca":"Activitats d\'inici de sessió","et":"Sisselogimiste tegevused","nl":"Loginactiviteiten"}');
        $this->updateLanguage('Home', '{"en":"Home","bn":"হোম (Hom)","fr":"Accueil","zh":"首页 (Shǒuyè)","ar":"الرئيسية (Ar-raʾīsīyah)","be":"Галоўная (Haloŭnaya)","bg":"Начало (Nachalo)","ca":"Inici","et":"Avaleht","nl":"Home"}');
        $this->updateLanguage('Home 1', '{"en":"Home 1","bn":"হোম 1","fr":"Accueil 1","zh":"主页 1","ar":"الصفحة الرئيسية 1","be":"Галоўная 1","bg":"Начало 1","ca":"Inici 1","et":"Kodu 1","nl":"Home 1"}');
        $this->updateLanguage('Home 2', '{"en":"Home 2","bn":"হোম 2","fr":"Accueil 2","zh":"主页 2","ar":"الصفحة الرئيسية 2","be":"Галоўная 2","bg":"Начало 2","ca":"Inici 2","et":"Kodu 2","nl":"Home 2"}');
        $this->updateLanguage('Home 3', '{"en":"Home 3","bn":"হোম 3","fr":"Accueil 3","zh":"主页 3","ar":"الصفحة الرئيسية 3","be":"Галоўная 3","bg":"Начало 3","ca":"Inici 3","et":"Kodu 3","nl":"Home 3"}');
        $this->updateLanguage('Home 4', '{"en":"Home 4","bn":"হোম 4","fr":"Accueil 4","zh":"主页 4","ar":"الصفحة الرئيسية 4","be":"Галоўная 4","bg":"Начало 4","ca":"Inici 4","et":"Kodu 4","nl":"Home 4"}');

        $this->updateLanguage('Shop', '{"en":"Shop","bn":"দোকান","fr":"Boutique","zh":"商店","ar":"متجر","be":"Магазін","bg":"Магазин","ca":"Botiga","et":"Pood","nl":"Winkel"}');
        $this->updateLanguage('Coupon', '{"en":"Coupon","bn":"কুপন","fr":"Coupon","zh":"优惠券","ar":"كوبون","be":"Купон","bg":"Купон","ca":"Cupó","et":"Kupong","nl":"Coupon"}');
        $this->updateLanguage('Blogs', ' {"en":"Blogs","bn":"ব্লগ","fr":"Blogs","zh":"博客","ar":"المدونات","be":"Блогі","bg":"Блогове","ca":"Blogs","et":"Blogid","nl":"Blogs"}');
        $this->updateLanguage('Pages', '{"en":"Pages","bn":"পৃষ্ঠা","fr":"Pages","zh":"页面","ar":"الصفحات","be":"Старонкі","bg":"Страници","ca":"Pàgines","et":"Leheküljed","nl":"Pagina\'s"}');
        $this->updateLanguage('About Us', ' {"en":"About Us","bn":"আমাদের সম্পর্কে","fr":"À propos de nous","zh":"关于我们","ar":"معلومات عنا","be":"Пра нас","bg":"За нас","ca":"Sobre nosaltres","et":"Meist","nl":"Over ons"}');
        $this->updateLanguage('Contact Us', '{"en":"Contact Us","bn":"যোগাযোগ করুন","fr":"Contactez-nous","zh":"联系我们","ar":"اتصل بنا","be":"Кантактная інфармацыя","bg":"Свържете се с нас","ca":"Contacta amb nosaltres","et":"Võta meiega ühendust","nl":"Neem contact met ons op"}');
        $this->updateLanguage('Home 5', '{"en":"Home 5","bn":"হোম 5","fr":"Accueil 5","zh":"主页 5","ar":"الصفحة الرئيسية 5","be":"Галоўная 5","bg":"Начало 5","ca":"Inici 5","et":"Kodu 5","nl":"Home 5"}');
        $this->updateLanguage('Home 6', '{"en":"Home 6","bn":"হোম 6","fr":"Accueil 6","zh":"主页 6","ar":"الصفحة الرئيسية 6","be":"Галоўная 6","bg":"Начало 6","ca":"Inici 6","et":"Kodu 6","nl":"Home 6"}');
        $this->updateLanguage('Home 7', '{"en":"Home 7","bn":"হোম 7","fr":"Accueil 7","zh":"主页 7","ar":"الصفحة الرئيسية 7","be":"Галоўная 7","bg":"Начало 7","ca":"Inici 7","et":"Kodu 7","nl":"Home 7"}');
        $this->updateLanguage('Home 8', '{"en":"Home 8","bn":"হোম 8","fr":"Accueil 8","zh":"主页 8","ar":"الصفحة الرئيسية 8","be":"Галоўная 8","bg":"Начало 8","ca":"Inici 8","et":"Kodu 8","nl":"Home 8"}');
        $this->updateLanguage('Home 9', '{"en":"Home 9","bn":"হোম 9","fr":"Accueil 9","zh":"主页 9","ar":"الصفحة الرئيسية 9","be":"Галоўная 9","bg":"Начало 9","ca":"Inici 9","et":"Kodu 9","nl":"Home 9"}');
        $this->updateLanguage('Tickets', '{"en":"Tickets","bn":"টিকিট","fr":"Tickets","zh":"票","ar":"تذاكر","be":"Квіткі","bg":"Билети","ca":"Tiquets","et":"Piletid","nl":"Tickets"}');
        $this->updateLanguage('Import Products', '{"en":"Import Products","bn":"পণ্য আমদানি করুন","fr":"Importer des produits","zh":"导入产品","ar":"استيراد المنتجات","be":"Імпартаваць прадукцыю","bg":"Импортиране на продукти","ca":"Importar productes","et":"Impordi tooteid","nl":"Producten importeren"}');
        $this->updateLanguage('Tools', '{"en":"Tools","bn":"সরঞ্জাম","fr":"Outils","zh":"工具","ar":"أدوات","be":"Інструменты","bg":"Инструменти","ca":"Eines","et":"Tööriistad","nl":"Gereedschap"}');
        $this->updateLanguage('System Info', '{"en":"System Info","bn":"সিস্টেম তথ্য","fr":"Informations système","zh":"系统信息","ar":"معلومات النظام","be":"Сістэмная інфармацыя","bg":"Системна информация","ca":"Informació del sistema","et":"Süsteemiinfo","nl":"Systeeminformatie"}');
        $this->updateLanguage('Export Products', '{"en":"Export Products","bn":"পণ্য রফতানি করুন","fr":"Exporter des produits","zh":"导出产品","ar":"تصدير المنتجات","be":"Экспарт прадукцыі","bg":"Изнасяне на продукти","ca":"Exportar productes","et":"Eksportige tooteid","nl":"Producten exporteren"}');
        $this->updateLanguage('Import', '{"en":"Import","bn":"আমদানি","fr":"Importer","zh":"导入","ar":"استيراد","be":"Імпарт","bg":"Импорт","ca":"Importació","et":"Import","nl":"Importeren"}');
        $this->updateLanguage('Export', '{"en":"Export","bn":"রফতানি","fr":"Exporter","zh":"出口","ar":"تصدير","be":"Экспарт","bg":"Изнасяне","ca":"Exportació","et":"Eksport","nl":"Exporteren"}');
        $this->updateLanguage('System Update', '{"en":"System Update","bn":"সিস্টেম আপডেট","fr":"Mise à jour du système","zh":"系统更新","ar":"تحديث النظام","be":"Абнаўленне сістэмы","bg":"Актуализиране на системата","ca":"Actualització del sistema","et":"Süsteemi uuendus","nl":"Systeemupdate"}');
        $this->updateLanguage('All Categories', '{"en":"All Categories","bn":"সব বিভাগ","fr":"Toutes les catégories","zh":"所有类别","ar":"جميع الفئات","be":"Усе катэгорыі","bg":"Всички категории","ca":"Totes les categories","et":"Kõik kategooriad","nl":"Alle categorieën"}');
        $this->updateLanguage('Customers', '{"en":"Customers","bn":"গ্রাহক","fr":"Clients","zh":"顾客","ar":"العملاء","be":"Кліенты","bg":"Клиенти","ca":"Clients","et":"Kliendid","nl":"Klanten"}');
        $this->updateLanguage('Decorate Shop', '{"en":"Decorate Shop","bn":"দোকান সাজানো","fr":"Décorer le magasin","zh":"装饰店铺","ar":"تزيين المتجر","be":"Імпартаваць прадукцыю","bg":"Украсяване на магазина","ca":"Decorar botiga","et":"Kaupluse kaunistamine","nl":"Winkel versieren"}');
        $this->updateLanguage('Barcode', '{"en":"Barcode","bn":"বারকোড","fr":"Code-barres","zh":"条码","ar":"الباركود","be":"Штрых-код","bg":"Баркод","ca":"Codi de barres","et":"Vöötkood","nl":"Barcode"}');
        $this->updateLanguage('Product', '{"en":"Product","bn":"পণ্য","fr":"Produit","zh":"产品","ar":"المنتج","be":"Прадукт","bg":"Продукт","ca":"Producte","et":"Toode","nl":"Product"}');
        $this->updateLanguage('Settings', '{"en":"Settings","bn":"সেটিংস","fr":"Paramètres","zh":"设置","ar":"الإعدادات","be":"Налады","bg":"Настройки","ca":"Configuració","et":"Sätted","nl":"Instellingen"}');
        $this->updateLanguage('Sms', '{"en":"Sms","bn":"এসএমএস","fr":"SMS","zh":"短信","ar":"رسالة نصية قصيرة","be":"СМС","bg":"СМС","ca":"Missatges de text","et":"SMS","nl":"Sms"}');
        $this->updateLanguage('Notification Log', '{"en":"Notification Log","bn":"বিজ্ঞপ্তি লগ","fr":"Journal des notifications","zh":"通知日志","ar":"سجل الإشعارات","be":"Журнал апавяшчэнняў","bg":"Дневник за известия","ca":"Registre de notificacions","et":"Teavituste logi","nl":"Meldingslogboek"}');
        $this->updateLanguage('Authentication Layout', '{"en":"Authentication Layout","bn":"প্রমাণীকরণ লেআউট","fr":"Disposition d\'authentification","zh":"身份验证布局","ar":"تخطيط المصادقة","be":"Макет аўтэнтыфікацыі","bg":"Оформление на удостоверяването","ca":"Disposició d\'autenticació","et":"Autentimise kujundus","nl":"Authenticatielayout"}');
        $this->updateLanguage('Inventory', '{"en":"Inventory","bn":"মজুদ","fr":"Inventaire","zh":"库存","ar":"المخزون","be":"Сток","bg":"Наличност","ca":"Inventari","et":"Varu","nl":"Voorraad"}');
        $this->updateLanguage('Location', '{"en":"Location","bn":"অবস্থান","fr":"Emplacement","zh":"位置","ar":"الموقع","be":"Месцазнаходжанне","bg":"Местоположение","ca":"Ubicació","et":"Asukoht","nl":"Locatie"}');
        $this->updateLanguage('Supplier', '{"en":"Supplier","bn":"সরবরাহকারী","fr":"Fournisseur","zh":"供应商","ar":"المورد","be":"Пастаўшчык","bg":"Доставчик","ca":"Proveïdor","et":"Tarnija","nl":"Leverancier"}');
        $this->updateLanguage('Transaction', '{"en":"Transaction","bn":"লেনদেন","fr":"Transaction","zh":"交易","ar":"المعاملة","be":"Трансакцыя","bg":"Транзакция","ca":"Transacció","et":"Tehing","nl":"Transactie"}');
        $this->updateLanguage('Purchase Order', '{"en":"Purchase Order","bn":"ক্রয় আদেশ","fr":"Bon de commande","zh":"采购订单","ar":"طلب الشراء","be":"Заказ","bg":"Поръчка","ca":"Ordre de compra","et":"Tellimus","nl":"Aankooporder"}');
        $this->updateLanguage('Stock', '{"en":"Stock","bn":"স্টক","fr":"Stock","zh":"股票","ar":"المخزون","be":"Запас","bg":"Акции","ca":"Estoc","et":"Aksiad","nl":"Voorraad"}');
        $this->updateLanguage('Transfer', '{"en":"Transfer","bn":"স্থানান্তর","fr":"Transfert","zh":"转账","ar":"تحويل","be":"Перанос","bg":"Трансфер","ca":"Transferència","et":"Ülekanne","nl":"Overdracht"}');
    }
}
