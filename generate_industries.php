<?php
$index = file_get_contents('index.html');

// extract header and footer
$header_end = strpos($index, '<main class="relative">');
$header = substr($index, 0, $header_end);

$footer_start = strpos($index, '<!-- Footer -->');
$footer = substr($index, $footer_start);

// modify header and footer links to be absolute paths for the root
$header = str_replace('href="#', 'href="/#', $header);
$footer = str_replace('href="#', 'href="/#', $footer);

// create industry directory
if (!is_dir('industry')) {
    mkdir('industry', 0755, true);
}

// Define industries
$industries = [
    'e-commerce-and-retail.html' => [
        'title' => 'E-Commerce & Retail IT Solutions',
        'icon' => 'fas fa-shopping-cart',
        'subtitle' => 'Scalable Laravel Solutions for Online Retail',
        'description' => 'Transform your retail business with custom, high-performance E-Commerce platforms built on Laravel. We develop secure payment gateways, inventory management systems, and omnichannel shopping experiences.',
        'benefits' => [
            'Custom storefronts with advanced product filtering and search.',
            'Secure and PCI-compliant payment gateway integrations.',
            'Real-time inventory and supply chain management sync.',
            'High-converting checkout flows and cart abandonment recovery.'
        ]
    ],
    'healthcare-and-telemedicine.html' => [
        'title' => 'Healthcare & Telemedicine IT Solutions',
        'icon' => 'fas fa-heartbeat',
        'subtitle' => 'Secure & HIPAA-Compliant Medical Software',
        'description' => 'We build robust Laravel applications for the healthcare sector, including telemedicine platforms, patient portals, and clinic management systems, with a strict focus on data security and privacy.',
        'benefits' => [
            'HIPAA-compliant data architecture and secure patient records.',
            'Telemedicine video conferencing integrations (Zoom/Agora).',
            'Online appointment scheduling and doctor discovery.',
            'Automated prescription and billing management workflows.'
        ]
    ],
    'logistics-and-transportation.html' => [
        'title' => 'Logistics & Transportation Software',
        'icon' => 'fas fa-truck',
        'subtitle' => 'Fleet Management & Supply Chain Solutions',
        'description' => 'Optimize your supply chain with custom logistics software. We develop route optimization tools, real-time fleet tracking, and comprehensive warehouse management systems using Laravel.',
        'benefits' => [
            'Live GPS tracking and geofencing capabilities.',
            'Automated dispatching and route optimization algorithms.',
            'Comprehensive driver applications and delivery proof handling.',
            'Multi-carrier API integrations for automated shipping.'
        ]
    ],
    'real-estate-and-proptech.html' => [
        'title' => 'Real Estate & PropTech Solutions',
        'icon' => 'fas fa-building',
        'subtitle' => 'Property Management & Listing Platforms',
        'description' => 'Revolutionize the real estate market with dynamic property listing websites, CRM systems for agents, and comprehensive property management software built on scalable Laravel architecture.',
        'benefits' => [
            'Advanced property search with interactive map integrations.',
            'Automated lead generation and agent CRM workflows.',
            'Virtual tour integrations and high-resolution media galleries.',
            'Tenant portal and automated rent collection systems.'
        ]
    ],
    'fintech-and-banking.html' => [
        'title' => 'FinTech & Banking Software Development',
        'icon' => 'fas fa-wallet',
        'subtitle' => 'Secure Financial Applications & Wallets',
        'description' => 'Develop highly secure, lightning-fast financial applications. From digital wallets to complex lending platforms, our Laravel experts ensure compliance, encryption, and reliability.',
        'benefits' => [
            'Bank-grade security, encryption, and automated fraud detection.',
            'Custom digital wallets and secure payment processing.',
            'P2P lending platforms and crowdfunding portals.',
            'Automated KYC/AML verification integrations.'
        ]
    ],
    'edtech-and-elearning.html' => [
        'title' => 'EdTech & E-Learning Platforms',
        'icon' => 'fas fa-graduation-cap',
        'subtitle' => 'Custom Learning Management Systems (LMS)',
        'description' => 'Empower educators and students with custom LMS platforms. We build interactive video courses, quiz engines, and student progress tracking systems designed for scale.',
        'benefits' => [
            'Interactive video streaming and secure content delivery.',
            'Dynamic assessment engines and automated grading.',
            'Student progress dashboards and analytics.',
            'Subscription management and course monetization.'
        ]
    ],
    'travel-and-hospitality.html' => [
        'title' => 'Travel & Hospitality IT Solutions',
        'icon' => 'fas fa-plane',
        'subtitle' => 'Booking Engines & Hotel Management',
        'description' => 'Enhance the traveler experience with custom booking engines, itinerary planners, and hotel management systems. We integrate global GDS APIs and local payment gateways.',
        'benefits' => [
            'Real-time flight, hotel, and car rental booking engines.',
            'GDS (Global Distribution System) API integrations.',
            'Dynamic pricing and availability calendars.',
            'Automated customer itineraries and travel alerts.'
        ]
    ],
    'saas-and-startups.html' => [
        'title' => 'SaaS Development for Startups',
        'icon' => 'fas fa-rocket',
        'subtitle' => 'Scalable Multi-Tenant Architecture',
        'description' => 'Turn your idea into a profitable software product. We specialize in building robust, multi-tenant SaaS applications from MVP to enterprise scale using Laravel.',
        'benefits' => [
            'Secure multi-tenant database architecture.',
            'Automated subscription billing with Stripe/Braintree.',
            'Role-based access control and granular user permissions.',
            'High-performance API endpoints for mobile app support.'
        ]
    ]
];

