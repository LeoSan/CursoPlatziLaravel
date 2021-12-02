<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class UserTest extends TestCase
{
    public function test_has_many_repositorios(){

        $user= new User; 
        Self::assertInstanceOf(Collection::class, $user->repositories);
    }
}
