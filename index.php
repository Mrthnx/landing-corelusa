<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . '/includes/data.php';
require_once __DIR__ . '/includes/mail.php';
require_once __DIR__ . '/includes/forms.php';
require_once __DIR__ . '/includes/ui.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$normalized = rtrim($requestPath, '/');
$normalized = $normalized === '' ? '/' : (preg_replace('/\.html$/', '', $normalized) ?: '/');

if ($method === 'POST' && ($normalized === '/request-quote' || $normalized === '/solicite-orcamento')) {
    $result = handle_orcamento($_POST);
    set_feedback('/request-quote', $result['ok'] ? 'success' : 'error', $result['message']);
    redirect_back('/request-quote');
}

if ($method === 'POST' && ($normalized === '/contact' || $normalized === '/entre-em-contato')) {
    $result = handle_contato($_POST);
    set_feedback('/contact', $result['ok'] ? 'success' : 'error', $result['message']);
    redirect_back('/contact');
}

if ($normalized === '/') {
    page_start('CORELUSA - Predictive Maintenance and Industrial Inspection');

    echo '<section class="hero-video-fallback relative overflow-hidden border-b border-border-subtle bg-background bg-cover bg-center bg-no-repeat pt-28">';
    echo '<video class="hero-video" autoplay muted loop playsinline preload="metadata" poster="/images/slider_03.jpg" onloadeddata="this.playbackRate=0.75;"><source src="/videos/hero-bg.mp4" type="video/mp4"></video>';
    echo '<div class="absolute inset-0 bg-[#0a0e17]/60"></div><div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(10,14,23,0.55),rgba(10,14,23,0.45),rgba(10,14,23,0.60))]"></div>';
    echo '<div class="absolute inset-0 opacity-10" style="background-image:radial-gradient(circle at center, rgba(241,245,249,0.15) 1px, transparent 1px);background-size:24px 24px"></div>';
    echo '<div class="relative z-10 mx-auto max-w-[1140px] px-4 py-20 sm:px-6 md:py-28">';
    echo '<div class="grid gap-12 lg:grid-cols-[minmax(0,1.2fr)_minmax(320px,0.8fr)] lg:items-end">';
    echo '<div class="max-w-4xl text-white">';
    echo '<p class="mb-6 font-mono text-xs uppercase tracking-[0.38em] text-[#0066cc] php-fly" style="--php-fly-delay:0ms">INDUSTRIAL MONITORING · PREVENTION · PRECISION</p>';
    echo '<h1 class="mb-6 text-5xl font-bold leading-none md:text-7xl php-fly" style="--php-fly-delay:0ms">TECHNOLOGY THAT <span class="text-[#0066cc]">PREVENTS FAILURES</span></h1>';
    echo '<p class="mb-8 max-w-2xl text-base leading-7 text-slate-200 md:text-lg php-fly" style="--php-fly-delay:180ms">Since 2005, CORELUSA has delivered predictive maintenance and industrial inspection with technical depth, fast response, and commitment to operational continuity.</p>';
    echo '<div class="flex flex-col gap-4 sm:flex-row php-fly" style="--php-fly-delay:320ms"><a href="/request-quote" class="inline-flex items-center justify-center rounded-full border border-[#0066cc] bg-[#0066cc] px-8 py-3 font-semibold text-white transition hover:bg-[#0056ad]">Request a quote</a><a href="/our-services" class="inline-flex items-center justify-center rounded-full border border-[#d9d9d9] bg-white/70 px-8 py-3 font-semibold text-[#111111] transition hover:border-[#0066cc] hover:text-[#0066cc]">Explore services</a></div>';
    echo '</div>';
    echo '<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-1">';
    foreach (array_slice(HOME_STATS, 0, 3) as $stat) {
        $val = (string) $stat['value'];
        echo '<div class="rounded-3xl border border-white/20 bg-background/82 p-5 backdrop-blur-xl shadow-[0_18px_48px_rgba(10,14,23,0.35)]" data-reveal><p class="mb-2 font-mono text-[11px] uppercase tracking-[0.28em] text-white/85">' . h((string) $stat['label']) . '</p><div class="text-3xl font-bold text-[#0066cc] md:text-4xl"><span data-countup="' . h($val) . '">' . h($val) . '</span></div></div>';
    }
    echo '</div></div></div></section>';

    echo '<section class="bg-elevated py-20"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="mb-12 text-center"><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em] text-[#0066cc]">CLIENTS AND PARTNERS</p><h2 class="mb-4 font-heading text-3xl font-bold text-text-main">Major operations trust <span class="text-[#0066cc]">CORELUSA</span></h2><p class="mx-auto max-w-3xl text-text-secondary">We operate with a focus on availability, safety, and predictability for industries that cannot stop.</p></div><div class="overflow-hidden rounded-[2rem] border border-border-subtle bg-[#111827] px-6 py-6 shadow-[0_24px_80px_rgba(10,14,23,0.14)]"><div class="marquee-track flex min-w-max items-center gap-10">';
    $clients = array_merge(CLIENT_LOGOS, CLIENT_LOGOS);
    foreach ($clients as $index => $client) {
        $ariaHidden = $index >= count(CLIENT_LOGOS) ? 'true' : 'false';
        echo '<div class="flex h-20 w-40 items-center justify-center rounded-2xl border px-6 opacity-90 transition duration-300 hover:-translate-y-0.5 hover:border-[#7eb8f7]/50 hover:bg-[#1e293b] hover:opacity-100" style="border-color:rgba(255,255,255,0.12);background:rgba(255,255,255,0.04)" aria-hidden="' . $ariaHidden . '"><img src="' . h((string) $client) . '" alt="CORELUSA client" class="max-h-10 w-auto object-contain brightness-0 invert" loading="lazy"></div>';
    }
    echo '</div></div></div></section>';

    echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="mb-12 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between"><div class="max-w-2xl"><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em] text-[#0066cc]" data-reveal>TECHNICAL CAPABILITIES</p><h2 class="text-3xl font-bold text-text-main md:text-4xl" data-reveal>Services designed to prevent failures and protect critical assets</h2></div><a href="/our-services" class="inline-flex items-center gap-2 self-start rounded-full border border-border-subtle px-5 py-3 font-mono text-xs uppercase tracking-[0.28em] text-text-secondary transition hover:border-secondary/40 hover:text-[#0066cc]" data-reveal>View full portfolio<span aria-hidden="true">→</span></a></div>';
    render_service_grid();
    echo '</div></section>';

    echo '<section class="border-y border-border-subtle bg-surface/60 py-16 text-text-main"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="mb-8 flex flex-col gap-3 text-center"><p class="font-mono text-xs uppercase tracking-[0.32em] text-secondary">OPERATIONS DATA</p><h2 class="text-3xl font-bold">Performance indicators that demonstrate execution and trust</h2></div><div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">';
    foreach (HOME_STATS as $stat) {
        $val = (string) $stat['value'];
        echo '<div class="rounded-3xl border border-border-subtle bg-background/80 p-6 text-center shadow-[0_18px_48px_rgba(10,14,23,0.28)]" data-reveal><div class="mb-3 font-mono text-[11px] uppercase tracking-[0.26em] text-text-secondary">' . h((string) $stat['label']) . '</div><div class="font-heading text-4xl font-bold text-[#0066cc] md:text-5xl"><span data-countup="' . h($val) . '">' . h($val) . '</span></div></div>';
    }
    echo '</div></div></section>';

    echo '<section class="bg-elevated py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="grid gap-12 lg:grid-cols-[minmax(0,1fr)_minmax(340px,0.9fr)] lg:items-stretch"><div><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em] text-[#0066cc]" data-reveal>WHY CORELUSA</p><h2 class="mb-6 text-3xl font-bold text-text-main md:text-4xl" data-reveal>A technical operation designed to reduce risk and increase predictability</h2><p class="max-w-2xl leading-7 text-text-secondary" data-reveal>CORELUSA combines field experience, technical insight, and rapid response to anticipate failures, protect assets, and sustain operational continuity in demanding industrial environments.</p><div class="mt-8 grid gap-4">';
    foreach (HOME_FEATURES as $feature) {
        echo '<div class="rounded-3xl border border-border-subtle bg-surface/70 p-5" data-reveal><p class="mb-2 font-mono text-[11px] uppercase tracking-[0.26em] text-[#0066cc]">' . h((string) $feature['eyebrow']) . '</p><h3 class="mb-2 text-lg font-semibold text-text-main">' . h((string) $feature['title']) . '</h3><p class="text-sm leading-6 text-text-secondary">' . h((string) $feature['desc']) . '</p></div>';
    }
    echo '</div></div><div class="relative overflow-hidden rounded-[2rem] border border-border-subtle bg-dark shadow-[0_24px_80px_rgba(10,14,23,0.45)]" data-reveal><img src="/images/2022/03/02/manutencao-industrial.jpg" alt="CORELUSA technical team" class="h-full w-full object-cover object-[65%_center]"><div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(10,14,23,0.1),rgba(10,14,23,0.85))]"></div><div class="absolute bottom-0 left-0 right-0 p-6"><p class="mb-2 font-mono text-xs uppercase tracking-[0.28em] text-[#0066cc]">FIELD RESPONSE</p><p class="max-w-xs text-sm leading-6 text-slate-200">Support before, during, and after execution with focus on safety, schedule, and technical clarity.</p></div></div></div></div></section>';

    echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="grid gap-12 lg:grid-cols-[minmax(320px,0.95fr)_minmax(0,1.05fr)] lg:items-center"><div class="relative overflow-hidden rounded-[2rem] border border-border-subtle bg-surface shadow-[0_24px_80px_rgba(10,14,23,0.32)]" data-reveal><img src="/images/2022/03/02/about-1.jpg" alt="About CORELUSA" class="h-full w-full object-cover"><div class="absolute left-5 top-5 rounded-2xl border px-4 py-3 backdrop-blur-md" style="background:rgba(10,14,23,0.72);border-color:rgba(255,255,255,0.15)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#7eb8f7">STATUS</p><p class="text-sm font-semibold text-white">ACTIVE OPERATION</p></div></div><div><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em] text-[#0066cc]" data-reveal>ABOUT US</p><h2 class="mb-5 text-3xl font-bold text-text-main md:text-4xl" data-reveal>Technical execution with precision, safety, and advisory support</h2><p class="mb-6 max-w-2xl leading-7 text-text-secondary" data-reveal>We are an Inmetro-accredited company recognized for delivering predictive maintenance, industrial inspection, and technical follow-up with a long-term view for every plant.</p><div class="mb-8 grid gap-4 sm:grid-cols-2"><div class="rounded-3xl border border-border-subtle bg-surface/60 p-5" data-reveal><p class="font-mono text-[11px] uppercase tracking-[0.24em] text-[#0066cc]">DIAGNOSIS</p><p class="mt-2 text-sm leading-6 text-text-secondary">Data-driven assessment to anticipate failures and define real priorities.</p></div><div class="rounded-3xl border border-border-subtle bg-surface/60 p-5" data-reveal><p class="font-mono text-[11px] uppercase tracking-[0.24em] text-[#0066cc]">CONTINUITY</p><p class="mt-2 text-sm leading-6 text-text-secondary">Execution focused on reducing downtime, increasing reliability, and protecting production.</p></div></div><h3 class="mb-4 font-heading text-lg font-bold uppercase tracking-wider text-[#0066cc]" data-reveal>O QUE NÓS FAZEMOS</h3><div class="mb-8 flex flex-wrap gap-3" data-reveal>';
    foreach (['Vibration Analysis', 'Oil Analysis', 'Infrared Thermography', 'Laser Alignment'] as $item) {
        echo '<span class="rounded-full bg-surface px-4 py-2 text-sm text-text-main">' . h($item) . '</span>';
    }
    echo '</div><a href="/about-us" class="inline-flex items-center gap-2 rounded-full border border-secondary/40 px-6 py-3 font-semibold text-[#0066cc] transition hover:bg-[#0066cc] hover:text-white" data-reveal>Get to know CORELUSA<span aria-hidden="true">→</span></a></div></div></div></section>';

    echo '<section class="relative overflow-hidden bg-dark py-20 text-white"><div class="absolute inset-0 bg-[#08111f]"></div><div class="absolute inset-0" style="background-image:url(\'/images/world-map-dark.png\');background-size:cover;background-position:center"></div><div class="absolute inset-0"></div><div class="relative z-10 mx-auto max-w-[1140px] px-4 sm:px-6"><div class="mb-12 text-center"><h2 class="mb-2 font-heading text-3xl font-bold text-white" data-reveal>OUR DIFFERENTIALS</h2></div><div class="grid grid-cols-2 gap-8 text-center md:grid-cols-4">';
    foreach (HOME_DIFFERENTIALS as $diff) {
        echo '<div data-reveal><div class="mb-2 font-heading text-4xl font-bold md:text-5xl" style="color:#7eb8f7">' . h((string) $diff['value']) . '</div><div class="text-sm uppercase tracking-wider text-slate-200">' . h((string) $diff['label']) . '</div></div>';
    }
    echo '</div></div></section>';

    echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="overflow-hidden rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.18)] md:p-12" style="border-color:rgba(0,102,204,0.18);background:#0f172a" data-reveal><div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between"><div class="max-w-3xl"><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em]" style="color:#7eb8f7" data-reveal>READY TO START?</p><h2 class="mb-4 text-3xl font-bold text-white md:text-4xl" data-reveal>Request a no-obligation quote and discover where your operation can gain predictability</h2><p class="leading-7 text-slate-200" data-reveal>Our team reviews your scenario, identifies critical points, and proposes the best path to increase reliability and reduce unplanned downtime.</p></div><a href="/request-quote" class="inline-flex items-center justify-center rounded-full border px-8 py-4 font-semibold shadow-[0_0_24px_rgba(0,102,204,0.22)] transition hover:bg-[#0056ad]" style="border-color:#0066cc;background:#0066cc;color:#ffffff" data-reveal>Request a quote</a></div></div></div></section>';

    page_end();
    exit;
}

