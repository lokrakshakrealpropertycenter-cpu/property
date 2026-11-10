<?php
require 'config.php';
$db = getDB();

$interest = isset($_GET['interest']) ? sanitizeString($_GET['interest'], 200) : '';
$msg      = '';
$errors   = [];
$success  = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCSRFToken($_POST['csrf_token'] ?? '');

    $name    = sanitizeString($_POST['name']    ?? '', 100);
    $phone   = sanitizeString($_POST['phone']   ?? '',  20);
    $email   = filter_var(trim($_POST['email']  ?? ''), FILTER_VALIDATE_EMAIL);
    $message = sanitizeString($_POST['message'] ?? '', 1000);

    // Validation
    if (strlen($name) < 2)          $errors[] = 'Please enter your full name.';
    if (!preg_match('/^[0-9+\-\s]{7,20}$/', $phone)) $errors[] = 'Enter a valid phone number.';
    if ($email === false)            $errors[] = 'Enter a valid email address.';
    if (strlen($message) < 10)      $errors[] = 'Message must be at least 10 characters.';

    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO contacts (name, phone, email, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $phone, $email ?: '', $message]);
        $success = true;
    }
}

$page_title       = 'Contact Lokrakshak Real Property Center – Real Estate Navsari | Call +91 98986 30756';
$page_description = 'Contact Lokrakshak Real Property Center for premium real estate in Navsari. Call +91 98986 30756, WhatsApp us or visit our office at Vijalpore, Navsari, Gujarat.';
$page_canonical   = SITE_URL . '/contact';
include 'header.php';
?>

<!-- ══ PAGE HERO ══════════════════════════════════════════════════════════ -->
<div class="py-20 md:py-24 text-center" style="background:var(--ink);">
    <div class="max-w-3xl mx-auto px-5">
        <p class="fade-up text-xs font-semibold tracking-widest uppercase mb-3" style="color:var(--gold-dark);">We're Here to Help</p>
        <h1 class="fade-up delay-1 text-4xl md:text-6xl font-bold text-white" style="font-family:'Cormorant Garamond',serif;">
            Get in <span style="color:var(--gold);">Touch</span>
        </h1>
        <p class="fade-up delay-2 mt-4 text-slate-400">
            Send us a message and our agent will respond within a few hours.
        </p>
    </div>
</div>

