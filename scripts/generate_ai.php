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

// create ai directory
if (!is_dir(__DIR__ . '/../ai')) {
    mkdir(__DIR__ . '/../ai', 0755, true);
}

// Define AI & Vector technologies
$ai_pages = [
    'openai-api.html' => [
        'title' => 'OpenAI API Integration Services',
        'icon' => 'fas fa-robot',
        'subtitle' => 'GPT Models, Assistants API & Laravel 13 Integration',
        'description' => 'Power your business workflows with industry-leading GPT-4o models. We implement conversational AI, automated text classification, sentiment analysis, semantic summaries, and structured JSON parsing using the official Laravel AI SDK.',
        'benefits' => [
            'Seamless connection to GPT-4o, GPT-4-turbo, and Assistants API endpoints.',
            'Strict schema validation using Laravel JSON casts and type-hinted LLM returns.',
            'Custom tool integration enabling the AI model to perform database and API tasks.',
            'Asynchronous task handling with Laravel Queues to avoid locking browser requests.'
        ],
        'code_title' => 'Laravel 13 OpenAI Facade Integration',
        'code' => <<<PHP
use Laravel\Ai\Facades\Ai;

// 1. Dispatch simple chat prompt
\$response = Ai::chat('openai')
    ->withInstructions('Categorize the user inquiry.')
    ->prompt('I need help updating my billing details.');

// 2. Structured output cast to a DTO / Class
\$customerProfile = Ai::chat('openai')
    ->withInstructions('Extract customer metadata.')
    ->castTo(CustomerProfile::class)
    ->prompt(\$rawText);
PHP
    ],
    'anthropic-claude.html' => [
        'title' => 'Anthropic Claude Integration Services',
        'icon' => 'fas fa-brain',
        'subtitle' => 'Advanced Cognitive Agents & Long-Context Analysis',
        'description' => 'Integrate Claude 3.5 Sonnet to handle complex logical reasoning, long document scanning, and multi-step agent actions. We build robust context-aware agent solutions tailored for enterprise Laravel workflows.',
        'benefits' => [
            'State-of-the-art cognitive abilities optimized for complex reasoning tasks.',
            'Extremely large 200k context window: Process full PDF contracts and log dumps.',
            'Object-oriented AI Agent classes generated via Artisan commands.',
            'Reliable API execution with detailed error management and middleware shielding.'
        ],
        'code_title' => 'Laravel 13 Custom AI Agent Definition',
        'code' => <<<PHP
// Generate with: php artisan make:agent TicketAgent

namespace App\Agents;
use Laravel\Ai\Agent;

class TicketAgent extends Agent
{
    // Configure Claude as primary agent model
    protected string \$provider = 'anthropic';

    protected string \$instructions = 'Analyze tech support tickets and identify the bug category.';
    
    // Add custom helper tools accessible to Claude
    protected array \$tools = [
        RetrieveUserAccount::class
    ];
}
PHP
    ],
    'pgvector.html' => [
        'title' => 'pgvector Database Services',
        'icon' => 'fas fa-database',
        'subtitle' => 'Native PostgreSQL Semantic Search for Laravel',
        'description' => 'Build high-performance semantic search engines, content recommendations, and Retrieval-Augmented Generation (RAG) directly within your PostgreSQL database. Avoid external SaaS costs by storing vectors natively.',
        'benefits' => [
            'Native vector embedding storage alongside standard relational Eloquent tables.',
            'Optimized vector distance operators: Cosine (<=>), L2 (<->), and Inner Product (<#>) queries.',
            'Fast search indexing using HNSW and IVFFlat index configurations.',
            'Full Eloquent model integration for clean, maintainable PHP code.'
        ],
        'code_title' => 'Laravel pgvector Schema & Query',
        'code' => <<<PHP
// 1. Database Migration definition
Schema::create('documents', function (Blueprint \$table) {
    \$table->id();
    \$table->text('content');
    \$table->vector('embedding', 1536); // 1536 dimensions for OpenAI
    \$table->timestamps();
});

// 2. Perform Cosine Similarity query in Eloquent
\$queryVector = Ai::embeddings('openai')->generate('Laravel vector search');

\$nearestDocuments = Document::query()
    ->select('*')
    ->selectRaw('embedding <=> ? as distance', [\$queryVector])
    ->whereRaw('embedding <=> ? < 0.25', [\$queryVector]) // Cosine threshold
    ->orderBy('distance', 'asc')
    ->limit(5)
    ->get();
PHP
    ],
    'ollama.html' => [
        'title' => 'Ollama Local LLM Integration Services',
        'icon' => 'fas fa-cloud-download-alt',
        'subtitle' => 'Privacy-First, Self-Hosted Local AI Pipelines',
        'description' => 'Deploy private LLMs (like Llama 3, Qwen, DeepSeek-R1) on your own secure infrastructure. We set up Ollama on GPU servers and configure your Laravel applications to run offline AI queries with zero per-token costs.',
        'benefits' => [
            '100% data privacy: Customer information never leaves your local server environment.',
            'Predictable costs: Zero billing fees per API request or generated tokens.',
            'Support for top-tier open-source models optimized for specific domains.',
            'Standard OpenAI-compatible REST server connection setup out of the box.'
        ],
        'code_title' => 'Laravel config/ai.php local setup',
        'code' => <<<PHP
// 1. Register Ollama driver in config/ai.php
'providers' => [
    'ollama' => [
        'driver' => 'openai',
        'base_url' => env('OLLAMA_BASE_URL', 'http://localhost:11434/v1'),
        'api_key' => 'ollama',
        'model' => env('OLLAMA_MODEL', 'llama3'),
    ],
]

// 2. Execute query in controller
\$localOutput = Ai::chat('ollama')
    ->prompt('Perform sentiment analysis on this customer message.');
PHP
    ]
];

