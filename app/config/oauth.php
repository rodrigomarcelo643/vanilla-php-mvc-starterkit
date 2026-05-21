<?php

// ── Google OAuth ───────────────────────────────────────────────
// 1. Go to https://console.cloud.google.com/
// 2. Create a project → APIs & Services → Credentials → OAuth 2.0 Client ID
// 3. Set Authorized redirect URI to: BASE_URL/oauth/google/callback
define('GOOGLE_CLIENT_ID',     $_ENV['GOOGLE_CLIENT_ID']     ?? '');
define('GOOGLE_CLIENT_SECRET', $_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
define('GOOGLE_REDIRECT_URI',  ($_ENV['BASE_URL'] ?? '') . '/oauth/google/callback');

// ── GitHub OAuth ───────────────────────────────────────────────
// 1. Go to https://github.com/settings/developers → OAuth Apps → New OAuth App
// 2. Set Authorization callback URL to: BASE_URL/oauth/github/callback
define('GITHUB_CLIENT_ID',     $_ENV['GITHUB_CLIENT_ID']     ?? '');
define('GITHUB_CLIENT_SECRET', $_ENV['GITHUB_CLIENT_SECRET'] ?? '');
define('GITHUB_REDIRECT_URI',  ($_ENV['BASE_URL'] ?? '') . '/oauth/github/callback');