foreach ($industries as $file => $data) {
    $title = $data['title'];
    $subtitle = $data['subtitle'];
    $desc = $data['description'];
    $icon = $data['icon'];
    
    $benefitsHtml = '';
    foreach ($data['benefits'] as $benefit) {
        $benefitsHtml .= "<li>{$benefit}</li>\n                ";
    }

    $shortTitle = str_replace([' IT Solutions', ' Software', ' Development', ' Platforms'], '', $title);

    $content = <<<HTML
<main class="relative pt-24 pb-16 min-h-[70vh] bg-gray-50">
    <!-- Hero / Intro Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-gray-500 hover:text-laravel-red transition-colors duration-300 text-xs font-semibold">
                        <i class="fas fa-home mr-2 text-[11px] text-gray-400"></i>
                        Home
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-1"></i>
                    <a href="/industries.html" class="inline-flex items-center text-gray-500 hover:text-laravel-red transition-colors duration-300 text-xs font-semibold">
                        Industries
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-1"></i>
                </li>
                <li aria-current="page" class="flex items-center">
                    <span class="inline-flex items-center bg-gradient-to-r from-laravel-red/10 to-laravel-orange/10 text-laravel-red px-3 py-1 rounded-full text-xs font-bold border border-laravel-red/20">
                        <i class="{$icon} mr-1.5 text-[10px]"></i>
                        {$shortTitle}
                    </span>
                </li>
            </ol>
        </nav>
        
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-6 border border-laravel-red/20">
                    <i class="{$icon} mr-2"></i>
                    <span class="text-sm font-semibold tracking-wide uppercase">Industry Expertise</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {$title}
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {$desc}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/#contact" class="inline-flex justify-center items-center bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Discuss Your Project
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 border-t-4 border-laravel-red relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-laravel-orange/10 to-transparent rounded-bl-full"></div>
                <h2 class="text-2xl font-bold mb-6 text-gray-900 relative z-10">{$subtitle}</h2>
                <h3 class="text-lg font-semibold mb-4 text-laravel-red relative z-10">Industry Specific Solutions</h3>
                <ul class="space-y-4 text-gray-700 relative z-10">
                    {$benefitsHtml}
                </ul>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="bg-white py-20 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Development Process</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">A proven, systematic approach to ensure your {$shortTitle} application is secure, scalable, and deployed successfully.</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -z-10 -translate-y-1/2"></div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Discovery</h3>
                    <p class="text-gray-600 text-sm">We analyze your business requirements and map out technical architecture specific to {$shortTitle}.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Development</h3>
                    <p class="text-gray-600 text-sm">Our Laravel experts write clean, scalable code tailored to handle high traffic and complex logic.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Testing</h3>
                    <p class="text-gray-600 text-sm">Rigorous QA testing, security audits, and load testing ensure the application is completely stable.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deployment</h3>
                    <p class="text-gray-600 text-sm">We securely push the project to production and provide ongoing maintenance.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us / CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gray-900 rounded-3xl overflow-hidden shadow-2xl relative">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-gradient-to-br from-laravel-red/30 to-laravel-orange/30 rounded-full blur-3xl"></div>
            
            <div class="grid lg:grid-cols-5 gap-0 items-stretch">
                <div class="lg:col-span-3 p-10 lg:p-16 relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Why Partner With Laravel Experts Kolkata?</h2>
                    <div class="space-y-6 text-gray-300">
                        <p class="text-lg">
                            Building a solution for the <strong>{$shortTitle}</strong> industry requires a deep understanding of Laravel's architecture, queue systems, and security best practices.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>10+ Years of Specialization:</strong> We exclusively work with the Laravel ecosystem.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Enterprise-Grade Security:</strong> Strict adherence to data protection and compliance.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Performance Optimized:</strong> We utilize Laravel Horizon and modern cloud architecture for speed.</span></li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-gradient-to-br from-laravel-red to-laravel-orange p-10 lg:p-16 text-center lg:text-left text-white h-full flex flex-col justify-center items-center lg:items-start relative z-10">
                    <h3 class="text-2xl font-bold mb-4">Ready to Build?</h3>
                    <p class="mb-8 opacity-90">Get a free technical consultation for your {$shortTitle} project.</p>
                    <a href="/#contact" class="bg-white text-laravel-red px-8 py-3 rounded-full font-bold hover:shadow-lg transform hover:scale-105 transition duration-300 whitespace-nowrap">
                        Contact Our Experts
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
HTML;

    $html = $header . $content . "\n" . $footer;
    // update title tag
    $html = preg_replace('/<title>.*?<\/title>/', "<title>{$title} - Laravel Experts Kolkata</title>", $html);
    
    // SEO Update: update canonical and hreflang links to point to this subpage
    $html = str_replace(
        'href="https://laravelkolkata.com"',
        "href=\"https://laravelkolkata.com/industry/{$file}\"",
        $html
    );
    // SEO Update: update og:url
    $html = str_replace(
        '<meta property="og:url" content="https://laravelkolkata.com">',
        "<meta property=\"og:url\" content=\"https://laravelkolkata.com/industry/{$file}\">",
        $html
    );
    
    file_put_contents('industry/' . $file, $html);
}
echo "Created " . count($industries) . " customized industry pages.\n";

