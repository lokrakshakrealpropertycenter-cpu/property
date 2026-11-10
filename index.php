<?php
require 'config.php';
$db = getDB();
$featured = $db->query("SELECT * FROM properties ORDER BY created_at DESC LIMIT 6")->fetchAll();

$page_title       = 'Lokrakshak Real Property Center – Premium Real Estate in Navsari, Gujarat';
$page_description = 'Lokrakshak Real Property Center offers exclusive residential plots, luxury bungalows, agricultural land & commercial spaces in Navsari, Gujarat. Call +91 98986 30756 today.';
$page_canonical   = SITE_URL . '/';
include 'header.php';
?>

<!-- ══ HERO ══════════════════════════════════════════════════════════════════ -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden" style="background:var(--ink);">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&w=2000&q=80"
             alt="Premium property" class="w-full h-full object-cover opacity-30"
             loading="eager" fetchpriority="high">
        <!-- Gradient overlays -->
        <div class="absolute inset-0" style="background:linear-gradient(to right, rgba(13,17,23,0.98) 0%, rgba(13,17,23,0.6) 55%, rgba(13,17,23,0.25) 100%);"></div>
        <div class="absolute bottom-0 left-0 right-0 h-40" style="background:linear-gradient(to top, var(--paper), transparent);"></div>
    </div>

    <!-- Floating ornament rings -->
    <div class="absolute right-10 top-1/4 w-80 h-80 rounded-full border opacity-10 hidden lg:block" style="border-color:var(--gold);"></div>
    <div class="absolute right-20 top-1/4 w-56 h-56 rounded-full border opacity-10 hidden lg:block" style="border-color:var(--gold);"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-5 py-24 w-full">
        <div class="max-w-2xl">
            <!-- Label -->
            <div class="fade-up inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full text-xs font-semibold tracking-widest uppercase"
                 style="background:rgba(201,168,76,0.12); border:1px solid rgba(201,168,76,0.3); color:var(--gold);">
                <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background:var(--gold);"></span>
                Navsari's Premier Real Estate Partner
            </div>

            <h1 class="fade-up delay-1 text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-[1.08] mb-6"
                style="font-family:'Cormorant Garamond',serif;">
                Find Your<br>
                <span style="color:var(--gold);">Dream Property</span><br>
                <span class="text-4xl md:text-5xl font-normal" style="color:#94a3b8;">in Navsari</span>
            </h1>

            <p class="fade-up delay-2 text-lg text-slate-400 mb-10 leading-relaxed max-w-xl font-light">
                Exclusive agricultural lands, luxury bungalows, residential plots &amp; prime commercial spaces — curated for discerning buyers across Navsari &amp; Gujarat.
            </p>

            <div class="fade-up delay-3 flex flex-wrap gap-4">
                <a href="listings" class="btn-gold inline-flex items-center gap-2 px-8 py-4 rounded-xl text-sm font-semibold">
                    <i class="fas fa-search"></i> Explore Properties
                </a>
                <a href="contact" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl text-sm font-semibold text-white transition"
                   style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15);"
                   onmouseover="this.style.background='rgba(255,255,255,0.15)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.08)'">
                    <i class="fas fa-phone-alt" style="color:var(--gold);"></i> Talk to Agent
                </a>
            </div>

            <!-- Quick Stats -->
            <div class="fade-up delay-4 flex flex-wrap gap-8 mt-14 pt-10 border-t" style="border-color:rgba(255,255,255,0.08);">
                <?php
                $stats = [
                    ['500+', 'Properties Sold'],
                    ['15+',  'Years Experience'],
                    ['100%', 'Trusted Deals'],
                ];
                foreach ($stats as $s): ?>
                <div>
                    <div class="text-3xl font-bold" style="font-family:'Cormorant Garamond',serif; color:var(--gold);"><?= $s[0] ?></div>
                    <div class="text-xs text-slate-500 tracking-widest uppercase mt-1"><?= $s[1] ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Scroll indicator -->
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 flex flex-col items-center gap-2 text-slate-600 text-xs tracking-widest uppercase">
        <span>Scroll</span>
        <div class="w-px h-10 animate-bounce" style="background:linear-gradient(to bottom, var(--gold), transparent);"></div>
    </div>
</section>

