<?php
require 'config.php';
requireAdmin();
$db  = getDB();
$msg = '';
$err = '';

// ─── Add Property ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add') {
    verifyCSRFToken($_POST['csrf_token'] ?? '');

    $title       = sanitizeString($_POST['title']       ?? '', 200);
    $type        = sanitizeString($_POST['type']        ?? '', 100);
    $price       = sanitizePrice ($_POST['price']       ?? 0);
    $location    = sanitizeString($_POST['location']    ?? '', 200);
    $description = sanitizeString($_POST['description'] ?? '', 1000);
    $image_path  = null;

    if (!empty($_FILES['image']['tmp_name'])) {
        $image_path = handleSecureImageUpload($_FILES['image']);
    }

    if ($title && $type && $price > 0 && $location) {
        $db->prepare("INSERT INTO properties (title, type, price, location, description, image_path, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())")
           ->execute([$title, $type, $price, $location, $description, $image_path]);
        $msg = "Property <strong>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</strong> published successfully!";
    } else {
        $err = "Please fill in all required fields.";
    }
}

// ─── Delete Property ──────────────────────────────────────────────────────────
if (isset($_GET['delete'])) {
    $id   = sanitizeInt($_GET['delete']);
    $prop = $db->prepare("SELECT image_path FROM properties WHERE id = ?");
    $prop->execute([$id]);
    $res = $prop->fetch();
    if ($res && $res['image_path'] && file_exists(__DIR__ . '/' . $res['image_path'])) {
        unlink(__DIR__ . '/' . $res['image_path']);
    }
    $db->prepare("DELETE FROM properties WHERE id = ?")->execute([$id]);
    header("Location: admin?deleted=1");
    exit;
}

// ─── Delete Inquiry ────────────────────────────────────────────────────────────
if (isset($_GET['delete_msg'])) {
    $db->prepare("DELETE FROM contacts WHERE id = ?")->execute([sanitizeInt($_GET['delete_msg'])]);
    header("Location: admin?dmsg=1");
    exit;
}

$properties = $db->query("SELECT * FROM properties ORDER BY created_at DESC")->fetchAll();
$inquiries  = $db->query("SELECT * FROM contacts ORDER BY created_at DESC")->fetchAll();
$totalPrice = array_sum(array_column($properties, 'price'));

$page_title = 'Admin Dashboard – Lokrakshak Real Property Center';
include 'header.php';
?>

