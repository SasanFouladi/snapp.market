<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->withExceptionHandling();
        $response = $this->json('POST',route('user.login'),[
            'username' => 's.fouladi',
            'password' => '3169945454'
        ]);
        $this->assertEquals(json_decode($response->getContent(),true)['data']['api_token'],Auth::user()->api_token);
    }
}
