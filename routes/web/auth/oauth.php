<?php

// ── OAuth Routes ───────────────────────────────────────────────
Router::get('oauth/google',          ['OAuthController', 'googleRedirect']);
Router::get('oauth/google/callback', ['OAuthController', 'googleCallback']);
Router::get('oauth/github',          ['OAuthController', 'githubRedirect']);
Router::get('oauth/github/callback', ['OAuthController', 'githubCallback']);
