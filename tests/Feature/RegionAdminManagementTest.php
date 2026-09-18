<?php

declare(strict_types=1);

use App\Models\District;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function (): void {
    $this->region = Region::query()->create(['name_uz' => 'Test viloyat']);
    District::query()->create([
        'region_id' => $this->region->id,
        'name_uz' => 'Test tuman',
    ]);
});

it('forbids region admin from accessing region-admins section', function (): void {
    $regionAdmin = User::factory()->regionAdmin($this->region->id)->create();

    $this->actingAs($regionAdmin)
        ->get(route('admin.region-admins.index'))
        ->assertForbidden();
});

it('allows super admin to view region-admins index', function (): void {
    $super = User::factory()->superAdmin()->create();

    $this->actingAs($super)
        ->get(route('admin.region-admins.index'))
        ->assertOk();
});

it('allows super admin to create a region admin', function (): void {
    $super = User::factory()->superAdmin()->create();

    $this->actingAs($super)
        ->post(route('admin.region-admins.store'), [
            'full_name' => 'Viloyat Admin',
            'phone' => '+998901112233',
            'password' => 'Password123!xx',
            'password_confirmation' => 'Password123!xx',
            'region_id' => $this->region->id,
        ])
        ->assertRedirect(route('admin.region-admins.index'))
        ->assertSessionHas('success');

    $created = User::query()->where('phone', '+998901112233')->first();
    expect($created)->not->toBeNull();
    expect($created->role)->toBe(User::ROLE_REGION_ADMIN);
    expect((int) $created->region_id)->toBe($this->region->id);
});

it('allows super admin to demote a region admin', function (): void {
    $super = User::factory()->superAdmin()->create();
    $target = User::factory()->regionAdmin($this->region->id)->create([
        'phone' => '+998902223344',
    ]);

    $this->actingAs($super)
        ->delete(route('admin.region-admins.destroy', $target))
        ->assertRedirect(route('admin.region-admins.index'));

    $target->refresh();
    expect($target->role)->toBe(User::ROLE_USER);
    expect($target->region_id)->toBeNull();
});
