<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_login_does_not_redirect_to_admin_dashboard(): void
    {
        $staff = User::create([
            'name' => 'Staff User',
            'email' => 'staff@cleantrack.com',
            'role' => 'staff',
            'password' => Hash::make('password'),
        ]);

        $response = $this->withSession([
            'url.intended' => route('dashboard'),
        ])->post('/login', [
            'email' => $staff->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('rooms.index'));
        $this->assertAuthenticatedAs($staff);
    }
}