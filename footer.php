<!-- ════════════════════════════════════════════════════════════════════════════ -->
</main>

<!-- ══ WhatsApp Float Button ═════════════════════════════════════════════════ -->
<a href="https://wa.me/<?= WHATSAPP_NUMBER ?>?text=Hello%20Lokrakshak%20Real%20Property%20Center%2C%20I%20am%20interested%20in%20your%20properties." 
   class="wa-float" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<!-- ══ Footer ════════════════════════════════════════════════════════════════ -->
<footer style="background:var(--ink); color:#94a3b8; border-top:3px solid var(--gold-dark);">
    <div class="max-w-7xl mx-auto px-5 pt-16 pb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

            <!-- Brand -->
            <div class="md:col-span-1">
                <div class="mb-6 -ml-2 md:-ml-7">
                    <a href="/" class="inline-block group">
                        <div class="overflow-hidden flex items-center justify-center w-[180px] h-[55px] md:w-[280px] md:h-[80px]">
                            <img src="assets/lrp-logo.png" alt="Lokrakshak Real Property Center logo" 
                                 class="w-[150%] md:w-[140%] max-w-none object-center" 
                                 style="mix-blend-mode: screen;">
                        </div>
                    </a>
                </div>
                <p class="text-sm leading-relaxed text-slate-400">
                    Navsari's most trusted real estate partner. We connect families and investors with premium properties in Navsari & surrounding areas.
                </p>
                <div class="mt-5 flex items-center gap-3">
                    <a href="https://wa.me/<?= WHATSAPP_NUMBER ?>" target="_blank" rel="noopener"
                       class="w-9 h-9 rounded-lg bg-green-600 hover:bg-green-500 flex items-center justify-center text-white transition text-sm" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="mailto:<?= CONTACT_EMAIL ?>"
                       class="w-9 h-9 rounded-lg flex items-center justify-center text-white transition text-sm" 
                       style="background:var(--ink-soft);" aria-label="Email">
                        <i class="fas fa-envelope"></i>
                    </a>
                    <a href="tel:<?= CONTACT_PHONE1 ?>"
                       class="w-9 h-9 rounded-lg flex items-center justify-center text-white transition text-sm"
                       style="background:var(--ink-soft);" aria-label="Phone">
                        <i class="fas fa-phone"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-5 text-sm tracking-widest uppercase" style="color:var(--gold);">Navigation</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="/"    class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs" style="color:var(--gold-dark);"></i>Home</a></li>
                    <li><a href="listings" class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs" style="color:var(--gold-dark);"></i>All Properties</a></li>
                    <li><a href="contact"  class="hover:text-white transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs" style="color:var(--gold-dark);"></i>Contact Us</a></li>
                </ul>
            </div>

            <!-- Property Types -->
            <div>
                <h4 class="text-white font-semibold mb-5 text-sm tracking-widest uppercase" style="color:var(--gold);">We Deal In</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2"><i class="fas fa-seedling text-xs" style="color:var(--gold-dark);"></i>Agricultural / NA Land</li>
                    <li class="flex items-center gap-2"><i class="fas fa-home text-xs" style="color:var(--gold-dark);"></i>Residential Plots</li>
                    <li class="flex items-center gap-2"><i class="fas fa-building text-xs" style="color:var(--gold-dark);"></i>Luxury Bungalows</li>
                    <li class="flex items-center gap-2"><i class="fas fa-store text-xs" style="color:var(--gold-dark);"></i>Commercial Spaces</li>
                    <li class="flex items-center gap-2"><i class="fas fa-city text-xs" style="color:var(--gold-dark);"></i>Flats & Apartments</li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-5 text-sm tracking-widest uppercase" style="color:var(--gold);">Contact</h4>
                <address class="not-italic space-y-4 text-sm">
                    <p class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-0.5 flex-shrink-0" style="color:var(--gold);"></i>
                        <span><?= CONTACT_ADDRESS ?></span>
                    </p>
                    <p class="flex items-center gap-3">
                        <i class="fas fa-phone flex-shrink-0" style="color:var(--gold);"></i>
                        <span>
                            <a href="tel:<?= CONTACT_PHONE1 ?>" class="hover:text-white transition block"><?= CONTACT_PHONE1 ?></a>
                            <a href="tel:<?= CONTACT_PHONE2 ?>" class="hover:text-white transition block"><?= CONTACT_PHONE2 ?></a>
                        </span>
                    </p>
                    <p class="flex items-center gap-3">
                        <i class="fas fa-envelope flex-shrink-0" style="color:var(--gold);"></i>
                        <a href="mailto:<?= CONTACT_EMAIL ?>" class="hover:text-white transition break-all"><?= CONTACT_EMAIL ?></a>
                    </p>
                    <p class="flex items-center gap-3">
                        <i class="fas fa-clock flex-shrink-0" style="color:var(--gold);"></i>
                        <span>Mon–Sat: 9:00 AM – 7:00 PM</span>
                    </p>
                </address>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs" style="border-color:#1e293b;">
            <p>&copy; <?= date('Y') ?> Lokrakshak Real Property Center. All rights reserved.</p>
            <p class="text-slate-600">
                <a href="/" class="hover:text-slate-400 transition">Privacy Policy</a>
                <span class="mx-2">·</span>
                <a href="/" class="hover:text-slate-400 transition">Terms of Service</a>
            </p>
        </div>
    </div>
</footer>
</body>
</html>