<!-- ══ SERVICES STRIP ═════════════════════════════════════════════════════════ -->
<section class="py-5 border-y" style="background:var(--paper-warm); border-color:rgba(201,168,76,0.2);">
    <div class="max-w-7xl mx-auto px-5">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <?php
            $services = [
                ['fas fa-seedling',  'Agricultural Land',   'Agri & NA plots'],
                ['fas fa-home',      'Residential Plots',   'Prime locations'],
                ['fas fa-gem',       'Luxury Bungalows',    'Exclusive homes'],
                ['fas fa-store',     'Commercial Spaces',   'Shops & offices'],
            ];
            foreach ($services as $svc): ?>
            <div class="py-6 px-4 flex flex-col items-center gap-2 rounded-xl transition hover:bg-white hover:shadow-sm" style="">
                <div class="w-11 h-11 rounded-full flex items-center justify-center" style="background:rgba(201,168,76,0.12);">
                    <i class="<?= $svc[0] ?> text-base" style="color:var(--gold-dark);"></i>
                </div>
                <div class="text-sm font-semibold" style="color:var(--ink);"><?= $svc[1] ?></div>
                <div class="text-xs" style="color:var(--slate);"><?= $svc[2] ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══ FEATURED PROPERTIES ═══════════════════════════════════════════════════ -->
<section class="py-20 md:py-28" style="background:var(--paper);">
    <div class="max-w-7xl mx-auto px-5">

        <!-- Heading -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-5 mb-14">
            <div>
                <p class="text-xs font-semibold tracking-widest uppercase mb-3" style="color:var(--gold-dark);">Hand-Picked Listings</p>
                <h2 class="text-4xl md:text-5xl font-bold leading-tight" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                    Featured Properties
                </h2>
                <div class="gold-line mt-4"></div>
            </div>
            <a href="listings" class="btn-dark inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm self-start md:self-auto">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- Cards Grid -->
        <?php if (empty($featured)): ?>
        <div class="text-center py-20 rounded-2xl border-2 border-dashed" style="border-color:rgba(201,168,76,0.3);">
            <i class="fas fa-building text-4xl mb-4" style="color:var(--gold);"></i>
            <p class="text-lg font-medium" style="color:var(--slate);">Exciting listings coming soon.</p>
            <a href="contact" class="btn-gold inline-block mt-5 px-7 py-3 rounded-xl text-sm">Contact Us</a>
        </div>
        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($featured as $p): ?>
            <article class="prop-card flex flex-col">
                <!-- Image -->
                <div class="card-img relative h-60">
                    <?php $img = $p['image_path'] ? e($p['image_path']) : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=75'; ?>
                    <img src="<?= $img ?>" alt="<?= e($p['title']) ?>"
                         class="w-full h-full object-cover" loading="lazy" width="800" height="480">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,17,23,0.7) 0%, transparent 55%);"></div>
                    <!-- Type Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="prop-badge"><?= e($p['type']) ?></span>
                    </div>
                    <!-- Price on image -->
                    <div class="absolute bottom-4 left-4">
                        <p class="text-white font-bold text-xl" style="font-family:'Cormorant Garamond',serif; text-shadow:0 2px 8px rgba(0,0,0,0.5);">
                            ₹<?= number_format($p['price']) ?>
                        </p>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-xs mb-2 flex items-center gap-1.5 font-medium" style="color:var(--gold-dark);">
                        <i class="fas fa-map-marker-alt"></i> <?= e($p['location']) ?>
                    </p>
                    <h3 class="text-xl font-bold mb-3 leading-snug" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                        <?= e($p['title']) ?>
                    </h3>
                    <?php if (!empty($p['description'])): ?>
                    <p class="text-sm mb-5 flex-grow leading-relaxed" style="color:var(--slate); display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= e($p['description']) ?>
                    </p>
                    <?php endif; ?>
                    <div class="mt-auto flex gap-3">
                        <a href="contact?interest=<?= urlencode($p['title']) ?>"
                           class="btn-gold flex-1 text-center py-3 rounded-xl text-sm font-semibold">
                            Inquire Now
                        </a>
                        <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Hi!%20I'm%20interested%20in%20<?= urlencode($p['title']) ?>"
                           target="_blank" rel="noopener"
                           class="w-12 h-12 rounded-xl flex items-center justify-center text-white bg-green-600 hover:bg-green-500 transition flex-shrink-0 text-base"
                           aria-label="WhatsApp inquiry">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ══ WHY CHOOSE US ══════════════════════════════════════════════════════════ -->
