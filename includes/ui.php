<?php

declare(strict_types=1);

function h(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}

function canonicalize_image(string $path): string
{
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }

    return str_starts_with($path, '/') ? $path : '/' . $path;
}

function current_path(): string
{
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $normalized = rtrim($requestPath, '/');

    // PHP < 8.0 no soporta ternarios anidados sin paréntesis.
    // Queremos: si está vacío => '/', si no => (path sin .html) o '/' si queda vacío.
    return $normalized === '' ? '/' : (preg_replace('/\.html$/', '', $normalized) ?: '/');
}

function is_active_path(string $href): bool
{
    return current_path() === $href;
}

function render_desktop_nav_link(array $item): void
{
    $active = is_active_path((string) $item['href']);
    $classes = $active
        ? 'border-[#0066cc] bg-[#0066cc] text-white'
        : 'border-transparent text-[#111111] hover:border-[#d9d9d9] hover:bg-white hover:text-[#0066cc]';

    echo '<a href="' . h((string) $item['href']) . '" class="rounded-full border px-4 py-2 text-sm font-medium uppercase tracking-wide transition-colors ' . $classes . '">' . h((string) $item['label']) . '</a>';
}

function render_mobile_nav_link(array $item): void
{
    $active = is_active_path((string) $item['href']);
    $classes = $active ? 'bg-[#0066cc] text-white' : 'text-[#111111] hover:bg-[#f5f5f7] hover:text-[#0066cc]';
    echo '<a href="' . h((string) $item['href']) . '" class="rounded-2xl px-3 py-2 text-sm font-medium uppercase tracking-wide transition-colors ' . $classes . '">' . h((string) $item['label']) . '</a>';
}

function render_brand_signature(string $context = 'nav'): void
{
    $logo = '<img src="/images/monitor.svg" alt="CORELUSA PDM Technologies" class="h-full w-full object-contain" loading="eager">';

    if ($context === 'hero') {
        echo '<div class="mb-8 inline-flex items-center gap-5 rounded-[100px] border border-white/25 bg-white/20 px-6 py-4 backdrop-blur-md php-fly" style="--php-fly-delay:0ms">';
        echo '<div class="flex h-11 w-11 items-center justify-center">' . $logo . '</div>';
        echo '<div class="leading-tight"><p class="mb-1 text-[0.6rem] font-mono uppercase tracking-[0.32em] text-[#7eb8f7]">INDUSTRIAL MONITORING PLATFORM</p><p class="text-base font-semibold text-white md:text-lg">Corelusa PDM Technologies</p></div>';
        echo '</div>';
        return;
    }

    echo '<a href="/" class="inline-flex items-center gap-3 rounded-full px-1 py-1 transition hover:opacity-90" aria-label="Go to CORELUSA home">';
    echo '<span class="flex h-10 w-10 items-center justify-center"><span class="h-8 w-8">' . $logo . '</span></span>';
    echo '<span class="leading-tight"><span class="block text-xs font-mono uppercase tracking-[0.28em] text-[#0066cc]">CORELUSA</span><span class="hidden text-sm font-semibold text-[#111111] sm:block">PDM Technologies</span></span>';
    echo '</a>';
}

