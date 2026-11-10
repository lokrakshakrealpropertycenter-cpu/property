<?php
require 'config.php';
$db = getDB();

// ─── Filtering (safe) ─────────────────────────────────────────────────────────
$type     = isset($_GET['type'])   ? sanitizeString($_GET['type'],  100) : '';
$sort     = isset($_GET['sort'])   ? sanitizeString($_GET['sort'],   30) : 'newest';
$search   = isset($_GET['search']) ? sanitizeString($_GET['search'], 150) : '';

$where  = [];
$params = [];

if ($type !== '' && $type !== 'all') {
    $where[]  = "type = ?";
    $params[] = $type;
}
if ($search !== '') {
    $where[]  = "(title LIKE ? OR location LIKE ? OR description LIKE ?)";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
    $params[] = "%{$search}%";
}

$orderBy = match($sort) {
    'price_asc'  => 'price ASC',
    'price_desc' => 'price DESC',
    'oldest'     => 'created_at ASC',
    default      => 'created_at DESC',
};

$sql = "SELECT * FROM properties" . ($where ? " WHERE " . implode(' AND ', $where) : '') . " ORDER BY {$orderBy}";
$stmt = $db->prepare($sql);
$stmt->execute($params);
$properties = $stmt->fetchAll();

// Distinct types for filter
$types = $db->query("SELECT DISTINCT type FROM properties ORDER BY type")->fetchAll(PDO::FETCH_COLUMN);

$page_title       = 'All Properties – Lokrakshak Real Property Center | Navsari Real Estate';
$page_description = 'Browse all available properties at Lokrakshak Real Property Center. Residential plots, luxury bungalows, agricultural land and commercial spaces in Navsari, Gujarat.';
$page_canonical   = SITE_URL . '/listings';
include 'header.php';
?>

<!-- ══ PAGE HERO ══════════════════════════════════════════════════════════ -->
<div class="relative py-20 md:py-28 overflow-hidden" style="background:var(--ink);">
    <div class="absolute inset-0 opacity-15">
        <img src="https://images.unsplash.com/photo-1582407947304-fd86f028f716?auto=format&fit=crop&w=1600&q=60"
             alt="" class="w-full h-full object-cover" loading="lazy">
    </div>
    <div class="absolute inset-0" style="background:linear-gradient(to right, var(--ink) 40%, transparent 100%);"></div>
    <div class="relative max-w-7xl mx-auto px-5 text-center">
        <p class="fade-up text-xs font-semibold tracking-widest uppercase mb-3" style="color:var(--gold-dark);">Browse Listings</p>
        <h1 class="fade-up delay-1 text-4xl md:text-6xl font-bold text-white mb-4" style="font-family:'Cormorant Garamond',serif;">
            Available <span style="color:var(--gold);">Properties</span>
        </h1>
        <p class="fade-up delay-2 text-slate-400 max-w-xl mx-auto">
            Explore our exclusive collection of verified properties in Navsari and surrounding areas.
        </p>
    </div>
</div>

<!-- ══ FILTERS ════════════════════════════════════════════════════════════ -->
<div class="filter-bar">
    <div class="max-w-7xl mx-auto px-5">
        <form method="GET" action="listings" id="filterForm">
            <!-- Row 1: Main controls -->
            <div class="flex flex-wrap gap-3 items-center filter-row">

                <!-- Search field -->
                <div class="search-wrapper" id="searchWrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="search" id="searchInput"
                           value="<?= e($search) ?>"
                           placeholder="Search by title, location…"
                           class="search-field"
                           autocomplete="off">
                    <button type="button" class="search-clear" id="searchClear" aria-label="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Type filter -->
                <div class="relative">
                    <select name="type" class="filter-select" style="min-width:160px;">
                        <option value="all">All Property Types</option>
                        <?php foreach ($types as $t): ?>
                        <option value="<?= e($t) ?>" <?= $type === $t ? 'selected' : '' ?>><?= e($t) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Sort -->
                <div class="relative">
                    <select name="sort" class="filter-select" style="min-width:150px;">
                        <option value="newest"     <?= $sort === 'newest'     ? 'selected' : '' ?>>Newest First</option>
                        <option value="oldest"     <?= $sort === 'oldest'     ? 'selected' : '' ?>>Oldest First</option>
                        <option value="price_asc"  <?= $sort === 'price_asc'  ? 'selected' : '' ?>>Price: Low → High</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Price: High → Low</option>
                    </select>
                </div>

                <!-- Search button -->
                <button type="submit" class="filter-btn">
                    <i class="fas fa-search" style="font-size:0.75rem;"></i>
                    Search
                </button>

                <!-- Active filters + Clear -->
                <?php if ($type && $type !== 'all' || $search): ?>
                <div class="flex items-center gap-2 flex-wrap">
                    <?php if ($search): ?>
                    <span class="filter-chip"><i class="fas fa-search" style="font-size:0.6rem;"></i> "<?= e($search) ?>"</span>
                    <?php endif; ?>
                    <?php if ($type && $type !== 'all'): ?>
                    <span class="filter-chip"><i class="fas fa-tag" style="font-size:0.6rem;"></i> <?= e($type) ?></span>
                    <?php endif; ?>
                    <a href="listings" class="clear-link">
                        <i class="fas fa-times-circle" style="font-size:0.75rem;"></i>
                        Clear all
                    </a>
                </div>
                <?php endif; ?>

                <!-- Result count -->
                <div class="ml-auto hidden md:flex items-center gap-2">
                    <span class="result-count">
                        <strong><?= count($properties) ?></strong>
                        propert<?= count($properties) === 1 ? 'y' : 'ies' ?> found
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Search clear button logic
const searchInput   = document.getElementById('searchInput');
const searchWrapper = document.getElementById('searchWrapper');
const searchClear   = document.getElementById('searchClear');

