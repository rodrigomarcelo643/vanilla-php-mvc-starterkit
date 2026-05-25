<?php

// ── App / Authenticated User Page Routes ──────────────────────
Router::get('app/home',     ['AppController', 'home'])->middleware('auth');
Router::get('app/profile',  ['AppController', 'profile'])->middleware('auth');
Router::get('app/settings', ['AppController', 'settings'])->middleware('auth');
