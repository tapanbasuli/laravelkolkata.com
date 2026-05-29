<?php
$index = file_get_contents(__DIR__ . '/../index.html');

// extract header and footer
$header_end = strpos($index, '<main class="relative">');
$header = substr($index, 0, $header_end);

$footer_start = strpos($index, '<!-- Footer -->');
$footer = substr($index, $footer_start);

// modify header and footer links to be absolute paths for the root
$header = str_replace('href="#', 'href="/#', $header);
$footer = str_replace('href="#', 'href="/#', $footer);

// create location directory
if (!is_dir(__DIR__ . '/../location')) {
    mkdir(__DIR__ . '/../location', 0755, true);
}

// 1. Define technologies
$technologies = [
    'laravel' => [
        'name' => 'Laravel',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-laravel',
        'subtitle' => 'Enterprise Web Applications & Dedicated Teams',
        'desc' => 'Scale your business with expert Laravel backend architecture, secure API integrations, optimized databases, and robust task queues.',
        'benefits' => [
            'Robust MVC architecture for clean and maintainable codebases.',
            'Enterprise security features including built-in CSRF, XSS, and SQL injection defense.',
            'Advanced caching (Redis), job queues, and scheduled tasks.',
            'Seamless Eloquent ORM for optimized database interactions.'
        ],
        'faqs' => [
            'How do you optimize Laravel database performance?' => 'We implement eager loading, query caching, indexing on critical columns, and setup master-slave database replication for high-load environments.',
            'What Laravel versions do you work with?' => 'We support and build on all active Laravel versions, including Laravel 10, 11, and the early-adoption features of Laravel 12 and 13.'
        ]
    ],
    'livewire' => [
        'name' => 'Livewire',
        'title_suffix' => 'Development Services',
        'icon' => 'fas fa-bolt',
        'subtitle' => 'Reactive, Server-Rendered UI Components',
        'desc' => 'Build highly interactive, real-time frontend interfaces without leaving the comfort of Laravel, reducing JavaScript overhead and speed constraints.',
        'benefits' => [
            'Interactive and dynamic components without the overhead of heavy JS frameworks.',
            'SEO-friendly, server-side rendering for optimal indexability.',
            'Seamless connection with Laravel validation and state handling.',
            'Faster development timelines by staying in PHP/Blade context.'
        ],
        'faqs' => [
            'Is Livewire SEO-friendly?' => 'Yes! Unlike single-page applications that render completely on the client, Livewire renders HTML on the server first, making it 100% crawlable by Google.',
            'Can Livewire handle complex UI interactions?' => 'Absolutely. For highly complex elements, Livewire integrates seamlessly with Alpine.js, giving you reactive frontend speed without leaving the Laravel ecosystem.'
        ]
    ],
    'filamentphp' => [
        'name' => 'FilamentPHP',
        'title_suffix' => 'Development Services',
        'icon' => 'fas fa-desktop',
        'subtitle' => 'Beautiful, TALL-Stack Admin Panels & CRMs',
        'desc' => 'Build lightning-fast content management portals, custom CRMs, and backend administration panels with structured TALL-stack workflows.',
        'benefits' => [
            'Rapid deployment of administrative dashboards, forms, and data tables.',
            'Custom metrics, analytical charts, and real-time dashboard widgets.',
            'Fine-grained role-based access control (RBAC) and permissions.',
            'Sleek Tailwind-based design matching your custom themes.'
        ],
        'faqs' => [
            'Can we use FilamentPHP for public-facing portals?' => 'Yes, Filament is highly extensible. While excellent for admin panels, it is often used to build customer portals, billing areas, and membership directories.',
            'Does Filament support translation and localization?' => 'Yes, Filament has full multi-lingual support, allowing us to configure admin interfaces in English, German, Arabic (RTL), and more.'
        ]
    ],
    'node-js' => [
        'name' => 'Node.js',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-node-js',
        'subtitle' => 'Scalable Server-Side JS & Real-Time APIs',
        'desc' => 'Power your digital systems with asynchronous Node.js backends, high-concurrency microservices, and rapid API gateways.',
        'benefits' => [
            'Asynchronous, event-driven architecture built for high concurrency.',
            'Real-time data synchronization using WebSockets (Socket.io).',
            'Fast-running API response times powered by the V8 Engine.',
            'Unified full-stack JavaScript environment across client and server.'
        ],
        'faqs' => [
            'When should we choose Node.js over PHP?' => 'Node.js is ideal for real-time applications (chat apps, gaming, collaborative tools), serverless microservices, and applications requiring high-concurrency connections.',
            'How do you secure Node.js APIs?' => 'We implement JSON Web Tokens (JWT), rate-limiting, Helmet middleware headers, input sanitization, and continuous dependency vulnerability scanning.'
        ]
    ],
    'python' => [
        'name' => 'Python',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-python',
        'subtitle' => 'AI Integrations, Data Science & Backends',
        'desc' => 'Leverage Python for machine learning pipelines, LLM fine-tuning, large-scale data processing, and custom automation backends.',
        'benefits' => [
            'Integration of advanced AI models, LLMs, and machine learning pipelines.',
            'Clean, readable syntax optimized for long-term codebase maintenance.',
            'Robust data processing, web scraping, and automation scripts.',
            'Wide array of open-source libraries for scientific computation.'
        ],
        'faqs' => [
            'Can you connect Python AI scripts with a Laravel site?' => 'Yes, we specialize in building hybrid systems where a Laravel web platform communicates with a Python-based AI microservice via REST APIs or gRPC.',
            'What Python libraries do you use for AI?' => 'We work with PyTorch, TensorFlow, Scikit-Learn, Pandas, LangChain, and coordinate API connections with OpenAI, Claude, and HuggingFace models.'
        ]
    ],
    'fast-api' => [
        'name' => 'FastAPI',
        'title_suffix' => 'Development Services',
        'icon' => 'fas fa-bolt',
        'subtitle' => 'Lightning-Fast Python REST & Async APIs',
        'desc' => 'Build high-performance, asynchronous RESTful APIs using Python\'s type hints and automatic Swagger generation.',
        'benefits' => [
            'Extremely high response speed, on par with NodeJS and Go.',
            'Self-documenting interactive API layouts (Swagger UI & ReDoc).',
            'Built-in data validation using Pydantic schemas.',
            'Native support for asynchronous and concurrent python scripts.'
        ],
        'faqs' => [
            'Why use FastAPI instead of Flask?' => 'FastAPI offers vastly superior execution speed, supports async/await natively, performs automatic validation of incoming payloads, and generates interactive docs out-of-the-box.',
            'Does FastAPI support vector search integration?' => 'Yes, we frequently build FastAPI endpoints that interface with pgvector, Qdrant, or Pinecone databases to power AI search and semantic engines.'
        ]
    ],
    'django' => [
        'name' => 'Django',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-python',
        'subtitle' => 'Secure, Rapid Enterprise Python Web Apps',
        'desc' => 'Create robust, secure, and data-heavy enterprise web applications rapidly using Django\'s batteries-included framework.',
        'benefits' => [
            '"Batteries-included" framework with robust built-in admin panels.',
            'Secure-by-default features protecting from common web exploits.',
            'Highly scalable structure suitable for large data models and analytics.',
            'Powerful Django ORM for flexible SQL query builds.'
        ],
        'faqs' => [
            'Is Django suitable for high-traffic platforms?' => 'Yes, major platforms like Instagram and Pinterest use Django. With proper caching (Redis) and database load-balancing, Django scales seamlessly to millions of users.',
            'Do you build REST APIs with Django?' => 'Yes, we use the Django REST Framework (DRF) to build secure, robust, and clean RESTful APIs for web and mobile clients.'
        ]
    ],
    'react-js' => [
        'name' => 'React.js',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-react',
        'subtitle' => 'Dynamic Single Page Apps & Component Libraries',
        'desc' => 'Deliver premium client experiences with responsive React interfaces, component-based reuse, and rich browser transitions.',
        'benefits' => [
            'Component-based structure allowing high UI reusability.',
            'Virtual DOM updates for lightning-fast rendering of interactive views.',
            'State management solutions (Redux/Context API) for complex client workflows.',
            'Huge ecosystem of open-source UI libraries and plugins.'
        ],
        'faqs' => [
            'Can React be integrated with a Laravel backend?' => 'Absolutely. We build headless applications where React (via Inertia.js or a standalone SPA) consumes APIs served from a secure Laravel backend.',
            'How do you manage state in large React apps?' => 'We utilize clean state architectures using React Context, Redux Toolkit, or Zustand, depending on the complexity of the application.'
        ]
    ],
    'next-js' => [
        'name' => 'Next.js',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-react',
        'subtitle' => 'SEO-Optimized React Clients & SSR Platforms',
        'desc' => 'Combine React\'s interactive layouts with Server-Side Rendering (SSR) and Static Site Generation (SSG) for ideal loading speeds and Google search index ranks.',
        'benefits' => [
            'Server-side rendering (SSR) and static generation (SSG) for ideal SEO rankings.',
            'Optimized image loading, script execution, and Core Web Vitals.',
            'File-based routing with API endpoints built-in.',
            'Fast refresh rates improving developer experience and release velocity.'
        ],
        'faqs' => [
            'How does Next.js improve SEO compared to standard React?' => 'Standard React renders on the client, which can delay crawler indexing. Next.js prerenders pages on the server, serving fully populated HTML to search engine bots instantly.',
            'What deployment platforms do you use for Next.js?' => 'We deploy Next.js apps on Vercel, AWS Amplify, or configure customized node-based deployments on secure VPS platforms.'
        ]
    ],
    'wordpress' => [
        'name' => 'WordPress',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-wordpress',
        'subtitle' => 'High-Performance Custom CMS & Blog Themes',
        'desc' => 'Launch modern corporate websites, custom blogs, and responsive marketing sites using bespoke WordPress theme and plugin development.',
        'benefits' => [
            'Fully custom theme design tailored to match corporate brand guidelines.',
            'Bespoke plugin engineering and third-party API connectivity.',
            'Intuitive Gutenberg block editor customized for page admins.',
            'Search engine optimized layouts with high loading speeds.'
        ],
        'faqs' => [
            'Do you use pre-made templates or build custom themes?' => 'We build custom Gutenberg themes from scratch, ensuring clean code, zero template bloat, and maximum page speeds (90+ Google PageSpeed scores).',
            'How do you keep WordPress secure?' => 'We implement custom security configurations, disable file editors, implement 2FA, configure firewalls (like Wordfence), and schedule weekly security updates.'
        ]
    ],
    'shopify' => [
        'name' => 'Shopify',
        'title_suffix' => 'Development Services',
        'icon' => 'fab fa-shopify',
        'subtitle' => 'Custom Liquid Stores & Headless E-Commerce APIs',
        'desc' => 'Scale your e-commerce store with custom Liquid theme layouts, public/private Shopify app creations, and headless Shopify integrations.',
        'benefits' => [
            'Custom Liquid theme development for high-converting storefronts.',
            'Headless commerce setups using Shopify Storefront GraphQL APIs.',
            'Inventory, shipping, and payment gateway automation.',
            'Adherence to Shopify app store standards and security policies.'
        ],
        'faqs' => [
            'What is Headless Shopify?' => 'It separates your frontend (built in Next.js or React) from Shopify\'s backend. The frontend queries Shopify via GraphQL APIs, providing custom design flexibility and fast load times.',
            'Can you build custom Shopify Apps?' => 'Yes! We build custom private and public Shopify apps using Laravel and Shopify\'s App Bridge SDK to extend your store\'s functions.'
        ]
    ],
    'nova-admin' => [
        'name' => 'Laravel Nova',
        'title_suffix' => 'Integration Services',
        'icon' => 'fas fa-star',
        'subtitle' => 'Official Laravel Admin Dashboard Integration',
        'desc' => 'Implement and customize Laravel Nova to give your team complete control over your application\'s database and data insights with a stunning official admin panel.',
        'benefits' => [
            'Deep, native integration with Laravel Eloquent models.',
            'Custom metrics, lenses, and filters for real-time business intelligence.',
            'Flexible resource management with advanced field types.',
            'Secure action execution and authorization gates using policies.'
        ],
        'faqs' => [
            'Can we customize Laravel Nova\'s dashboard?' => 'Yes, we can build custom cards, custom fields, custom tools, and write custom resource actions to match your operational workflows.',
            'Is a commercial license required for Laravel Nova?' => 'Yes, Laravel Nova requires a license key from the Laravel team. We can assist you in selecting and configuring the correct license for your project.'
        ]
    ]
];

