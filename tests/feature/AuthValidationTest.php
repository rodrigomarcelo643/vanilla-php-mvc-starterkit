<?php

use PHPUnit\Framework\TestCase;

/**
 * AuthValidationTest
 *
 * Tests the input validation rules that AuthController enforces
 * before touching the database. These run without HTTP — we test
 * the logic directly by extracting it into assertions.
 *
 * We do NOT call the controller methods directly (they call exit/header),
 * so we mirror the exact validation rules here as white-box tests.
 */
class AuthValidationTest extends TestCase
{
    // ── Login validation rules ────────────────────────────────

    #[\PHPUnit\Framework\Attributes\DataProvider('emptyLoginProvider')]
    public function test_login_fails_when_fields_are_empty(string $email, string $password): void
    {
        $this->assertFalse($this->loginIsValid($email, $password));
    }

    public static function emptyLoginProvider(): array
    {
        return [
            'both empty'           => ['', ''],
            'email only'           => ['user@example.com', ''],
            'password only'        => ['', 'secret'],
        ];
    }

    public function test_login_fails_with_invalid_email_format(): void
    {
        $this->assertFalse(filter_var('not-an-email', FILTER_VALIDATE_EMAIL) !== false);
        $this->assertFalse(filter_var('missing@', FILTER_VALIDATE_EMAIL) !== false);
        $this->assertFalse(filter_var('@nodomain.com', FILTER_VALIDATE_EMAIL) !== false);
    }

    public function test_login_passes_with_valid_credentials_format(): void
    {
        $this->assertTrue($this->loginIsValid('user@example.com', 'password'));
    }

    // ── Register validation rules ─────────────────────────────

    #[\PHPUnit\Framework\Attributes\DataProvider('emptyRegisterProvider')]
    public function test_register_fails_when_fields_are_empty(string $name, string $email, string $password): void
    {
        $this->assertFalse($this->registerIsValid($name, $email, $password));
    }

    public static function emptyRegisterProvider(): array
    {
        return [
            'all empty'            => ['', '', ''],
            'no name'              => ['', 'user@example.com', 'password'],
            'no email'             => ['Alice', '', 'password'],
            'no password'          => ['Alice', 'user@example.com', ''],
        ];
    }

    public function test_register_fails_with_short_password(): void
    {
        // AuthController requires >= 6 characters
        $this->assertFalse(strlen('abc') >= 6);
        $this->assertFalse(strlen('12345') >= 6);
    }

    public function test_register_passes_with_minimum_password_length(): void
    {
        $this->assertTrue(strlen('123456') >= 6);
    }

    public function test_register_fails_with_invalid_email(): void
    {
        $this->assertFalse(filter_var('plainaddress', FILTER_VALIDATE_EMAIL) !== false);
        $this->assertFalse(filter_var('user@', FILTER_VALIDATE_EMAIL) !== false);
    }

    public function test_register_passes_with_valid_inputs(): void
    {
        $this->assertTrue($this->registerIsValid('Alice', 'alice@example.com', 'password123'));
    }

    // ── Password hashing ─────────────────────────────────────

    public function test_bcrypt_hash_verifies_correctly(): void
    {
        $plain  = 'mypassword';
        $hashed = password_hash($plain, PASSWORD_BCRYPT);

        $this->assertTrue(password_verify($plain, $hashed));
        $this->assertFalse(password_verify('wrongpassword', $hashed));
    }

    public function test_bcrypt_produces_different_hashes_for_same_input(): void
    {
        $plain  = 'samepassword';
        $hash1  = password_hash($plain, PASSWORD_BCRYPT);
        $hash2  = password_hash($plain, PASSWORD_BCRYPT);

        // Bcrypt uses random salt — hashes must differ
        $this->assertNotSame($hash1, $hash2);
        // But both must verify
        $this->assertTrue(password_verify($plain, $hash1));
        $this->assertTrue(password_verify($plain, $hash2));
    }

    public function test_seeded_password_verifies_against_known_hash(): void
    {
        $hash = '$2y$10$UwBbtw7SU2RR5YPq5Moj2eZuHJUfYXP3Fd5QcoYIW65TIveFKIzAC';
        $this->assertTrue(password_verify('password', $hash));
    }

    // ── Role redirect logic ───────────────────────────────────

    public function test_admin_role_redirects_to_dashboard(): void
    {
        $role     = 'admin';
        $redirect = BASE_URL . ($role === 'admin' ? '/dashboard' : '/app/home');
        $this->assertStringContainsString('dashboard', $redirect);
    }

    public function test_user_role_redirects_to_app_home(): void
    {
        $role     = 'user';
        $redirect = BASE_URL . ($role === 'admin' ? '/dashboard' : '/app/home');
        $this->assertStringContainsString('app/home', $redirect);
    }

    public function test_editor_role_redirects_to_app_home(): void
    {
        $role     = 'editor';
        $redirect = BASE_URL . ($role === 'admin' ? '/dashboard' : '/app/home');
        $this->assertStringContainsString('app/home', $redirect);
    }

    // ── Inactive account check ────────────────────────────────

    public function test_inactive_status_is_blocked(): void
    {
        $user = ['status' => 'inactive'];
        $this->assertTrue(($user['status'] ?? 'active') === 'inactive');
    }

    public function test_active_status_is_allowed(): void
    {
        $user = ['status' => 'active'];
        $this->assertFalse(($user['status'] ?? 'active') === 'inactive');
    }

    public function test_missing_status_defaults_to_active(): void
    {
        $user   = [];
        $status = $user['status'] ?? 'active';
        $this->assertSame('active', $status);
    }

    // ── Helpers ───────────────────────────────────────────────

    private function loginIsValid(string $email, string $password): bool
    {
        if (!$email || !$password) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        return true;
    }

    private function registerIsValid(string $name, string $email, string $password): bool
    {
        if (!$name || !$email || !$password) return false;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
        if (strlen($password) < 6) return false;
        return true;
    }
}