<!-- ══ ADMIN WRAPPER ══════════════════════════════════════════════════════ -->
<div class="py-10 min-h-screen" style="background:#f1f5f9;">
<div class="max-w-7xl mx-auto px-5">

    <!-- ─ Top Bar ──────────────────────────────────────────────────────── -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                Admin Dashboard
            </h1>
            <p class="text-sm mt-1" style="color:var(--slate);">
                Welcome, <strong><?= e($_SESSION['admin_user']) ?></strong> &nbsp;·&nbsp;
                <?= date('D, d M Y') ?>
            </p>
        </div>
        <a href="logout" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-red-600 hover:bg-red-700 transition self-start sm:self-auto">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Alerts -->
    <?php if ($msg): ?>
    <div class="mb-6 p-4 rounded-xl text-sm border flex items-center gap-3" style="background:#f0fdf4; border-color:#86efac; color:#166534;">
        <i class="fas fa-check-circle"></i> <span><?= $msg ?></span>
    </div>
    <?php endif; ?>
    <?php if ($err): ?>
    <div class="mb-6 p-4 rounded-xl text-sm border flex items-center gap-3" style="background:#fef2f2; border-color:#fca5a5; color:#991b1b;">
        <i class="fas fa-exclamation-circle"></i> <?= e($err) ?>
    </div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
    <div class="mb-6 p-4 rounded-xl text-sm border flex items-center gap-3" style="background:#fff7ed; border-color:#fcd34d; color:#92400e;">
        <i class="fas fa-trash"></i> Property deleted.
    </div>
    <?php endif; ?>

    <!-- ─ Stats ────────────────────────────────────────────────────────── -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
        <?php
        $statCards = [
            ['fas fa-building',      count($properties),                              'Total Properties', '#dbeafe', '#1d4ed8'],
            ['fas fa-envelope',      count($inquiries),                               'Inquiries',        '#fce7f3', '#be185d'],
            ['fas fa-rupee-sign',    '₹' . number_format($totalPrice),               'Portfolio Value',  '#fef9c3', '#a16207'],
            ['fas fa-eye',           count(array_filter($properties, fn($p) => !empty($p['image_path']))), 'With Images', '#dcfce7', '#15803d'],
        ];
        foreach ($statCards as [$icon, $val, $label, $bg, $color]): ?>
        <div class="rounded-2xl p-5 flex items-center gap-4 shadow-sm border border-white" style="background:var(--white);">
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?= $bg ?>;">
                <i class="<?= $icon ?> text-sm" style="color:<?= $color ?>;"></i>
            </div>
            <div>
                <div class="text-xl font-bold" style="font-family:'Cormorant Garamond',serif; color:var(--ink);"><?= $val ?></div>
                <div class="text-xs" style="color:var(--slate);"><?= $label ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- ─ Main Grid ────────────────────────────────────────────────────── -->
    <div class="grid lg:grid-cols-3 gap-8">

        <!-- Add Property Form -->
        <div class="lg:col-span-1">
            <div class="rounded-2xl shadow-sm border border-white sticky top-24" style="background:var(--white);">
                <div class="p-6 border-b" style="border-color:#f1f5f9;">
                    <h2 class="font-bold text-lg flex items-center gap-2" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                        <i class="fas fa-plus-circle text-sm" style="color:var(--gold-dark);"></i>
                        Add Property
                    </h2>
                </div>
                <div class="p-6">
                    <form method="POST" enctype="multipart/form-data" class="space-y-4" action="admin">
                        <input type="hidden" name="csrf_token" value="<?= getCSRFToken() ?>">
                        <input type="hidden" name="action"     value="add">

                        <div>
                            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Title *</label>
                            <input type="text" name="title" required placeholder="e.g. 3BHK Bungalow, Vijalpore"
                                   class="form-input text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Type *</label>
                            <select name="type" class="form-input text-sm">
                                <option value="Land (Agri/NA)">Land (Agri/NA)</option>
                                <option value="Residential Plot">Residential Plot</option>
                                <option value="Commercial Plot">Commercial Plot</option>
                                <option value="Flat / Apartment">Flat / Apartment</option>
                                <option value="Bungalow">Bungalow / Row House</option>
                                <option value="Shop / Office">Shop / Office / Factory</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Price (₹) *</label>
                                <input type="number" name="price" required placeholder="2500000" min="0"
                                       class="form-input text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Location *</label>
                                <input type="text" name="location" required placeholder="Vijalpore"
                                       class="form-input text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Description</label>
                            <textarea name="description" rows="3" placeholder="Key details, size, facing, etc."
                                      class="form-input text-sm resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold mb-1.5 uppercase tracking-wider" style="color:var(--slate);">Image (JPG/PNG/WEBP, max 5MB)</label>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/webp"
                                   class="w-full text-sm text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold cursor-pointer"
                                   style="file:background:var(--ink); file:color:white;">
                        </div>

                        <button type="submit" class="btn-gold w-full py-3.5 rounded-xl text-sm font-semibold flex items-center justify-center gap-2">
                            <i class="fas fa-cloud-upload-alt"></i> Publish Property
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Panels -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Inquiries -->
            <div class="rounded-2xl shadow-sm border border-white overflow-hidden" style="background:var(--white);">
                <div class="p-6 border-b flex items-center justify-between" style="border-color:#f1f5f9;">
                    <h2 class="font-bold text-lg flex items-center gap-2" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                        <i class="fas fa-envelope text-sm" style="color:var(--gold-dark);"></i>
                        Client Inquiries
                        <?php if ($inquiries): ?>
                        <span class="text-xs px-2.5 py-1 rounded-full font-semibold" style="background:#fef3c7; color:#92400e;"><?= count($inquiries) ?></span>
                        <?php endif; ?>
                    </h2>
                </div>
                <?php if (empty($inquiries)): ?>
                <div class="p-12 text-center" style="color:var(--slate);">
                    <i class="fas fa-inbox text-3xl mb-3 block opacity-30"></i>
                    <p class="text-sm">No inquiries yet.</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead style="background:#f8fafc;">
                            <tr class="text-xs uppercase tracking-wider" style="color:var(--slate);">
                                <th class="px-5 py-3.5 text-left font-semibold">Date</th>
                                <th class="px-5 py-3.5 text-left font-semibold">Client</th>
                                <th class="px-5 py-3.5 text-left font-semibold hidden md:table-cell">Message</th>
                                <th class="px-5 py-3.5 text-right font-semibold">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="divide-color:#f8fafc;">
                            <?php foreach ($inquiries as $inq): ?>
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-xs" style="color:var(--slate);">
                                    <?= date('d M Y', strtotime($inq['created_at'])) ?>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold" style="color:var(--ink);"><?= e($inq['name']) ?></div>
                                    <a href="tel:<?= e($inq['phone']) ?>" class="text-xs" style="color:var(--gold-dark);">
                                        <i class="fas fa-phone mr-1"></i><?= e($inq['phone']) ?>
                                    </a>
                                    <?php if (!empty($inq['email'])): ?>
                                    <br><a href="mailto:<?= e($inq['email']) ?>" class="text-xs" style="color:var(--slate);"><?= e($inq['email']) ?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-4 hidden md:table-cell text-xs max-w-xs" style="color:var(--slate);">
                                    <span style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                                        <?= e($inq['message']) ?>
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="admin?delete_msg=<?= $inq['id'] ?>"
                                       onclick="return confirm('Delete this inquiry?');"
                                       class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 transition font-medium">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <!-- Active Listings -->
            <div class="rounded-2xl shadow-sm border border-white overflow-hidden" style="background:var(--white);">
                <div class="p-6 border-b flex items-center gap-3" style="border-color:#f1f5f9;">
                    <h2 class="font-bold text-lg flex items-center gap-2" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">
                        <i class="fas fa-building text-sm" style="color:var(--gold-dark);"></i>
                        Active Listings
                    </h2>
                    <span class="ml-auto text-xs font-semibold px-2.5 py-1 rounded-full" style="background:#dbeafe; color:#1d4ed8;"><?= count($properties) ?></span>
                </div>
                <?php if (empty($properties)): ?>
                <div class="p-12 text-center" style="color:var(--slate);">
                    <i class="fas fa-home text-3xl mb-3 block opacity-30"></i>
                    <p class="text-sm">No properties yet. Add one above!</p>
                </div>
                <?php else: ?>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead style="background:#f8fafc;">
                            <tr class="text-xs uppercase tracking-wider" style="color:var(--slate);">
                                <th class="px-5 py-3.5 text-left font-semibold">Property</th>
                                <th class="px-5 py-3.5 text-left font-semibold hidden sm:table-cell">Type</th>
                                <th class="px-5 py-3.5 text-left font-semibold">Price</th>
                                <th class="px-5 py-3.5 text-right font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y" style="divide-color:#f8fafc;">
                            <?php foreach ($properties as $p): ?>
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <?php if ($p['image_path']): ?>
                                        <img src="<?= e($p['image_path']) ?>" alt=""
                                             class="w-12 h-12 rounded-lg object-cover flex-shrink-0 border" style="border-color:#e2e8f0;">
                                        <?php else: ?>
                                        <div class="w-12 h-12 rounded-lg flex-shrink-0 flex items-center justify-center" style="background:#f1f5f9;">
                                            <i class="fas fa-home text-sm" style="color:#94a3b8;"></i>
                                        </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="font-semibold text-sm" style="color:var(--ink);"><?= e($p['title']) ?></div>
                                            <div class="text-xs" style="color:var(--slate);"><i class="fas fa-map-marker-alt mr-1" style="color:var(--gold-dark);"></i><?= e($p['location']) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-4 hidden sm:table-cell">
                                    <span class="text-xs px-2.5 py-1 rounded-full font-medium" style="background:#f1f5f9; color:#475569;"><?= e($p['type']) ?></span>
                                </td>
                                <td class="px-5 py-4 font-semibold" style="color:var(--ink);">
                                    ₹<?= number_format($p['price']) ?>
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <a href="admin?delete=<?= $p['id'] ?>"
                                       onclick="return confirm('Delete \"<?= e(addslashes($p['title'])) ?>\"? This cannot be undone.');"
                                       class="inline-flex items-center gap-1.5 text-xs px-3 py-1.5 rounded-lg text-red-600 hover:bg-red-50 transition font-medium">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>

        </div><!-- /right panels -->
    </div><!-- /grid -->
</div><!-- /container -->
</div><!-- /wrapper -->

<?php include 'footer.php'; ?>