function page_start(string $title, string $subtitle = '', ?string $heroImage = null, string $description = 'CORELUSA: predictive maintenance and industrial inspection focused on operational continuity.'): void
{
    $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $host = $_SERVER['HTTP_HOST'] ?? 'www.corelusa.com.br';
    $canonical = 'https://' . $host . $requestPath;
    $path = current_path();

    echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="text-scale" content="scale">';
    echo '<title>' . h($title) . '</title>';
    echo '<meta name="description" content="' . h($description) . '">';
    echo '<link rel="canonical" href="' . h($canonical) . '">';
    echo '<link rel="icon" type="image/png" href="/images/favicon.png?v=2">';
    // Importante: replicamos EXACTO el tailwind.config.js de la landing Svelte.
    echo '<script>tailwind.config={theme:{extend:{colors:{background:"#f5f5f7",elevated:"#ffffff",surface:"#fbfbfd","border-subtle":"#d9d9d9","text-main":"#111111","text-secondary":"#6e6e73",primary:"#0066cc",secondary:"#0066cc",tertiary:"#0066cc",whatsapp:"#22c55e",dark:"#111111",darker:"#0b0b0c"},fontFamily:{sans:["-apple-system","BlinkMacSystemFont","system-ui","Segoe UI","Roboto","Helvetica","Arial","sans-serif"],heading:["-apple-system","BlinkMacSystemFont","system-ui","Segoe UI","Roboto","Helvetica","Arial","sans-serif"],mono:["ui-monospace","SFMono-Regular","Menlo","Monaco","Consolas","monospace"]}}}}</script>';
    echo '<script src="https://cdn.tailwindcss.com"></script>';
    echo '<link rel="stylesheet" href="/assets/css/site.css">';
    echo '</head><body class="bg-background font-sans text-text-main">';

    // NOTE: usamos colores explícitos para evitar depender de tailwind.config en runtime.
    echo '<a href="https://wa.me/5511947307300" target="_blank" rel="noopener noreferrer" aria-label="Talk to CORELUSA on WhatsApp" class="fixed bottom-6 left-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#22c55e] text-white transition-colors hover:scale-105 hover:bg-[#22c55e]/85">';
    echo '<svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>';
    echo '</a>';
    echo '<div id="scroll-progress" class="fixed left-0 top-0 z-[60] h-[2px] bg-[#0066cc] transition-[width] duration-150" style="width:0"></div>';

    // Igualamos EXACTO el navbar de Svelte: bg-elevated/85 + border-border-subtle.
    echo '<header class="sticky top-0 z-40 border-b border-[#d9d9d9] bg-white/95 text-[#111111] backdrop-blur-md">';
    echo '<input id="mobile-nav-toggle" type="checkbox" class="hidden">';
    echo '<div class="mx-auto max-w-[1140px] px-4 sm:px-6"><div class="flex h-16 items-center justify-between gap-6">';
    render_brand_signature();
    echo '<nav class="hidden items-center gap-1 lg:flex">';
    foreach (NAV_ITEMS as $item) {
        render_desktop_nav_link($item);
    }
    $serviceActive = str_starts_with($path, '/our-services') || str_starts_with($path, '/nossos-servicos');
    $productsActive = str_starts_with($path, '/products');

    // Products dropdown (V100 / V200)
    $productsButton = $productsActive
        ? 'border-[#0066cc] bg-[#0066cc] text-white'
        : 'border-transparent text-[#111111] hover:border-[#d9d9d9] hover:bg-[#f5f5f7] hover:text-[#0066cc]';
    echo '<div class="group relative after:absolute after:left-0 after:top-full after:h-3 after:w-full after:content-[\'\']">';
    echo '<button type="button" class="flex items-center gap-1 rounded-full border px-4 py-2 text-sm font-medium uppercase tracking-wide transition-colors ' . $productsButton . '">Products<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>';
    echo '<div class="absolute left-0 top-full z-50 hidden min-w-[240px] overflow-hidden rounded-3xl border border-border-subtle bg-white text-text-main group-hover:block">';
    foreach (PRODUCT_ITEMS as $product) {
        $active = is_active_path((string) $product['href']);
        $classes = $active ? 'bg-[#0066cc] font-semibold text-white' : 'bg-transparent text-text-main hover:bg-[#f5f5f7] hover:text-[#0066cc]';
        echo '<a href="' . h((string) $product['href']) . '" class="block border-b border-white/10 px-5 py-4 text-sm transition-colors last:border-0 ' . $classes . '">' . h((string) $product['label']) . '</a>';
    }
    echo '</div></div>';

    $serviceButton = $serviceActive
        ? 'border-[#0066cc] bg-[#0066cc] text-white'
        : 'border-transparent text-[#111111] hover:border-[#d9d9d9] hover:bg-[#f5f5f7] hover:text-[#0066cc]';
    echo '<div class="group relative after:absolute after:left-0 after:top-full after:h-3 after:w-full after:content-[\'\']">';
    echo '<button type="button" class="flex items-center gap-1 rounded-full border px-4 py-2 text-sm font-medium uppercase tracking-wide transition-colors ' . $serviceButton . '">Our Services<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></button>';
    echo '<div class="absolute left-0 top-full z-50 hidden min-w-[320px] overflow-hidden rounded-3xl border border-border-subtle bg-white text-text-main group-hover:block">';
    foreach (SERVICE_ITEMS as $service) {
        $active = is_active_path((string) $service['href']);
        $classes = $active ? 'bg-[#0066cc] font-semibold text-white' : 'bg-transparent text-text-main hover:bg-[#f5f5f7] hover:text-[#0066cc]';
        echo '<a href="' . h((string) $service['href']) . '" class="block border-b border-white/10 px-5 py-4 text-sm transition-colors last:border-0 ' . $classes . '">' . h((string) $service['label']) . '</a>';
    }
    echo '</div></div></nav>';
    echo '<label for="mobile-nav-toggle" class="inline-flex cursor-pointer p-2 lg:hidden" aria-label="Menu"><svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg></label>';
    echo '</div></div>';
    echo '<div class="mobile-menu border-t border-[#d9d9d9] bg-white lg:hidden"><div class="mx-auto flex max-w-[1140px] flex-col gap-2 px-4 py-4 sm:px-6">';
    foreach (NAV_ITEMS as $item) {
        render_mobile_nav_link($item);
    }

    $mobileProductsClasses = $productsActive ? 'bg-[#0066cc] text-white' : 'text-[#111111] hover:bg-[#f5f5f7] hover:text-[#0066cc]';
    echo '<details class="rounded-2xl bg-elevated/80"><summary class="flex cursor-pointer items-center justify-between rounded-2xl px-3 py-2 text-sm font-medium uppercase tracking-wide ' . $mobileProductsClasses . '">Products<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></summary><div class="mt-2 flex flex-col gap-1 rounded-3xl bg-elevated p-2">';
    foreach (PRODUCT_ITEMS as $product) {
        $active = is_active_path((string) $product['href']);
        $classes = $active ? 'bg-[#0066cc] font-semibold text-white' : 'text-text-main hover:bg-surface hover:text-[#0066cc]';
        echo '<a href="' . h((string) $product['href']) . '" class="rounded-2xl px-3 py-2 text-sm transition-colors ' . $classes . '">' . h((string) $product['label']) . '</a>';
    }
    echo '</div></details>';

    $mobileServiceClasses = $serviceActive ? 'bg-[#0066cc] text-white' : 'text-[#111111] hover:bg-[#f5f5f7] hover:text-[#0066cc]';
    echo '<details class="rounded-2xl bg-elevated/80"><summary class="flex cursor-pointer items-center justify-between rounded-2xl px-3 py-2 text-sm font-medium uppercase tracking-wide ' . $mobileServiceClasses . '">Our Services<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></summary><div class="mt-2 flex flex-col gap-1 rounded-3xl bg-elevated p-2">';
    foreach (SERVICE_ITEMS as $service) {
        $active = is_active_path((string) $service['href']);
        $classes = $active ? 'bg-[#0066cc] font-semibold text-white' : 'text-text-main hover:bg-surface hover:text-[#0066cc]';
        echo '<a href="' . h((string) $service['href']) . '" class="rounded-2xl px-3 py-2 text-sm transition-colors ' . $classes . '">' . h((string) $service['label']) . '</a>';
    }
    echo '</div></details></div></div></header>';

    if ($heroImage !== null) {
        $eyebrow = 'CORELUSA · INDUSTRIAL INSPECTION';
        if ($path === '/about-us' || $path === '/quem-somos') {
            $eyebrow = 'ABOUT US';
        } elseif ($path === '/request-quote' || $path === '/solicite-orcamento') {
            $eyebrow = 'COMMERCIAL REQUEST';
        } elseif ($path === '/contact' || $path === '/entre-em-contato') {
            $eyebrow = 'SUPPORT';
        } elseif (str_starts_with($path, '/products')) {
            $eyebrow = 'PRODUCTS';
        } elseif ($path === '/our-services' || str_starts_with($path, '/our-services/') || $path === '/nossos-servicos' || str_starts_with($path, '/nossos-servicos/')) {
            $eyebrow = 'SPECIALIZED SERVICES';
        }

        echo '<section class="relative overflow-hidden bg-cover bg-center bg-no-repeat py-20 md:py-28" style="background-image:url(\'' . h(canonicalize_image($heroImage)) . '\')">';
        echo '<div class="absolute inset-0 bg-[#0a0e17]/75"></div>';
        echo '<div class="absolute inset-0 bg-[linear-gradient(160deg,rgba(10,14,23,0.60),rgba(10,14,23,0.50),rgba(10,14,23,0.65))]"></div>';
        echo '<div class="relative z-10 mx-auto max-w-[1140px] px-4 text-center text-white sm:px-6">';
         echo '<p class="mb-4 font-mono text-xs uppercase tracking-[0.34em] text-[#7eb8f7]">' . h($eyebrow) . '</p>';
        echo '<h1 class="mb-4 font-heading text-3xl font-bold md:text-4xl">' . h($title) . '</h1>';
        if ($subtitle !== '') {
            echo '<p class="mx-auto mb-6 max-w-2xl text-sm leading-6 text-slate-200 md:text-base">' . h($subtitle) . '</p>';
        }
          echo '<nav class="text-sm"><span class="text-text-secondary">You are here:</span> <a href="/" class="transition-colors hover:text-[#0066cc]">Home</a>';
        if ($path !== '/') {
             echo ' <span class="mx-2 text-text-secondary">/</span> <span class="text-[#0066cc]">' . h($title) . '</span>';
        }
        echo '</nav></div></section>';
    }
}

