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

// create service directory
if (!is_dir('service')) {
    mkdir('service', 0755, true);
}

$services = [
    'zoho-crm.html' => [
        'title' => 'Zoho CRM Integration Services',
        'icon' => 'fas fa-users-cog',
        'subtitle' => 'Expert Zoho CRM Integration in Kolkata',
        'description' => 'Automate your sales pipeline, enhance customer relationship management, and sync your Laravel application seamlessly with Zoho CRM. Our experts ensure real-time data flow for leads, contacts, and deals.',
        'benefits' => [
            'Two-way data synchronization between your platform and Zoho.',
            'Custom workflows and automation for efficient sales tracking.',
            'Secure and optimized API implementation via OAuth 2.0.',
            'Custom dashboard integrations to monitor CRM metrics in Laravel.'
        ]
    ],
    'gohighlevel.html' => [
        'title' => 'GoHighLevel Integration Services',
        'icon' => 'fas fa-chart-line',
        'subtitle' => 'Advanced GoHighLevel API Integration',
        'description' => 'Connect your Laravel application with GoHighLevel to supercharge your marketing campaigns, sales funnels, and CRM capabilities all in one unified platform.',
        'benefits' => [
            'Seamless synchronization of contacts, pipelines, and opportunities.',
            'Automated trigger workflows based on user actions.',
            'Custom webhook integrations for real-time notifications.',
            'Secure authentication and scalable data handling.'
        ]
    ],
    'brevo-mail-automation.html' => [
        'title' => 'Brevo Mail Automation & Marketing Integration',
        'icon' => 'fas fa-envelope-open-text',
        'subtitle' => 'Brevo (Sendinblue) Email API Integration',
        'description' => 'Enhance your user engagement by integrating Brevo into your Laravel application. We set up reliable transactional emails, marketing automation, and SMS campaigns.',
        'benefits' => [
            'Automated transactional email and SMS routing.',
            'Dynamic list management and audience segmentation.',
            'Custom email template rendering and delivery tracking.',
            'Webhook setups for bounce and open rate analytics.'
        ]
    ],
    'clover-pos.html' => [
        'title' => 'Clover POS Developer Platform API Integration',
        'icon' => 'fas fa-cash-register',
        'subtitle' => 'Retail & Point of Sale Integration',
        'description' => 'Bridge the gap between your physical store and online presence. We integrate Clover POS with Laravel e-commerce platforms to sync sales, inventory, and customer data in real-time.',
        'benefits' => [
            'Real-time inventory synchronization across all sales channels.',
            'Automated order processing and fulfillment tracking.',
            'Secure payment gateway data handling.',
            'Unified reporting dashboards for omnichannel sales.'
        ]
    ],
    'doordash-drive.html' => [
        'title' => 'DoorDash Drive Integration Services',
        'icon' => 'fas fa-motorcycle',
        'subtitle' => 'On-Demand Delivery API Integration',
        'description' => 'Implement seamless on-demand delivery capabilities directly into your web platform. We connect your application with DoorDash Drive to dispatch drivers automatically.',
        'benefits' => [
            'Automated delivery request creation upon order placement.',
            'Real-time driver tracking and status webhooks.',
            'Delivery fee calculation and optimized dispatching.',
            'Enhanced customer experience with live delivery updates.'
        ]
    ],
    'uber-direct.html' => [
        'title' => 'Uber Direct Integration Services',
        'icon' => 'fas fa-car',
        'subtitle' => 'Rapid Local Delivery Integrations',
        'description' => 'Leverage the Uber network for your business by integrating Uber Direct. We help you offer same-day delivery options to your customers directly from your Laravel platform.',
        'benefits' => [
            'Instant local delivery scheduling and quoting.',
            'Live GPS tracking of couriers within your app.',
            'Proof of delivery and robust error handling.',
            'Streamlined last-mile logistics for your business.'
        ]
    ],
    'delhivery.html' => [
        'title' => 'Delhivery Integration Services',
        'icon' => 'fas fa-truck-ramp-box',
        'subtitle' => 'Enterprise Logistics & Express Courier API',
        'description' => 'Automate your domestic shipping and fulfillment by integrating Delhivery\'s robust APIs. We implement automated pickup requests, shipping label generation, and real-time tracking webhooks.',
        'benefits' => [
            'Automated airway bill (AWB) generation and shipping label printing.',
            'Real-time package status and location tracking updates.',
            'Cash on Delivery (COD) shipping and payment reconciliation workflows.',
            'Automated return pickup creation and reverse logistics handling.'
        ]
    ],
    'blue-dart.html' => [
        'title' => 'Blue Dart Courier Integration Services',
        'icon' => 'fas fa-shipping-fast',
        'subtitle' => 'Premium Express Logistics API Solutions',
        'description' => 'Provide fast and secure shipping options across India and globally by integrating Blue Dart APIs. We integrate shipping rate calculators, package booking, and tracking tools.',
        'benefits' => [
            'Real-time shipping rate calculations based on weight and destination.',
            'Automated pickup scheduling and shipping label generation.',
            'Instant package tracking updates for customers.',
            'Cash on Delivery (COD) services and delivery confirmation.'
        ]
    ],
    'fedex.html' => [
        'title' => 'FedEx Integration Services',
        'icon' => 'fab fa-fedex',
        'subtitle' => 'Global Express Shipping & Logistics API',
        'description' => 'Expand your global reach with seamless FedEx API integrations. We implement shipping rate calculations, international customs document generation, and real-time package tracking.',
        'benefits' => [
            'Dynamic shipping rate calculation for domestic and international orders.',
            'Automated shipping label and customs documentation creation.',
            'Real-time shipment tracking and delivery status webhooks.',
            'Pickup scheduling and package pickup management workflows.'
        ]
    ],
    'ekart-logistics.html' => [
        'title' => 'Ekart Logistics Integration Services',
        'icon' => 'fas fa-truck-loading',
        'subtitle' => 'E-Commerce Supply Chain Integration',
        'description' => 'Connect your Laravel e-commerce store with Ekart Logistics to provide reliable supply chain and delivery solutions across India.',
        'benefits' => [
            'Seamless order manifesting and pickup scheduling.',
            'Real-time tracking updates via Ekart APIs.',
            'Cash on Delivery (COD) management and reconciliation.',
            'Scalable architecture for high-volume sales events.'
        ]
    ],
    'xpressbees.html' => [
        'title' => 'XpressBees Integration Services',
        'icon' => 'fas fa-shipping-fast',
        'subtitle' => 'End-to-End Logistics API Solutions',
        'description' => 'Integrate XpressBees logistics into your application to handle B2B, B2C, and cross-border deliveries efficiently. We ensure smooth communication between your store and their fulfillment network.',
        'benefits' => [
            'Automated dispatch and order syncing.',
            'Live parcel tracking for your customers.',
            'Return order processing and reverse logistics.',
            'Secure API authentication and payload handling.'
        ]
    ],
    'aramex.html' => [
        'title' => 'Aramex Integration Services',
        'icon' => 'fas fa-globe',
        'subtitle' => 'Cross-Border Logistics & Courier API',
        'description' => 'Enable smooth international and regional shipping by integrating Aramex APIs. We implement rates calculation, shipment booking, and real-time tracking for e-commerce platforms.',
        'benefits' => [
            'Real-time international and domestic shipping rate lookup.',
            'Automated booking, airway bill creation, and label printing.',
            'Real-time package tracking and custom notifications.',
            'Reverse logistics and return pickup scheduling.'
        ]
    ],
    'shree-maruti.html' => [
        'title' => 'Shree Maruti Courier Integration Services',
        'icon' => 'fas fa-truck-fast',
        'subtitle' => 'Fast & Reliable Domestic Logistics API',
        'description' => 'Integrate Shree Maruti Courier services seamlessly into your Laravel application. We automate your shipping processes, ensuring fast and reliable domestic deliveries across India.',
        'benefits' => [
            'Automated AWB generation and order dispatching.',
            'Real-time shipment tracking for your customers.',
            'Pin code serviceability checks via API.',
            'Streamlined reverse logistics and return tracking.'
        ]
    ],
    'amazon-shipping.html' => [
        'title' => 'Amazon Shipping Integration Services',
        'icon' => 'fab fa-amazon',
        'subtitle' => 'Amazon Logistics API Development',
        'description' => 'Automate your order fulfillment using Amazon\'s extensive delivery network. We integrate the Amazon Shipping API to handle rate calculation, label purchasing, and tracking.',
        'benefits' => [
            'Direct access to Amazon Shipping rates and services.',
            'Automated shipping label generation in PDF/ZPL formats.',
            'Strict adherence to Amazon\'s authentication (LWA) and security protocols.',
            'Reliable tracking webhooks and shipment lifecycle management.'
        ]
    ],
    'dtdc.html' => [
        'title' => 'DTDC Integration Services',
        'icon' => 'fas fa-truck',
        'subtitle' => 'Domestic & International Courier APIs',
        'description' => 'Provide extensive shipping coverage by integrating DTDC logistics into your platform. We handle everything from pin code serviceability to live tracking.',
        'benefits' => [
            'Automated serviceability checks for delivery pin codes.',
            'Instant booking and AWB generation.',
            'Real-time shipment status updates.',
            'Secure, robust error handling for API timeouts.'
        ]
    ],
    'shadowfax.html' => [
        'title' => 'Shadowfax Integration Services',
        'icon' => 'fas fa-bolt',
        'subtitle' => 'Hyper-Local Delivery Integration',
        'description' => 'Integrate Shadowfax into your Laravel platform for fast, hyper-local, and reverse logistics services. Perfect for food, grocery, and e-commerce instant deliveries.',
        'benefits' => [
            'Instant task creation for hyper-local pickups.',
            'Live tracking links for end customers.',
            'Reverse pickup scheduling and management.',
            'Reliable API connectivity for high-frequency orders.'
        ]
    ],
    'facebook-for-business.html' => [
        'title' => 'Facebook for Business Integration Services',
        'icon' => 'fab fa-facebook',
        'subtitle' => 'Conversions API & Catalog Sync',
        'description' => 'Maximize your ad ROI by integrating the Facebook Conversions API and automated Catalog syncing. We help you send reliable server-side events directly from Laravel.',
        'benefits' => [
            'Server-side tracking for highly accurate event logging.',
            'Automated product catalog synchronization.',
            'Facebook Login (OAuth) implementation.',
            'Enhanced data privacy and reliable pixel tracking.'
        ]
    ],
    'instagram-for-business.html' => [
        'title' => 'Instagram for Business Integration Services',
        'icon' => 'fab fa-instagram',
        'subtitle' => 'Graph API & Messaging Automation',
        'description' => 'Engage your audience automatically by connecting your platform to the Instagram Graph API. Manage posts, comments, and direct messages seamlessly.',
        'benefits' => [
            'Automated direct message (DM) replies and bot integrations.',
            'Post scheduling and media publishing from your dashboard.',
            'Comment moderation and analytics tracking.',
            'Secure token management for long-lived access.'
        ]
    ],
    'whatsapp-business-bot.html' => [
        'title' => 'WhatsApp Business Platform Bot Integration',
        'icon' => 'fab fa-whatsapp',
        'subtitle' => 'Conversational Commerce & Notifications',
        'description' => 'Reach your customers where they are. We integrate the official WhatsApp Business API to send transactional alerts, OTPs, and deploy interactive chatbots.',
        'benefits' => [
            'Automated order updates and booking confirmations.',
            'Interactive message templates with buttons and lists.',
            'Two-way messaging setups with webhook processing.',
            'Integration with AI backends for smart conversational bots.'
        ]
    ],
    'telegram-bot.html' => [
        'title' => 'Telegram Bot Integration Services',
        'icon' => 'fab fa-telegram',
        'subtitle' => 'Custom Alerts & User Interactions',
        'description' => 'Build and integrate custom Telegram bots for your Laravel application. Perfect for admin alerts, community management, and quick user interactions.',
        'benefits' => [
            'Instant server-to-admin notification routing.',
            'Custom slash commands for application management.',
            'Secure webhook configurations for rapid responses.',
            'Automated group management and content broadcasting.'
        ]
    ],
    'wechat.html' => [
        'title' => 'WeChat Integration Services',
        'icon' => 'fab fa-weixin',
        'subtitle' => 'WeChat Mini Programs & Official Accounts',
        'description' => 'Connect with the Chinese market by integrating WeChat APIs. We handle Official Account messaging, WeChat Login, and complex Mini Program backends.',
        'benefits' => [
            'WeChat OAuth login integration.',
            'Automated message replies for Official Accounts.',
            'WeChat Pay API integration for seamless transactions.',
            'Custom backend APIs for WeChat Mini Programs.'
        ]
    ],
    'line-for-business.html' => [
        'title' => 'LINE for Business Integration Services',
        'icon' => 'fab fa-line',
        'subtitle' => 'LINE Messaging API Integration',
        'description' => 'Engage your audience across Asia with LINE messaging integrations. We build custom logic to send push messages, rich menus, and interactive chatbots.',
        'benefits' => [
            'LINE Login integration for your web applications.',
            'Push and reply message automation.',
            'Rich menu setup and dynamic content updates.',
            'Webhook handling for precise user interaction tracking.'
        ]
    ],
    'strava.html' => [
        'title' => 'Strava Integration Services',
        'icon' => 'fab fa-strava',
        'subtitle' => 'Fitness Activity & Route Syncing',
        'description' => 'Sync fitness activities, segment efforts, and routes into your application by integrating the Strava API. We handle complex OAuth flows and activity webhook events.',
        'benefits' => [
            'Secure Strava OAuth 2.0 authentication.',
            'Automated syncing of user activities and stats.',
            'Webhook implementation for real-time activity updates.',
            'Data visualization of routes and segment performance.'
        ]
    ],
    'apple-healthkit.html' => [
        'title' => 'Apple HealthKit Integration Services',
        'icon' => 'fas fa-heartbeat',
        'subtitle' => 'iOS Health Metrics & Fitness Data',
        'description' => 'Bridge the gap between your backend and iOS devices. We build secure APIs to receive and process Apple HealthKit data from your mobile applications.',
        'benefits' => [
            'Secure endpoints to ingest health and fitness metrics.',
            'Strict adherence to HIPAA and privacy standards.',
            'Data aggregation for user health dashboards.',
            'Seamless sync between Laravel backend and iOS apps.'
        ]
    ],
    'zoom-sdk.html' => [
        'title' => 'Zoom SDK Integration Services',
        'icon' => 'fas fa-video',
        'subtitle' => 'Embedded Video Conferencing APIs',
        'description' => 'Embed high-quality video conferencing, meetings, and webinars directly into your Laravel platform using the Zoom API and SDKs.',
        'benefits' => [
            'Automated meeting creation and scheduling.',
            'Server-to-Server OAuth app implementations.',
            'Direct embedding of the Zoom Web SDK in your frontend.',
            'Webhook integrations for meeting recordings and attendee tracking.'
        ]
    ],
    'agora-video-calling.html' => [
        'title' => 'Agora Real-Time Engagement Integration',
        'icon' => 'fas fa-broadcast-tower',
        'subtitle' => 'Video Calling SDK Integration',
        'description' => 'Build highly customized, low-latency live video and audio features. We integrate Agora\'s SDK to power your telemedicine, ed-tech, or social application.',
        'benefits' => [
            'Custom token generation for secure channel access.',
            'High-quality real-time audio and video streaming.',
            'Interactive live broadcasting capabilities.',
            'Cloud recording integrations directly to your AWS S3.'
        ]
    ],
    'twilio-bulk-sms.html' => [
        'title' => 'Twilio Bulk SMS Integration Services',
        'icon' => 'fas fa-sms',
        'subtitle' => 'Scalable SMS, Voice & 2FA',
        'description' => 'Power your application\'s communication with Twilio. We integrate reliable bulk SMS marketing, transactional alerts, and two-factor authentication (2FA).',
        'benefits' => [
            'Automated transactional SMS and OTP delivery.',
            'Programmable voice calls and IVR setups.',
            'Bulk message scheduling and delivery status tracking.',
            'Scalable architecture to handle high-volume messaging.'
        ]
    ],
    'google-maps-platform.html' => [
        'title' => 'Google Maps Platform Integration',
        'icon' => 'fas fa-map-marked-alt',
        'subtitle' => 'Real-Time Map & Routing APIs',
        'description' => 'Enhance your platform with dynamic maps, route optimization, and location intelligence using the Google Maps Platform APIs.',
        'benefits' => [
            'Interactive map embedding with custom markers.',
            'Address autocomplete and geocoding services.',
            'Distance Matrix and routing for logistics applications.',
            'Optimized API usage to control billing costs.'
        ]
    ],
    'google-geofencing-api.html' => [
        'title' => 'Google Geofencing API Integration',
        'icon' => 'fas fa-draw-polygon',
        'subtitle' => 'Location-Based Contextual Alerts',
        'description' => 'Implement location-based triggers and contextual alerts for your users. We connect backend geofencing logic with mobile and web platforms.',
        'benefits' => [
            'Creation and management of dynamic geofences.',
            'Automated server alerts when users enter/exit zones.',
            'Location-based marketing and push notifications.',
            'Efficient battery-saving tracking implementations.'
        ]
    ],
    'dhl.html' => [
        'title' => 'DHL Integration Services',
        'icon' => 'fab fa-dhl',
        'subtitle' => 'Global Logistics & Courier API Integration',
        'description' => 'Automate your international and domestic shipping with DHL. We integrate DHL Express and e-commerce APIs to handle rate calculation, label generation, and live package tracking directly within your Laravel app.',
        'benefits' => [
            'Real-time DHL shipping rate calculation at checkout.',
            'Automated label generation and customs document handling.',
            'Live shipment tracking and status webhooks.',
            'Seamless reverse logistics and return management.'
        ]
    ],
    'shiprocket.html' => [
        'title' => 'Shiprocket Integration Services',
        'icon' => 'fas fa-rocket',
        'subtitle' => 'Automated E-Commerce Shipping & Fulfillment',
        'description' => 'Connect your Laravel e-commerce platform with Shiprocket to automate your entire shipping workflow. Select from multiple courier partners, generate AWBs instantly, and track orders effortlessly.',
        'benefits' => [
            'Automated order syncing and AWB generation.',
            'Dynamic courier allocation based on pricing and performance.',
            'NDR (Non-Delivery Report) management and RTO handling.',
            'Branded tracking pages and automated buyer notifications.'
        ]
    ],
    'hubspot.html' => [
        'title' => 'HubSpot Integration Services',
        'icon' => 'fab fa-hubspot',
        'subtitle' => 'Comprehensive CRM & Marketing Automation Integration',
        'description' => 'Unify your marketing, sales, and customer service by integrating HubSpot into your Laravel platform. We help you automate workflows, sync contacts in real-time, and leverage inbound marketing tools directly from your application.',
        'benefits' => [
            'Two-way synchronization of contacts, companies, and deals.',
            'Integration of HubSpot tracking codes and custom event triggers.',
            'Automated form submissions and lead generation workflows.',
            'Secure API connections using HubSpot OAuth 2.0.'
        ]
    ],
    'payment-gateways.html' => [
        'title' => 'Payment Gateway Integration Services',
        'icon' => 'fas fa-credit-card',
        'subtitle' => 'Global & Regional Payment Solutions',
        'description' => 'Securely accept online payments from customers worldwide. We provide seamless integration for a variety of top payment gateways including PayPal, Stripe, Razorpay, PayU, Globalpay, Powertranz, Ipay88, Apple Pay, Google Pay etc.',
        'benefits' => [
            'PCI-compliant integration with tokenized data storage.',
            'Support for recurring billing, subscriptions, and split payments.',
            'Robust webhook handling for instant payment confirmations and refunds.',
            'Multi-currency and localized payment method support.'
        ]
    ],
    'sms-gateway-dlt.html' => [
        'title' => 'SMS Gateway & DLT Integration Services',
        'icon' => 'fas fa-comment-sms',
        'subtitle' => 'Compliant Bulk SMS & OTP Routing',
        'description' => 'Ensure highly reliable and compliant messaging with SMS Gateway and DLT (Distributed Ledger Technology) integration. We connect your application to major SMS providers while strictly adhering to TRAI guidelines.',
        'benefits' => [
            'Seamless integration with leading SMS gateways for transactional alerts.',
            'End-to-end DLT compliance for scrubbing, templates, and header approvals.',
            'Real-time automated OTP generation and verification flows.',
            'Detailed delivery reports and fall-back routing for high success rates.'
        ]
    ]
];

