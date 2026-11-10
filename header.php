<?php
// Determine page meta for SEO
$page_title       = $page_title       ?? 'Lokrakshak Real Property Center – Premium Real Estate in Navsari, Gujarat';
$page_description = $page_description ?? 'Lokrakshak Real Property Center is Navsari\'s trusted real estate agency offering premium residential plots, luxury bungalows, commercial spaces and agricultural land. Call us today.';
$page_keywords    = $page_keywords    ?? 'real estate Navsari, property Navsari, plots Navsari, bungalow Navsari, Lokrakshak Real Property Center, land Vijalpore, commercial property Gujarat';
$current_file     = basename($_SERVER['PHP_SELF']);
$canonical_path   = ($current_file === 'index.php') ? '/' : '/' . preg_replace('/\.php$/', '', $current_file);
$page_canonical   = $page_canonical   ?? SITE_URL . $canonical_path;
$og_image         = $og_image         ?? SITE_URL . '/assets/og-image.jpg';
?>
<!DOCTYPE html>
<html lang="en-IN" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- ─── SEO Core ─── -->
    <title><?= e($page_title) ?></title>
    <meta name="description" content="<?= e($page_description) ?>">
    <meta name="keywords"    content="<?= e($page_keywords) ?>">
    <meta name="author"      content="Lokrakshak Real Property Center">
    <meta name="robots"      content="index, follow, max-image-preview:large">
    <link rel="canonical"    href="<?= e($page_canonical) ?>">
    <link rel="icon" type="image/jpeg" href="assets/lrp-logo.jpg">
    <link rel="apple-touch-icon" href="assets/lrp-logo.jpg">

    <!-- ─── Open Graph / Facebook ─── -->
    <meta property="og:type"        content="website">
    <meta property="og:url"         content="<?= e($page_canonical) ?>">
    <meta property="og:title"       content="<?= e($page_title) ?>">
    <meta property="og:description" content="<?= e($page_description) ?>">
    <meta property="og:image"       content="<?= e($og_image) ?>">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale"      content="en_IN">
    <meta property="og:site_name"   content="Lokrakshak Real Property Center">

    <!-- ─── Twitter Card ─── -->
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="<?= e($page_title) ?>">
    <meta name="twitter:description" content="<?= e($page_description) ?>">
    <meta name="twitter:image"       content="<?= e($og_image) ?>">

    <!-- ─── Geo / Local SEO ─── -->
    <meta name="geo.region"   content="IN-GJ">
    <meta name="geo.placename" content="Navsari, Gujarat, India">
    <meta name="geo.position"  content="20.9418;72.9366">
    <meta name="ICBM"          content="20.9418, 72.9366">

    <!-- ─── Schema.org JSON-LD ─── -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "RealEstateAgent",
        "name": "Lokrakshak Real Property Center",
        "description": "<?= e($page_description) ?>",
        "url": "<?= SITE_URL ?>",
        "telephone": ["<?= CONTACT_PHONE1 ?>", "<?= CONTACT_PHONE2 ?>"],
        "email": "<?= CONTACT_EMAIL ?>",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "104 Shushrusha Hospital Shopping Centre, Sardar Chowk, Vijalpore",
            "addressLocality": "Navsari",
            "addressRegion": "Gujarat",
            "postalCode": "396445",
            "addressCountry": "IN"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": 20.9418,
            "longitude": 72.9366
        },
        "openingHoursSpecification": [{
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],
            "opens": "09:00",
            "closes": "19:00"
        }],
        "areaServed": {
            "@type": "Place",
            "name": "Navsari, Gujarat"
        },
        "priceRange": "₹₹₹",
        "image": "<?= e($og_image) ?>",
        "sameAs": [
            "https://wa.me/<?= WHATSAPP_NUMBER ?>"
        ]
    }
    </script>

    <!-- ─── Preconnect / Fonts ─── -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        :root {
            --gold:        #C9A84C;
            --gold-light:  #E8C96A;
            --gold-dark:   #A8892D;
            --ink:         #0D1117;
            --ink-mid:     #1A2332;
            --ink-soft:    #243044;
            --slate:       #64748b;
            --paper:       #FAF8F4;
            --paper-warm:  #F5F0E8;
            --white:       #FFFFFF;
        }

        * { -webkit-tap-highlight-color: transparent; }
        html { font-size: 16px; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, .serif {
            font-family: 'Cormorant Garamond', Georgia, serif;
            letter-spacing: -0.01em;
        }

        /* ─ Gold Gradient Text ─ */
        .gold-text {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light), var(--gold));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* ─ Animated Underline ─ */
        .underline-gold {
            position: relative;
            display: inline-block;
        }
        .underline-gold::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gold);
            transition: width 0.35s ease;
        }
        .underline-gold:hover::after { width: 100%; }

        /* ─ Buttons ─ */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-light) 100%);
            color: var(--ink);
            font-weight: 600;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.04em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(201,168,76,0.35);
        }
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(201,168,76,0.5);
            filter: brightness(1.08);
        }
        .btn-dark {
            background: var(--ink);
            color: var(--white);
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.3s ease;
        }
        .btn-dark:hover {
            background: var(--ink-mid);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(13,17,23,0.4);
        }

        /* ─ Card ─ */
        .prop-card {
            background: var(--white);
            border: 1px solid rgba(201,168,76,0.15);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        }
        .prop-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.14);
            border-color: rgba(201,168,76,0.4);
        }
        .prop-card:hover .card-img img { transform: scale(1.07); }

        .card-img { overflow: hidden; }
        .card-img img { transition: transform 0.6s ease; }

        /* ─ Section Divider ─ */
        .gold-line {
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light));
            border-radius: 2px;
        }

        /* ════════════════════════════════════════════
           IMPROVED NAVBAR
        ════════════════════════════════════════════ */
        #mainNav {
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            border-bottom: 1px solid rgba(201,168,76,0.08);
        }
        #mainNav.scrolled {
            background: rgba(10,14,20,0.97) !important;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 8px 40px rgba(0,0,0,0.5), 0 1px 0 rgba(201,168,76,0.15);
            border-bottom-color: rgba(201,168,76,0.2);
        }

        /* Nav link pill style */
        .nav-link {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            color: #94a3b8;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.07);
        }
        .nav-link.active {
            color: var(--gold);
            background: rgba(201,168,76,0.1);
        }
        .nav-link.active::before {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 14px;
            right: 14px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-light));
            border-radius: 2px 2px 0 0;
        }

        /* Logo mark animation */
        .logo-mark {
            width: 46px;
            height: 46px;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 4px 16px rgba(201,168,76,0.35);
            transition: all 0.3s ease;
        }
        .logo-mark img { width:100%; height:100%; display:block; object-fit:cover; }
        .logo-mark:hover { transform: rotate(-5deg) scale(1.05); box-shadow: 0 6px 24px rgba(201,168,76,0.5); }

        /* Mobile menu improved */
        #mobileMenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.45s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
            opacity: 0;
        }
        #mobileMenu.open {
            max-height: 500px;
            opacity: 1;
        }

        /* Hamburger animation */
        .hamburger { cursor: pointer; width: 40px; height: 40px; display:flex; align-items:center; justify-content:center; border-radius:8px; transition: background 0.2s; }
        .hamburger:hover { background: rgba(255,255,255,0.08); }
        .hamburger-lines { display:flex; flex-direction:column; gap:5px; width:22px; }
        .hamburger-lines span {
            display: block;
            height: 2px;
            background: #fff;
            border-radius: 2px;
            transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
            transform-origin: center;
        }
        .hamburger.open .hamburger-lines span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open .hamburger-lines span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open .hamburger-lines span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile nav link */
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 10px;
            margin: 0 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        .mobile-nav-link:hover { color: #fff; background: rgba(255,255,255,0.07); }
        .mobile-nav-link.active { color: var(--gold); background: rgba(201,168,76,0.1); }
        .mobile-nav-link .nav-icon {
            width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px;
            background: rgba(255,255,255,0.05);
            font-size: 0.75rem;
            flex-shrink: 0;
        }
        .mobile-nav-link.active .nav-icon { background: rgba(201,168,76,0.15); color: var(--gold); }

        /* ════════════════════════════════════════════
           IMPROVED SEARCH BAR
        ════════════════════════════════════════════ */

        /* Search wrapper */
        .search-wrapper {
            position: relative;
            flex-grow: 1;
            min-width: 240px;
            max-width: 380px;
        }
        .search-field {
            width: 100%;
            background: var(--paper);
            border: 1.5px solid rgba(201,168,76,0.25);
            border-radius: 12px;
            padding: 0.7rem 3rem 0.7rem 2.8rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            transition: all 0.3s ease;
            outline: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .search-field::placeholder { color: #a0aec0; }
        .search-field:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201,168,76,0.12), 0 4px 16px rgba(0,0,0,0.08);
            background: #fff;
        }
        .search-icon {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold-dark);
            font-size: 0.8rem;
            pointer-events: none;
            transition: color 0.2s;
        }
        .search-field:focus ~ .search-icon { color: var(--gold); }
        .search-clear {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px; height: 22px;
            border-radius: 50%;
            background: #e2e8f0;
            border: none;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            color: #64748b;
            transition: all 0.2s;
        }
        .search-clear:hover { background: #cbd5e1; color: #374151; }
        .search-wrapper.has-value .search-clear { display: flex; }

        /* Select dropdowns styled */
        .filter-select {
            background: var(--paper);
            border: 1.5px solid rgba(201,168,76,0.25);
            border-radius: 12px;
            padding: 0.7rem 2.2rem 0.7rem 0.9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.875rem;
            color: var(--ink);
            transition: all 0.3s ease;
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23A8892D' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .filter-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(201,168,76,0.12);
            background-color: #fff;
        }

        /* Filter bar */
        .filter-bar {
            position: sticky;
            top: 70px;
            z-index: 40;
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(201,168,76,0.18);
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
            padding: 14px 0;
        }

        /* Filter submit btn */
        .filter-btn {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: var(--ink);
            font-weight: 600;
            font-size: 0.875rem;
            letter-spacing: 0.04em;
            padding: 0.7rem 1.2rem;
            border-radius: 12px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 16px rgba(201,168,76,0.3);
            transition: all 0.25s ease;
            white-space: nowrap;
        }
        .filter-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(201,168,76,0.45);
            filter: brightness(1.07);
        }
        .filter-btn:active { transform: translateY(0); }

        /* Clear link */
        .clear-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            color: var(--slate);
            padding: 6px 10px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }
        .clear-link:hover { color: var(--ink); background: #f1f5f9; border-color: #e2e8f0; }

        /* Result count badge */
        .result-count {
            font-size: 0.8rem;
            color: var(--slate);
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 4px 14px;
            white-space: nowrap;
        }
        .result-count strong { color: var(--ink); }

        /* Active filter chips */
        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            background: rgba(201,168,76,0.12);
            color: var(--gold-dark);
            border: 1px solid rgba(201,168,76,0.25);
            letter-spacing: 0.03em;
        }

        /* ─ Form Inputs ─ */
        .form-input {
            background: var(--paper);
            border: 1.5px solid #ddd6cc;
            border-radius: 10px;
            padding: 0.85rem 1.1rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            transition: border-color 0.25s, box-shadow 0.25s;
            width: 100%;
            outline: none;
            color: var(--ink);
        }
        .form-input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.18);
        }

        /* ─ Badge ─ */
        .prop-badge {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: var(--ink);
            font-size: 0.65rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* ─ WhatsApp Float ─ */
        .wa-float {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 999;
            background: #25D366;
            color: white;
            width: 58px;
            height: 58px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            box-shadow: 0 6px 24px rgba(37,211,102,0.5);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .wa-float:hover {
            transform: scale(1.12) rotate(-5deg);
            box-shadow: 0 10px 35px rgba(37,211,102,0.65);
        }

        /* ─ Page Fade-in ─ */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.7s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.22s; }
        .delay-3 { animation-delay: 0.36s; }
        .delay-4 { animation-delay: 0.5s; }

        /* ─ Scrollbar ─ */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--ink); }
        ::-webkit-scrollbar-thumb { background: var(--gold-dark); border-radius: 3px; }

        /* ─ Selection ─ */
        ::selection { background: var(--gold); color: var(--ink); }

        /* ─ Print ─ */
        @media print {
            #mainNav, .wa-float, footer { display: none !important; }
        }

        /* Mobile filter row wrapping */
        @media (max-width: 640px) {
            .filter-bar .filter-row { gap: 8px; }
            .search-wrapper { min-width: 100%; max-width: 100%; }
            .filter-select { flex: 1; min-width: 130px; }
        }
    </style>
