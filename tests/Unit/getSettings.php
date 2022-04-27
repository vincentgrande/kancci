<?php

namespace Tests\Feature;

use App\User;
use Str;
use Tests\TestCase;

class getSettings extends TestCase
{
    /**
     * Test if unlogged user get redirected while trying to access settings page
     *
     * @return void
     */
    public function testSettingsUnlogged()
    {

        $response = $this->get('/settings/profile');
        $response->assertStatus(302);
    }
    /**
     * Test if logged user has access to settings page
     *
     * @return void
     */
    public function testSettingsLogged()
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
        $users->updated_at = "";
        // As a logged user, we should be able to access /settings/profile
        $this->actingAs($users);
        $response = $this->get('/settings/profile');
        $response->assertStatus(200);
    }
}