foreach ($services as $file => $data) {
    $title = $data['title'];
    $subtitle = $data['subtitle'];
    $desc = $data['description'];
    $icon = $data['icon'];
    
    $benefitsHtml = '';
    foreach ($data['benefits'] as $benefit) {
        $benefitsHtml .= "<li>{$benefit}</li>\n                ";
    }

    $shortTitle = str_replace(' Integration Services', '', $title);

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
                    <a href="/services.html" class="inline-flex items-center text-gray-500 hover:text-laravel-red transition-colors duration-300 text-xs font-semibold">
                        Services
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
                    <span class="text-sm font-semibold tracking-wide uppercase">Integration Expertise</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {$title}
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {$desc}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/#contact" class="inline-flex justify-center items-center bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Start Your Integration
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 border-t-4 border-laravel-red relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-laravel-orange/10 to-transparent rounded-bl-full"></div>
                <h2 class="text-2xl font-bold mb-6 text-gray-900 relative z-10">{$subtitle}</h2>
                <h3 class="text-lg font-semibold mb-4 text-laravel-red relative z-10">Key Features & Technical Benefits</h3>
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
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Our Integration Process</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">A proven, systematic approach to ensure your {$shortTitle} implementation is secure, scalable, and deployed without downtime.</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line (hidden on mobile) -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -z-10 -translate-y-1/2"></div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Discovery</h3>
                    <p class="text-gray-600 text-sm">We analyze your business requirements, map out data flows, and determine the exact API endpoints required for {$shortTitle}.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Development</h3>
                    <p class="text-gray-600 text-sm">Our Laravel experts implement secure authentication (OAuth/Tokens) and write clean, scalable code to handle API requests and webhooks.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Testing</h3>
                    <p class="text-gray-600 text-sm">Rigorous staging environment tests, edge-case handling, and API rate-limit management ensure the integration is completely stable.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deployment</h3>
                    <p class="text-gray-600 text-sm">We securely push the integration to production, set up continuous monitoring, and provide documentation for your team.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us / CTA -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="bg-gray-900 rounded-3xl overflow-hidden shadow-2xl relative">
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-gradient-to-br from-laravel-red/30 to-laravel-orange/30 rounded-full blur-3xl"></div>
            
            <div class="grid lg:grid-cols-5 gap-0 items-center">
                <div class="lg:col-span-3 p-10 lg:p-16 relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Why Partner With Laravel Experts Kolkata?</h2>
                    <div class="space-y-6 text-gray-300">
                        <p class="text-lg">
                            Integrating <strong>{$shortTitle}</strong> requires more than just reading API documentation. It requires a deep understanding of Laravel's architecture, queue systems, and security best practices.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>10+ Years of Specialization:</strong> We exclusively work with the Laravel ecosystem.</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>Enterprise-Grade Security:</strong> strict adherence to API rate limits, payload encryption, and secure token storage.</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>Performance Optimized:</strong> We utilize Laravel Horizon and asynchronous queues to prevent API calls from blocking your application.</li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-gradient-to-br from-laravel-red to-laravel-orange p-10 lg:p-16 text-center lg:text-left text-white h-full flex flex-col justify-center items-center lg:items-start relative z-10">
                    <h3 class="text-2xl font-bold mb-4">Ready to Integrate?</h3>
                    <p class="mb-8 opacity-90">Get a free technical consultation and architecture proposal for your {$shortTitle} project.</p>
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
                <p class="text-gray-600">Common questions about our {$shortTitle} services.</p>
            </div>
            
            <div class="space-y-6">
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">How long does a typical integration take?</h3>
                    <p class="text-gray-600">The timeline depends entirely on the complexity of the data mapping and the number of API endpoints required. Simple integrations can take 1-2 weeks, while complex, two-way syncs may take 3-6 weeks.</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you provide ongoing support after deployment?</h3>
                    <p class="text-gray-600">Yes! APIs change and update over time. We offer comprehensive maintenance packages to monitor your integration, handle API version deprecations, and ensure 99.9% uptime.</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Is the integration secure?</h3>
                    <p class="text-gray-600">Absolutely. We use industry-standard encryption, secure environment variables for API keys, and implement proper OAuth 2.0 flows to ensure your application data remains completely secure.</p>
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
        "href=\"https://laravelkolkata.com/service/{$file}\"",
        $html
    );
    // SEO Update: update og:url
    $html = str_replace(
        '<meta property="og:url" content="https://laravelkolkata.com">',
        "<meta property=\"og:url\" content=\"https://laravelkolkata.com/service/{$file}\">",
        $html
    );
    
    file_put_contents('service/' . $file, $html);
}
echo "Created " . count($services) . " customized pages.\n";