foreach ($ai_pages as $file => $data) {
    $title = $data['title'];
    $icon = $data['icon'];
    $subtitle = $data['subtitle'];
    $desc = $data['description'];
    
    $benefitsHtml = '';
    foreach ($data['benefits'] as $benefit) {
        $benefitsHtml .= '
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-laravel-red mt-1 mr-3 flex-shrink-0"></i>
                        <span>' . htmlspecialchars($benefit) . '</span>
                    </li>';
    }
    
    $codeTitle = htmlspecialchars($data['code_title']);
    $codeHtml = htmlspecialchars($data['code']);
    
    $shortTitle = str_replace([' Development', ' Services', ' Integration', ' Styling', ' Admin Panels'], '', $title);

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
                    <span class="text-gray-500 text-xs font-semibold">AI Solutions</span>
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
                    <span class="text-sm font-semibold tracking-wide uppercase">AI Tech Integration</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {$title}
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {$desc}
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
                <h3 class="text-lg font-semibold mb-4 text-laravel-red relative z-10">Technical Benefits</h3>
                <ul class="space-y-4 text-gray-700 relative z-10">
                    {$benefitsHtml}
                </ul>
            </div>
        </div>
    </div>

    <!-- Implementation Process Section with Code Block -->
    <div class="bg-white py-20 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Implementation Process -->
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Our Implementation Process</h2>
                    <p class="text-gray-600 mb-8">We follow clean architecture standards to ensure AI API features run optimally, utilizing cache layer wrappers, background job queues, and robust failover strategies.</p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-laravel-red/10 rounded-full flex items-center justify-center text-laravel-red font-bold text-sm shrink-0 mr-4">1</div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Architecture & Design</h3>
                                <p class="text-gray-600 text-sm">We analyze the query workload, token volumes, and latency limits to design the optimal asynchronous caching and retrieval structure.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-laravel-red/10 rounded-full flex items-center justify-center text-laravel-red font-bold text-sm shrink-0 mr-4">2</div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">API Integration</h3>
                                <p class="text-gray-600 text-sm">Deploying Laravel models, migration schemas, and background queues for processing raw prompts and structured casting response objects.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-laravel-red/10 rounded-full flex items-center justify-center text-laravel-red font-bold text-sm shrink-0 mr-4">3</div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Queue & Stream Optimization</h3>
                                <p class="text-gray-600 text-sm">Configuring live Server-Sent Events (SSE) streaming or WebSockets with broadcasting libraries so users get responses character-by-character.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-10 h-10 bg-laravel-red/10 rounded-full flex items-center justify-center text-laravel-red font-bold text-sm shrink-0 mr-4">4</div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg mb-1">Monitoring & Failovers</h3>
                                <p class="text-gray-600 text-sm">Implementing token rate limit monitors and automatic failover keys to backup providers to ensure 100% application uptime.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Code Block Section -->
                <div class="bg-gray-900 rounded-2xl shadow-xl overflow-hidden border border-gray-800">
                    <div class="bg-gray-850 px-6 py-3 border-b border-gray-800 flex justify-between items-center">
                        <span class="text-xs text-gray-400 font-mono">{$codeTitle}</span>
                        <div class="flex space-x-1.5">
                            <span class="w-3 h-3 bg-red-500 rounded-full"></span>
                            <span class="w-3 h-3 bg-yellow-500 rounded-full"></span>
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                        </div>
                    </div>
                    <div class="p-6 overflow-x-auto">
                        <pre class="text-sm font-mono text-gray-300 leading-relaxed"><code>{$codeHtml}</code></pre>
                    </div>
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
        "href=\"https://laravelkolkata.com/ai/{$file}\"",
        $html
    );
    // SEO Update: update og:url
    $html = str_replace(
        '<meta property="og:url" content="https://laravelkolkata.com">',
        "<meta property=\"og:url\" content=\"https://laravelkolkata.com/ai/{$file}\">",
        $html
    );
    
    file_put_contents(__DIR__ . '/../ai/' . $file, $html);
}
echo "Created " . count($ai_pages) . " customized AI integration pages inside ai/ folder.\n";
