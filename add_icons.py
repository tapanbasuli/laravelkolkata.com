import re

file_path = r"d:\laragon\www\laravelkolkata.com\generate_services.php"

with open(file_path, "r", encoding="utf-8") as f:
    content = f.read()

icons = {
    'zoho-crm.html': 'fas fa-users-cog',
    'gohighlevel.html': 'fas fa-chart-line',
    'brevo-mail-automation.html': 'fas fa-envelope-open-text',
    'clover-pos.html': 'fas fa-cash-register',
    'doordash-drive.html': 'fas fa-motorcycle',
    'uber-direct.html': 'fas fa-car',
    'courier-aggregator.html': 'fas fa-boxes',
    'ekart-logistics.html': 'fas fa-truck-loading',
    'xpressbees.html': 'fas fa-shipping-fast',
    'delivery-management.html': 'fas fa-route',
    'maruti-techlabs.html': 'fas fa-robot',
    'amazon-shipping.html': 'fab fa-amazon',
    'dtdc.html': 'fas fa-truck',
    'shadowfax.html': 'fas fa-bolt',
    'facebook-for-business.html': 'fab fa-facebook',
    'instagram-for-business.html': 'fab fa-instagram',
    'whatsapp-business-bot.html': 'fab fa-whatsapp',
    'telegram-bot.html': 'fab fa-telegram',
    'wechat.html': 'fab fa-weixin',
    'line-for-business.html': 'fab fa-line',
    'strava.html': 'fab fa-strava',
    'apple-healthkit.html': 'fas fa-heartbeat',
    'zoom-sdk.html': 'fas fa-video',
    'agora-video-calling.html': 'fas fa-broadcast-tower',
    'twilio-bulk-sms.html': 'fas fa-sms',
    'google-maps-platform.html': 'fas fa-map-marked-alt',
    'google-geofencing-api.html': 'fas fa-draw-polygon',
    'dhl.html': 'fab fa-dhl',
    'shiprocket.html': 'fas fa-rocket',
    'hubspot.html': 'fab fa-hubspot',
    'payment-gateways.html': 'fas fa-credit-card',
    'sms-gateway-dlt.html': 'fas fa-comment-sms'
}

for key, icon in icons.items():
    pattern = rf"('{key}'\s*=>\s*\[\s*'title'\s*=>\s*'[^']+',)"
    replacement = rf"\1\n        'icon' => '{icon}',"
    content = re.sub(pattern, replacement, content)

# Extract icon variable
content = content.replace("$desc = $data['description'];", "$desc = $data['description'];\n    $icon = $data['icon'];")

# Update individual service page hero section
content = content.replace('<span class="text-sm font-semibold tracking-wide uppercase">Integration Expertise</span>', '<i class="{$icon} mr-2"></i>\n                    <span class="text-sm font-semibold tracking-wide uppercase">Integration Expertise</span>')

# Update services directory page cards
content = content.replace('<i class="fas fa-plug text-laravel-red group-hover:text-white transition-colors duration-300 text-xl"></i>', '<i class="{$data[\'icon\']} text-laravel-red group-hover:text-white transition-colors duration-300 text-xl"></i>')

with open(file_path, "w", encoding="utf-8") as f:
    f.write(content)