// Generate services.html
// Define categories
$categories = [
    'CRM & Marketing Integrations' => [
        'zoho-crm.html', 'gohighlevel.html', 'brevo-mail-automation.html', 'hubspot.html'
    ],
    'POS & Payment Integrations' => [
        'clover-pos.html', 'payment-gateways.html'
    ],
    'Logistics & Delivery Integrations' => [
        'delhivery.html', 'blue-dart.html', 'fedex.html', 'ekart-logistics.html', 'xpressbees.html', 'aramex.html', 'shree-maruti.html', 'amazon-shipping.html', 'dtdc.html', 'shadowfax.html', 'dhl.html', 'shiprocket.html'
    ],
    'Quick & Local Delivery Integrations' => [
        'doordash-drive.html', 'uber-direct.html'
    ],
    'Social Media & Messaging Integrations' => [
        'facebook-for-business.html', 'instagram-for-business.html', 'whatsapp-business-bot.html', 'telegram-bot.html', 'wechat.html', 'line-for-business.html'
    ],
    'Fitness & Health Integrations' => [
        'strava.html', 'apple-healthkit.html'
    ],
    'Communication & Video SDK Integrations' => [
        'zoom-sdk.html', 'agora-video-calling.html', 'twilio-bulk-sms.html', 'sms-gateway-dlt.html'
    ],
    'Maps & Location-Based Integrations' => [
        'google-maps-platform.html', 'google-geofencing-api.html'
    ]
];