<!-- ══ CONTACT SECTION ════════════════════════════════════════════════════ -->
<section class="py-16 md:py-24" style="background:var(--paper);">
    <div class="max-w-7xl mx-auto px-5 grid md:grid-cols-5 gap-12 lg:gap-16 items-start">

        <!-- ─ Form (3/5) ─────────────────────────────────────────────────── -->
        <div class="md:col-span-3">
            <div class="rounded-2xl p-8 md:p-10 shadow-xl border" style="background:var(--white); border-color:rgba(201,168,76,0.15);">

                <?php if ($success): ?>
                <!-- Success Message -->
                <div class="text-center py-12">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6"
                         style="background:linear-gradient(135deg,var(--gold-dark),var(--gold-light));">
                        <i class="fas fa-check text-2xl" style="color:var(--ink);"></i>
                    </div>
                    <h2 class="text-3xl font-bold mb-3" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">Message Sent!</h2>
                    <p class="mb-6" style="color:var(--slate);">Thank you! We'll contact you shortly.</p>
                    <a href="contact" class="btn-gold inline-block px-8 py-3 rounded-xl text-sm font-semibold">Send Another</a>
                </div>

                <?php else: ?>

                <h2 class="text-3xl font-bold mb-2" style="font-family:'Cormorant Garamond',serif; color:var(--ink);">Send a Message</h2>
                <p class="text-sm mb-8" style="color:var(--slate);">Fill in the form below and we'll get back to you soon.</p>

                <!-- Errors -->
                <?php if (!empty($errors)): ?>
                <div class="mb-6 p-4 rounded-xl text-sm border" style="background:#fef2f2; border-color:#fecaca; color:#dc2626;">
                    <ul class="list-disc list-inside space-y-1">
                        <?php foreach ($errors as $err): ?>
                        <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <form method="POST" action="contact" class="space-y-5" novalidate>
                    <input type="hidden" name="csrf_token" value="<?= getCSRFToken() ?>">

                    <div class="grid sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color:var(--ink);">Full Name <span style="color:var(--gold);">*</span></label>
                            <input type="text" name="name" required autocomplete="name"
                                   value="<?= e($_POST['name'] ?? '') ?>"
                                   placeholder="Ramesh Patel"
                                   class="form-input">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold mb-2" style="color:var(--ink);">Phone <span style="color:var(--gold);">*</span></label>
                            <input type="tel" name="phone" required autocomplete="tel"
                                   value="<?= e($_POST['phone'] ?? '') ?>"
                                   placeholder="+91 98765 43210"
                                   class="form-input">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:var(--ink);">Email Address <span style="color:var(--gold);">*</span></label>
                        <input type="email" name="email" required autocomplete="email"
                               value="<?= e($_POST['email'] ?? '') ?>"
                               placeholder="you@example.com"
                               class="form-input">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:var(--ink);">Message <span style="color:var(--gold);">*</span></label>
                        <textarea name="message" rows="5" required
                                  placeholder="I'm interested in..."
                                  class="form-input resize-none"><?= e($interest ? "I am interested in: {$interest}" : ($_POST['message'] ?? '')) ?></textarea>
                    </div>

                    <!-- Honeypot (bot trap) -->
                    <div style="display:none;" aria-hidden="true">
                        <input type="text" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <button type="submit" class="btn-gold w-full py-4 rounded-xl text-sm font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i> Send Message
                    </button>
                </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- ─ Contact Info (2/5) ─────────────────────────────────────────── -->
        <div class="md:col-span-2 space-y-6">

            <!-- Info Card -->
            <div class="rounded-2xl p-7 text-white" style="background:var(--ink);">
                <h3 class="text-2xl font-bold mb-6" style="font-family:'Cormorant Garamond',serif; color:var(--gold);">Contact Info</h3>
                <address class="not-italic space-y-5 text-sm">
                    <div class="flex items-start gap-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background:rgba(201,168,76,0.15);">
                            <i class="fas fa-map-marker-alt text-xs" style="color:var(--gold);"></i>
                        </div>
                        <p class="text-slate-300 leading-relaxed"><?= CONTACT_ADDRESS ?></p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background:rgba(201,168,76,0.15);">
                            <i class="fas fa-phone text-xs" style="color:var(--gold);"></i>
                        </div>
                        <div class="text-slate-300">
                            <a href="tel:<?= CONTACT_PHONE1 ?>" class="hover:text-white transition block"><?= CONTACT_PHONE1 ?></a>
                            <a href="tel:<?= CONTACT_PHONE2 ?>" class="hover:text-white transition block"><?= CONTACT_PHONE2 ?></a>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background:rgba(201,168,76,0.15);">
                            <i class="fas fa-envelope text-xs" style="color:var(--gold);"></i>
                        </div>
                        <a href="mailto:<?= CONTACT_EMAIL ?>" class="text-slate-300 hover:text-white transition break-all"><?= CONTACT_EMAIL ?></a>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background:rgba(201,168,76,0.15);">
                            <i class="fas fa-clock text-xs" style="color:var(--gold);"></i>
                        </div>
                        <p class="text-slate-300">Mon–Sat: 9:00 AM – 7:00 PM</p>
                    </div>
                </address>

                <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Hello%20Lokrakshak%20Real%20Property%20Center%2C%20I%20need%20help%20with%20a%20property."
                   target="_blank" rel="noopener"
                   class="mt-7 flex items-center justify-center gap-2 w-full py-3.5 rounded-xl font-semibold text-sm bg-green-600 hover:bg-green-500 text-white transition">
                    <i class="fab fa-whatsapp text-base"></i> Chat on WhatsApp
                </a>
            </div>

            <!-- Map -->
            <div class="rounded-2xl overflow-hidden border shadow-sm" style="border-color:rgba(201,168,76,0.2);">
                <iframe
                    title="Lokrakshak Real Property Center Location – Navsari"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.2678665042624!2d72.9366115!3d20.9417855!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be0f7a0be82f25b%3A0xc3924c538a7c2937!2sSardar%20Chowk!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin"
                    width="100%" height="240" style="border:0;" allowfullscreen loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