function render_service_grid(): void
{
    echo '<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">';
    foreach (HOME_SERVICES as $service) {
        echo '<a href="' . h((string) $service['href']) . '" data-reveal class="group relative block overflow-hidden rounded-3xl border border-border-subtle bg-surface/60 shadow-[0_24px_80px_rgba(10,14,23,0.35)] transition duration-500 hover:-translate-y-1 hover:border-primary/50 hover:shadow-[0_0_30px_rgba(0,102,204,0.18)]">';
        echo '<div class="absolute inset-0"><img src="' . h(canonicalize_image((string) $service['image'])) . '" alt="' . h((string) $service['title']) . '" class="h-full w-full object-cover transition duration-700 group-hover:scale-110" loading="lazy"><div class="absolute inset-0 bg-[#0a0e17]/45"></div><div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(10,14,23,0.22),rgba(10,14,23,0.74)_40%,rgba(10,14,23,0.97))]"></div></div>';
        echo '<div class="relative flex min-h-[22rem] flex-col justify-between gap-8 p-6">';
        echo '<div class="flex items-start justify-between gap-4">';
        echo '<div class="relative grid h-14 w-14 place-items-center text-[#7eb8f7]" aria-label="' . h((string) $service['title']) . '"><svg viewBox="0 0 100 100" class="absolute inset-0 h-full w-full drop-shadow-[0_0_18px_rgba(0,102,204,0.25)]" fill="none" aria-hidden="true"><path d="M50 6 84 25v39L50 94 16 75V25L50 6Z" stroke="currentColor" stroke-width="4"></path></svg><span class="relative z-10 font-mono text-xs font-semibold tracking-[0.28em] text-white">' . h((string) $service['code']) . '</span></div>';
        echo '<span class="rounded-full border border-white/35 bg-white/10 px-3 py-1 font-mono text-[11px] uppercase tracking-[0.24em] text-white">CORELUSA</span>';
        echo '</div><div class="space-y-4"><h3 class="max-w-[16ch] font-heading text-xl font-semibold uppercase tracking-[0.08em] text-white">' . h((string) $service['title']) . '</h3><p class="max-w-[28ch] text-sm leading-6 text-slate-200 transition duration-300 group-hover:text-white">' . h((string) $service['description']) . '</p><span class="inline-flex items-center gap-2 font-mono text-xs uppercase tracking-[0.24em] text-[#7eb8f7]">View service<span aria-hidden="true">→</span></span></div>';
        echo '</div></a>';
    }
    echo '</div>';
}