<section class="py-20 md:py-28" style="background:var(--ink); position:relative; overflow:hidden;">
    <!-- Decorative circles -->
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-5 border-4" style="border-color:var(--gold);"></div>
    <div class="absolute -bottom-16 -left-16 w-64 h-64 rounded-full opacity-5 border-4" style="border-color:var(--gold);"></div>

    <div class="relative max-w-7xl mx-auto px-5">
        <div class="text-center mb-16">
            <p class="text-xs font-semibold tracking-widest uppercase mb-3" style="color:var(--gold-dark);">Our Promise</p>
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family:'Cormorant Garamond',serif;">
                Why Choose <span style="color:var(--gold);">Lokrakshak Real Property Center?</span>
            </h2>
            <div class="gold-line mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            $reasons = [
                ['fas fa-shield-alt',     'Legally Verified',    'Every property is title-verified and legally clear before listing.'],
                ['fas fa-handshake',      'Trusted Since 2009',  '15+ years of serving Navsari families and investors with integrity.'],
                ['fas fa-map-marked-alt', 'Local Expertise',     'Deep knowledge of Navsari, Vijalpore & surrounding micro-markets.'],
                ['fas fa-headset',        '24/7 Support',        'We answer every query. Call, WhatsApp or visit us anytime.'],
            ];
            foreach ($reasons as $r): ?>
            <div class="rounded-2xl p-7 transition group hover:-translate-y-1"
                 style="background:var(--ink-mid); border:1px solid rgba(201,168,76,0.15);">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-5 group-hover:scale-110 transition"
                     style="background:linear-gradient(135deg,var(--gold-dark),var(--gold-light));">
                    <i class="<?= $r[0] ?>" style="color:var(--ink); font-size:1.1rem;"></i>
                </div>
                <h3 class="text-white font-bold text-lg mb-2" style="font-family:'Cormorant Garamond',serif;"><?= $r[1] ?></h3>
                <p class="text-sm leading-relaxed" style="color:#64748b;"><?= $r[2] ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══ TESTIMONIALS ══════════════════════════════════════════════════════════ -->
<section class="py-20 md:py-28" style="background:var(--paper-warm);">
    <div class="max-w-5xl mx-auto px-5">
        <div class="text-center mb-14">
            <p class="text-xs font-semibold tracking-widest uppercase mb-3" style="color:var(--gold-dark);">Happy Clients</p>
            <h2 class="text-4xl md:text-5xl font-bold mb-4" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">What Our Clients Say</h2>
            <div class="gold-line mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $testimonials = [
                ['Ramesh Patel',    'Navsari',    'Lokrakshak Real Property Center helped us find the perfect NA plot in Vijalpore. The process was transparent and very smooth. Highly recommended!', 5],
                ['Priya Shah',      'Surat',      'We were searching for a bungalow for 2 years. Lokrakshak Real Property Center found us our dream home in just 3 weeks. Excellent service!', 5],
                ['Dinesh Mehta',    'Navsari',    'Very professional team. They guided us through every step of the legal documentation. Trustworthy and reliable agency.', 5],
            ];
            foreach ($testimonials as $t): ?>
            <div class="rounded-2xl p-7 bg-white border shadow-sm hover:shadow-md transition" style="border-color:rgba(201,168,76,0.15);">
                <div class="flex mb-4">
                    <?php for ($i = 0; $i < $t[3]; $i++): ?>
                    <i class="fas fa-star text-sm" style="color:var(--gold);"></i>
                    <?php endfor; ?>
                </div>
                <p class="text-sm leading-relaxed mb-5 italic" style="color:#475569;">"<?= $t[0] === 'Ramesh Patel' ? 'Lokrakshak Real Property Center helped us find the perfect NA plot in Vijalpore. The process was transparent and very smooth. Highly recommended!' : ($t[0] === 'Priya Shah' ? 'We were searching for a bungalow for 2 years. Lokrakshak Real Property Center found us our dream home in just 3 weeks. Excellent service!' : 'Very professional team. They guided us through every step of the legal documentation. Trustworthy and reliable agency.') ?>"</p>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm"
                         style="background:linear-gradient(135deg,var(--gold-dark),var(--gold-light)); color:var(--ink);">
                        <?= strtoupper(substr($t[0], 0, 1)) ?>
                    </div>
                    <div>
                        <div class="font-semibold text-sm" style="color:var(--ink);"><?= $t[0] ?></div>
                        <div class="text-xs" style="color:var(--slate);"><?= $t[1] ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══ CTA BANNER ════════════════════════════════════════════════════════════ -->
<section class="py-16 md:py-20" style="background:linear-gradient(135deg, var(--gold-dark) 0%, var(--gold-light) 50%, var(--gold) 100%);">
    <div class="max-w-4xl mx-auto px-5 text-center">
        <h2 class="text-3xl md:text-5xl font-bold mb-4" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
            Ready to Find Your Property?
        </h2>
        <p class="text-base mb-8 font-medium" style="color:rgba(13,17,23,0.7);">
            Call us now or send a WhatsApp message. Our agents are ready to help you.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="tel:<?= CONTACT_PHONE1 ?>"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-sm bg-white hover:bg-slate-50 transition shadow-lg"
               style="color:var(--ink);">
                <i class="fas fa-phone-alt"></i> <?= CONTACT_PHONE1 ?>
            </a>
            <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>"
               target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-sm text-white bg-green-600 hover:bg-green-500 transition shadow-lg">
                <i class="fab fa-whatsapp text-base"></i> WhatsApp Us
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
