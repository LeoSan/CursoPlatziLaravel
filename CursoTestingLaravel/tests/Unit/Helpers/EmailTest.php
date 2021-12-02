<?php

namespace Tests\Unit\Helpers;

use PHPUnit\Framework\TestCase;

use App\Helpers\Email;

class EmailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testEmail()
    {
        $email = 'i@admin.com';
        $email2 = 'i@@admin.com';
        
        $result = Email::validate($email);
        $this->assertTrue($result);

        $result2 = Email::validate($email2);
        $this->assertFalse($result2);
    }

    
}
