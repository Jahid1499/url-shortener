<?php

namespace Tests\Feature;

use App\Helper\JWTToken;
use App\Models\Url;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class UrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_url_content_empty_table()
    {
        $response = $this->get('/home');
        $response->assertSee('No shortened URLs yet.');
        $response->assertStatus(200);
    }

    public function test_url_content_non_empty_table(): void
    {
        $user = User::create([
            'name'=>'jahid',
            'email'=>"jahid@gmail.com",
            'password'=>"63146416",
        ]);

        $url = Url::create([
            'original_url'=>"https://www.facebook.com",
            'code'=>"U4JN345",
            'user_id'=>$user->id,
        ]);
        $response = $this->get('/home');
        $response->assertStatus(200);
        $response->assertDontSee('No shortened URLs yet.');
        $response->assertViewHas('urls', function ($collection) use ($url){
            return $collection->contains($url);
        });
    }
}