$cardsHtml = '';
foreach ($categories as $categoryName => $files) {
    $cardsHtml .= '<div class="col-span-full mt-10 mb-2"><h3 class="text-2xl font-bold text-gray-900 border-b-2 border-laravel-red pb-2 inline-block">' . $categoryName . '</h3></div>';
    foreach ($files as $file) {
        if (isset($services[$file])) {
            $data = $services[$file];
            $shortTitle = str_replace(' Integration Services', '', $data['title']);
            $cardsHtml .= <<<HTML
            <a href="/service/{$file}" class="group flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-laravel-red/30 transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 flex flex-col flex-grow">
                    <div class="w-12 h-12 bg-laravel-red/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-laravel-red transition-colors duration-300 shrink-0">
                        <i class="{$data['icon']} text-laravel-red group-hover:text-white transition-colors duration-300 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-laravel-red transition-colors duration-300">{$shortTitle}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-6">{$data['subtitle']}</p>
                    <div class="mt-auto flex items-center text-laravel-red text-sm font-semibold pt-2">
                        View Details <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </div>
                </div>
            </a>
HTML;
        }
    }
}

// Extract "Our Services" section from index.html
$services_start = strpos($index, '<!-- Services Section -->');
$services_end = strpos($index, '<!-- Technologies Section -->');
$ourServicesHtml = '';
if ($services_start !== false && $services_end !== false) {
    $ourServicesHtml = substr($index, $services_start, $services_end - $services_start);
    $ourServicesHtml = str_replace('class="py-20 bg-gray-50 relative"', 'class="py-20 bg-white relative"', $ourServicesHtml);
}

