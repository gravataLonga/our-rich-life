<?php

namespace Tests\Feature;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FortifyTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_user ()
    {
        $user = new CreateNewUser()->create([
            'name' => 'Test User',
            'email' => 'geral@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'geral@gmail.com'
        ]);
    }

    #[Test]
    public function reset_user_password ()
    {
        $user = User::factory()->create();

        new ResetUserPassword()->reset($user, [
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::first();
        $this->assertTrue(password_verify('password', $user->password));
    }

    #[Test]
    public function update_user_password ()
    {
        $user = User::factory()->create(['password' => \Hash::make('12345678')]);
        $this->actingAs($user);

        new UpdateUserPassword()->update($user, [
            'password' => 'password',
            'password_confirmation' => 'password',
            'current_password' => '12345678',
        ]);

        $user = User::first();
        $this->assertTrue(password_verify('password', $user->password));
    }

    #[Test]
    public function update_user_profile_information ()
    {
        \Notification::fake();
        $user = User::factory()->create();
        $this->actingAs($user);

        new UpdateUserProfileInformation()->update($user, [
            'name' => 'Test User',
            'email' => 'geral@gmail.com',
        ]);

        \Notification::assertCount(1);
        \Notification::assertSentTo($user, VerifyEmail::class);
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'geral@gmail.com',
            'email_verified_at' => null,
        ]);
    }

    #[Test]
    public function update_user_profile_information_without_change_email ()
    {
        Carbon::setTestNow('2025-01-01 00:00:00');
        \Notification::fake();
        $user = User::factory()->create(['email' => 'geral@gmail.com']);
        $this->actingAs($user);

        new UpdateUserProfileInformation()->update($user, [
            'name' => 'Test User',
            'email' => 'geral@gmail.com',
            'email_verified_at' => null,
        ]);

        \Notification::assertNothingSent();
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email_verified_at' => '2025-01-01 00:00:00',
        ]);
    }
}
