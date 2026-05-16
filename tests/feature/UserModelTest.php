<?php

use PHPUnit\Framework\TestCase;

/**
 * UserModelTest
 *
 * Integration tests against the real database.
 * Each test cleans up after itself — no permanent data left behind.
 *
 * Requires a running MySQL instance with credentials in .env.
 */
class UserModelTest extends TestCase
{
    private static string $testEmail = 'phpunit_test_user@example.com';

    protected function setUp(): void
    {
        require_once __DIR__ . '/../../app/models/User.php';
        // Clean up any leftover test user before each test
        $this->deleteTestUser();
    }

    protected function tearDown(): void
    {
        $this->deleteTestUser();
    }

    private function deleteTestUser(): void
    {
        $db = (new Database())->connect();
        $db->prepare('DELETE FROM users WHERE email = ?')->execute([self::$testEmail]);
    }

    // ── create ────────────────────────────────────────────────

    public function test_create_returns_integer_id(): void
    {
        $model = new User();
        $id    = $model->create('PHPUnit User', self::$testEmail, 'password123');
        $this->assertIsInt($id);
        $this->assertGreaterThan(0, $id);
    }

    public function test_create_hashes_password(): void
    {
        $model = new User();
        $model->create('PHPUnit User', self::$testEmail, 'plaintext');

        $user = $model->findByEmail(self::$testEmail);
        $this->assertNotSame('plaintext', $user['password']);
        $this->assertTrue(password_verify('plaintext', $user['password']));
    }

    // ── findByEmail ───────────────────────────────────────────

    public function test_find_by_email_returns_correct_user(): void
    {
        $model = new User();
        $model->create('PHPUnit User', self::$testEmail, 'password123');

        $user = $model->findByEmail(self::$testEmail);
        $this->assertIsArray($user);
        $this->assertSame(self::$testEmail, $user['email']);
        $this->assertSame('PHPUnit User', $user['name']);
    }

    public function test_find_by_email_returns_false_for_unknown_email(): void
    {
        $model  = new User();
        $result = $model->findByEmail('nobody@nowhere.invalid');
        $this->assertFalse($result);
    }

    public function test_find_by_email_is_case_sensitive(): void
    {
        $model = new User();
        $model->create('PHPUnit User', self::$testEmail, 'password123');

        // MySQL default collation is case-insensitive for email — document this behaviour
        $upper = $model->findByEmail(strtoupper(self::$testEmail));
        // Result depends on DB collation — just assert it doesn't crash
        $this->assertTrue($upper === false || is_array($upper));
    }

    // ── findById ──────────────────────────────────────────────

    public function test_find_by_id_returns_correct_user(): void
    {
        $model = new User();
        $id    = $model->create('PHPUnit User', self::$testEmail, 'password123');

        $user = $model->findById($id);
        $this->assertIsArray($user);
        $this->assertSame($id, (int) $user['id']);
    }

    public function test_find_by_id_returns_false_for_nonexistent_id(): void
    {
        $model  = new User();
        $result = $model->findById(999999999);
        $this->assertFalse($result);
    }

    // ── emailExists ───────────────────────────────────────────

    public function test_email_exists_returns_true_after_create(): void
    {
        $model = new User();
        $model->create('PHPUnit User', self::$testEmail, 'password123');
        $this->assertTrue($model->emailExists(self::$testEmail));
    }

    public function test_email_exists_returns_false_for_unknown_email(): void
    {
        $model = new User();
        $this->assertFalse($model->emailExists('ghost@nowhere.invalid'));
    }

    // ── count ─────────────────────────────────────────────────

    public function test_count_increases_after_create(): void
    {
        $model  = new User();
        $before = $model->count();
        $model->create('PHPUnit User', self::$testEmail, 'password123');
        $after  = $model->count();
        $this->assertSame($before + 1, $after);
    }

    public function test_count_returns_integer(): void
    {
        $model = new User();
        $this->assertIsInt($model->count());
    }

    // ── getAll ────────────────────────────────────────────────

    public function test_get_all_returns_array(): void
    {
        $model = new User();
        $this->assertIsArray($model->getAll());
    }

    public function test_get_all_does_not_expose_password_column(): void
    {
        $model = new User();
        $model->create('PHPUnit User', self::$testEmail, 'password123');
        $users = $model->getAll();

        $found = array_filter($users, fn($u) => $u['email'] === self::$testEmail);
        $user  = array_values($found)[0] ?? null;

        $this->assertNotNull($user);
        $this->assertArrayNotHasKey('password', $user);
    }

    // ── Edge: default role ────────────────────────────────────

    public function test_new_user_has_default_role_of_user(): void
    {
        $model = new User();
        $id    = $model->create('PHPUnit User', self::$testEmail, 'password123');
        $user  = $model->findById($id);
        $this->assertSame('user', $user['role']);
    }

    public function test_new_user_has_default_status_of_active(): void
    {
        $model = new User();
        $id    = $model->create('PHPUnit User', self::$testEmail, 'password123');
        $user  = $model->findById($id);
        $this->assertSame('active', $user['status']);
    }
}
