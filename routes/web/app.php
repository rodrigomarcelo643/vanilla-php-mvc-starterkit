<?php

// ── App / Authenticated User Routes ──────────────────────────
Router::get('app/home',     ['AppController', 'home']);
Router::get('app/profile',  ['AppController', 'profile']);
Router::get('app/settings', ['AppController', 'settings']);
