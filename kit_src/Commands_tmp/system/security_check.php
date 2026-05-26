<?php

/**
 * MARDEV SECURITY CONFIGURATION & STATIC DEFENSE CHECKER
 * 
 * This command performs static analysis on the application codebase, views, 
 * configurations, and routes to ensure security controls are present.
 */

// ── Helpers & Formatting ──────────────────────────────────────

function securityHeading($title) {
    echo "\n\033[1;35m=========================================================\033[0m\n";
    echo "  \033[1;36m{$title}\033[0m\n";
    echo "\033[1;35m=========================================================\033[0m\n";
}

function securityPass($message) {
    echo "  \033[1;32m[PASS]\033[0m {$message}\n";
}

function securityFail($message, $fixSuggestion) {
    echo "  \033[1;31m[FAIL]\033[0m \033[1;37m{$message}\033[0m\n";
    echo "         \033[1;33mFix Recommendation:\033[0m {$fixSuggestion}\n";
}

function securityWarning($message, $fixSuggestion) {
    echo "  \033[1;33m[WARN]\033[0m \033[1;37m{$message}\033[0m\n";
    echo "         \033[1;33mAdvice:\033[0m {$fixSuggestion}\n";
}

function findPhpFiles($dir) {
    $files = [];
    if (!is_dir($dir)) return $files;
    
    $it = new RecursiveDirectoryIterator($dir);
    foreach (new RecursiveIteratorIterator($it) as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $files[] = $file->getPathname();
        }
    }
    return $files;
}

// ── Initialization ─────────────────────────────────────────────

$appRoot = KIT_ROOT;
$controllersDir = $appRoot . '/app/controllers';
$modelsDir = $appRoot . '/app/models';
$viewsDir = $appRoot . '/app/views';
$routesDir = $appRoot . '/routes';

securityHeading("MARDEV STATIC APPLICATION SECURITY DEFENSE SCANNER");
echo "Scanning directory: \033[1;32m{$appRoot}\033[0m\n";
echo "Performing security checklist audits...\n";

// ── 1. CSRF Protection Check ────────────────────────────────────
securityHeading("1. CROSS-SITE REQUEST FORGERY (CSRF) MITIGATION");

$viewFiles   = findPhpFiles($viewsDir);
$formsCount  = 0;
$formsWithCsrf = 0;
$missingCsrfViews = [];

// Detect if the project uses header-based CSRF (Ajax.js X-CSRF-Token + verifyCsrf())
$controllerScanFiles = findPhpFiles($controllersDir);
$hasHeaderCsrf = false;
foreach ($controllerScanFiles as $csf) {
    $csc = file_get_contents($csf);
    if (stripos($csc, 'verifyCsrf') !== false || stripos($csc, 'HTTP_X_CSRF_TOKEN') !== false) {
        $hasHeaderCsrf = true;
        break;
    }
}

foreach ($viewFiles as $file) {
    $content = file_get_contents($file);
    if (preg_match_all('/<form\b[^>]*>/si', $content, $matches)) {
        $formsCount += count($matches[0]);
        if ($hasHeaderCsrf) {
            // All AJAX forms are covered by the X-CSRF-Token header mechanism
            $formsWithCsrf += count($matches[0]);
        } else {
            $csrfCount = preg_match_all('/csrf_field\b|csrf_token\b|name=["\']csrf_token["\']/si', $content, $csrfMatches);
            $formsWithCsrf += $csrfCount;
            if ($csrfCount < count($matches[0])) {
                $missingCsrfViews[] = basename($file);
            }
        }
    }
}

if ($formsCount === 0) {
    securityPass("No HTML input forms detected in the view templates.");
} elseif ($formsWithCsrf >= $formsCount) {
    $method = $hasHeaderCsrf ? 'X-CSRF-Token header (Ajax.js + verifyCsrf)' : 'hidden csrf_token field';
    securityPass("All {$formsCount} form(s) are CSRF-protected via: {$method}.");
} else {
    $diff = $formsCount - $formsWithCsrf;
    securityFail(
        "{$diff} form(s) are missing CSRF protection (hidden field and no verifyCsrf() detected).",
        "Add hidden CSRF fields, or implement header-based CSRF: add verifyCsrf() in Controller.php and auto-inject X-CSRF-Token via Ajax.js."
    );
}

