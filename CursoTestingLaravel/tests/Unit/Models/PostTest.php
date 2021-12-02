<?php

namespace Tests\Unit\Models;

use App\Models\Post;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    public function test_set_name_in_lowercase()
    {
        $post = new Post();
        $post->name = "Proyecto en PHP";
        self::assertEquals(Str::lower($post->name), $post->name);
    }

    public function test_get_slug()
    {
        $post = new Post();
        $post->name = "Proyecto en PHP";
        self::assertEquals(Str::slug($post->name), $post->slug);
    }    
    
    public function test_get_href()
    {
        $post = new Post();
        $post->name = "Proyecto en PHP";
        $href = Str::of($post->name)->slug()->prepend('blog/');
        self::assertEquals($href, $post->href());
    }
}