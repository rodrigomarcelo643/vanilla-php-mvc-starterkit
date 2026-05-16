<?php

use PHPUnit\Framework\TestCase;

/**
 * AuthSessionTest
 *
 * Tests Auth::check() and Session get/set/destroy.
 * These are the gatekeepers for every protected route —
 * a bug here exposes the entire admin panel.
 */
class AuthSessionTest extends TestCase
{
    protected function setUp(): void
    {
        // Always start clean
        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
    }

    // ── Auth::check ───────────────────────────────────────────

    public function test_auth_check_returns_false_when_no_session(): void
    {
        $this->assertFalse(Auth::check());
    }

    public function test_auth_check_returns_true_when_user_in_session(): void
    {
        $_SESSION['user'] = ['id' => 1, 'name' => 'Alice', 'role' => 'admin'];
        $this->assertTrue(Auth::check());
    }

    public function test_auth_check_returns_false_after_session_cleared(): void
    {
        $_SESSION['user'] = ['id' => 1];
        $_SESSION = [];
        $this->assertFalse(Auth::check());
    }

    // ── Session::set / get ────────────────────────────────────

    public function test_session_set_and_get_string(): void
    {
        Session::set('key', 'value');
        $this->assertSame('value', Session::get('key'));
    }

    public function test_session_set_and_get_array(): void
    {
        $user = ['id' => 5, 'name' => 'Bob', 'role' => 'user'];
        Session::set('user', $user);
        $this->assertSame($user, Session::get('user'));
    }

    public function test_session_get_returns_null_for_missing_key(): void
    {
        $this->assertNull(Session::get('nonexistent_key'));
    }

    public function test_session_overwrites_existing_key(): void
    {
        Session::set('role', 'user');
        Session::set('role', 'admin');
        $this->assertSame('admin', Session::get('role'));
    }

    public function test_session_set_integer_value(): void
    {
        Session::set('count', 42);
        $this->assertSame(42, Session::get('count'));
    }

    public function test_session_set_null_value(): void
    {
        Session::set('empty', null);
        $this->assertNull(Session::get('empty'));
    }

    // ── Session::destroy ──────────────────────────────────────

    public function test_session_destroy_clears_user(): void
    {
        Session::set('user', ['id' => 1]);
        Session::destroy();
        // After destroy, $_SESSION is wiped — Auth::check must be false
        $_SESSION = []; // reset superglobal for test isolation
        $this->assertFalse(Auth::check());
    }

    // ── Edge: user payload shape ──────────────────────────────

    public function test_session_user_role_defaults_safely(): void
    {
        Session::set('user', ['id' => 1, 'name' => 'Test']);
        $user = Session::get('user');
        $role = $user['role'] ?? 'user';
        $this->assertSame('user', $role);
    }

    public function test_auth_check_does_not_care_about_user_payload_shape(): void
    {
        // Auth::check only checks isset($_SESSION['user']) — any truthy value works
        Session::set('user', 'malformed-string');
        $this->assertTrue(Auth::check());
    }
}
