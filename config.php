<?php
/**
 * Lokrakshak Real Property Center - Secure Configuration
 * Real Estate Platform | Navsari, Gujarat
 */

// ─── Session Security Hardening ───────────────────────────────────────────────
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1);       // HTTPS only
ini_set('session.cookie_samesite', 'Strict');
ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.gc_maxlifetime', 1800);   // 30 min timeout

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID periodically to prevent fixation
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

// ─── Security Headers (call before any output) ────────────────────────────────
function sendSecurityHeaders(): void {
    if (!headers_sent()) {
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: DENY");
        header("X-XSS-Protection: 1; mode=block");
        header("Referrer-Policy: strict-origin-when-cross-origin");
        header("Permissions-Policy: camera=(), microphone=(), geolocation=()");
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdnjs.cloudflare.com https://fonts.googleapis.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdnjs.cloudflare.com; font-src 'self' https://fonts.gstatic.com https://cdnjs.cloudflare.com; img-src 'self' data: https: blob:; frame-src https://www.google.com; connect-src 'self';");
    }
}
sendSecurityHeaders();

// ─── Database Configuration ───────────────────────────────────────────────────
define('DB_HOST', 'sql104.infinityfree.com');
define('DB_NAME', 'if0_41784051_lokrakshak');
define('DB_USER', 'if0_41784051');         // ← Change on production
define('DB_PASS', 'Rupesh65');             // ← Change on production
define('DB_CHARSET', 'utf8mb4');

// ─── Application Constants ────────────────────────────────────────────────────
define('SITE_NAME', 'Lokrakshak Real Property Center');
define('SITE_TAGLINE', 'Premium Real Estate in Navsari');
define('SITE_URL', 'https://lrpcenter.in');
define('CONTACT_PHONE1', '+91 98986 30756');
define('CONTACT_PHONE2', '+91 92278 50786');
define('CONTACT_EMAIL', 'info@lrpcenter.in');
define('CONTACT_ADDRESS', '104 Shushrusha Hospital Shopping Centre, Sardar Chowk, Vijalpore, Navsari – 396445');
define('WHATSAPP_NUMBER', '919898630756');
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('RATE_LIMIT_WINDOW', 900);  // 15 minutes
define('RATE_LIMIT_MAX', 5);

// ─── Database Connection (Singleton) ─────────────────────────────────────────
function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_PERSISTENT         => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Never expose DB errors to client
            error_log("DB Connection Error: " . $e->getMessage());
            http_response_code(503);
            die(renderError("Service temporarily unavailable. Please try again later."));
        }
    }
    return $pdo;
}

// ─── Output Escaping ──────────────────────────────────────────────────────────
function e(string $string): string {
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function eAttr(string $string): string {
    return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ─── CSRF Protection ──────────────────────────────────────────────────────────
function getCSRFToken(): string {
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time']) || 
        (time() - $_SESSION['csrf_token_time']) > 3600) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

function verifyCSRFToken(string $token): void {
    if (!isset($_SESSION['csrf_token']) || 
        !hash_equals($_SESSION['csrf_token'], $token)) {
        http_response_code(403);
        die(renderError("Security validation failed. Please go back and try again."));
    }
    // Rotate token after use
    unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
}

// ─── Rate Limiting (Brute Force Protection) ───────────────────────────────────
function getClientIP(): string {
    $headers = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_REAL_IP', 'REMOTE_ADDR'];
    foreach ($headers as $h) {
        if (!empty($_SERVER[$h])) {
            $ip = filter_var($_SERVER[$h], FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE);
            if ($ip) return $ip;
        }
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}

function checkRateLimit(string $ip): void {
    $db = getDB();
    $window = time() - RATE_LIMIT_WINDOW;
    $db->prepare("DELETE FROM login_attempts WHERE attempt_time < ?")->execute([$window]);
    
    $stmt = $db->prepare("SELECT COUNT(*) FROM login_attempts WHERE ip_address = ?");
    $stmt->execute([$ip]);
    if ((int)$stmt->fetchColumn() >= RATE_LIMIT_MAX) {
        http_response_code(429);
        die(renderError("Too many failed attempts. Please try again in 15 minutes."));
    }
}

function logFailedAttempt(string $ip): void {
    getDB()->prepare("INSERT INTO login_attempts (ip_address, attempt_time) VALUES (?, ?)")
           ->execute([$ip, time()]);
}

// ─── Auth Guard ───────────────────────────────────────────────────────────────
function requireAdmin(): void {
    if (empty($_SESSION['admin_logged_in']) || empty($_SESSION['admin_user'])) {
        session_destroy();
        header("Location: login");
        exit;
    }
    // Session timeout check
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > 1800) {
        session_destroy();
        header("Location: login?timeout=1");
        exit;
    }
    $_SESSION['last_activity'] = time();
}

// ─── Input Sanitization ───────────────────────────────────────────────────────
function sanitizeString(string $input, int $maxLen = 255): string {
    $input = trim($input);
    $input = strip_tags($input);
    return mb_substr($input, 0, $maxLen, 'UTF-8');
}

function sanitizeInt(mixed $input): int {
    return (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
}

function sanitizePrice(mixed $input): float {
    return (float) filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
}

// ─── Secure Image Upload ──────────────────────────────────────────────────────
function handleSecureImageUpload(array $file): ?string {
    if (empty($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        die(renderError("Image too large. Maximum size is 5MB."));
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    $allowed_exts  = ['jpg', 'jpeg', 'png', 'webp'];
    
    // Verify by MIME type (not extension)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    if (!in_array($mime, $allowed_types, true)) {
        die(renderError("Invalid file type. Only JPG, PNG, WEBP allowed."));
    }
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_exts, true)) {
        die(renderError("Invalid file extension."));
    }

    // Sanitize with GD to strip EXIF/malicious data
    $img = match($mime) {
        'image/jpeg' => imagecreatefromjpeg($file['tmp_name']),
        'image/png'  => imagecreatefrompng($file['tmp_name']),
        'image/webp' => imagecreatefromwebp($file['tmp_name']),
        default      => null
    };
    if (!$img) {
        die(renderError("Could not process the image. Please use a valid photo."));
    }

    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    
    $filename = bin2hex(random_bytes(16)) . '.webp';
    $dest     = $uploadDir . $filename;
    
    imagewebp($img, $dest, 85);
    imagedestroy($img);
    
    return 'uploads/' . $filename;
}

// ─── Error Page Renderer ──────────────────────────────────────────────────────
function renderError(string $message): string {
    return "<!DOCTYPE html><html><head><title>Error – Lokrakshak Real Property Center</title>
    <link href='https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;600&display=swap' rel='stylesheet'>
    <style>*{margin:0;padding:0;box-sizing:border-box}body{font-family:'DM Sans',sans-serif;background:#0f172a;color:#e2e8f0;display:flex;align-items:center;justify-content:center;min-height:100vh;padding:2rem}
    .card{background:#1e293b;border:1px solid #334155;border-radius:16px;padding:2.5rem 3rem;max-width:500px;text-align:center}
    h2{color:#f59e0b;font-size:1.5rem;margin-bottom:1rem}p{color:#94a3b8;margin-bottom:1.5rem;line-height:1.6}
    a{display:inline-block;background:#f59e0b;color:#0f172a;padding:.75rem 2rem;border-radius:8px;font-weight:600;text-decoration:none}</style>
    </head><body><div class='card'><h2>⚠ Error</h2><p>" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "</p>
    <a href='/'>← Return Home</a></div></body></html>";
}
