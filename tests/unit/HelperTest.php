<?php

use PHPUnit\Framework\TestCase;

/**
 * HelperTest
 *
 * Tests global helper functions defined in app/helpers/helper.php.
 */
class HelperTest extends TestCase
{
    // ── dd() ──────────────────────────────────────────────────

    public function test_dd_outputs_pre_wrapped_content(): void
    {
        ob_start();
        dd(['key' => 'value']);
        $output = ob_get_clean();

        $this->assertStringContainsString('<pre>', $output);
        $this->assertStringContainsString('</pre>', $output);
        $this->assertStringContainsString('key', $output);
        $this->assertStringContainsString('value', $output);
    }

    public function test_dd_outputs_string(): void
    {
        ob_start();
        dd('hello world');
        $output = ob_get_clean();

        $this->assertStringContainsString('hello world', $output);
    }

    public function test_dd_outputs_integer(): void
    {
        ob_start();
        dd(123);
        $output = ob_get_clean();

        $this->assertStringContainsString('123', $output);
    }

    public function test_dd_outputs_null(): void
    {
        ob_start();
        dd(null);
        $output = ob_get_clean();

        $this->assertStringContainsString('<pre>', $output);
    }

    public function test_dd_outputs_nested_array(): void
    {
        ob_start();
        dd(['user' => ['id' => 1, 'role' => 'admin']]);
        $output = ob_get_clean();

        $this->assertStringContainsString('user', $output);
        $this->assertStringContainsString('admin', $output);
    }
}
