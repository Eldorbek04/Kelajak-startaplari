<?php

declare(strict_types=1);

use App\Models\District;
use App\Models\ProjectSubmission;
use App\Models\Region;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

function createRegionWithDistrict(): array
{
    $region = Region::query()->create(['name_uz' => 'Test viloyat']);
    $district = District::query()->create([
        'region_id' => $region->id,
        'name_uz' => 'Test tuman',
    ]);

    return [$region, $district];
}

it('redirects guests from ariza form to login', function (): void {
    $this->get(route('project.submit.form'))
        ->assertRedirect(route('login'));
});

it('redirects to dashboard after successful submission', function (): void {
    Storage::fake('local');
    [$region, $district] = createRegionWithDistrict();
    $user = User::factory()->create();

    $file = UploadedFile::fake()->create('deck.pdf', 100, 'application/pdf');

    $response = $this->actingAs($user)->post(route('project.submit'), [
        'project_title' => 'Test loyiha',
        'document' => $file,
        'required_budget' => 1_000_000,
        'region_id' => $region->id,
        'district_id' => $district->id,
    ]);

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('project_submitted');
    expect(ProjectSubmission::query()->where('user_id', $user->id)->count())->toBe(1);
});

it('blocks opening ariza form when user already submitted', function (): void {
    [$region, $district] = createRegionWithDistrict();
    $user = User::factory()->create();

    ProjectSubmission::query()->create([
        'user_id' => $user->id,
        'project_title' => 'Mavjud',
        'required_budget' => 500_000,
        'region_id' => $region->id,
        'district_id' => $district->id,
        'document_path' => 'project-submissions/test.pdf',
    ]);

    $this->actingAs($user)
        ->get(route('project.submit.form'))
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('already_submitted');
});

it('blocks duplicate post submission', function (): void {
    Storage::fake('local');
    [$region, $district] = createRegionWithDistrict();
    $user = User::factory()->create();

    ProjectSubmission::query()->create([
        'user_id' => $user->id,
        'project_title' => 'Mavjud',
        'required_budget' => 500_000,
        'region_id' => $region->id,
        'district_id' => $district->id,
        'document_path' => 'project-submissions/old.pdf',
    ]);

    $file = UploadedFile::fake()->create('deck2.pdf', 100, 'application/pdf');

    $this->actingAs($user)->post(route('project.submit'), [
        'project_title' => 'Yana bitta',
        'document' => $file,
        'required_budget' => 2_000_000,
        'region_id' => $region->id,
        'district_id' => $district->id,
    ])
        ->assertRedirect(route('dashboard'))
        ->assertSessionHas('already_submitted');

    expect(ProjectSubmission::query()->where('user_id', $user->id)->count())->toBe(1);
});
