<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Exports Valley B2B - ربط المصانع السعودية بالمستوردين العالميين</title>
    <meta name="description" content="منصة رائدة تربط المصانع السعودية بالمستوردين حول العالم، توفر حلول متكاملة للتجارة الإلكترونية B2B">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('public/landing/styles.css') }}">

    <meta name="google-site-verification" content="p9KulfNqluiDeDGxC5DLHya46P_BNvD12TilaoFxm3I" />

</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-brand">
                    <div class="logo">
                        <div class="logo-icon">🏭</div>
                        <span class="logo-text">
                            Exports Valley
                        </span>
                    </div>
                </div>
                <div class="nav-menu">
                    <a href="#features" class="nav-link">الخدمات</a>
                    <a href="#how-it-works" class="nav-link">كيف تعمل</a>
                    <a href="#stats" class="nav-link">الإحصائيات</a>
                    <a href="#contact" class="nav-link">تواصل معنا</a>
                    <div class="nav-actions">
                        <button class="btn btn-outline" id="loginBtn">تسجيل الدخول</button>
                        <button class="lang-toggle" id="langToggle">EN</button>
                    </div>
                </div>
                <div class="mobile-menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg">
            <div class="hero-overlay"></div>
        </div>
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    الجسر الرقمي بين 
                    <span class="highlight">المصانع السعودية</span>
                    و المستوردين العالميين
                </h1>
                <p class="hero-subtitle">
                    منصة متطورة تجمع المصانع السعودية مع المستوردين من جميع أنحاء العالم، 
                    توفر بيئة آمنة ومتكاملة للتجارة الإلكترونية B2B
                </p>
                <div class="hero-cta">
                    <button class="btn btn-primary btn-large" id="factorySignup">
                        انضم كمصنع
                        <span class="btn-icon">🏭</span>
                    </button>
                    <button class="btn btn-secondary btn-large" id="importerSignup">
                        انضم كمستورد
                        <span class="btn-icon">🌍</span>
                    </button>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-number" >500+</div>
                        <div class="stat-label">مصنع سعودي</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">2000+</div>
                        <div class="stat-label">مستورد دولي</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">منتج متاح</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">خدماتنا المتميزة</h2>
                <p class="section-subtitle">حلول شاملة تلبي احتياجات المصانع والمستوردين</p>
            </div>
            
            <!-- For Factories -->
            <div class="feature-category">
                <h3 class="category-title">
                    <span class="category-icon">🏭</span>
                    للمصانع السعودية
                </h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">📊</div>
                        <h4 class="feature-title">تسجيل حساب مجاني</h4>
                        <p class="feature-description">ابدأ رحلتك مع منصتنا بتسجيل حساب مجاني وسهل للمصانع السعودية</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📦</div>
                        <h4 class="feature-title">إضافة أقسام ومنتجات</h4>
                        <p class="feature-description">أضف وإدارة منتجاتك بسهولة مع أدوات متقدمة لتنظيم الأقسام والفئات</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🏭</div>
                        <h4 class="feature-title">عرض تفاصيل المصنع</h4>
                        <p class="feature-description">اعرض معلومات مصنعك وخدماتك للمستوردين من جميع أنحاء العالم</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📋</div>
                        <h4 class="feature-title">إدارة الطلبات والمخزون</h4>
                        <p class="feature-description">نظام متقدم لإدارة الطلبات الواردة ومتابعة المخزون بكفاءة</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">💬</div>
                        <h4 class="feature-title">تواصل مباشر مع المستوردين</h4>
                        <p class="feature-description">تواصل مباشرة مع المستوردين لمناقشة التفاصيل والتفاوض على الأسعار</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📈</div>
                        <h4 class="feature-title">تقارير مبيعات مفصلة</h4>
                        <p class="feature-description">احصل على تقارير شاملة ومفصلة عن أداء منتجاتك ومبيعاتك</p>
                    </div>
                </div>
            </div>

            <!-- For Importers -->
            <div class="feature-category">
                <h3 class="category-title">
                    <span class="category-icon">🌍</span>
                    للمستوردين الدوليين
                </h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🔍</div>
                        <h4 class="feature-title">تصفح آلاف المنتجات</h4>
                        <p class="feature-description">استكشف مجموعة واسعة من المنتجات السعودية عالية الجودة من مختلف الصناعات</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🏭</div>
                        <h4 class="feature-title">البحث في قائمة المصانع</h4>
                        <p class="feature-description">ابحث عن المصانع والمنتجات بدقة باستخدام فلاتر متطورة ومتقدمة</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🛒</div>
                        <h4 class="feature-title">إضافة المنتجات للسلة</h4>
                        <p class="feature-description">أضف المنتجات المفضلة لديك إلى سلة التسوق بسهولة ومرونة</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">✅</div>
                        <h4 class="feature-title">إكمال الطلبات بسهولة</h4>
                        <p class="feature-description">نظام طلبات مبسط وآمن لإكمال عمليات الشراء بخطوات قليلة</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📍</div>
                        <h4 class="feature-title">تتبع حالة الطلبات</h4>
                        <p class="feature-description">تتبع طلباتك لحظة بلحظة من التصنيع حتى الوصول لبلدك</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">⭐</div>
                        <h4 class="feature-title">تقييم المصانع والمنتجات</h4>
                        <p class="feature-description">قيم تجربتك مع المصانع والمنتجات لمساعدة المستوردين الآخرين</p>
                    </div>
                </div>
            </div>

            <!-- Shipping & Delivery -->
            <div class="feature-category">
                <h3 class="category-title">
                    <span class="category-icon">🚚</span>
                    الشحن والتوصيل
                </h3>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="feature-icon">🌐</div>
                        <h4 class="feature-title">شراكات عالمية</h4>
                        <p class="feature-description">شراكات مع أكبر شركات الشحن العالمية لضمان وصول آمن وسريع</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📍</div>
                        <h4 class="feature-title">تتبع الطلبات</h4>
                        <p class="feature-description">تتبع شحناتك لحظة بلحظة من المصنع حتى وصولها لوجهتها النهائية</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">⚡</div>
                        <h4 class="feature-title">خيارات شحن متنوعة</h4>
                        <p class="feature-description">اختر من بين خيارات الشحن المختلفة: عادي، سريع، أو فائق السرعة</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">🛡️</div>
                        <h4 class="feature-title">ضمان الوصول</h4>
                        <p class="feature-description">تأمين شامل على الشحنات مع ضمان الوصول أو استرداد كامل</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">كيف تعمل المنصة</h2>
                <p class="section-subtitle">خطوات بسيطة للبدء في رحلتك التجارية</p>
            </div>
            
            <div class="process-tabs">
                <button class="tab-btn active" data-tab="factory">للمصانع</button>
                <button class="tab-btn" data-tab="importer">للمستوردين</button>
            </div>

            <div class="tab-content active" id="factory-process">
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>إنشاء حساب المصنع</h4>
                            <p>سجل معلومات مصنعك وأحصل على التحقق</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>إضافة المنتجات</h4>
                            <p>أضف منتجاتك مع الصور والأوصاف التفصيلية</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>استقبال الطلبات</h4>
                            <p>ابدأ في استقبال طلبات من مستوردين حول العالم</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>إنجاز الصفقات</h4>
                            <p>أكمل الطلبات واحصل على الدفع بأمان</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="importer-process">
                <div class="process-steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div class="step-content">
                            <h4>إنشاء حساب مستورد</h4>
                            <p>سجل معلومات شركتك وحدد احتياجاتك</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-content">
                            <h4>تصفح المنتجات</h4>
                            <p>ابحث واستكشف آلاف المنتجات من مصانع مختلفة</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-content">
                            <h4>إضافة للسلة</h4>
                            <p>اختر المنتجات وأضفها لسلة التسوق الخاصة بك</p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">4</div>
                        <div class="step-content">
                            <h4>إكمال الطلب</h4>
                            <p>أكمل عملية الشراء واستلم منتجاتك</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics -->
    <section class="stats" id="stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">🏭</div>
                    <div class="stat-number" data-target="500">0</div>
                    <div class="stat-label">مصنع سعودي</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🌍</div>
                    <div class="stat-number" data-target="2000">0</div>
                    <div class="stat-label">مستورد دولي</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📦</div>
                    <div class="stat-number" data-target="50000">0</div>
                    <div class="stat-label">منتج متاح</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">💰</div>
                    <div class="stat-number" data-target="100">0</div>
                    <div class="stat-label">مليون ريال معاملات</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2 class="cta-title">ابدأ رحلتك التجارية اليوم</h2>
                <p class="cta-subtitle">انضم لآلاف المصانع والمستوردين الذين يثقون بمنصتنا</p>
                <div class="cta-buttons">
                    <button class="btn btn-primary btn-large">
                        تسجيل مصنع جديد
                        <span class="btn-icon">🏭</span>
                    </button>
                    <button class="btn btn-outline btn-large">
                        تسجيل مستورد جديد
                        <span class="btn-icon">🌍</span>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <div class="logo">
                            <div class="logo-icon">🏭</div>
                            <span class="logo-text">Exports Valley</span>
                        </div>
                    </div>
                    <p class="footer-description">
                        المنصة الرائدة في ربط المصانع السعودية بالمستوردين العالميين
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link">📱</a>
                        <a href="#" class="social-link">📧</a>
                        <a href="#" class="social-link">🐦</a>
                        <a href="#" class="social-link">💼</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-title">الخدمات</h4>
                    <ul class="footer-links">
                        <li><a href="#">للمصانع</a></li>
                        <li><a href="#">للمستوردين</a></li>
                        <li><a href="#">الحلول المتقدمة</a></li>
                        <li><a href="#">الدعم الفني</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-title">المساعدة</h4>
                    <ul class="footer-links">
                        <li><a href="#">مركز المساعدة</a></li>
                        <li><a href="#">الأسئلة الشائعة</a></li>
                        <li><a href="#">شروط الاستخدام</a></li>
                        <li><a href="#">سياسة الخصوصية</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4 class="footer-title">تواصل معنا</h4>
                    <div class="contact-info">
                        <div class="contact-item">
                            <span class="contact-icon">📍</span>
                            <span>الرياض، المملكة العربية السعودية</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">📞</span>
                            <span dir="ltr">+966 11 123 4567</span>
                        </div>
                        <div class="contact-item">
                            <span class="contact-icon">📧</span>
                            <span dir="ltr">info@b2bplatform.sa</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 Exports Valley. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Signup Modals -->
    <div class="modal" id="factoryModal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-header">
                <h3>تسجيل مصنع جديد</h3>
                <p>انضم لشبكتنا من المصانع السعودية الرائدة</p>
            </div>
            <form class="signup-form">
                <div class="form-group">
                    <label>اسم المصنع</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="tel" required>
                </div>
                <div class="form-group">
                    <label>نوع الصناعة</label>
                    <select required>
                        <option value="">اختر نوع الصناعة</option>
                        <option value="textile">النسيج</option>
                        <option value="food">الأغذية</option>
                        <option value="chemicals">الكيماويات</option>
                        <option value="electronics">الإلكترونيات</option>
                        <option value="construction">مواد البناء</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-full">تسجيل المصنع</button>
            </form>
        </div>
    </div>

    <div class="modal" id="importerModal">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <div class="modal-header">
                <h3>تسجيل مستورد جديد</h3>
                <p>ابدأ في استيراد أفضل المنتجات السعودية</p>
            </div>
            <form class="signup-form">
                <div class="form-group">
                    <label>اسم الشركة</label>
                    <input type="text" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" required>
                </div>
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="tel" required>
                </div>
                <div class="form-group">
                    <label>الدولة</label>
                    <select required>
                        <option value="">اختر الدولة</option>
                        <option value="ae">الإمارات العربية المتحدة</option>
                        <option value="kw">الكويت</option>
                        <option value="qa">قطر</option>
                        <option value="bh">البحرين</option>
                        <option value="om">عُمان</option>
                        <option value="jo">الأردن</option>
                        <option value="lb">لبنان</option>
                        <option value="eg">مصر</option>
                        <option value="other">دولة أخرى</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-full">تسجيل المستورد</button>
            </form>
        </div>
    </div>

    <div class="modal-backdrop"></div>

    <script src="{{ asset('public/landing/script.js')  }}"></script>
</body>
</html>