if ($normalized === '/about-us' || $normalized === '/quem-somos') {
    page_start('About CORELUSA', 'A journey built on technical expertise, schedule commitment, and operational continuity.', '/images/2022/03/02/about-1.jpg');
    // Forzamos colores como en Svelte para no depender de tokens custom del CDN.
    echo '<section class="py-16 md:py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="grid gap-14 lg:grid-cols-[minmax(0,1fr)_380px] lg:items-start"><div>';
    echo '<div class="mb-10 rounded-[2rem] border p-8" style="border-color:rgba(0,102,204,0.25);background:#1e2535">';
    echo '<p class="mb-4 font-mono text-xs uppercase tracking-[0.3em]" style="color:#7eb8f7">WHY CHOOSE CORELUSA</p>';
    echo '<p class="text-base leading-8" style="color:#e2e8f0">Due to the shortage of qualified professionals and frequent quality gaps in the market, CORELUSA works to deliver safety, quality, strong cost-benefit, and commitment—preventing future failures and reducing production stoppage risks.</p>';
    echo '</div>';
    echo '<div class="mb-10 rounded-[2rem] border p-8" style="border-color:rgba(0,102,204,0.25);background:#1e2535">';
    echo '<p class="mb-4 font-mono text-xs uppercase tracking-[0.3em]" style="color:#7eb8f7">MISSION AND VISION</p>';
    echo '<p class="text-base leading-8" style="color:#e2e8f0">Deliver service contracts with specialized labor, continuously pursuing better solutions and strengthening client trust through predictive maintenance and safe equipment monitoring.</p>';
    echo '</div>';
    echo '<div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div class="rounded-3xl border bg-[#1e2535] p-6" style="border-color:rgba(0,102,204,0.25)"><h3 class="mb-2 text-lg font-semibold" style="color:#7eb8f7">Certified Company</h3><p class="text-sm leading-6" style="color:#cbd5e1">We are proud to inform that CORELUSA is certified across key areas of operation.</p></div>';
    echo '<div class="rounded-3xl border bg-[#1e2535] p-6" style="border-color:rgba(0,102,204,0.25)"><h3 class="mb-2 text-lg font-semibold" style="color:#7eb8f7">Innovative Technology</h3><p class="text-sm leading-6" style="color:#cbd5e1">We invest continuously in modern equipment and Industry 4.0-ready technical methods.</p></div>';
    echo '<div class="rounded-3xl border bg-[#1e2535] p-6" style="border-color:rgba(0,102,204,0.25)"><h3 class="mb-2 text-lg font-semibold" style="color:#7eb8f7">Market Presence</h3><p class="text-sm leading-6" style="color:#cbd5e1">An Inmetro-accredited company with consolidated technical performance in the sector.</p></div>';
    echo '<div class="rounded-3xl border bg-[#1e2535] p-6" style="border-color:rgba(0,102,204,0.25)"><h3 class="mb-2 text-lg font-semibold" style="color:#7eb8f7">Experienced Team</h3><p class="text-sm leading-6" style="color:#cbd5e1">Professionals with strong field background focused on precision and operational safety.</p></div>';
    echo '</div>';
    echo '<div class="rounded-[2rem] border bg-[#1e2535] p-8 text-center" style="border-color:rgba(0,102,204,0.25)"><h3 class="mb-4 text-xl font-bold uppercase tracking-wider" style="color:#7eb8f7">Beyond Borders</h3><p class="leading-7" style="color:#e2e8f0">We serve clients in over 25 countries and continue expanding our presence in South America, the United States, and Europe with commitment to quality, performance, and productivity.</p></div>';
    echo '</div><div class="lg:sticky lg:top-24"><p class="mb-4 font-mono text-xs uppercase tracking-[0.3em]" style="color:#0066cc">TIMELINE</p>';
    render_timeline();
    echo '</div></div></div></section>';
    page_end();
    exit;
}