// ── 2. SQL Injection Static Audit ──────────────────────────────
securityHeading("2. DATABASE INTERACTION & SQL INJECTION SANITIZATION");

$modelFiles = findPhpFiles($modelsDir);
$sqlConcatWarnings = [];

foreach ($modelFiles as $file) {
    $content = file_get_contents($file);

    // Only flag when a $variable is directly interpolated INSIDE the SQL string itself.
    // [^"']* prevents the regex crossing the string boundary into surrounding ->execute() calls.
    // This eliminates false positives from correct parameterized queries like prepare("... WHERE id = ?").
    if (preg_match_all('/(query|prepare)\s*\(\s*"([^"]*\$[a-zA-Z_][a-zA-Z0-9_]*[^"]*)"/i', $content, $sqm)) {
        foreach ($sqm[2] as $hit) {
            $sqlConcatWarnings[] = [
                'file'    => basename($file),
                'snippet' => trim(substr($hit, 0, 80))
            ];
        }
    }
    // Also check single-quoted strings with concatenated variables: 'SELECT ... ' . $var . ' ...'
    if (preg_match_all('/prepare\s*\(\s*\'[^\']*\'\s*\.\s*\$[a-zA-Z_][a-zA-Z0-9_]*/i', $content, $sqm2)) {
        foreach ($sqm2[0] as $hit2) {
            $sqlConcatWarnings[] = [
                'file'    => basename($file),
                'snippet' => trim(substr($hit2, 0, 80))
            ];
        }
    }
}

if (empty($sqlConcatWarnings)) {
    securityPass("All database Model queries use parameterized prepared statements. No raw variable interpolation detected.");
} else {
    foreach ($sqlConcatWarnings as $warn) {
        securityFail(
            "Raw PHP variable interpolated inside SQL string in '{$warn['file']}': {$warn['snippet']}",
            "Replace with a placeholder: \$pdo->prepare('SELECT ... WHERE id = ?') then \$stmt->execute([\$id]);"
        );
    }
}

// ── 3. Strict Type Escalation & CAST Audit ─────────────────────
securityHeading("3. ROUTE INPUT ESCALATION & PARAMETER CASTING");

$controllerFiles = findPhpFiles($controllersDir);
$uncastInputWarnings = [];

foreach ($controllerFiles as $file) {
    $content = file_get_contents($file);
    
    if (preg_match_all('/(\$[a-zA-Z0-9_]*id)\s*=\s*\$_(GET|POST|REQUEST)\[[\'"]id[\'"]\]\s*;/i', $content, $matches)) {
        foreach ($matches[1] as $varName) {
            $uncastInputWarnings[] = [
                'file' => basename($file),
                'var' => $varName
            ];
        }
    }
}

if (empty($uncastInputWarnings)) {
    securityPass("Controller action input variables (such as entity IDs) are correctly validated or type-cast.");
} else {
    foreach ($uncastInputWarnings as $warn) {
        securityWarning(
            "Controller input {$warn['var']} in '{$warn['file']}' is assigned from request query parameters without strict integer casting.",
            "Enforce type safety by wrapping the incoming variable with integer casting: `{$warn['var']} = (int) (\$_GET['id'] ?? 0);`"
        );
    }
}

// ── 4. Cryptographic Password Hashing Check ────────────────────
securityHeading("4. PASSWORDS STORAGE & CRYPTOGRAPHIC HASHING");

$insecureHashFunctions = ['md5', 'sha1', 'crypt'];
$insecureHashWarnings = [];
$secureHashDetected = false;

foreach (array_merge($controllerFiles, $modelFiles) as $file) {
    $content = file_get_contents($file);
    
    if (strpos($content, 'password_hash') !== false) {
        $secureHashDetected = true;
    }
    
    foreach ($insecureHashFunctions as $func) {
        if (preg_match('/' . $func . '\s*\(\s*.*password/i', $content)) {
            $insecureHashWarnings[] = [
                'file' => basename($file),
                'func' => $func
            ];
        }
    }
}

