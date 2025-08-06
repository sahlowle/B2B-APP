// DOM Elements
const factorySignupBtns = document.querySelectorAll('#factorySignup, button[id="factorySignup"]');
const importerSignupBtns = document.querySelectorAll('#importerSignup, button[id="importerSignup"]');
const factoryModal = document.getElementById('factoryModal');
const importerModal = document.getElementById('importerModal');
const modalBackdrop = document.querySelector('.modal-backdrop');
const modalCloses = document.querySelectorAll('.modal-close');
const tabBtns = document.querySelectorAll('.tab-btn');
const tabContents = document.querySelectorAll('.tab-content');
const langToggle = document.getElementById('langToggle');
const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
const navMenu = document.querySelector('.nav-menu');

// Modal Functions
function openModal(modal) {
    modal.classList.add('show');
    modalBackdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    factoryModal.classList.remove('show');
    importerModal.classList.remove('show');
    modalBackdrop.classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Event Listeners for Factory Signup
factorySignupBtns.forEach(btn => {
    btn.addEventListener('click', () => openModal(factoryModal));
});

// Event Listeners for Importer Signup  
importerSignupBtns.forEach(btn => {
    btn.addEventListener('click', () => openModal(importerModal));
});

// Event Listeners for CTA buttons
document.addEventListener('click', (e) => {
    if (e.target.textContent.includes('تسجيل مصنع جديد')) {
        openModal(factoryModal);
    } else if (e.target.textContent.includes('تسجيل مستورد جديد')) {
        openModal(importerModal);
    }
});

// Close Modal Events
modalCloses.forEach(close => {
    close.addEventListener('click', closeModal);
});

modalBackdrop.addEventListener('click', closeModal);

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeModal();
    }
});

// Tab Functionality
tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        const targetTab = btn.getAttribute('data-tab');
        
        // Remove active class from all tabs and contents
        tabBtns.forEach(tab => tab.classList.remove('active'));
        tabContents.forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked tab
        btn.classList.add('active');
        
        // Show corresponding content
        const targetContent = document.getElementById(`${targetTab}-process`);
        if (targetContent) {
            targetContent.classList.add('active');
        }
    });
});

// Language Toggle
langToggle.addEventListener('click', () => {
    const currentLang = document.documentElement.getAttribute('lang');
    if (currentLang === 'ar') {
        // Switch to English
        document.documentElement.setAttribute('lang', 'en');
        document.documentElement.setAttribute('dir', 'ltr');
        langToggle.textContent = 'AR';
        
        // Here you would typically load English translations
        updateLanguage('en');
    } else {
        // Switch to Arabic
        document.documentElement.setAttribute('lang', 'ar');
        document.documentElement.setAttribute('dir', 'rtl');
        langToggle.textContent = 'EN';
        
        // Here you would typically load Arabic translations
        updateLanguage('ar');
    }
});

// Mobile Menu Toggle
mobileMenuToggle.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    mobileMenuToggle.classList.toggle('active');
});

// Statistics Counter Animation
function animateCounters() {
    const counters = document.querySelectorAll('.stat-number');
    
    counters.forEach(counter => {
        var target = parseInt(counter.getAttribute('data-target'));

        if (isNaN(target)) {
            return;
        }
        
        const duration = 2000; // 2 seconds
        const increment = target / (duration / 16); // 60fps
        let current = 0;
        
        const updateCounter = () => {
            current += increment;
            if (current < target) {
                counter.textContent = Math.floor(current).toLocaleString('ar-SA');
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target.toLocaleString('ar-SA');
            }
        };
        
        updateCounter();
    });
}

// Intersection Observer for animations
const observerOptions = {
    threshold: 0.3,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            if (entry.target.classList.contains('stats')) {
                animateCounters();
            }
            
            // Add animation classes
            const animatedElements = entry.target.querySelectorAll('.feature-card, .step, .stat-card');
            animatedElements.forEach((el, index) => {
                setTimeout(() => {
                    el.style.animationDelay = `${index * 0.1}s`;
                    el.classList.add('animate-in');
                }, index * 100);
            });
        }
    });
}, observerOptions);

// Observe sections for animations
document.addEventListener('DOMContentLoaded', () => {
    const sectionsToObserve = document.querySelectorAll('.features, .how-it-works, .stats');
    sectionsToObserve.forEach(section => {
        observer.observe(section);
    });
});

// Smooth scroll for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            const headerHeight = document.querySelector('.header').offsetHeight;
            const targetPosition = target.offsetTop - headerHeight - 20;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.98)';
        header.style.borderBottomColor = 'var(--gray-300)';
    } else {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.borderBottomColor = 'var(--gray-200)';
    }
});

// Form Submissions
document.querySelectorAll('.signup-form').forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Get form data
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        
        // Simulate form submission
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.textContent;
        
        submitBtn.textContent = 'جاري التسجيل...';
        submitBtn.disabled = true;
        
        setTimeout(() => {
            submitBtn.textContent = 'تم التسجيل بنجاح ✓';
            submitBtn.style.background = 'var(--success-color)';
            
            setTimeout(() => {
                closeModal();
                form.reset();
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.style.background = '';
            }, 2000);
        }, 2000);
    });
});

// Language Updates (placeholder for actual translations)
function updateLanguage(lang) {
    // This would typically connect to a translation service
    // For now, it's a placeholder for the language switching functionality
    console.log(`Switched to language: ${lang}`);
    
    // You could implement actual translations here
    // Example:
    // const translations = {
    //     ar: { /* Arabic translations */ },
    //     en: { /* English translations */ }
    // };
}

// Add loading animation to buttons
document.querySelectorAll('.btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        // Create ripple effect
        const ripple = document.createElement('span');
        const rect = this.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = e.clientX - rect.left - size / 2;
        const y = e.clientY - rect.top - size / 2;
        
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
        ripple.classList.add('ripple');
        
        this.appendChild(ripple);
        
        setTimeout(() => {
            ripple.remove();
        }, 600);
    });
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .btn {
        position: relative;
        overflow: hidden;
    }
    
    .ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        transform: scale(0);
        animation: ripple-animation 0.6s linear;
        pointer-events: none;
    }
    
    @keyframes ripple-animation {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    @media (max-width: 768px) {
        .nav-menu {
            position: fixed;
            top: 100%;
            right: 0;
            left: 0;
            background: white;
            flex-direction: column;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            transform: translateY(-100%);
            transition: var(--transition);
            z-index: 999;
        }
        
        .nav-menu.active {
            transform: translateY(0);
        }
        
        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        
        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -6px);
        }
    }
`;
document.head.appendChild(style);

// Parallax effect for hero section
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const hero = document.querySelector('.hero-bg');
    if (hero) {
        hero.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Initialize AOS (Animate On Scroll) alternative
document.addEventListener('DOMContentLoaded', () => {
    // Add animation classes to elements
    const animatedElements = document.querySelectorAll('.feature-card, .step, .stat-card');
    animatedElements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease-out';
    });
});

console.log('B2B E-commerce Platform Loaded Successfully! 🚀');