if ($normalized === '/our-services' || $normalized === '/nossos-servicos') {
    page_start('Our Services', 'A technical portfolio for predictive maintenance, industrial inspection, and failure prevention.', '/images/desk1.jpg');
    echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6">';
    echo '<div class="mb-12 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">';
    echo '<div class="max-w-2xl">';
    echo '<p class="mb-4 font-mono text-xs uppercase tracking-[0.34em]" style="color:#0066cc">TECHNICAL CAPABILITIES</p>';
    echo '<h2 class="text-3xl font-bold md:text-4xl" style="color:#f1f5f9" data-reveal>Services designed to prevent failures and protect critical assets</h2>';
    echo '</div>';
    echo '<a href="/our-services" class="inline-flex items-center gap-2 self-start rounded-full border px-5 py-3 font-mono text-xs uppercase tracking-[0.28em] transition" style="border-color:rgba(0,102,204,0.18);color:#94a3b8">View full portfolio<span aria-hidden="true">→</span></a>';
    echo '</div>';
    render_service_grid();
    echo '</div></section>';
    page_end();
    exit;
}

if ($normalized === '/products') {
    page_start('Products', 'Explore PDM product lines for online monitoring and portable inspections.', '/images/desk1.jpg');
    echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 sm:px-6">';
    echo '<div class="mb-10"><p class="mb-4 font-mono text-xs uppercase tracking-[0.34em]" style="color:#0066cc">PRODUCTS</p><h2 class="text-3xl font-bold md:text-4xl" style="color:#f1f5f9">PDM hardware built for industrial environments</h2><p class="mt-4 max-w-2xl leading-7" style="color:#cbd5e1">Choose between continuous online monitoring (V100) or fast portable inspections (V200).</p></div>';
    echo '<div class="grid gap-6 md:grid-cols-2">';
    foreach (PRODUCT_ITEMS as $product) {
        $key = (string) $product['value'];
        $content = PRODUCT_CONTENT[$key] ?? null;
        if (!is_array($content)) {
            continue;
        }
        echo '<a href="' . h((string) $product['href']) . '" class="group overflow-hidden rounded-[2rem] border bg-[#0f172a] p-8 shadow-[0_24px_80px_rgba(10,14,23,0.35)] transition hover:-translate-y-1" style="border-color:rgba(0,102,204,0.22)">';
        echo '<p class="font-mono text-xs uppercase tracking-[0.34em]" style="color:#7eb8f7">' . h((string) $content['badge']) . '</p>';
        echo '<h3 class="mt-3 text-2xl font-bold" style="color:#f1f5f9">' . h((string) $content['title']) . '</h3>';
        echo '<p class="mt-3 leading-7" style="color:#cbd5e1">' . h((string) $content['subtitle']) . '</p>';
        echo '<span class="mt-6 inline-flex items-center gap-2 font-mono text-xs uppercase tracking-[0.24em]" style="color:#7eb8f7">View details<span aria-hidden="true">→</span></span>';
        echo '</a>';
    }
    echo '</div></div></section>';
    page_end();
    exit;
}

