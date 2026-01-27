<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => [
                    'ar' => 'ما هي منصة Exports Valley؟',
                    'en' => 'What is Exports Valley platform?',
                ],
                'answer' => [
                    'ar' => 'منصة Exports Valley هي منصة تجارة إلكترونية B2B متكاملة تهدف إلى تمكين الصادرات السعودية وربط المصانع المحلية بالمشترين الدوليين عبر حل رقمي احترافي لإدارة عمليات التصدير.',
                    'en' => 'Exports Valley is an integrated B2B e-commerce platform aimed at empowering Saudi exports and connecting local factories with international buyers through a professional digital solution for managing export operations.',
                ],
                'order' => 1,
            ],
            [
                'question' => [
                    'ar' => 'كيف تساعد Exports Valley في التصدير من السعودية؟',
                    'en' => 'How does Exports Valley help with exporting from Saudi Arabia?',
                ],
                'answer' => [
                    'ar' => 'تساعد Exports Valley في التصدير من السعودية من خلال إنشاء متجر إلكتروني مخصص للمصنع، وإدارة المنتجات، وتحسين الظهور العالمي، وتسهيل التواصل المباشر مع المشترين الدوليين.',
                    'en' => 'Exports Valley helps with exporting from Saudi Arabia by creating a dedicated online store for factories, managing products, improving global visibility, and facilitating direct communication with international buyers.',
                ],
                'order' => 2,
            ],
            [
                'question' => [
                    'ar' => 'ما هي خدمات منصة Exports Valley للمصانع السعودية؟',
                    'en' => 'What services does Exports Valley offer to Saudi factories?',
                ],
                'answer' => [
                    'ar' => 'تقدم منصة Exports Valley للمصانع السعودية خدمات تشمل: إنشاء متجر إلكتروني للتصدير، إدارة المنتجات والكتالوجات، تحسين محركات البحث (SEO) عالميًا، استقبال طلبات عروض الأسعار (RFQ)، التواصل المباشر مع المشترين.',
                    'en' => 'Exports Valley offers Saudi factories services including: creating an online export store, managing products and catalogs, global SEO optimization, receiving RFQ requests, and direct communication with buyers.',
                ],
                'order' => 3,
            ],
            [
                'question' => [
                    'ar' => 'هل منصة Exports Valley مناسبة للتجارة الإلكترونية B2B؟',
                    'en' => 'Is Exports Valley suitable for B2B e-commerce?',
                ],
                'answer' => [
                    'ar' => 'نعم، تم تصميم Exports Valley كتجارة إلكترونية B2B مخصصة لقطاع التصدير، مع أدوات احترافية لإدارة المبيعات، التفاوض، وتتبع الأداء.',
                    'en' => 'Yes, Exports Valley is designed as a B2B e-commerce platform dedicated to the export sector, with professional tools for sales management, negotiation, and performance tracking.',
                ],
                'order' => 4,
            ],
            [
                'question' => [
                    'ar' => 'كيف تساهم Exports Valley في تحقيق رؤية السعودية 2030؟',
                    'en' => 'How does Exports Valley contribute to Saudi Vision 2030?',
                ],
                'answer' => [
                    'ar' => 'تدعم Exports Valley رؤية 2030 عبر: تمكين المصانع السعودية من الوصول للأسواق العالمية، زيادة الصادرات غير النفطية، تعزيز الحضور العالمي للمنتج السعودي.',
                    'en' => 'Exports Valley supports Vision 2030 through: enabling Saudi factories to reach global markets, increasing non-oil exports, and enhancing the global presence of Saudi products.',
                ],
                'order' => 5,
            ],
            [
                'question' => [
                    'ar' => 'هل توفر Exports Valley تحسين محركات البحث (SEO)؟',
                    'en' => 'Does Exports Valley provide SEO optimization?',
                ],
                'answer' => [
                    'ar' => 'نعم، توفر Exports Valley تحسين محركات البحث SEO للمتاجر والمنتجات، مما يساعد على ظهور المصنع في نتائج البحث العالمية وزيادة فرص الوصول إلى المشترين الدوليين.',
                    'en' => 'Yes, Exports Valley provides SEO optimization for stores and products, helping factories appear in global search results and increasing opportunities to reach international buyers.',
                ],
                'order' => 6,
            ],
            [
                'question' => [
                    'ar' => 'ما هو نظام إدارة المنتجات في Exports Valley؟',
                    'en' => 'What is the product management system in Exports Valley?',
                ],
                'answer' => [
                    'ar' => 'يتيح نظام إدارة المنتجات في Exports Valley: إضافة حتى 200 منتج، رفع حتى 25 كتالوج احترافي، تنظيم بيانات المنتجات للتصدير، تسهيل تحديث المحتوى بشكل مرن.',
                    'en' => 'The product management system in Exports Valley allows: adding up to 200 products, uploading up to 25 professional catalogs, organizing product data for export, and facilitating flexible content updates.',
                ],
                'order' => 7,
            ],
            [
                'question' => [
                    'ar' => 'كيف يتم التواصل مع المشترين عبر Exports Valley؟',
                    'en' => 'How do you communicate with buyers through Exports Valley?',
                ],
                'answer' => [
                    'ar' => 'توفر المنصة نظام تواصل مباشر مع المشترين الدوليين داخل المنصة، مع رسائل آمنة وفورية دون وسطاء، مما يقلل مدة دورة المبيعات.',
                    'en' => 'The platform provides a direct communication system with international buyers within the platform, with secure and instant messaging without intermediaries, reducing the sales cycle duration.',
                ],
                'order' => 8,
            ],
            [
                'question' => [
                    'ar' => 'ما هي ميزة عروض الأسعار (RFQ) في Exports Valley؟',
                    'en' => 'What is the RFQ feature in Exports Valley?',
                ],
                'answer' => [
                    'ar' => 'ميزة RFQ في Exports Valley تمنح المصانع أولوية في استقبال والرد على طلبات عروض الأسعار، مما يزيد فرص التحويل وتحقيق الصفقات.',
                    'en' => 'The RFQ feature in Exports Valley gives factories priority in receiving and responding to quote requests, increasing conversion opportunities and deal closure.',
                ],
                'order' => 9,
            ],
            [
                'question' => [
                    'ar' => 'هل توفر Exports Valley تقارير وتحليلات أداء؟',
                    'en' => 'Does Exports Valley provide performance reports and analytics?',
                ],
                'answer' => [
                    'ar' => 'نعم، توفر Exports Valley تقارير وتحليلات أداء تشمل: إحصائيات الزيارات، معدلات التفاعل، مؤشرات الأداء (KPIs)، دعم اتخاذ القرار المبني على البيانات.',
                    'en' => 'Yes, Exports Valley provides performance reports and analytics including: visit statistics, engagement rates, KPIs, and data-driven decision-making support.',
                ],
                'order' => 10,
            ],
            [
                'question' => [
                    'ar' => 'لمن تناسب منصة Exports Valley؟',
                    'en' => 'Who is Exports Valley suitable for?',
                ],
                'answer' => [
                    'ar' => 'تناسب Exports Valley: المصانع السعودية، الشركات المصدّرة، العلامات التجارية الراغبة بالتوسع عالميًا، الشركات الباحثة عن حلول تصدير رقمية.',
                    'en' => 'Exports Valley is suitable for: Saudi factories, exporting companies, brands seeking global expansion, and companies looking for digital export solutions.',
                ],
                'order' => 11,
            ],
            [
                'question' => [
                    'ar' => 'كيف أبدأ باستخدام منصة Exports Valley؟',
                    'en' => 'How do I start using Exports Valley platform?',
                ],
                'answer' => [
                    'ar' => 'يمكنك البدء عبر تسجيل مصنعك في منصة Exports Valley، ثم إنشاء المتجر الإلكتروني، إضافة المنتجات، والبدء في التواصل مع المشترين حول العالم.',
                    'en' => 'You can start by registering your factory on Exports Valley platform, then creating your online store, adding products, and beginning communication with buyers around the world.',
                ],
                'order' => 12,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
