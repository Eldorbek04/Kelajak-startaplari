<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'phone' => '+998'.fake()->unique()->numerify('#########'),
            'password' => static::$password ??= Hash::make('password'),
            'role' => User::ROLE_USER,
        ];
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => User::ROLE_SUPER_ADMIN,
            'region_id' => null,
        ]);
    }

    /**
     * @param  int|null  $regionId  null bo‘lsa, keyinroq qo‘lda beriladi
     */
    public function regionAdmin(?int $regionId = null): static
    {
        return $this->state(fn (array $attributes): array => [
            'role' => User::ROLE_REGION_ADMIN,
            'region_id' => $regionId,
        ]);
    }
}
