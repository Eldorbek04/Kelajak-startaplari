<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRegionAdminRequest;
use App\Http\Requests\Admin\UpdateRegionAdminRequest;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegionAdminController extends Controller
{
    public function index(): View
    {
        $admins = User::query()
            ->where('role', User::ROLE_REGION_ADMIN)
            ->with('region')
            ->orderBy('full_name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.region-admins.index', [
            'admins' => $admins,
        ]);
    }

    public function create(): View
    {
        $regions = Region::query()->orderBy('name_uz')->get();

        return view('admin.region-admins.create', [
            'regions' => $regions,
        ]);
    }

    public function store(StoreRegionAdminRequest $request): RedirectResponse
    {
        $data = $request->validated();

        User::query()->create([
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'password' => $data['password'],
            'role' => User::ROLE_REGION_ADMIN,
            'region_id' => $data['region_id'],
        ]);

        return redirect()
            ->route('admin.region-admins.index')
            ->with('success', 'Viloyat administratori yaratildi.');
    }

    public function edit(User $region_admin): View
    {
        $regions = Region::query()->orderBy('name_uz')->get();

        return view('admin.region-admins.edit', [
            'regionAdmin' => $region_admin,
            'regions' => $regions,
        ]);
    }

    public function update(UpdateRegionAdminRequest $request, User $region_admin): RedirectResponse
    {
        $validated = $request->validated();
        unset($validated['password'], $validated['password_confirmation']);
        $region_admin->fill($validated);

        if ($request->filled('password')) {
            $region_admin->password = (string) $request->validated('password');
        }

        $region_admin->save();

        return redirect()
            ->route('admin.region-admins.index')
            ->with('success', 'Ma’lumotlar yangilandi.');
    }

    public function destroy(User $region_admin): RedirectResponse
    {
        $region_admin->update([
            'role' => User::ROLE_USER,
            'region_id' => null,
        ]);

        return redirect()
            ->route('admin.region-admins.index')
            ->with('success', 'Administrator oddiy foydalanuvchi darajasiga tushirildi (admin huquqi olib tashlandi).');
    }
}


// 
//     ===================================================
//     11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
//     ===================================================
// 