$servicesContent = <<<HTML
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
                        <i class="fas fa-cogs mr-1.5 text-[10px]"></i>
                        All Services
                    </span>
                </li>
            </ol>
        </nav>
    </div>
</div>

{$ourServicesHtml}

<main class="relative py-20 bg-gray-50 border-t border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-4 border border-laravel-red/20">
                <span class="text-sm font-semibold tracking-wide uppercase">Third-Party Integrations</span>
            </div>
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Integration Services Directory</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explore our comprehensive suite of API and third-party integration solutions for Laravel applications.
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
            
            <div class="grid lg:grid-cols-5 gap-0 items-center">
                <div class="lg:col-span-3 p-10 lg:p-16 relative z-10">
                    <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Why Partner With Laravel Experts Kolkata?</h2>
                    <div class="space-y-6 text-gray-300">
                        <p class="text-lg">
                            Integrating APIs and third-party systems requires secure authentication, proper webhook handlers, error monitoring, and optimized background queue processing.
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>10+ Years of Specialization:</strong> We exclusively work with the Laravel ecosystem.</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>Enterprise-Grade Security:</strong> Strict compliance, token encryption, and safe payload management.</li>
                            <li class="flex items-center"><i class="fas fa-check-circle text-laravel-red mr-3"></i> <strong>Performance Optimized:</strong> Asynchronous queuing (Redis/RabbitMQ) to prevent blocking user actions.</li>
                        </ul>
                    </div>
                </div>
                <div class="lg:col-span-2 bg-gradient-to-br from-laravel-red to-laravel-orange p-10 lg:p-16 text-center lg:text-left text-white h-full flex flex-col justify-center items-center lg:items-start relative z-10">
                    <h3 class="text-2xl font-bold mb-4">Ready to Integrate?</h3>
                    <p class="mb-8 opacity-90">Get a free technical consultation and architecture proposal for your API integration needs.</p>
                    <a href="/#contact" class="bg-white text-laravel-red px-8 py-3 rounded-full font-bold hover:shadow-lg transform hover:scale-105 transition duration-300 whitespace-nowrap">
                        Contact Our Experts
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
HTML;

$servicesPageHtml = $header . $servicesContent . "\n" . $footer;
$servicesPageHtml = preg_replace('/<title>.*?<\/title>/', "<title>All Integration Services - Laravel Experts Kolkata</title>", $servicesPageHtml);

// SEO Update: update canonical and hreflang links to point to this directory page
$servicesPageHtml = str_replace(
    'href="https://laravelkolkata.com"',
    'href="https://laravelkolkata.com/services.html"',
    $servicesPageHtml
);
// SEO Update: update og:url
$servicesPageHtml = str_replace(
    '<meta property="og:url" content="https://laravelkolkata.com">',
    '<meta property="og:url" content="https://laravelkolkata.com/services.html">',
    $servicesPageHtml
);

file_put_contents('services.html', $servicesPageHtml);

echo "Created services.html directory page.\n";
