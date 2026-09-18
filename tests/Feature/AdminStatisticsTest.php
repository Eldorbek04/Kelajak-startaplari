<?php

declare(strict_types=1);

use App\Models\District;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->region = Region::query()->create(['name_uz' => 'Stat viloyat']);
    District::query()->create([
        'region_id' => $this->region->id,
        'name_uz' => 'Stat tuman',
    ]);
});

it('allows super admin to open statistics', function (): void {
    $super = User::factory()->superAdmin()->create();

    $this->actingAs($super)
        ->get(route('admin.statistics.index'))
        ->assertOk();
});

it('allows region admin to open statistics scoped to region', function (): void {
    $admin = User::factory()->regionAdmin($this->region->id)->create();

    $this->actingAs($admin)
        ->get(route('admin.statistics.index'))
        ->assertOk();
});

it('allows super admin to change any user password', function (): void {
    $super = User::factory()->superAdmin()->create();
    $target = User::factory()->create([
        'phone' => '+998907776665',
        'region_id' => $this->region->id,
    ]);

    $this->actingAs($super)
        ->post(route('admin.statistics.users.password'), [
            'user_id' => $target->id,
            'password' => 'Password123!xx',
            'password_confirmation' => 'Password123!xx',
        ])
        ->assertRedirect();

    $target->refresh();
    expect(Hash::check('Password123!xx', $target->password))->toBeTrue();
});

it('allows region admin to change password only for users in same region', function (): void {
    $admin = User::factory()->regionAdmin($this->region->id)->create();
    $sameRegionUser = User::factory()->create([
        'role' => User::ROLE_USER,
        'region_id' => $this->region->id,
        'phone' => '+998901112233',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.statistics.users.password'), [
            'user_id' => $sameRegionUser->id,
            'password' => 'Password123!xx',
            'password_confirmation' => 'Password123!xx',
        ])
        ->assertRedirect();

    $otherRegion = Region::query()->create(['name_uz' => 'Boshqa']);
    $otherUser = User::factory()->create([
        'role' => User::ROLE_USER,
        'region_id' => $otherRegion->id,
        'phone' => '+998904445556',
    ]);

    $this->actingAs($admin)
        ->post(route('admin.statistics.users.password'), [
            'user_id' => $otherUser->id,
            'password' => 'Password123!xx',
            'password_confirmation' => 'Password123!xx',
        ])
        ->assertForbidden();
});