// 2. Define locations
$locations = [
    'india' => [
        'name' => 'India',
        'icon' => 'fas fa-globe-asia',
        'outsource_desc' => 'Scale your technical capacity with India\'s top developers, cost-effective sprint cycles, and timezone-aligned scrum teams.',
        'benefits' => [
            'Access to regional top-tier software engineers and TALL stack experts.',
            'Up to 60% development budget arbitrage with zero code quality compromise.',
            'Flexible models including hourly contracts, fixed-price sprints, or monthly retainers.',
            'Timezone alignment for daily reviews, standups, and direct Slack communication.'
        ],
        'faqs' => [
            'Why outsource development to India?' => 'Outsourcing to India provides access to a massive technical talent pool with exceptional English communications and agile credentials, helping you scale production budgets efficiently.',
            'How do we manage coordination and timeline sync?' => 'Our team coordinates daily meetings, updates tasks in Jira or Trello, and schedules reviews during overlapping windows of your business day.'
        ]
    ],
    'usa' => [
        'name' => 'USA',
        'icon' => 'fas fa-globe-americas',
        'outsource_desc' => 'Empower your US enterprise, tech startup, or agency with premier offshore developers, strict NDAs, and overlapping working hours.',
        'benefits' => [
            'Substantial cost arbitrage, allowing you to double your sprint team capacity.',
            'Aligned timezone scheduling (EST and PST overlap) for live collaboration.',
            'IP protection protocols, NDAs, and robust contracts in compliance with US legal frameworks.',
            'Deep experience with US SaaS models, payment systems, and startup MVPs.'
        ],
        'faqs' => [
            'Are our source codes and business secrets legally protected?' => 'Yes. We sign strict US-compliant Non-Disclosure Agreements (NDAs) before reviewing project code or specifications to ensure complete IP security.',
            'What billing structures do you support for US companies?' => 'We bill in USD and support wire transfers, credit card processing, and milestone-based payments with transparent invoicing.'
        ]
    ],
    'uk' => [
        'name' => 'UK',
        'icon' => 'fas fa-globe-europe',
        'outsource_desc' => 'Accelerate your digital deliverables with professional, GDPR-compliant developers aligned with London and UK business standards.',
        'benefits' => [
            'Strict adherence to EU/UK GDPR guidelines and database encryption standards.',
            'Timezone overlap enabling real-time morning meetings and daily sprint check-ins.',
            'Fluent English communication, documented code comments, and detailed git logs.',
            'Outsource cost efficiency, maximizing ROI for UK agencies and enterprises.'
        ],
        'faqs' => [
            'How do you ensure GDPR compliance for UK clients?' => 'We write secure validation pipelines, encrypt PII data, configure cookie consent models, and ensure all staging/production hosting runs on GDPR-compliant servers.',
            'Can we hire developers for long-term UK agency partnerships?' => 'Yes! We act as white-label offshore extensions for several UK digital agencies, providing reliable development retainers.'
        ]
    ],
    'australia' => [
        'name' => 'Australia',
        'icon' => 'fas fa-globe-asia',
        'outsource_desc' => 'Grow your digital product velocity in Australia with dedicated offshore engineers and convenient AEST/AWST timezone coordination.',
        'benefits' => [
            'Timezone alignment (AEST) ensuring our developers work during your primary hours.',
            'Rapid development cycles with continuous integration and delivery (CI/CD).',
            'Cost-effective rates helping Australian SMBs and startups scale budget lines.',
            'Integration with local payment systems (eWAY, Pin Payments) and logistics APIs.'
        ],
        'faqs' => [
            'How does the timezone overlap work for Sydney/Melbourne clients?' => 'Our team starts early to align directly with AEST/AEDT schedules, providing several hours of overlapping communication window for meetings and calls.',
            'What code quality checks are performed before handover?' => 'We implement automated testing (Pest/PHPUnit), run static code analysis (PHPStan/ESLint), and conduct peer review audits on all pull requests.'
        ]
    ],
    'canada' => [
        'name' => 'Canada',
        'icon' => 'fas fa-globe-americas',
        'outsource_desc' => 'Deploy secure, compliant web platforms and extend your Canadian team with senior engineers under cost-effective models.',
        'benefits' => [
            'Favorable development rates compared to local Canadian hires.',
            'Timezone coverage supporting Eastern (EST) and Western (PST/MST) business schedules.',
            'PIPEDA compliance guidelines followed for secure customer data flows.',
            'Agile sprint structures with weekly demos and clear roadmap reviews.'
        ],
        'faqs' => [
            'Do you support remote team integration with Canadian teams?' => 'Yes, our developers can integrate seamlessly into your existing workflows, participating in your team\'s Slack channels, Jira boards, and standups.',
            'What happens if we need to scale down the team?' => 'We offer flexible team scaling agreements with a simple 30-day notice period to increase or decrease developer headcounts.'
        ]
    ],
    'uae' => [
        'name' => 'UAE',
        'icon' => 'fas fa-globe-europe',
        'outsource_desc' => 'Drive digital transformation in Dubai and the Gulf region with custom enterprise web architectures and regional payment integrations.',
        'benefits' => [
            'Convenient timezone scheduling, allowing overlapping windows for collaboration.',
            'Expertise integrating Middle East payment systems (PayFort, Checkout.com) and courier APIs.',
            'Bespoke RTL styling and Arabic localization support for GCC applications.',
            'Fast-track MVP launches tailored for venture-backed UAE ecosystems.'
        ],
        'faqs' => [
            'Have you integrated Middle East shipping and payment platforms?' => 'Yes, we have built integrations with shipping APIs like Aramex and payment portals including PayFort, Checkout.com, and HyperPay.',
            'Do you support Arabic UI localization?' => 'Absolutely. We implement Right-to-Left (RTL) stylesheets using Tailwind CSS, allowing seamless toggle between English and Arabic layouts.'
        ]
    ],
    'singapore' => [
        'name' => 'Singapore',
        'icon' => 'fas fa-globe-asia',
        'outsource_desc' => 'Scale startup MVPs and secure enterprise platforms in Singapore with high-speed API builds and SGT timezone coordination.',
        'benefits' => [
            'SGT timezone overlap ensuring instant Slack feedback and live team syncs.',
            'Fintech-ready, highly secure endpoints utilizing modern authentication.',
            'Rapid MVP turnaround cycles assisting venture-funded Singapore hubs.',
            'Compliance with strict international standards on customer data privacy.'
        ],
        'faqs' => [
            'Can you help build secure banking/financial API integrations?' => 'Yes, we design secure, rate-limited architectures with payload encryption, OAuth 2.0 validation, and detailed logging for financial apps.',
            'What is the turnaround time for an MVP build?' => 'A typical MVP using Laravel/React can be deployed to staging in 4 to 8 weeks, depending on the scope of integrations.'
        ]
    ],
    'germany' => [
        'name' => 'Germany',
        'icon' => 'fas fa-globe-europe',
        'outsource_desc' => 'Implement strict code standards, EU GDPR parameters, and secure database layouts matching German engineering guidelines.',
        'benefits' => [
            'Clean-code architectural standards following SOLID design principles.',
            'Strict GDPR compliance, cookieless telemetry parameters, and EU cloud setups.',
            'CET business hour coordination for daily standups and live scrum feedback.',
            'Fluent English documentation, code commenting, and strict testing practices.'
        ],
        'faqs' => [
            'Can you host our application in EU-only data centers?' => 'Yes. We configure and deploy production files onto AWS, Hetzner, or DigitalOcean servers located in Frankfurt, ensuring data never leaves the EU.',
            'Do you write automated tests (TDD)?' => 'Yes, we write unit and feature tests using Pest or PHPUnit for PHP projects, and Jest/Cypress for JavaScript frontends, ensuring long-term code safety.'
        ]
    ]
];