function checkSearchVal() {
    searchWrapper.classList.toggle('has-value', searchInput.value.length > 0);
}
searchInput.addEventListener('input', checkSearchVal);
searchClear.addEventListener('click', () => {
    searchInput.value = '';
    checkSearchVal();
    searchInput.focus();
});
// Init on load
checkSearchVal();
</script>

<!-- ══ LISTINGS GRID ══════════════════════════════════════════════════════ -->
<section class="py-14 md:py-20" style="background:var(--paper);">
    <div class="max-w-7xl mx-auto px-5">

        <?php if (empty($properties)): ?>
        <div class="text-center py-24 rounded-2xl border-2 border-dashed" style="border-color:rgba(201,168,76,0.3);">
            <i class="fas fa-search text-5xl mb-5" style="color:rgba(201,168,76,0.4);"></i>
            <h3 class="text-2xl font-bold mb-2" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">No Properties Found</h3>
            <p class="mb-6" style="color:var(--slate);">Try changing your filters or search terms.</p>
            <a href="listings" class="btn-gold inline-block px-8 py-3 rounded-xl text-sm font-semibold">Show All Listings</a>
        </div>

        <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($properties as $p): ?>
            <article class="prop-card flex flex-col">
                <!-- Image -->
                <div class="card-img relative h-60">
                    <?php $img = $p['image_path'] ? e($p['image_path']) : 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&w=800&q=70'; ?>
                    <img src="<?= $img ?>" alt="<?= e($p['title']) ?>"
                         class="w-full h-full object-cover" loading="lazy" width="800" height="480">
                    <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(13,17,23,0.72) 0%, transparent 55%);"></div>
                    <div class="absolute top-4 left-4">
                        <span class="prop-badge"><?= e($p['type']) ?></span>
                    </div>
                    <div class="absolute bottom-4 left-4">
                        <p class="text-white font-bold text-xl" style="font-family:'Cormorant Garamond',serif; text-shadow:0 2px 8px rgba(0,0,0,0.5);">
                            ₹<?= number_format($p['price']) ?>
                        </p>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <p class="text-xs mb-2 flex items-center gap-1.5 font-medium" style="color:var(--gold-dark);">
                        <i class="fas fa-map-marker-alt"></i> <?= e($p['location']) ?>
                    </p>
                    <h2 class="text-xl font-bold mb-2 leading-snug" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                        <?= e($p['title']) ?>
                    </h2>
                    <?php if (!empty($p['description'])): ?>
                    <p class="text-sm mb-5 flex-grow leading-relaxed" style="color:var(--slate); display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">
                        <?= e($p['description']) ?>
                    </p>
                    <?php endif; ?>

                    <div class="mt-auto pt-4 border-t flex gap-3" style="border-color:#f1ede6;">
                        <a href="contact?interest=<?= urlencode($p['title']) ?>"
                           class="btn-gold flex-1 text-center py-3 rounded-xl text-sm font-semibold">
                            Contact Agent
                        </a>
                        <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Hello!%20I'm%20interested%20in%20the%20property%3A%20<?= urlencode($p['title']) ?>"
                           target="_blank" rel="noopener"
                           class="w-12 h-12 rounded-xl flex items-center justify-center text-white bg-green-600 hover:bg-green-500 transition flex-shrink-0 text-base"
                           aria-label="WhatsApp">
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

<?php include 'footer.php'; ?>
