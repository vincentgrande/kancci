<?php

namespace Tests\Feature;

use App\User;
use Str;
use Tests\TestCase;

class getWorkgroup extends TestCase
{

    public function testGroupHome()
    {
        $users = new User();
        $users->id = 1;
        $users->name = "vincent";
        $users->email = "vincent.grande@outlook.fr";
        $users->password = '$2y$10$On1dRLBP16AIZ7qAURobXe0mlKigeamy.0c.N7ENYurup1LKhyR4W';
        $users->reset_token = '$2y$10$NDVEQafMqBi/EFXBd.arXup2ZTxbJ1kKH7qCrECB0sjwmU9DCVoFO';
        $users->picture = "undraw_profile.svg";
        $users->remember_token = "";
        $users->created_at = "";
        $users->updated_at ="";
        // As a logged user, we should be able to access /
        $this->actingAs($users);
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
