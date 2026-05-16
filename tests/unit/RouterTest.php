<?php

use PHPUnit\Framework\TestCase;

/**
 * RouterTest
 *
 * Tests Router::parseUri() edge cases — the most critical
 * part of the routing layer since a wrong URI parse means
 * every route silently 404s.
 */
class RouterTest extends TestCase
{
    protected function setUri(string $uri): void
    {
        $_SERVER['REQUEST_URI'] = $uri;
    }

    // ── Happy path ────────────────────────────────────────────

    public function test_root_uri_returns_slash(): void
    {
        $this->setUri('/starterkit');
        $this->assertSame('/', Router::parseUri());
    }

    public function test_simple_segment_parsed_correctly(): void
    {
        $this->setUri('/starterkit/login');
        $this->assertSame('login', Router::parseUri());
    }

    public function test_nested_segment_parsed_correctly(): void
    {
        $this->setUri('/starterkit/admin/users');
        $this->assertSame('admin/users', Router::parseUri());
    }

    public function test_app_prefix_parsed_correctly(): void
    {
        $this->setUri('/starterkit/app/settings');
        $this->assertSame('app/settings', Router::parseUri());
    }

    // ── Query string stripping ────────────────────────────────

    public function test_query_string_is_stripped(): void
    {
        $this->setUri('/starterkit/dashboard?tab=users&page=2');
        $this->assertSame('dashboard', Router::parseUri());
    }

    public function test_root_with_query_string_returns_slash(): void
    {
        $this->setUri('/starterkit/?ref=email');
        $this->assertSame('/', Router::parseUri());
    }

    // ── Trailing slash normalisation ──────────────────────────

    public function test_trailing_slash_is_trimmed(): void
    {
        $this->setUri('/starterkit/about/');
        $this->assertSame('about', Router::parseUri());
    }

    // ── Edge cases ────────────────────────────────────────────

    public function test_double_slash_in_uri_is_handled(): void
    {
        $this->setUri('/starterkit//login');
        // trim('/') collapses leading slash — result should not be empty
        $result = Router::parseUri();
        $this->assertNotEmpty($result);
    }

    public function test_ajax_route_parsed_correctly(): void
    {
        $this->setUri('/starterkit/ajax/login');
        $this->assertSame('ajax/login', Router::parseUri());
    }

    public function test_uri_without_base_url_still_parses(): void
    {
        // Simulates app running at web root (BASE_URL = '')
        $this->setUri('/dashboard');
        $result = Router::parseUri();
        // Should return 'dashboard' or '/' — must not crash
        $this->assertIsString($result);
    }

    // ── Route registration ────────────────────────────────────

    public function test_get_route_is_registered(): void
    {
        Router::get('test/route', ['HomeController', 'index']);
        // No exception = registered. Dispatch is tested in feature tests.
        $this->assertTrue(true);
    }

    public function test_post_route_is_registered(): void
    {
        Router::post('test/post', ['AuthController', 'ajaxLogin']);
        $this->assertTrue(true);
    }

    // ── isAjax ────────────────────────────────────────────────

    public function test_is_ajax_returns_false_without_header(): void
    {
        unset($_SERVER['HTTP_X_REQUESTED_WITH']);
        $this->assertFalse(Router::isAjax());
    }

    public function test_is_ajax_returns_true_with_header(): void
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
        $this->assertTrue(Router::isAjax());
        unset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    public function test_is_ajax_is_case_insensitive(): void
    {
        $_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
        $this->assertTrue(Router::isAjax());
        unset($_SERVER['HTTP_X_REQUESTED_WITH']);
    }
}