</head>
<body>

<!-- ══ Top Info Bar ═══════════════════════════════════════════════════════════ -->
<div class="hidden md:block text-xs py-2.5 px-4" style="background:var(--ink-mid); color:#94a3b8; border-bottom:1px solid rgba(201,168,76,0.1);">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-6">
            <a href="tel:<?= CONTACT_PHONE1 ?>" class="hover:text-amber-400 transition flex items-center gap-2 group">
                <span class="w-5 h-5 rounded-full flex items-center justify-center" style="background:rgba(201,168,76,0.12);">
                    <i class="fas fa-phone-alt" style="color:var(--gold); font-size:0.6rem;"></i>
                </span>
                <?= CONTACT_PHONE1 ?> &nbsp;/&nbsp; <?= CONTACT_PHONE2 ?>
            </a>
            <a href="mailto:<?= CONTACT_EMAIL ?>" class="hover:text-amber-400 transition flex items-center gap-2">
                <span class="w-5 h-5 rounded-full flex items-center justify-center" style="background:rgba(201,168,76,0.12);">
                    <i class="fas fa-envelope" style="color:var(--gold); font-size:0.6rem;"></i>
                </span>
                <?= CONTACT_EMAIL ?>
            </a>
        </div>
        <div class="flex items-center gap-3">
            <span class="flex items-center gap-1.5">
                <i class="fas fa-map-marker-alt" style="color:var(--gold); font-size:0.65rem;"></i>
                Vijalpore, Navsari – 396445
            </span>
            <span class="w-px h-3 opacity-30" style="background:var(--gold);"></span>
            <span class="flex items-center gap-1.5">
                <i class="fas fa-clock" style="color:var(--gold); font-size:0.6rem;"></i>
                Mon–Sat, 9AM–7PM
            </span>
        </div>
    </div>