// Generate industries.html
$cardsHtml = '';
foreach ($industries as $file => $data) {
    $shortTitle = str_replace([' IT Solutions', ' Software', ' Development', ' Platforms'], '', $data['title']);
    $cardsHtml .= <<<HTML
            <a href="/industry/{$file}" class="group flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-laravel-red/30 transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 flex flex-col flex-grow">
                    <div class="w-12 h-12 bg-laravel-red/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-laravel-red transition-colors duration-300 shrink-0">
                        <i class="{$data['icon']} text-laravel-red group-hover:text-white transition-colors duration-300 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-laravel-red transition-colors duration-300">{$shortTitle}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-6">{$data['subtitle']}</p>
                    <div class="mt-auto flex items-center text-laravel-red text-sm font-semibold pt-2">
                        View Solutions <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </div>
                </div>
            </a>
HTML;
}

$industriesContent = <<<HTML
<div class="bg-gray-50/60 pt-28 pb-4 border-b border-gray-100/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2 bg-white px-4 py-2 rounded-full border border-gray-100 shadow-sm">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center text-gray-500 hover:text-laravel-red transition-colors duration-300 text-xs font-semibold">
                        <i class="fas fa-home mr-2 text-[11px] text-gray-400"></i>
                        Home
                    </a>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-1"></i>
                </li>
                <li aria-current="page" class="flex items-center">
                    <span class="inline-flex items-center bg-gradient-to-r from-laravel-red/10 to-laravel-orange/10 text-laravel-red px-3 py-1 rounded-full text-xs font-bold border border-laravel-red/20">
                        <i class="fas fa-building mr-1.5 text-[10px]"></i>
                        Industries
                    </span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<main class="relative py-20 bg-gray-50 border-t border-gray-200 min-h-[70vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-4 border border-laravel-red/20">
                <span class="text-sm font-semibold tracking-wide uppercase">Domains We Serve</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Industries We Empower</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Discover our specialized Laravel development solutions tailored for various industry verticals. From robust FinTech platforms to engaging E-Commerce storefronts.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
{$cardsHtml}
        </div>
    </div>
    <!-- CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gray-900 rounded-3xl overflow-hidden shadow-2xl relative">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-gradient-to-br from-laravel-red/30 to-laravel-orange/30 rounded-full blur-3xl"></div>
            
            <div class="grid lg:grid-cols-5 gap-0 items-stretch">
                <div class="lg:col-span-3 p-10 lg:p-16 relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Why Partner With Laravel Experts Kolkata?</h2>
                    <div class="space-y-6 text-gray-300">
                        <p class="text-lg">
                            Building industry-specific solutions requires more than generic templates. It requires a deep understanding of Laravel's architecture, security standards, and high-performance databases.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>10+ Years of Specialization:</strong> We exclusively work with the Laravel ecosystem.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Enterprise-Grade Security:</strong> Strict adherence to compliance, encryption, and data protection.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Performance Optimized:</strong> Scalable cloud deployments with Redis caching and Horizon queues.</span></li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-gradient-to-br from-laravel-red to-laravel-orange p-10 lg:p-16 text-center lg:text-left text-white h-full flex flex-col justify-center items-center lg:items-start relative z-10">
                    <h3 class="text-2xl font-bold mb-4">Ready to Build?</h3>
                    <p class="mb-8 opacity-90">Get a free technical consultation and architecture proposal for your project.</p>
                    <a href="/#contact" class="bg-white text-laravel-red px-8 py-3 rounded-full font-bold hover:shadow-lg transform hover:scale-105 transition duration-300 whitespace-nowrap">
                        Contact Our Experts
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
HTML;

$industriesPageHtml = $header . $industriesContent . "\n" . $footer;
$industriesPageHtml = preg_replace('/<title>.*?<\/title>/', "<title>Industries We Serve - Laravel Experts Kolkata</title>", $industriesPageHtml);

// SEO Update: update canonical and hreflang links to point to this directory page
$industriesPageHtml = str_replace(
    'href="https://laravelkolkata.com"',
    'href="https://laravelkolkata.com/industries.html"',
    $industriesPageHtml
);
// SEO Update: update og:url
$industriesPageHtml = str_replace(
    '<meta property="og:url" content="https://laravelkolkata.com">',
    '<meta property="og:url" content="https://laravelkolkata.com/industries.html">',
    $industriesPageHtml
);

file_put_contents('industries.html', $industriesPageHtml);

echo "Created industries.html directory page.\n";