function render_timeline(): void
{
    echo '<div class="relative space-y-6">';
    echo '<div class="absolute left-[1.15rem] top-0 h-full w-px" style="background:rgba(56,189,248,0.15)"></div>';

    // Icons: simple inline SVGs (stroke=currentColor)
    $timelineIcons = [
        // Start / launch
        '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 13l4 4L19 7"></path></svg>',
        // Growth
        '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 17l6-6 4 4 7-7"></path><path d="M14 8h6v6"></path></svg>',
        // Consolidation
        '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2l7 4v6c0 5-3 9-7 10C8 21 5 17 5 12V6l7-4z"></path></svg>',
        // Today / ongoing
        '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2v6"></path><path d="M12 16v6"></path><path d="M4.93 4.93l4.24 4.24"></path><path d="M14.83 14.83l4.24 4.24"></path><path d="M2 12h6"></path><path d="M16 12h6"></path><path d="M4.93 19.07l4.24-4.24"></path><path d="M14.83 9.17l4.24-4.24"></path></svg>',
    ];

    $i = 0;
    foreach (TIMELINE_ITEMS as $item) {
        echo '<div class="relative pl-12">';
        $icon = $timelineIcons[$i % count($timelineIcons)];
        echo '<div class="absolute left-0 top-1 grid h-9 w-9 place-items-center rounded-full border bg-[#0a0e17] shadow-[0_0_18px_rgba(0,102,204,0.18)]" style="border-color:rgba(0,102,204,0.4);color:#7eb8f7">' . $icon . '</div>';
        echo '<div class="rounded-3xl border p-6" style="border-color:rgba(0,102,204,0.25);background:#1e2535">';
        echo '<p class="mb-2 font-mono text-xs uppercase tracking-[0.26em]" style="color:#7eb8f7">' . h((string) $item['year']) . '</p>';
        echo '<h3 class="mb-2 text-xl font-semibold" style="color:#f1f5f9">' . h((string) $item['title']) . '</h3>';
        echo '<p class="text-sm leading-6" style="color:#cbd5e1">' . h((string) $item['description']) . '</p>';
        echo '</div></div>';
        $i++;
    }
    echo '</div>';
}