$count = 0;
foreach ($technologies as $techKey => $techData) {
    foreach ($locations as $locKey => $locData) {
        $techName = $techData['name'];
        $titleSuffix = $techData['title_suffix'];
        $techIcon = $techData['icon'];
        $techSubtitle = $techData['subtitle'];
        $techDesc = $techData['desc'];
        
        $locName = $locData['name'];
        $locIcon = $locData['icon'];
        $locOutsource = $locData['outsource_desc'];
        
        // Build customized title & filename
        $file = "{$techKey}-development-services-{$locKey}.html";
        $title = "{$techName} {$titleSuffix} in {$locName}";
        $subtitle = "{$techSubtitle} in {$locName}";
        
        // Merge benefits
        $benefitsHtml = '';
        // 2 tech benefits + 2 location outsource benefits
        $combinedBenefits = [
            $techData['benefits'][0],
            $techData['benefits'][1],
            $locData['benefits'][1], // cost/overlap benefit
            $locData['benefits'][2]  // contract/compliance benefit
        ];
        foreach ($combinedBenefits as $benefit) {
            $benefitsHtml .= "<li><i class=\"fas fa-check-circle text-laravel-red mr-2\"></i> {$benefit}</li>\n                ";
        }

        // Merge FAQs
        $combinedFaqs = [];
        // Add 1 location FAQ, 1 tech FAQ, 1 generic outsource FAQ
        $locFaqKeys = array_keys($locData['faqs']);
        $combinedFaqs[$locFaqKeys[0]] = $locData['faqs'][$locFaqKeys[0]];
        
        $techFaqKeys = array_keys($techData['faqs']);
        $combinedFaqs[$techFaqKeys[0]] = $techData['faqs'][$techFaqKeys[0]];
        
        // Add third generic FAQ
        $combinedFaqs['Who owns the intellectual property and source code?'] = 'You do. Once milestones are paid, 100% of the repository source code and intellectual property rights are signed over and pushed to your GitHub or GitLab account.';

        $faqsHtml = '';
        foreach ($combinedFaqs as $q => $a) {
            $faqsHtml .= '
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">' . htmlspecialchars($q) . '</h3>
                    <p class="text-gray-600">' . htmlspecialchars($a) . '</p>
                </div>';
        }

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
                    <span class="inline-flex items-center text-gray-500 text-xs font-semibold">
                        Locations
                    </span>
                </li>
                <li class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-300 text-[10px] mx-1"></i>
                </li>
                <li aria-current="page" class="flex items-center">
                    <span class="inline-flex items-center bg-gradient-to-r from-laravel-red/10 to-laravel-orange/10 text-laravel-red px-3 py-1 rounded-full text-xs font-bold border border-laravel-red/20">
                        <i class="{$techIcon} mr-1.5 text-[10px]"></i>
                        {$techName} in {$locName}
                    </span>
                </li>
            </ol>
        </nav>
        
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-6 border border-laravel-red/20">
                    <i class="{$locIcon} mr-2"></i>
                    <span class="text-sm font-semibold tracking-wide uppercase">Dedicated Service Hub</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {$title}
                </h1>
                <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                    {$techDesc}
                </p>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    {$locOutsource}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/#contact" class="inline-flex justify-center items-center bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Start Your Project
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 border-t-4 border-laravel-red relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-laravel-orange/10 to-transparent rounded-bl-full"></div>
                <h2 class="text-2xl font-bold mb-6 text-gray-900 relative z-10">{$subtitle}</h2>
                <h3 class="text-lg font-semibold mb-4 text-laravel-red relative z-10">Outsource Advantages & Technical Benefits</h3>
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
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">A proven, systematic approach to ensure your custom {$techName} application is secure, scalable, and deployed without downtime.</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line (hidden on mobile) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -z-10 -translate-y-1/2"></div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Discovery & Blueprint</h3>
                    <p class="text-gray-600 text-sm">We map out your business goals, draft custom API structures, and finalize the {$techName} app blueprints.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Agile Sprints</h3>
                    <p class="text-gray-600 text-sm">Our expert developers write clean, documented, and secure {$techName} code matching strict coding standards.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">QA & Testing</h3>
                    <p class="text-gray-600 text-sm">Rigorous manual testing, page speed tuning, security auditing, and staging environment verification.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deployment & Support</h3>
                    <p class="text-gray-600 text-sm">Deploying files to production servers, monitoring core vitals, and setting up support retainers.</p>
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
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Partner With Laravel Experts Kolkata</h2>
                    <div class="space-y-6 text-gray-300">
                        <p class="text-lg">
                            We deliver high-end, responsive web engineering platforms. We work with leading international frameworks to ensure secure scaling.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>10+ Years of Specialization:</strong> Experienced offshore development services.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Enterprise Security:</strong> Strict database encryption, token protection, and secure data pipelines.</span></li>
                            <li class="flex items-start"><i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i> <span><strong>Performance Tuning:</strong> Optimized query structures, Redis caching, and async job execution.</span></li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-gradient-to-br from-laravel-red to-laravel-orange p-10 lg:p-16 text-center lg:text-left text-white h-full flex flex-col justify-center items-center lg:items-start relative z-10">
                    <h3 class="text-2xl font-bold mb-4">Ready to Partner?</h3>
                    <p class="mb-8 opacity-90">Get a free architecture audit and project estimation for your {$techName} system.</p>
                    <a href="/#contact" class="bg-white text-laravel-red px-8 py-3 rounded-full font-bold hover:shadow-lg transform hover:scale-105 transition duration-300 whitespace-nowrap">
                        Contact Our Experts
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="bg-white py-20 border-t border-gray-100">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600">Common questions about our {$techName} development services for {$locName} clients.</p>
            </div>
            
            <div class="space-y-6">
                {$faqsHtml}
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
            "href=\"https://laravelkolkata.com/location/{$file}\"",
            $html
        );
        // SEO Update: update og:url
        $html = str_replace(
            '<meta property="og:url" content="https://laravelkolkata.com">',
            "<meta property=\"og:url\" content=\"https://laravelkolkata.com/location/{$file}\">",
            $html
        );
        
        file_put_contents(__DIR__ . '/../location/' . $file, $html);
        $count++;
    }
}
echo "Created {$count} customized location-wise service pages.\n";
