<?php
require 'config.php';

// Already logged in → redirect
if (!empty($_SESSION['admin_logged_in'])) {
    header("Location: admin");
    exit;
}

$error   = '';
$timeout = isset($_GET['timeout']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCSRFToken($_POST['csrf_token'] ?? '');

    $ip       = getClientIP();
    checkRateLimit($ip);

    $username = sanitizeString($_POST['username'] ?? '', 80);
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            // Success
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_user']      = $user['username'];
            $_SESSION['last_activity']   = time();
            // Clear failed attempts for this IP
            $db->prepare("DELETE FROM login_attempts WHERE ip_address = ?")->execute([$ip]);
            header("Location: admin");
            exit;
        } else {
            logFailedAttempt($ip);
            // Generic error (don't reveal whether user exists)
            $error = 'Invalid username or password.';
            // Micro-sleep to slow brute force
            usleep(400000);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Lokrakshak Real Property Center</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --gold: #C9A84C; --gold-light: #E8C96A; --gold-dark: #A8892D;
            --ink: #0D1117; --ink-mid: #1A2332;
        }
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, .serif { font-family: 'Cormorant Garamond', serif; }
        .form-input {
            background: #f8f6f2; border: 1.5px solid #e2d8cc; border-radius: 10px;
            padding: 0.85rem 1.1rem; width: 100%; outline: none; font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem; transition: border-color .25s, box-shadow .25s; color: var(--ink);
        }
        .form-input:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,0.18); }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold-dark), var(--gold-light));
            color: var(--ink); font-weight: 600; letter-spacing: 0.04em;
            transition: all .3s ease; box-shadow: 0 4px 20px rgba(201,168,76,0.35);
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(201,168,76,0.5); }
    </style>
</head>
<body class="min-h-screen flex" style="background:var(--ink);">

    <!-- Left decorative panel -->
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden items-center justify-center" style="background:var(--ink-mid);">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1000&q=70"
                 alt="" class="w-full h-full object-cover opacity-20">
        </div>
        <div class="absolute inset-0" style="background:linear-gradient(135deg, rgba(13,17,23,0.9) 0%, rgba(13,17,23,0.5) 100%);"></div>
        <div class="relative text-center px-12">
            <div class="mb-8 mx-auto flex justify-center">
                <div class="overflow-hidden flex items-center justify-center w-[250px] h-[75px] md:w-[350px] md:h-[100px]">
                    <img src="assets/lrp-logo.png" alt="Lokrakshak Real Property Center logo" 
                         class="w-[150%] md:w-[140%] max-w-none object-center" 
                         style="mix-blend-mode: screen;">
                </div>
            </div>
            <div class="mt-10 p-6 rounded-2xl text-left" style="background:rgba(255,255,255,0.04); border:1px solid rgba(201,168,76,0.15);">
                <p class="text-slate-400 text-sm leading-relaxed italic">"The trusted partner for premium real estate in Navsari and Gujarat."</p>
            </div>
        </div>
    </div>

    <!-- Right login panel -->
    <div class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">

            <!-- Mobile logo -->
            <div class="lg:hidden text-center mb-8">
                <div class="mx-auto flex justify-center">
                    <div class="overflow-hidden flex items-center justify-center w-[220px] h-[70px]">
                        <img src="assets/lrp-logo.png" alt="Lokrakshak Real Property Center logo" 
                             class="w-[150%] max-w-none object-center" 
                             style="mix-blend-mode: screen;">
                    </div>
                </div>
            </div>

            <div class="rounded-2xl p-8 md:p-10" style="background:#0f1623; border:1px solid rgba(201,168,76,0.18);">
                <h2 class="text-2xl font-bold text-white mb-1 serif">Admin Access</h2>
                <p class="text-sm mb-8" style="color:#64748b;">Authorised personnel only.</p>

                <?php if ($timeout): ?>
                <div class="mb-5 p-4 rounded-xl text-sm border" style="background:rgba(251,191,36,0.08); border-color:rgba(251,191,36,0.3); color:#fbbf24;">
                    <i class="fas fa-clock mr-2"></i>Session expired. Please log in again.
                </div>
                <?php endif; ?>

                <?php if ($error): ?>
                <div class="mb-5 p-4 rounded-xl text-sm border" style="background:rgba(239,68,68,0.08); border-color:rgba(239,68,68,0.25); color:#f87171;">
                    <i class="fas fa-exclamation-circle mr-2"></i><?= e($error) ?>
                </div>
                <?php endif; ?>

                <form method="POST" action="login" class="space-y-5" autocomplete="off">
                    <input type="hidden" name="csrf_token" value="<?= getCSRFToken() ?>">

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:#94a3b8;">Username</label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-3.5 top-1/2 -translate-y-1/2 text-xs" style="color:#475569;"></i>
                            <input type="text" name="username" required autocomplete="off"
                                   class="form-input pl-10"
                                   style="background:#111827; border-color:#1e293b; color:#e2e8f0;"
                                   onfocus="this.style.borderColor='var(--gold)'"
                                   onblur="this.style.borderColor='#1e293b'">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-2" style="color:#94a3b8;">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-xs" style="color:#475569;"></i>
                            <input type="password" id="pwdField" name="password" required autocomplete="current-password"
                                   class="form-input pl-10 pr-10"
                                   style="background:#111827; border-color:#1e293b; color:#e2e8f0;"
                                   onfocus="this.style.borderColor='var(--gold)'"
                                   onblur="this.style.borderColor='#1e293b'">
                            <button type="button" onclick="togglePwd()" tabindex="-1"
                                    class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs transition"
                                    style="color:#475569;" aria-label="Toggle password">
                                <i id="eyeIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-gold w-full py-4 rounded-xl text-sm font-semibold mt-2">
                        <i class="fas fa-sign-in-alt mr-2"></i>Sign In Securely
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="/" class="text-xs transition" style="color:#475569;"
                       onmouseover="this.style.color='var(--gold)'" onmouseout="this.style.color='#475569'">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Website
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePwd() {
        const f = document.getElementById('pwdField');
        const i = document.getElementById('eyeIcon');
        if (f.type === 'password') {
            f.type = 'text';
            i.className = 'fas fa-eye-slash';
        } else {
            f.type = 'password';
            i.className = 'fas fa-eye';
        }
    }
    </script>
</body>
</html>
