<div class="space-y-5">
    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="full_name">To‘liq ism</label>
        <input type="text"
               id="full_name"
               name="full_name"
               value="{{ old('full_name', $regionAdmin->full_name ?? '') }}"
               required
               maxlength="255"
               autocomplete="name"
               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('full_name') border-rose-500 @enderror">
        @error('full_name')
            <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="phone">Telefon</label>
        <input type="text"
               id="phone"
               name="phone"
               value="{{ old('phone', $regionAdmin->phone ?? '') }}"
               required
               autocomplete="tel"
               placeholder="+998901234567"
               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('phone') border-rose-500 @enderror">
        @error('phone')
            <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="region_id">Viloyat</label>
        <select id="region_id"
                name="region_id"
                required
                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('region_id') border-rose-500 @enderror">
            <option value="" disabled @selected(old('region_id', $regionAdmin->region_id ?? '') === null || old('region_id', $regionAdmin->region_id ?? '') === '')>Tanlang</option>
            @foreach ($regions as $region)
                <option value="{{ $region->id }}" @selected((string) old('region_id', $regionAdmin->region_id ?? '') === (string) $region->id)>
                    {{ $region->name_uz }}
                </option>
            @endforeach
        </select>
        @error('region_id')
            <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="password">Parol @if($isEdit)<span class="font-normal text-slate-500">(ixtiyoriy — bo‘sh qoldirsangiz, o‘zgarmaydi)</span>@endif</label>
        <input type="password"
               id="password"
               name="password"
               autocomplete="new-password"
               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white @error('password') border-rose-500 @enderror"
               @if(! $isEdit) required @endif>
        @error('password')
            <p class="mt-2 text-sm font-medium text-rose-600 dark:text-rose-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="mb-2 block text-sm font-semibold text-slate-800 dark:text-slate-200" for="password_confirmation">Parolni tasdiqlash</label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               autocomplete="new-password"
               class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-slate-900 shadow-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/25 dark:border-slate-600 dark:bg-slate-800 dark:text-white"
               @if(! $isEdit) required @endif>
    </div>
</div>
