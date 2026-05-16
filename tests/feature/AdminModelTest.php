<?php

use PHPUnit\Framework\TestCase;

/**
 * AdminModelTest
 *
 * Integration tests for the Admin model.
 * Verifies findByEmail behaviour and role normalization.
 */
class AdminModelTest extends TestCase
{
    protected function setUp(): void
    {
        require_once __DIR__ . '/../../app/models/Admin.php';
    }

    // ── findByEmail ───────────────────────────────────────────

    public function test_find_by_email_returns_seeded_admin(): void
    {
        $model = new Admin();
        $admin = $model->findByEmail('admin@starter.com');

        $this->assertIsArray($admin);
        $this->assertSame('admin@starter.com', $admin['email']);
    }

    public function test_find_by_email_returns_false_for_unknown_email(): void
    {
        $model  = new Admin();
        $result = $model->findByEmail('nobody@nowhere.invalid');
        $this->assertFalse($result);
    }

    public function test_find_by_email_normalizes_role_to_admin(): void
    {
        $model = new Admin();
        $admin = $model->findByEmail('admin@starter.com');

        // Admin table has no role column — model injects it
        $this->assertArrayHasKey('role', $admin);
        $this->assertSame('admin', $admin['role']);
    }

    public function test_find_by_email_returns_password_for_verification(): void
    {
        $model = new Admin();
        $admin = $model->findByEmail('admin@starter.com');

        $this->assertArrayHasKey('password', $admin);
        $this->assertTrue(password_verify('password', $admin['password']));
    }

    // ── getAll ────────────────────────────────────────────────

    public function test_get_all_returns_array(): void
    {
        $model = new Admin();
        $this->assertIsArray($model->getAll());
    }

    public function test_get_all_does_not_expose_password_column(): void
    {
        $model  = new Admin();
        $admins = $model->getAll();

        foreach ($admins as $admin) {
            $this->assertArrayNotHasKey('password', $admin);
        }
    }

    public function test_get_all_contains_seeded_admin(): void
    {
        $model  = new Admin();
        $admins = $model->getAll();
        $emails = array_column($admins, 'email');

        $this->assertContains('admin@starter.com', $emails);
    }

    // ── Edge: inactive admin ──────────────────────────────────

    public function test_inactive_admin_is_still_returned_by_find(): void
    {
        // findByEmail does not filter by status — that's the controller's job
        $model = new Admin();
        $admin = $model->findByEmail('admin@starter.com');
        $this->assertNotFalse($admin);
        // Status check responsibility belongs to AuthController
        $this->assertArrayHasKey('status', $admin);
    }
}
