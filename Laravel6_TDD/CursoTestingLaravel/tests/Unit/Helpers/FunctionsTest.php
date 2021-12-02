<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testEmail()
    {
        $email = 'i@admin.com';
        $emailFalse = 'i@@admin.com';
        $result = validate_email($email);
        $this->assertTrue($result);

        $resultFalse = validate_email($emailFalse);
        $this->assertFalse($resultFalse);
    }
}