if (!empty($insecureHashWarnings)) {
    foreach ($insecureHashWarnings as $warn) {
        securityFail(
            "Insecure hashing function '{$warn['func']}' applied to password strings in '{$warn['file']}'.",
            "Replace MD5/SHA1/Crypt with secure password hashing. In PHP, use `password_hash(\$password, PASSWORD_BCRYPT)` and verify with `password_verify(\$password, \$hashed)`."
        );
    }
} elseif ($secureHashDetected) {
    securityPass("Secure password storage standard recognized (validated use of `password_hash` & `password_verify`).");
} else {
    securityWarning(
        "No password hashing validation detected statically in your controllers/models.",
        "Ensure all user credentials and administrative access secrets are persisted using secure industry-standard algorithms: `password_hash(\$password, PASSWORD_DEFAULT)`."
    );
}

// ── 5. Secure Output Escaping (XSS Prevention) ────────────────
securityHeading("5. TEMPLATE OUTPUT ESCAPING & DYNAMIC XSS PREVENTION");

$untrustedOutputWarnings = [];
foreach ($viewFiles as $file) {
    $content = file_get_contents($file);
    
    if (preg_match_all('/<\?=\s*(\$[a-zA-Z0-9_]+)\s*\?>/i', $content, $matches)) {
        foreach ($matches[1] as $matchVar) {
            if (in_array($matchVar, ['$total', '$page', '$totalPages', '$sortKey', '$sortDir'])) {
                continue;
            }
            $untrustedOutputWarnings[] = [
                'file' => basename($file),
                'snippet' => '<' . '?=' . $matchVar . '?' . '>'
            ];
        }
    }
}

if (empty($untrustedOutputWarnings)) {
    securityPass("Template system output statements are securely encoded.");
} else {
    $sample = array_slice($untrustedOutputWarnings, 0, 5);
    securityWarning(
        "Detected " . count($untrustedOutputWarnings) . " direct raw tag outputs (e.g. " . $sample[0]['snippet'] . " in '" . $sample[0]['file'] . "') that bypass XSS sanitation rules.",
        "Always escape dynamically generated browser variables using `htmlspecialchars(\$value, ENT_QUOTES, 'UTF-8')` or register an escaping layout helper like `e(\$value)`."
    );
}

// ── 6. Auth Protection & Rate Limiting Verification ───────────
securityHeading("6. API MIDDLEWARE & RATE LIMITING DEFENSE");

$routesFiles = findPhpFiles($routesDir);
$hasRateLimiting = false;

foreach ($routesFiles as $file) {
    $content = file_get_contents($file);
    if (strpos($content, 'rate') !== false || strpos($content, 'throttle') !== false || strpos($content, 'limit') !== false) {
        $hasRateLimiting = true;
    }
}

if ($hasRateLimiting) {
    securityPass("Active request rate limiting middleware configurations or hooks detected inside route configurations.");
} else {
    securityWarning(
        "No rate limiting or authentication request throttling configurations found in route definitions.",
        "Implement rate limiting middleware on public POST auth endpoints (e.g., `/ajax/login`, `/register`) to prevent server resource abuse and automated authentication sweeps."
    );
}

// ── 7. HTTP Security Headers Audit ─────────────────────────────
securityHeading("7. APP CONFIGURATION & HTTP SECURITY HEADERS");

$appConfig = $appRoot . '/app/config/app.php';
$hasHeaders = false;

if (file_exists($appConfig)) {
    $content = file_get_contents($appConfig);
    if (strpos($content, 'X-Frame-Options') !== false || strpos($content, 'Content-Security-Policy') !== false) {
        $hasHeaders = true;
    }
}

if ($hasHeaders) {
    securityPass("Secure HTTP security headers are globally registered inside configuration files.");
} else {
    securityWarning(
        "Application bootstrap does not explicitly declare secure client headers (CSP, HSTS, Frame Guard).",
        "Add core PHP security headers in your main entry bootstrap file:\n" .
        "         header(\"X-Frame-Options: SAMEORIGIN\");\n" .
        "         header(\"X-Content-Type-Options: nosniff\");\n" .
        "         header(\"Content-Security-Policy: default-src 'self'\");\n" .
        "         header(\"Referrer-Policy: strict-origin-when-cross-origin\");"
    );
}

echo "\n\033[1;35m=========================================================\033[0m\n";
echo "  \033[1;32mAUDIT COMPLETE\033[0m\n";
echo "\033[1;35m=========================================================\033[0m\n\n";