if (str_starts_with($normalized, '/products/')) {
    $slug = basename($normalized);
    if (!isset(PRODUCT_CONTENT[$slug])) {
        http_response_code(404);
        page_start('Page not found');
        echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 text-center sm:px-6"><h1 class="mb-3 text-3xl font-bold">404</h1><p class="text-text-secondary">Product not found.</p></div></section>';
        page_end();
        exit;
    }

    $product = PRODUCT_CONTENT[$slug];
    // Estructura tipo "product showcase": specs + stats a la izquierda, imagen hero a la derecha.
    // Usamos un hero neutro para no oscurecer el render del producto.
    page_start((string) $product['title'], (string) $product['subtitle'], '/images/desk1.jpg');
    echo '<section class="py-16 md:py-20"><div class="mx-auto max-w-[1140px] px-4 sm:px-6">';

    // HERO (2 columnas)
    echo '<div class="grid gap-10 lg:grid-cols-[minmax(0,1fr)_minmax(0,1fr)] lg:items-start">';

    // Left: badge + title + quick specs + stats
    echo '<div class="pt-2">';
    echo '<a href="/products" class="inline-flex items-center gap-2 rounded-full border px-4 py-2 font-mono text-xs uppercase tracking-[0.28em] transition hover:border-[#0066cc]" style="border-color:rgba(0,102,204,0.22);color:#0066cc">' . h((string) $product['badge']) . '<span aria-hidden="true">→</span></a>';
    echo '<h2 class="mt-6 text-4xl font-bold leading-[1.05] md:text-5xl" style="color:#111111">' . h((string) $product['title']) . '</h2>';
    echo '<p class="mt-4 max-w-xl text-base leading-7" style="color:#475569">' . h((string) $product['subtitle']) . '</p>';

    // Key highlights (no duplicar la sección completa de especificaciones)
    echo '<ul class="mt-8 space-y-3 text-sm" style="color:#334155">';
    $quickSpecs = array_slice((array) $product['specs'], 0, 6);
    foreach ($quickSpecs as $spec) {
        $clean = preg_replace('/^\s*✓\s*/u', '', (string) $spec);
        echo '<li class="flex gap-2"><span aria-hidden="true" style="color:#0066cc">✓</span><span>' . h($clean) . '</span></li>';
    }
    echo '</ul>';

    if (isset($product['stats']) && is_array($product['stats'])) {
        echo '<div class="mt-10 grid grid-cols-3 gap-6 border-t pt-8" style="border-color:rgba(0,102,204,0.14)">';
        foreach ($product['stats'] as $stat) {
            echo '<div>';
            echo '<div class="font-heading text-2xl font-bold" style="color:#0f172a">' . h((string) $stat['value']) . '</div>';
            echo '<div class="mt-1 text-xs uppercase tracking-[0.22em]" style="color:#64748b">' . h((string) $stat['label']) . '</div>';
            echo '</div>';
        }
        echo '</div>';
    }

    echo '<div class="mt-10 flex flex-wrap gap-3">';
    echo '<a href="/request-quote" class="inline-flex items-center justify-center rounded-full border px-6 py-3 font-semibold shadow-[0_0_24px_rgba(0,102,204,0.14)] transition hover:bg-[#0056ad]" style="border-color:#0066cc;background:#0066cc;color:#ffffff">Request a quote</a>';
    echo '<a href="#details" class="inline-flex items-center justify-center rounded-full border px-6 py-3 font-semibold transition hover:border-[#0066cc] hover:text-[#0066cc]" style="border-color:rgba(0,102,204,0.20);color:#0f172a">See details</a>';
    echo '</div>';
    echo '</div>';

    // Right: framed product image
    echo '<div class="relative">';
    echo '<div class="relative overflow-hidden rounded-[2rem] border bg-white shadow-[0_24px_80px_rgba(10,14,23,0.12)]" style="border-color:rgba(0,102,204,0.18)">';
    echo '<div class="absolute inset-0" style="background:radial-gradient(circle at top right, rgba(0,102,204,0.10), transparent 55%), radial-gradient(circle at bottom left, rgba(126,184,247,0.18), transparent 55%)"></div>';
    echo '<div class="absolute inset-6 rounded-[1.5rem] border" style="border-color:rgba(0,102,204,0.14)"></div>';
    echo '<img src="' . h(canonicalize_image((string) $product['image'])) . '" alt="' . h((string) $product['title']) . '" class="relative z-10 h-[520px] w-full object-contain px-10 py-12 md:h-[620px]" loading="lazy">';
    echo '</div>';
    echo '</div>';

    echo '</div>';

    // DETAILS (solo specs completas)
    // scroll-mt: compensa el header sticky al navegar con #details
    echo '<div id="details" class="mt-16 scroll-mt-24">';
    echo '<div class="rounded-[2rem] border bg-white p-8 shadow-[0_24px_80px_rgba(10,14,23,0.12)]" style="border-color:rgba(0,102,204,0.18)">';
    echo '<div class="mb-6 flex items-end justify-between gap-6">';
    echo '<h3 class="text-2xl font-bold" style="color:#111111">Technical specifications</h3>';
    echo '<a href="/request-quote" class="hidden rounded-full border px-5 py-2 text-sm font-semibold transition hover:bg-[#0056ad] md:inline-flex" style="border-color:#0066cc;background:#0066cc;color:#ffffff">Request a quote</a>';
    echo '</div>';
    echo '<ul class="grid gap-3 text-sm md:grid-cols-2" style="color:#334155">';
    foreach ($product['specs'] as $spec) {
        $clean = preg_replace('/^\s*✓\s*/u', '', (string) $spec);
        echo '<li class="flex gap-2"><span aria-hidden="true" style="color:#0066cc">✓</span><span>' . h($clean) . '</span></li>';
    }
    echo '</ul>';
    echo '<div class="mt-8 md:hidden">';
    echo '<a href="/request-quote" class="inline-flex w-full items-center justify-center rounded-full border px-6 py-3 font-semibold transition hover:bg-[#0056ad]" style="border-color:#0066cc;background:#0066cc;color:#ffffff">Request a quote</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';

    // HOW IT WORKS (solo abajo)
    echo '<div class="mt-12 rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.18)]" style="border-color:rgba(0,102,204,0.18);background:#0f172a">';
    echo '<div class="mb-8 flex flex-col gap-2 md:flex-row md:items-end md:justify-between">';
    echo '<div><p class="font-mono text-xs uppercase tracking-[0.34em]" style="color:#7eb8f7">HOW IT WORKS</p><h3 class="mt-3 text-2xl font-bold" style="color:#f1f5f9">Setup and usage in three steps</h3></div>';
    echo '<a href="/request-quote" class="inline-flex items-center justify-center rounded-full border px-6 py-3 font-semibold transition hover:bg-[#0056ad]" style="border-color:#0066cc;background:#0066cc;color:#ffffff">Request a quote</a>';
    echo '</div>';
    echo '<div class="grid gap-4 lg:grid-cols-3">';
    foreach ($product['steps'] as $step) {
        echo '<div class="rounded-2xl border p-6" style="border-color:rgba(255,255,255,0.12);background:rgba(10,14,23,0.55)">';
        echo '<p class="font-mono text-xs uppercase tracking-[0.24em]" style="color:#7eb8f7">' . h((string) $step['number']) . '</p>';
        echo '<h4 class="mt-3 text-base font-semibold" style="color:#f1f5f9">' . h((string) $step['title']) . '</h4>';
        echo '<p class="mt-3 text-sm leading-6" style="color:#cbd5e1">' . h((string) $step['description']) . '</p>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';

    echo '</div></div></section>';
    page_end();
    exit;
}

if ($normalized === '/request-quote' || $normalized === '/solicite-orcamento') {
    page_start('No-obligation Quote', 'Share your operational context and we will align the best technical approach for your needs.', '/images/2022/03/02/manutencao-industrial.jpg');
    $feedback = consume_feedback('/request-quote');
    echo '<section class="relative overflow-hidden py-20"><div class="absolute inset-0" style="background:radial-gradient(circle at top right, rgba(0,102,204,0.12), transparent 30%), radial-gradient(circle at bottom left, rgba(16,185,129,0.10), transparent 28%)"></div><div class="relative z-10 mx-auto max-w-[1140px] px-4 sm:px-6">';
    if ($feedback) {
        $style = $feedback['status'] === 'success' ? 'border-emerald-500 bg-emerald-900/30 text-emerald-200' : 'border-rose-500 bg-rose-900/30 text-rose-200';
        echo '<p class="mb-6 rounded-2xl border px-4 py-3 ' . $style . '">' . h((string) $feedback['message']) . '</p>';
    }
    echo '<div class="grid gap-8 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:items-start">';
    echo '<aside class="rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.45)]" style="border-color:rgba(0,102,204,0.22);background:#0f172a">';
    echo '<p class="mb-4 font-mono text-xs uppercase tracking-[0.3em]" style="color:#0066cc">TECHNICAL QUOTE</p>';
    echo '<h2 class="mb-4 text-3xl font-bold" style="color:#f1f5f9">Request a quote with enough context for a more precise recommendation</h2>';
    echo '<p class="mb-8 leading-7" style="color:#cbd5e1">The better we understand your operation, its criticality, and the service required, the more accurate our initial recommendation will be.</p>';
    echo '<div class="space-y-4">';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">ESCOPO</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Share the service of interest and the operational context of your request.</p></div>';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">SPEED</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Complete details reduce rework and speed up our response.</p></div>';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">SUPPORT</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Execution focused on predictive maintenance, industrial inspection, and operational continuity.</p></div>';
    echo '</div></aside>';
    echo '<div class="rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.45)] md:p-10" style="border-color:rgba(0,102,204,0.22);background:#0f172a">';
    echo '<form method="post" action="/request-quote" class="space-y-6">';
    echo '<input type="hidden" name="_csrf" value="' . h(csrf_token()) . '"><input type="hidden" name="captcha" value="7"><input type="text" name="_hp" class="hidden" tabindex="-1" autocomplete="off">';
    echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div><label for="nome" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Seu Nome:</label><input type="text" id="nome" name="nome" placeholder="Digite o seu Nome" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '<div><label for="endereco" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Endereço Completo:</label><input type="text" id="endereco" name="endereco" placeholder="Digite o seu Endereço" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '</div>';
    echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div><label for="complemento" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Complemento:</label><input type="text" id="complemento" name="complemento" placeholder="Digite o Complemento" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '<div><label for="email" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">E-mail: <span class="text-red-500">*</span></label><input type="email" id="email" name="email" placeholder="Digite o seu E-mail" required class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '</div>';
    echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div><label for="telefone" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Telefone:</label><input type="text" id="telefone" name="telefone" placeholder="Digite o seu Telefone/Celular" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '<div><label for="cidade" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Cidade:</label><input type="text" id="cidade" name="cidade" placeholder="Digite a sua Cidade" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '</div>';
    echo '<div><label for="servico" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Service of Interest:</label><select id="servico" name="servico" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"><option value="">Select a service</option>';
    foreach (SERVICE_ITEMS as $service) {
        echo '<option value="' . h((string) $service['label']) . '">' . h((string) $service['label']) . '</option>';
    }
    echo '</select></div>';
    echo '<div><label for="mensagem" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Message:</label><textarea id="mensagem" name="mensagem" rows="4" placeholder="Type your message" class="php-field w-full resize-none rounded-md border px-4 py-2.5 transition-all"></textarea></div>';
    echo '<button type="submit" class="w-full rounded-md px-8 py-3 font-semibold transition-colors md:w-auto" style="background:#0066cc;color:#ffffff">Request Quote</button>';
    echo '</form></div></div></div></section>';
    page_end();
    exit;
}

if ($normalized === '/contact' || $normalized === '/entre-em-contato') {
    page_start('Contact Us', 'Talk to our team to clarify questions, assess scenarios, and define the best solution for your operation.', '/images/slider_03.jpg');
    $feedback = consume_feedback('/contact');
    echo '<section class="relative overflow-hidden py-20"><div class="absolute inset-0" style="background:radial-gradient(circle at top right, rgba(0,102,204,0.12), transparent 30%), radial-gradient(circle at bottom left, rgba(16,185,129,0.10), transparent 28%)"></div><div class="relative z-10 mx-auto max-w-[1140px] px-4 sm:px-6">';
    if ($feedback) {
        $style = $feedback['status'] === 'success' ? 'border-emerald-500 bg-emerald-900/30 text-emerald-200' : 'border-rose-500 bg-rose-900/30 text-rose-200';
        echo '<p class="mb-6 rounded-2xl border px-4 py-3 ' . $style . '">' . h((string) $feedback['message']) . '</p>';
    }
    echo '<div class="grid gap-8 lg:grid-cols-[minmax(0,0.85fr)_minmax(0,1.15fr)] lg:items-start">';
    echo '<aside class="rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.45)]" style="border-color:rgba(0,102,204,0.22);background:#0f172a">';
    echo '<h2 class="mb-4 text-3xl font-bold" style="color:#f1f5f9">Está em dúvida? Nossa equipe retorna com orientação técnica.</h2>';
    echo '<p class="mb-8 leading-7" style="color:#cbd5e1">Fill out the form to talk to CORELUSA. We organize our response around context, operational priority, and clear next steps.</p>';
    echo '<div class="space-y-4">';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">SUPPORT</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Suporte antes, durante e após a execução dos serviços.</p></div>';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">FOCO</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Esclarecer dúvidas, analisar cenários e direcionar a melhor solução.</p></div>';
    echo '<div class="rounded-2xl border p-4" style="border-color:rgba(0,102,204,0.18);background:rgba(10,14,23,0.78)"><p class="font-mono text-[11px] uppercase tracking-[0.24em]" style="color:#0066cc">RESPONSE</p><p class="mt-2 text-sm leading-6" style="color:#f1f5f9">Structured contact to understand your criticality and timeline.</p></div>';
    echo '</div></aside>';
    echo '<div class="rounded-[2rem] border p-8 shadow-[0_24px_80px_rgba(10,14,23,0.45)] md:p-10" style="border-color:rgba(0,102,204,0.22);background:#0f172a">';
    echo '<form method="post" action="/contact" class="space-y-6">';
    echo '<input type="hidden" name="_csrf" value="' . h(csrf_token()) . '"><input type="hidden" name="captcha" value="7"><input type="text" name="_hp" class="hidden" tabindex="-1" autocomplete="off">';
    echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div><label for="nome" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Nome:</label><input type="text" id="nome" name="nome" placeholder="Digite seu Nome" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '<div><label for="email" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Email: <span class="text-red-500">*</span></label><input type="email" id="email" name="email" placeholder="Digite seu E-mail" required class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '</div>';
    echo '<div class="grid grid-cols-1 gap-6 md:grid-cols-2">';
    echo '<div><label for="telefone" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Telefone:</label><input type="text" id="telefone" name="telefone" placeholder="Digite seu Telefone/Celular com DDD" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '<div><label for="assunto" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Assunto:</label><input type="text" id="assunto" name="assunto" placeholder="Digite o Assunto" class="php-field w-full rounded-md border px-4 py-2.5 transition-all"></div>';
    echo '</div>';
    echo '<div><label for="mensagem" class="mb-1 block text-sm font-medium" style="color:#cbd5e1">Message:</label><textarea id="mensagem" name="mensagem" rows="5" placeholder="Type your message" class="php-field w-full resize-none rounded-md border px-4 py-2.5 transition-all"></textarea></div>';
    echo '<button type="submit" class="w-full rounded-md px-8 py-3 font-semibold transition-colors md:w-auto" style="background:#0066cc;color:#ffffff">Send Message</button>';
    echo '</form></div></div></div></section>';
    page_end();
    exit;
}

if (str_starts_with($normalized, '/our-services/') || str_starts_with($normalized, '/nossos-servicos/')) {
    $slug = basename($normalized);
    if (!isset(SERVICE_CONTENT[$slug])) {
        http_response_code(404);
        page_start('Page not found');
        echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 text-center sm:px-6"><h1 class="mb-3 text-3xl font-bold">404</h1><p class="text-text-secondary">Service not found.</p></div></section>';
        page_end();
        exit;
    }

    $service = SERVICE_CONTENT[$slug];
    page_start((string) $service['title'], 'Technical execution focused on availability, safety, and operational reliability.', '/images/desk1.jpg');
    echo '<section class="py-16" style="background:#f5f5f7"><div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="flex flex-col gap-8 lg:flex-row"><div class="lg:w-3/4">';
    if ((string) $service['image'] !== '') {
        echo '<img src="' . h(canonicalize_image((string) $service['image'])) . '" alt="' . h((string) $service['title']) . '" class="mb-8 w-full rounded-[2rem] border shadow-md" style="border-color:rgba(0,102,204,0.18)">';
    }
    echo '<div class="max-w-none space-y-5 rounded-[2rem] border bg-white p-8 text-justify leading-relaxed shadow-[0_24px_80px_rgba(10,14,23,0.12)]" style="border-color:rgba(0,102,204,0.18);color:#111111">' . $service['content'] . '</div></div>';
    echo '<div class="lg:w-1/4"><div class="sticky top-24 space-y-3"><div class="rounded-[2rem] border bg-white p-6 shadow-[0_24px_80px_rgba(10,14,23,0.12)]" style="border-color:rgba(0,102,204,0.18)"><p class="mb-2 font-mono text-[11px] uppercase tracking-[0.26em]" style="color:#0066cc">OTHER SERVICES</p><h3 class="mb-4 font-heading text-lg font-semibold" style="color:#111111">Technical navigation</h3><div class="space-y-3">';
    foreach (SERVICE_ITEMS as $item) {
        $active = is_active_path((string) $item['href']);
        $classes = $active
            ? 'border-[#0066cc] bg-[#0066cc] text-white'
            : 'border-border-subtle text-text-main hover:border-[#0066cc]/40 hover:bg-[#f5f5f7] hover:text-[#0066cc]';
        echo '<a href="' . h((string) $item['href']) . '" class="block rounded-2xl border px-4 py-3 text-sm font-medium transition-colors ' . $classes . '">' . h((string) $item['label']) . '</a>';
    }
    echo '</div></div></div></div></div></section>';
    page_end();
    exit;
}

http_response_code(404);
page_start('Page not found');
echo '<section class="py-24"><div class="mx-auto max-w-[1140px] px-4 text-center sm:px-6"><h1 class="mb-3 text-3xl font-bold">404</h1><p class="text-text-secondary">Route not found.</p></div></section>';
page_end();
