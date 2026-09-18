@extends('layouts.auth')

@section('title', 'Parolni tiklash — '.config('app.name'))

@section('auth-card')
    <div class="auth-card" data-aos="fade-up" data-aos-duration="700">
        <h1 class="auth-card-title text-center">Parolni tiklash</h1>
        <p class="auth-card-sub text-center">Bu funksiya tez orada SMS orqali parolni tiklash bilan ishlaydi. Hozircha administrator bilan bog‘laning yoki kirish sahifasiga qayting.</p>

        <div class="auth-links" style="border-top: none; margin-top: 0; padding-top: 0;">
            @if (Route::has('login'))
                <a href="{{ route('login') }}">← Kirish sahifasiga</a>
            @endif
        </div>
    </div>
@endsection