function page_end(): void
{
    echo '<section class="relative overflow-hidden bg-dark py-16 text-white">';
    echo '<div class="absolute inset-0 bg-[#0b1220]"></div>';
    echo '<div class="absolute inset-0 opacity-20" style="background-image:url(\'/images/world-map-dark.png\');background-size:cover;background-position:center"></div>';
    echo '<div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(10,14,23,0.88),rgba(15,23,42,0.78),rgba(10,14,23,0.9))]"></div>';
    echo '<div class="relative z-10 mx-auto max-w-[1140px] px-4 sm:px-6"><div class="flex flex-col items-center justify-between gap-8 md:flex-row">';
    echo '<div class="md:w-3/5"><div class="mb-4 text-2xl font-semibold tracking-[0.12em] text-white">CORELUSA</div><p class="max-w-2xl leading-relaxed text-slate-200">Industrial plant services focused on reliability, predictive diagnostics, and execution support for critical operations in the United States.</p></div>';
    echo '<div class="flex gap-4">';
    foreach (['facebook', 'twitter', 'google-plus', 'dribbble', 'behance'] as $social) {
        // Simple inline icons (fill=currentColor) to avoid external deps
        $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><circle cx="12" cy="12" r="10" /></svg>';
        if ($social === 'facebook') {
            $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12a10 10 0 10-11.5 9.9v-7H8v-3h2.5V9.6c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.5V12H18l-.5 3h-2.9v7A10 10 0 0022 12z"/></svg>';
        } elseif ($social === 'twitter') {
            $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23 22h-6.2l-4.9-6.4L6.3 22H2l7.3-8.4L1 2h6.3l4.4 5.8L18.9 2zm-1.1 18h1.7L7.2 3.9H5.4L17.8 20z"/></svg>';
        } elseif ($social === 'google-plus') {
            $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 11v2.6h3.7c-.2 1.1-1.3 3.2-3.7 3.2-2.2 0-4-1.8-4-4.1s1.8-4.1 4-4.1c1.3 0 2.1.6 2.6 1l1.8-1.8C15.4 7 14 6.4 12 6.4 8.9 6.4 6.4 9 6.4 12.7S8.9 19 12 19c3.6 0 6-2.5 6-6.1 0-.4-.1-.7-.1-1H12z"/><path d="M21.6 11.2v-1.6H20v1.6h-1.6v1.6H20v1.6h1.6v-1.6H23v-1.6h-1.4z"/></svg>';
        } elseif ($social === 'dribbble') {
            $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8 3c3 3.5 5 7.5 6 18"/><path d="M3 12c6 0 10-2 14-6"/><path d="M4 17c5-3 10-3.5 16-1"/></svg>';
        } elseif ($social === 'behance') {
            $icon = '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M7.2 11.2c.9 0 1.6-.4 1.6-1.3 0-.9-.6-1.2-1.5-1.2H4.5v2.5h2.7zm.2 4.1c1.1 0 1.8-.4 1.8-1.5 0-1.1-.7-1.5-1.8-1.5H4.5v3h2.9zM2 6h5.7c2.1 0 3.6.9 3.6 3 0 1.2-.6 2.1-1.6 2.5 1.3.4 2.1 1.5 2.1 3.1 0 2.4-2 3.4-4.1 3.4H2V6zm14 3.4h5V8h-5v1.4zm2.5 4.7c1 0 1.8-.5 2-1.5h-4c.2 1 .9 1.5 2 1.5zm0-5.8c2.7 0 4.5 1.8 4.5 5.1v.5h-6.9c.1 1.3 1.2 2.2 2.4 2.2 1 0 1.7-.4 2-1.1H23c-.5 2.1-2.4 3.3-4.6 3.3-2.9 0-5-2.1-5-5s2.1-5 5.1-5z"/></svg>';
        }

        echo '<a href="/contact" aria-label="CORELUSA on ' . h($social) . '" class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 transition-colors hover:-translate-y-0.5" style="--php-hover:#0066cc" onmouseover="this.style.backgroundColor=this.style.getPropertyValue(\'--php-hover\')" onmouseout="this.style.backgroundColor=\'\'">';
        echo '<span class="sr-only">' . h($social) . '</span>' . $icon . '</a>';
    }
    echo '</div></div></div></section>';

    echo '<footer class="py-16" style="background:#0f172a;color:#cbd5e1"><div class="mx-auto grid max-w-[1140px] grid-cols-1 gap-8 px-4 sm:px-6 md:grid-cols-2 lg:grid-cols-3"><div><h3 class="mb-4 font-heading text-lg font-semibold" style="color:#ffffff">CORELUSA USA</h3><div class="space-y-3 text-sm" style="color:#e2e8f0"><p class="flex items-start gap-2"><svg class="mt-0.5 h-4 w-4 flex-shrink-0" style="color:#0066cc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>1942 Via Lago Dr., Lakeland, FL 33810</p><p class="flex items-center gap-2"><svg class="h-4 w-4 flex-shrink-0" style="color:#0066cc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>+1 813-810-0093</p><p class="flex items-center gap-2"><svg class="h-4 w-4 flex-shrink-0" style="color:#0066cc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>info@corelusa.com.com</p></div></div>';
    echo '<div><h3 class="mb-4 font-heading text-lg font-semibold" style="color:#ffffff">Useful Links</h3><div class="space-y-2 text-sm" style="color:#e2e8f0">';
    foreach (NAV_ITEMS as $item) {
        echo '<a href="' . h((string) $item['href']) . '" class="flex items-center gap-2 transition-colors hover:text-[#0066cc]"><svg class="h-3 w-3" style="color:#0066cc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>' . h((string) $item['label']) . '</a>';
    }
    echo '</div></div><div><h3 class="mb-4 font-heading text-lg font-semibold" style="color:#ffffff">Services</h3><div class="space-y-2 text-sm" style="color:#e2e8f0">';
    foreach (SERVICE_ITEMS as $service) {
        echo '<a href="' . h((string) $service['href']) . '" class="flex items-center gap-2 transition-colors hover:text-[#0066cc]"><svg class="h-3 w-3" style="color:#0066cc" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>' . h((string) $service['label']) . '</a>';
    }
    echo '</div></div></div></footer>';
    echo '<div class="py-4 text-center text-sm" style="background:#0b1220;color:#cbd5e1"><div class="mx-auto max-w-[1140px] px-4 sm:px-6">© ' . date('Y') . ' CORELUSA · All rights reserved.</div></div>';

    echo '<script>';
    // Scroll progress
    echo 'const progress=document.getElementById("scroll-progress");const updateProgress=()=>{if(!progress)return;const docHeight=document.documentElement.scrollHeight-window.innerHeight;const scrollTop=window.scrollY;const value=docHeight>0?Math.min(scrollTop/docHeight,1):0;progress.style.width=`${value*100}%`;};updateProgress();window.addEventListener("scroll",updateProgress,{passive:true});window.addEventListener("resize",updateProgress);';
    // Tabs (manutencao-preditiva)
    echo 'document.querySelectorAll("[data-tabs]").forEach((tabs)=>{const buttons=tabs.querySelectorAll("[data-tab-button]");const panels=tabs.querySelectorAll("[data-tab-panel]");buttons.forEach((button)=>{button.addEventListener("click",()=>{const target=button.getAttribute("data-tab-target");buttons.forEach((btn)=>btn.className="bg-[#111827] px-4 py-3 text-left text-sm font-medium text-[#94a3b8] transition-colors hover:bg-[#1f2937]");button.className="bg-[#0066cc] px-4 py-3 text-left text-sm font-medium text-[#ffffff] transition-colors";panels.forEach((panel)=>panel.classList.toggle("hidden",panel.getAttribute("data-tab-panel")!==target));});});});';
    // Reveal on scroll (match Svelte RevealOnScroll/useReveal)
    echo '(()=>{if(window.matchMedia&&window.matchMedia("(prefers-reduced-motion: reduce)").matches){document.querySelectorAll("[data-reveal]").forEach(el=>{el.classList.remove("reveal-hidden");el.classList.add("reveal-visible");});return;}const els=[...document.querySelectorAll("[data-reveal]")];if(!els.length||!("IntersectionObserver" in window)) return;els.forEach(el=>{if(!el.classList.contains("reveal-visible"))el.classList.add("reveal-hidden");});const obs=new IntersectionObserver((entries)=>{entries.forEach((entry)=>{if(entry.isIntersecting){entry.target.classList.remove("reveal-hidden");entry.target.classList.add("reveal-visible");obs.unobserve(entry.target);}});},{threshold:0.15});els.forEach(el=>obs.observe(el));})();';

    // CountUp (match Svelte CountUp feel)
    echo '(()=>{const reduce=window.matchMedia&&window.matchMedia("(prefers-reduced-motion: reduce)").matches;const els=[...document.querySelectorAll("[data-countup]")];if(!els.length) return;const animate=(el)=>{const raw=el.getAttribute("data-countup")||"0";const target=parseFloat(raw.replace(/[^0-9.]/g,""))||0;const duration=parseInt(el.getAttribute("data-duration")||"1200",10);if(reduce){el.textContent=raw;return;}const start=performance.now();const from=0;const step=(t)=>{const p=Math.min((t-start)/duration,1);const eased=1-Math.pow(1-p,3);const val=Math.round(from+(target-from)*eased);el.textContent=val.toString();if(p<1) requestAnimationFrame(step);};requestAnimationFrame(step);};if(!("IntersectionObserver" in window)){els.forEach(animate);return;}const obs=new IntersectionObserver((entries)=>{entries.forEach((e)=>{if(e.isIntersecting){animate(e.target);obs.unobserve(e.target);}});},{threshold:0.25});els.forEach((el)=>obs.observe(el));})();';
    echo '</script></body></html>';
}