</div>

<!-- ══ Navigation ════════════════════════════════════════════════════════════ -->
<nav id="mainNav" class="sticky top-0 z-50" style="background:var(--ink);">
    <div class="max-w-7xl mx-auto px-5">
        <div class="flex items-center justify-between py-3 md:py-4">

            <a href="/" class="flex items-center group" style="text-decoration:none;">
                <div class="overflow-hidden flex items-center justify-center w-[200px] h-[55px] md:w-[280px] md:h-[75px] -ml-2">
                    <img src="assets/lrp-logo.png" alt="Lokrakshak Real Property Center logo" 
                         class="w-[145%] md:w-[135%] max-w-none object-center transition-transform duration-300 group-hover:scale-105" 
                         style="mix-blend-mode: screen;">
                </div>
            </a>
            <!-- Desktop Links -->
            <div class="hidden md:flex items-center gap-1">
                <?php
                $current = basename($_SERVER['PHP_SELF']);
                $navLinks = [
                    '/'        => ['file' => 'index.php',    'label' => 'Home',       'icon' => 'fas fa-home'],
                    'listings' => ['file' => 'listings.php', 'label' => 'Properties', 'icon' => 'fas fa-building'],
                    'contact'  => ['file' => 'contact.php',  'label' => 'Contact',    'icon' => 'fas fa-envelope'],
                ];
                foreach ($navLinks as $href => $item):
                    $isActive = ($current === $item['file']);
                ?>
                    <a href="<?= $href ?>" class="nav-link <?= $isActive ? 'active' : '' ?>">
                        <?= $item['label'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Desktop Right Actions -->
            <div class="hidden md:flex items-center gap-3">
                <?php if (isset($_SESSION['admin_logged_in'])): ?>
                    <a href="admin" class="btn-gold inline-flex items-center gap-2 text-sm px-5 py-2.5 rounded-xl">
                        <i class="fas fa-th-large"></i>Dashboard
                    </a>
                <?php else: ?>
                    <a href="contact" class="btn-gold inline-flex items-center gap-2 text-sm px-5 py-2.5 rounded-xl">
                        <i class="fas fa-phone-alt" style="font-size:0.75rem;"></i>
                        Get In Touch
                    </a>
                <?php endif; ?>
            </div>

            <!-- Mobile Hamburger -->
            <button id="menuToggle" class="md:hidden hamburger" 
                    aria-label="Toggle menu" aria-expanded="false" aria-controls="mobileMenu">
                <div class="hamburger-lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" style="background:var(--ink-mid);">
        <div style="border-top:1px solid rgba(201,168,76,0.15); padding:10px 0 16px;">
            <?php
            $mobileLinks = [
                '/'        => ['file' => 'index.php',    'label' => 'Home',       'icon' => 'fas fa-home'],
                'listings' => ['file' => 'listings.php', 'label' => 'Properties', 'icon' => 'fas fa-building'],
                'contact'  => ['file' => 'contact.php',  'label' => 'Contact Us', 'icon' => 'fas fa-envelope'],
            ];
            foreach ($mobileLinks as $href => $item):
                $isActive = ($current === $item['file']);
            ?>
                <a href="<?= $href ?>" class="mobile-nav-link <?= $isActive ? 'active' : '' ?>">
                    <span class="nav-icon"><i class="<?= $item['icon'] ?>"></i></span>
                    <?= $item['label'] ?>
                    <?php if ($isActive): ?><i class="fas fa-chevron-right ml-auto text-xs opacity-40"></i><?php endif; ?>
                </a>
            <?php endforeach; ?>

            <div style="margin: 12px 8px 4px; padding-top: 12px; border-top:1px solid rgba(255,255,255,0.05);">
                <a href="contact" class="btn-gold flex items-center justify-center gap-2 text-sm px-5 py-3.5 rounded-xl w-full text-center">
                    <i class="fas fa-phone-alt" style="font-size:0.75rem;"></i>
                    Get In Touch
                </a>
            </div>
        </div>
    </div>
</nav>

<main class="flex-grow">
<!-- ════════════════════════════════════════════════════════════════════════════ -->

<script>
// Scroll effect
const nav = document.getElementById('mainNav');
window.addEventListener('scroll', () => {
    nav.classList.toggle('scrolled', window.scrollY > 60);
}, { passive: true });

// Mobile menu with animated hamburger
const toggle  = document.getElementById('menuToggle');
const menu    = document.getElementById('mobileMenu');
const hamBtn  = toggle;

toggle.addEventListener('click', () => {
    const isOpen = menu.classList.toggle('open');
    toggle.setAttribute('aria-expanded', isOpen);
    hamBtn.classList.toggle('open', isOpen);
});

// Close mobile menu on link click
menu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
        menu.classList.remove('open');
        hamBtn.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
    });
});
</script>
