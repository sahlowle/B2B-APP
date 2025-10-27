// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileMenu = document.querySelector('.mobile-menu');
    const menuIcon = mobileMenuBtn?.querySelector('.menu-icon');
    const body = document.body;
    
    if (mobileMenuBtn && mobileMenu && menuIcon) {
        mobileMenuBtn.addEventListener('click', function() {
            const isOpen = !mobileMenu.classList.contains('hidden');
            
            if (isOpen) {
                mobileMenu.classList.add('hidden');
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                body.style.overflow = 'auto'; 
            } else {
                mobileMenu.classList.remove('hidden');
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                body.style.overflow = 'hidden'; 
            }
        });
    }
    
    // Close mobile menu when clicking on links
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (mobileMenu && menuIcon) {
                mobileMenu.classList.add('hidden');
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                body.style.overflow = 'auto';
            }
        });
    });
    
    // Close mobile menu when clicking on action buttons
    const mobileActionButtons = document.querySelectorAll('.mobile-sign-in-btn, .mobile-contact-btn');
    mobileActionButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (mobileMenu && menuIcon) {
                mobileMenu.classList.add('hidden');
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                body.style.overflow = 'auto';
            }
        });
    });
    
    // Language dropdown functionality
    const dropdownButton = document.getElementById('language-dropdown-button');
    const dropdownMenu = document.getElementById('language-dropdown-menu');
    const dropdownArrow = document.getElementById('dropdown-arrow');
    const langText = document.querySelector('.lang-text');
    const langFlag = document.querySelector('.lang-flag');
    const langOptions = document.querySelectorAll('.lang-option');
    
    if (dropdownButton && dropdownMenu) {
        // Toggle dropdown visibility
        dropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = dropdownMenu.classList.contains('hidden');
            
            if (isHidden) {
                dropdownMenu.classList.remove('hidden');
                // Use setTimeout to allow the display change before applying opacity/transform
                setTimeout(() => {
                    dropdownMenu.classList.remove('opacity-0', '-translate-y-2');
                    dropdownMenu.classList.add('opacity-100', 'translate-y-0');
                }, 10);
                dropdownArrow.style.transform = 'rotate(180deg)';
            } else {
                dropdownMenu.classList.add('opacity-0', '-translate-y-2');
                dropdownMenu.classList.remove('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 200);
                dropdownArrow.style.transform = 'rotate(0deg)';
            }
        });
        
        // Handle language selection
        langOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedLang = this.getAttribute('data-lang');
                const selectedFlag = this.getAttribute('data-flag');
                const selectedText = this.querySelector('span:last-child').textContent;
                
                // Update button text and flag
                langFlag.textContent = selectedFlag;
                langText.textContent = selectedText;
                
                // Close dropdown
                dropdownMenu.classList.add('opacity-0', '-translate-y-2');
                dropdownMenu.classList.remove('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    dropdownMenu.classList.add('hidden');
                }, 200);
                dropdownArrow.style.transform = 'rotate(0deg)';
                
                // Handle language change and RTL/LTR switching
                handleLanguageChange(selectedLang);
            });
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            dropdownMenu.classList.add('opacity-0', '-translate-y-2');
            dropdownMenu.classList.remove('opacity-100', 'translate-y-0');
            setTimeout(() => {
                dropdownMenu.classList.add('hidden');
            }, 200);
            dropdownArrow.style.transform = 'rotate(0deg)';
        });
        
        // Prevent dropdown from closing when clicking inside it
        dropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Account dropdown functionality
    const accountDropdownButton = document.getElementById('account-dropdown-button');
    const accountDropdownMenu = document.getElementById('account-dropdown-menu');
    
    if (accountDropdownButton && accountDropdownMenu) {
        // Toggle dropdown visibility
        accountDropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = accountDropdownMenu.classList.contains('hidden');
            
            if (isHidden) {
                accountDropdownMenu.classList.remove('hidden');
                // Use setTimeout to allow the display change before applying opacity/transform
                setTimeout(() => {
                    accountDropdownMenu.classList.remove('opacity-0', '-translate-y-2');
                    accountDropdownMenu.classList.add('opacity-100', 'translate-y-0');
                }, 10);
            } else {
                accountDropdownMenu.classList.add('opacity-0', '-translate-y-2');
                accountDropdownMenu.classList.remove('opacity-100', 'translate-y-0');
                setTimeout(() => {
                    accountDropdownMenu.classList.add('hidden');
                }, 200);
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            accountDropdownMenu.classList.add('opacity-0', '-translate-y-2');
            accountDropdownMenu.classList.remove('opacity-100', 'translate-y-0');
            setTimeout(() => {
                accountDropdownMenu.classList.add('hidden');
            }, 200);
        });
        
        // Prevent dropdown from closing when clicking inside it
        accountDropdownMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }
    
    // Hero image carousel
    const heroImages = document.querySelectorAll('.hero-img');
    let currentHeroIndex = 0;
    
    function rotateHeroImages() {
        heroImages.forEach(img => img.classList.remove('active'));
        currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
        heroImages[currentHeroIndex].classList.add('active');
    }
    
    // Industry image carousel
    const industryImages = document.querySelectorAll('.industry-img');
    let currentIndustryIndex = 0;
    
    function rotateIndustryImages() {
        industryImages.forEach(img => img.classList.remove('active'));
        currentIndustryIndex = (currentIndustryIndex + 1) % industryImages.length;
        industryImages[currentIndustryIndex].classList.add('active');
    }
    
    // Start carousels only if elements exist
    if (heroImages.length > 0) {
        setInterval(rotateHeroImages, 4000);
    }
    
    if (industryImages.length > 0) {
        setInterval(rotateIndustryImages, 4000);
    }
    
    // FAQ accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        const answer = question.nextElementSibling;
        const icon = question.querySelector('.faq-icon');
        
        question.addEventListener('click', function() {
            // Close all other FAQ items
            faqQuestions.forEach(q => {
                if (q !== question) {
                    const otherAnswer = q.nextElementSibling;
                    const otherIcon = q.querySelector('.faq-icon');
                    otherAnswer.classList.add('hidden');
                    otherIcon.style.transform = 'rotate(0deg)';
                    q.parentElement.classList.remove('expanded');
                }
            });
            
            // Toggle current FAQ item
            if (answer.classList.contains('hidden')) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
                question.parentElement.classList.add('expanded');
            } else {
                answer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                question.parentElement.classList.remove('expanded');
            }
        });
    });
    
    // Function to handle language change
    function handleLanguageChange(lang) {
        if (lang === 'ar') {
            document.documentElement.dir = 'rtl';
            document.documentElement.lang = 'ar';
            updateTextForRTL();
            updateFAQForRTL();
            updateFooterForRTL();
        } else {
            document.documentElement.dir = 'ltr';
            document.documentElement.lang = lang;
            updateTextForLTR();
            updateFAQForLTR();
            updateFooterForLTR();
        }
        
        // Close mobile menu if open
        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            if (menuIcon) {
                menuIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
            }
            body.style.overflow = 'auto';
        }
        
        console.log(`Language changed to: ${lang}`);
    }
    
    //text content for RTL (Arabic)
    function updateTextForRTL() {
        // Navigation links
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        
        if (navLinks.length >= 4) {
            navLinks[0].textContent = 'الفئات';
            navLinks[1].textContent = 'المصانع';
            navLinks[2].textContent = 'عروض الأسعار';
            navLinks[3].textContent = 'تواصل معنا';
        }
        
        if (mobileNavLinks.length >= 4) {
            mobileNavLinks[0].textContent = 'الفئات';
            mobileNavLinks[1].textContent = 'المصانع';
            mobileNavLinks[2].textContent = 'عروض الأسعار';
            mobileNavLinks[3].textContent = 'تواصل معنا';
        }
        
        // Buttons
        const signInBtns = document.querySelectorAll('.sign-in-btn, .mobile-sign-in-btn');
        const contactBtns = document.querySelectorAll('.mobile-contact-btn span, .btn-secondary span');
        
        signInBtns.forEach(btn => {
            const span = btn.querySelector('span');
            if (span) span.textContent = 'تسجيل دخول';
        });
        
        contactBtns.forEach(span => {
            if (span.textContent === 'Contact Us') {
                span.textContent = 'تواصل معنا';
            }
        });
        
        const heroTitle = document.querySelector('.hero-title');
        const heroDescription = document.querySelector('.hero-description');
        const heroButtons = document.querySelectorAll('.btn-primary span, .btn-secondary span');
        
        if (heroTitle) heroTitle.textContent = 'إكسبورتس فالي';
        if (heroDescription) {
            heroDescription.textContent = 'منصة متطورة تجمع المصانع السعودية مع المستوردين من جميع أنحاء العالم. نوفر بيئة آمنة ومتكاملة للتجارة الإلكترونية تمكن المصانع السعودية من الوصول إلى الأسواق العالمية بسهولة وتوفر حلولاً رقمية محلية مبتكرة ومدعومة بالذكاء الاصطناعي لتبسيط عمليات التواصل والتفاوض والاتفاق';
        }
        
        if (heroButtons.length >= 2) {
            heroButtons[0].textContent = 'سجل الآن';
        }
        
        //  hero button icons for RTL
        const heroBtnIcons = document.querySelectorAll('.hero-buttons .btn-icon');
        heroBtnIcons.forEach(icon => {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />';
        });

        //  CTA section
        const ctaTitle = document.querySelector('.cta-title');
        const ctaDescription = document.querySelector('.cta-description');
        const ctaButton = document.querySelector('.cta-button span');
        
        if (ctaTitle) ctaTitle.textContent = 'طلب عروض الأسعار بدون تسجيل';
        if (ctaDescription) {
            ctaDescription.textContent = 'احصل على أفضل العروض من المصنعين الموثوقين من خلال شبكة المتخصصين لدينا. اطلب عروض الأسعار بسهولة وقارن الأسعار لضمان أسعار تنافسية وخدمات عالية الجودة.';
        }
        if (ctaButton) ctaButton.textContent = 'طلب عرض سعر';

        //  features section
        const sectionTitle = document.querySelector('.features .section-title');
        const sectionDescription = document.querySelector('.features .section-description');
        
        if (sectionTitle) sectionTitle.textContent = 'ابدأ رحلتك التجارية اليوم';
        if (sectionDescription) {
            sectionDescription.textContent = 'انضم إلى آلاف المصانع والمستوردين الذين يثقون بمنصتنا ويستفيدون من أفضل الحلول التقنية في السوق.';
        }

        //  services section
        const servicesTitle = document.querySelector('.services .section-title');
        const servicesDescription = document.querySelector('.services .section-description');
        
        if (servicesTitle) servicesTitle.textContent = 'خدماتنا';
        if (servicesDescription) {
            servicesDescription.textContent = 'نوفر حلولاً شاملة للمصانع السعودية والمستوردين';
        }

        // Service type headers
        const factoryServiceTitle = document.querySelector('.service-type-title');
        const factoryServiceDescription = document.querySelector('.service-type-description');
        
        if (factoryServiceTitle) factoryServiceTitle.textContent = 'خدمات المصانع';
        if (factoryServiceDescription) {
            factoryServiceDescription.textContent = 'حلول ذكية لمساعدة المصانع السعودية على عرض منتجاتها والتواصل مباشرة مع المستوردين حول العالم.';
        }

        //  Saudi industry section
        const industryTitle = document.querySelector('.saudi-industry .section-title');
        const industryDescription = document.querySelector('.saudi-industry .section-description');
        const industryButton = document.querySelector('.saudi-industry .btn-primary span');
        const visionTitle = document.querySelector('.vision-title');
        const visionDescription = document.querySelector('.vision-description');
        
        if (industryTitle) industryTitle.textContent = 'اكتشف قوة الصناعة السعودية';
        if (industryDescription) {
            industryDescription.textContent = 'تصفح المنتجات عالية الجودة من المصانع السعودية الموثوقة. استفد من فرص التعاون والتوزيع من خلال منصتنا المتكاملة.';
        }
        if (industryButton) industryButton.textContent = 'تصفح المنتجات';
        if (visionTitle) visionTitle.textContent = 'نحو تحقيق رؤية المملكة 2030';
        if (visionDescription) {
            visionDescription.textContent = 'نساهم في تمكين الصناعة السعودية وتعزيزها عالمياً من خلال حلول رقمية مبتكرة تدعم التحول الاقتصادي وتتوافق مع أهداف رؤية المملكة 2030.';
        }
    }
    
    // text content for LTR
    function updateTextForLTR() {
        // Navigation links
        const navLinks = document.querySelectorAll('.nav-link');
        const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');
        
        if (navLinks.length >= 4) {
            navLinks[0].textContent = 'Categories';
            navLinks[1].textContent = 'Factories';
            navLinks[2].textContent = 'Quote Requests';
            navLinks[3].textContent = 'Contact Us';
        }
        
        if (mobileNavLinks.length >= 4) {
            mobileNavLinks[0].textContent = 'Categories';
            mobileNavLinks[1].textContent = 'Factories';
            mobileNavLinks[2].textContent = 'Quote Requests';
            mobileNavLinks[3].textContent = 'Contact Us';
        }
        
        // Buttons
        const signInBtns = document.querySelectorAll('.sign-in-btn, .mobile-sign-in-btn');
        const contactBtns = document.querySelectorAll('.mobile-contact-btn span, .btn-secondary span');
        
        signInBtns.forEach(btn => {
            const span = btn.querySelector('span');
            if (span) span.textContent = 'Sign In';
        });
        
        contactBtns.forEach(span => {
            if (span.textContent === 'تواصل معنا') {
                span.textContent = 'Contact Us';
            }
        });
        
        //  hero section text
        const heroTitle = document.querySelector('.hero-title');
        const heroDescription = document.querySelector('.hero-description');
        const heroButtons = document.querySelectorAll('.btn-primary span, .btn-secondary span');
        
        if (heroTitle) heroTitle.textContent = 'Exports Valley';
        if (heroDescription) {
            heroDescription.textContent = 'A comprehensive platform connecting Saudi factories with importers worldwide. We provide a safe and integrated environment for international trade, offering digital solutions backed by artificial intelligence to simplify communication, negotiation, and agreement processes.';
        }
        
        if (heroButtons.length >= 2) {
            heroButtons[0].textContent = 'Register Now';
        }
        
        //  hero button icons for LTR
        const heroBtnIcons = document.querySelectorAll('.hero-buttons .btn-icon');
        heroBtnIcons.forEach(icon => {
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />';
        });

        //  CTA section
        const ctaTitle = document.querySelector('.cta-title');
        const ctaDescription = document.querySelector('.cta-description');
        const ctaButton = document.querySelector('.cta-button span');
        
        if (ctaTitle) ctaTitle.textContent = 'Request Price Quotes Without Registration';
        if (ctaDescription) {
            ctaDescription.textContent = 'Get the best offers from trusted manufacturers through our network of specialists. Request quotes easily and compare prices to ensure competitive prices and quality services.';
        }
        if (ctaButton) ctaButton.textContent = 'Request a Quote';

        // Update features section
        const sectionTitle = document.querySelector('.features .section-title');
        const sectionDescription = document.querySelector('.features .section-description');
        
        if (sectionTitle) sectionTitle.textContent = 'Start Your Business Journey Today';
        if (sectionDescription) {
            sectionDescription.textContent = 'Join thousands of factories and importers who trust our platform and benefit from the best technical solutions in the market.';
        }

        // services section
        const servicesTitle = document.querySelector('.services .section-title');
        const servicesDescription = document.querySelector('.services .section-description');
        
        if (servicesTitle) servicesTitle.textContent = 'Our Services';
        if (servicesDescription) {
            servicesDescription.textContent = 'We provide comprehensive solutions for Saudi factories and importers';
        }

        // Service type headers
        const factoryServiceTitle = document.querySelector('.service-type-title');
        const factoryServiceDescription = document.querySelector('.service-type-description');
        
        if (factoryServiceTitle) factoryServiceTitle.textContent = 'Factory Services';
        if (factoryServiceDescription) {
            factoryServiceDescription.textContent = 'Smart solutions to help Saudi factories display their products and connect directly with importers around the world.';
        }

        
        const industryTitle = document.querySelector('.saudi-industry .section-title');
        const industryDescription = document.querySelector('.saudi-industry .section-description');
        const industryButton = document.querySelector('.saudi-industry .btn-primary span');
        const visionTitle = document.querySelector('.vision-title');
        const visionDescription = document.querySelector('.vision-description');
        
        if (industryTitle) industryTitle.textContent = 'Discover the Power of Saudi Industry';
        if (industryDescription) {
            industryDescription.textContent = 'Browse high-quality products from trusted Saudi factories. Benefit from cooperation and distribution opportunities through our integrated platform.';
        }
        if (industryButton) industryButton.textContent = 'Browse Products';
        if (visionTitle) visionTitle.textContent = 'Towards Achieving Kingdom\'s Vision 2030';
        if (visionDescription) {
            visionDescription.textContent = 'We contribute to empowering Saudi industry and promoting it globally through innovative digital solutions that support economic transformation and align with the Kingdom\'s Vision 2030 goals.';
        }
    }
    
    
    function updateFAQForRTL() {
        const faqTitle = document.querySelector('.faq-title');
        const faqQuestions = document.querySelectorAll('.faq-question span');
        
        if (faqTitle) faqTitle.textContent = 'الأسئلة الشائعة';
        
        
        if (faqQuestions.length >= 5) {
            faqQuestions[0].textContent = 'ما الدول التي تغطيها خدمات الشحن لديكم؟';
            faqQuestions[1].textContent = 'كيف أتابع حالة الشحنة الخاصة بي؟';
            faqQuestions[2].textContent = 'هل توفرون تأميناً على الشحنات؟';
            faqQuestions[3].textContent = 'ما هي مدة الشحن المتوقعة؟';
            faqQuestions[4].textContent = 'كيف يمكنني التواصل مع الدعم الفني؟';
        }
        
        // Update FAQ answers
        const faqAnswers = document.querySelectorAll('.faq-answer p');
        if (faqAnswers.length >= 5) {
            faqAnswers[0].textContent = 'نوفر خدمات الشحن إلى أكثر من 150 دولة حول العالم. تشمل شبكتنا الأسواق الرئيسية في آسيا وأوروبا والأمريكتين والشرق الأوسط.';
            faqAnswers[1].textContent = 'يمكنك تتبع شحنتك في الوقت الفعلي باستخدام رقم التتبع الخاص بك على منصتنا. ما عليك سوى تسجيل الدخول إلى حسابك والانتقال إلى قسم التتبع.';
            faqAnswers[2].textContent = 'نعم، نوفر تغطية تأمينية شاملة لجميع الشحنات. يمكنك الاختيار من بين مستويات تغطية مختلفة بناءً على احتياجاتك.';
            faqAnswers[3].textContent = 'تختلف مدة الشحن حسب الوجهة ونوع الخدمة. عادة ما يستغرق الشحن العادي 5-10 أيام عمل، بينما يستغرق الشحن السريع 2-3 أيام عمل.';
            faqAnswers[4].textContent = 'يمكنك التواصل مع فريق الدعم الفني لدينا عبر البريد الإلكتروني أو الهاتف أو الدردشة المباشرة. نحن متاحون على مدار الساعة لمساعدتك.';
        }
    }
    
    
    function updateFAQForLTR() {
        const faqTitle = document.querySelector('.faq-title');
        const faqQuestions = document.querySelectorAll('.faq-question span');
        
        if (faqTitle) faqTitle.textContent = 'Frequently Asked Questions';
        
        // Update FAQ questions and answers 
        if (faqQuestions.length >= 5) {
            faqQuestions[0].textContent = 'What countries do your shipping services cover?';
            faqQuestions[1].textContent = 'How do I track my shipment?';
            faqQuestions[2].textContent = 'Do you provide insurance on shipments?';
            faqQuestions[3].textContent = 'What is the expected shipping duration?';
            faqQuestions[4].textContent = 'How can I contact technical support?';
        }
        
        // Update FAQ answers
        const faqAnswers = document.querySelectorAll('.faq-answer p');
        if (faqAnswers.length >= 5) {
            faqAnswers[0].textContent = 'We provide shipping services to over 150 countries worldwide. Our network includes major markets in Asia, Europe, Americas, and the Middle East.';
            faqAnswers[1].textContent = 'You can track your shipment in real-time using your tracking number on our platform. Simply log in to your account and navigate to the tracking section.';
            faqAnswers[2].textContent = 'Yes, we offer comprehensive insurance coverage for all shipments. You can choose from different coverage levels based on your needs.';
            faqAnswers[3].textContent = 'Shipping duration varies depending on the destination and service type. Standard shipping typically takes 5-10 business days, while express shipping takes 2-3 business days.';
            faqAnswers[4].textContent = 'You can reach our technical support team via email, phone, or live chat. We\'re available 24/7 to assist you with any questions or issues.';
        }
    }
    
    
    function updateFooterForRTL() {
        const ltrFooter = document.querySelector('.footer:not([dir="rtl"])');
        const rtlFooter = document.querySelector('.footer[dir="rtl"]');
        
        
        if (ltrFooter) ltrFooter.style.display = 'none';
        if (rtlFooter) rtlFooter.style.display = 'block';
    }
    
    
    function updateFooterForLTR() {
        const ltrFooter = document.querySelector('.footer:not([dir="rtl"])');
        const rtlFooter = document.querySelector('.footer[dir="rtl"]');
        
                if (ltrFooter) ltrFooter.style.display = 'block';
        if (rtlFooter) rtlFooter.style.display = 'none';
    }
    
    
    function initializeFooter() {
        if (document.documentElement.dir === 'rtl') {
            updateFooterForRTL();
        } else {
            updateFooterForLTR();
        }
    }
    
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    

    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function() {
            if (this.classList.contains('btn-primary') || this.classList.contains('sign-in-btn') || this.classList.contains('cta-button')) {
                const originalText = this.innerHTML;
                const originalDisabled = this.disabled;
                
                this.innerHTML = '<span>Loading...</span>';
                this.disabled = true;
                
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.disabled = originalDisabled;
                }, 2000);
            }
        });
    });
    
    
    initializeFooter();
});

// Function to switch between LTR and RTL 
function switchLanguage(locale) {
    const isRTL = locale === 'ar';
    
    // Set direction 
    document.body.dir = isRTL ? 'rtl' : 'ltr';
    document.documentElement.dir = isRTL ? 'rtl' : 'ltr';
    document.documentElement.lang = locale;
    
    // Update language button
    const langBtn = document.querySelector('.lang-btn');
    if (langBtn) {
        const langText = langBtn.querySelector('.lang-text');
        const langFlag = langBtn.querySelector('.lang-flag');
        
        if (isRTL) {
            langText.textContent = 'English';
            langFlag.textContent = '🇺🇸';
            updateTextForRTL();
            updateFAQForRTL();
            updateFooterForRTL();
        } else {
            langText.textContent = 'عربي';
            langFlag.textContent = '🇸🇦';
            updateTextForLTR();
            updateFAQForLTR();
            updateFooterForLTR();
        }
    }
}


window.switchLanguage = switchLanguage;
