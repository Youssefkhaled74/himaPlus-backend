<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiAuthSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_email_cannot_login(): void
    {
        User::factory()->create([
            'email' => 'unverified@example.com',
            'mobile' => '966500000001',
            'password' => bcrypt('Strong!Pass123'),
            'email_verified_at' => null,
            'is_activate' => 1,
            'deleted_at' => null,
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'unverified@example.com',
            'password' => 'Strong!Pass123',
        ]);

        $response->assertOk()->assertJsonPath('status', 401);
    }

    public function test_reset_code_can_be_sent_to_verified_mobile_only(): void
    {
        Queue::fake();

        $verifiedMobileUser = User::factory()->create([
            'email' => 'mobile.verified@example.com',
            'mobile' => '966500000010',
            'password' => bcrypt('Strong!Pass123'),
            'email_verified_at' => now(),
            'mobile_verified_at' => now(),
            'is_activate' => 1,
            'deleted_at' => null,
        ]);

        $unverifiedMobileUser = User::factory()->create([
            'email' => 'mobile.unverified@example.com',
            'mobile' => '966500000011',
            'password' => bcrypt('Strong!Pass123'),
            'email_verified_at' => now(),
            'mobile_verified_at' => null,
            'is_activate' => 1,
            'deleted_at' => null,
        ]);

        $okResponse = $this->postJson('/api/auth/send-reset-code', [
            'data' => $verifiedMobileUser->mobile,
        ]);
        $okResponse->assertOk()->assertJsonPath('status', 200);

        $verifiedMobileUser->refresh();
        $this->assertNotNull($verifiedMobileUser->reset_code_hash);
        $this->assertSame('mobile', $verifiedMobileUser->reset_code_channel);

        $blockedResponse = $this->postJson('/api/auth/send-reset-code', [
            'data' => $unverifiedMobileUser->mobile,
        ]);
        $blockedResponse->assertOk()->assertJsonPath('status', 422);
    }

    public function test_user_cannot_fetch_another_users_order_details(): void
    {
        $owner = User::factory()->create([
            'mobile' => '966500000020',
            'password' => bcrypt('Strong!Pass123'),
            'email_verified_at' => now(),
            'is_activate' => 1,
            'deleted_at' => null,
        ]);

        $intruder = User::factory()->create([
            'mobile' => '966500000021',
            'password' => bcrypt('Strong!Pass123'),
            'email_verified_at' => now(),
            'is_activate' => 1,
            'deleted_at' => null,
        ]);

        $order = Order::create([
            'user_id' => $owner->id,
            'order_type' => 1,
            'address' => 'Test Address',
        ]);

        $token = JWTAuth::fromUser($intruder);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/orders/order/' . $order->id);

        $response->assertOk()->assertJsonPath('status', 404);
    }
}
