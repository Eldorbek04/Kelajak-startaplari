<?php

use App\Models\OtpCode;
use App\Models\User;
use App\Support\RegisterPending;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

it('rejects registration when phone is already registered', function () {
    User::factory()->create(['phone' => '+998901111111']);

    $response = $this->post(route('register'), [
        'full_name' => 'Yangi Foydalanuvchi',
        'phone' => '+998901111111',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors('phone');
    $response->assertSessionMissing('status');
});

it('stores pending registration and redirects to otp step when phone is new', function () {
    $response = $this->post(route('register'), [
        'full_name' => 'Yangi Foydalanuvchi',
        'phone' => '+998902222222',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('register.verify'));
    $response->assertSessionHas('status');
    expect(User::query()->where('phone', '+998902222222')->exists())->toBeFalse();
    expect(OtpCode::query()->where('phone', '+998902222222')->exists())->toBeTrue();
});

it('does not send a second otp when register form is submitted again before cooldown ends', function () {
    $first = $this->post(route('register'), [
        'full_name' => 'Birinchi',
        'phone' => '+998904444444',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $sessionCookie = $first->getCookie(config('session.cookie'));
    expect($sessionCookie)->not->toBeNull();
    $this->withCookie($sessionCookie->getName(), $sessionCookie->getValue());

    $firstId = OtpCode::query()->where('phone', '+998904444444')->value('id');
    expect($firstId)->not->toBeNull();

    $response = $this->post(route('register'), [
        'full_name' => 'Ikkinchi ism',
        'phone' => '+998904444444',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('register.verify'));
    $response->assertSessionHas('otp_throttle');
    $response->assertSessionMissing('status');

    expect(OtpCode::query()->where('phone', '+998904444444')->count())->toBe(1);
    expect(OtpCode::query()->where('phone', '+998904444444')->value('id'))->toBe($firstId);

    expect(Cache::get(RegisterPending::cacheKey(session()->getId()))['full_name'])->toBe('Ikkinchi ism');
});

it('redirects verify page to register when pending data is missing', function () {
    $response = $this->get(route('register.verify'));

    $response->assertRedirect(route('register'));
    $response->assertSessionHas('register_verify_expired');
});

it('creates account after valid otp', function () {
    $phone = '+998903333333';

    $registered = $this->post(route('register'), [
        'full_name' => 'OTP Test',
        'phone' => $phone,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);
    $registered->assertRedirect(route('register.verify'));

    $sessionCookie = $registered->getCookie(config('session.cookie'));
    expect($sessionCookie)->not->toBeNull();
    $this->withCookie($sessionCookie->getName(), $sessionCookie->getValue());

    $otpRow = OtpCode::query()->where('phone', $phone)->first();
    expect($otpRow)->not->toBeNull();
    $otpRow->update(['code' => Hash::make('123456')]);

    $response = $this->post(route('register.verify'), [
        'code' => '123456',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::query()->where('phone', $phone)->first();
    expect($user)->not->toBeNull();
    expect($user->full_name)->toBe('OTP Test');
});
