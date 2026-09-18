<!-- 
    ===================================================
    11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
    ===================================================
-->
@extends('layouts.app')

@section('title', 'Kelajak Startuplari Tanlovi — Startap musobaqasi')

@push('styles')
    <style>
        .project-submit-sec .form-label { font-weight: 600; margin-bottom: 0.35rem; display: block; }
        .project-submit-sec .form-control,
        .project-submit-sec textarea.form-control {
            width: 100%; border-radius: 8px; border: 1px solid rgba(0,0,0,.12);
            padding: 0.65rem 1rem; font-size: 1rem; background: var(--input-bg, #fff);
        }
        .dark .project-submit-sec .form-control,
        .dark .project-submit-sec textarea.form-control {
            background: rgba(255,255,255,.06); border-color: rgba(255,255,255,.15); color: inherit;
        }
        .project-submit-sec .form-text { font-size: 0.875rem; opacity: 0.8; margin-top: 0.25rem; }
        .project-submit-sec .alert { border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; }
        .project-submit-sec .alert-success { background: rgba(34, 197, 94, 0.12); border: 1px solid rgba(34, 197, 94, 0.35); }
        .project-submit-sec .is-invalid { border-color: #dc2626 !important; }
        .invalid-feedback { color: #dc2626; font-size: 0.875rem; margin-top: 0.25rem; display: block; }
        .hero-title-with-rocket {
            display: inline-flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.35em 0.55em;
        }
        .hero-rocket {
            display: inline-flex;
            align-items: center;
            line-height: 0;
        }
        .hero-rocket svg {
            width: 0.95em;
            height: 0.95em;
            min-width: 2.75rem;
            min-height: 2.75rem;
            color: #f53003;
        }
        @media (min-width: 768px) {
            .hero-rocket svg {
                width: 1em;
                height: 1em;
                min-width: 3.25rem;
                min-height: 3.25rem;
            }
        }
        .dark .hero-rocket svg { color: #ff6b4a; }
        .hero-rocket svg {
            animation: hero-rocket-nudge 2.8s ease-in-out infinite;
        }
        @keyframes hero-rocket-nudge {
            0%, 100% { transform: translate(0, 0) rotate(-12deg); }
            50% { transform: translate(0.08em, -0.06em) rotate(-8deg); }
        }
        @media (prefers-reduced-motion: reduce) {
            .hero-rocket svg { animation: none; }
        }

        /* Tanlov bosqichlari — 3 qadam kartochkalari */
        .tanlov-bosqichlari-steps .step-card--bosqich {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            transition: box-shadow 0.28s ease, transform 0.28s ease;
        }
        .tanlov-bosqichlari-steps .step-card__img-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-bottom: 1.25rem;
        }
        .tanlov-bosqichlari-steps .step-card__img {
            height: auto;
            object-fit: contain;
            display: block;
        }
        .tanlov-bosqichlari-steps .step-card--bosqich .working-content {
            width: 100%;
        }
        .tanlov-bosqichlari-steps .step-card--bosqich .working-content .title {
            margin-bottom: 0.65rem;
        }
        .tanlov-bosqichlari-steps .step-card--bosqich:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.1);
        }
        .dark .tanlov-bosqichlari-steps .step-card--bosqich:hover {
            box-shadow: 0 14px 36px rgba(0, 0, 0, 0.35);
        }
        @media (prefers-reduced-motion: reduce) {
            .tanlov-bosqichlari-steps .step-card--bosqich {
                transition: none;
            }
            .tanlov-bosqichlari-steps .step-card--bosqich:hover {
                transform: none;
            }
        }
    </style>
@endpush

@section('content')
    {{-- Hero + header --}}
    <section class="main-sec">
        <div class="anim-img">
            <img src="{{ asset('assets/images/event/bg1-1.png') }}" alt="" class="layer1 light">
            <img src="{{ asset('assets/images/event/bg1-1-dark.png') }}" alt="" class="layer1 dark">
            <img src="{{ asset('assets/images/event/bg1-2.png') }}" alt="" class="layer2 light">
            <img src="{{ asset('assets/images/event/bg1-2-dark.png') }}" alt="" class="layer2 dark">
        </div>

        @include('layouts.partials.site-header')

        <div class="hero-sec">
            <div class="carousel-container">
                <div class="hero-content">
                    <span class="sub-title">G‘oyangizni yuboring va g‘olib bo‘ling</span>
                    <h1 class="title hero-title-with-rocket">
                        <span>Kelajak Startuplari Tanlovi</span>
                    </h1>
                    <p>Innovatsion g‘oyalaringizni taqdim eting va respublika bosqichiga chiqing</p>
                    <div class="hero-btn">
                        <a href="{{ route('project.submit.form') }}" class="btn-style1">
                            Ariza topshirish
                            <span>
                                <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                            </span>
                        </a>
                    </div>
                    <ul class="hero-list">
                        <li><img src="{{ asset('assets/images/icon/check.svg') }}" alt="">Onlayn ariza va qulay jarayon</li>
                        <li><img src="{{ asset('assets/images/icon/check.svg') }}" alt="">Adolatli baholash va shaffof natijalar</li>
                        <li><img src="{{ asset('assets/images/icon/check.svg') }}" alt="">Respublika miqyosida imkoniyatlar</li>
                    </ul>
                </div>

                <div class="row">
                    @foreach ([1, 2, 3, 4] as $i)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="graph-img">
                                <img src="{{ asset("assets/images/event/graph1-{$i}.webp") }}" alt="" class="light">
                                <img src="{{ asset("assets/images/event/graph1-{$i}-dark.webp") }}" alt="" class="dark">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Hamkorlar / ishonch --}}
    <section class="brand-sec space">
        <div class="carousel-container">
            <div class="brand-title" data-aos="fade-down" data-aos-duration="900">
                <span>Startap ekotizimiga qo‘llab-quvvatlovchi tashkilotlar bilan bir qatorda</span>
            </div>
            <div class="swiper brand" data-aos="fade-up" data-aos-duration="900">
                <div class="swiper-wrapper">
                    @foreach (range(1, 6) as $n)
                        <div class="swiper-slide">
                            <div class="brand-img">
                                <a href="#" title=""><img src="{{ asset("assets/images/brand/brand{$n}.svg") }}" alt="Hamkor {{ $n }}"></a>
                            </div>
                        </div>
                    @endforeach
                    @foreach (range(1, 6) as $n)
                        <div class="swiper-slide">
                            <div class="brand-img">
                                <a href="#" title=""><img src="{{ asset("assets/images/brand/brand{$n}.svg") }}" alt=""></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Yo‘nalishlar (kategoriyalar) --}}
    <section class="feature-sec space-bottom" id="yo-nalishlar">
        <div class="carousel-container">
            <div class="sec-title">
                <span class="sub-title">Musobaqa yo‘nalishlari</span>
                <h2 class="title">Startapingiz qaysi sohada? Tanlang va loyihangizni taqdim eting</h2>
            </div>
            <div class="row g-4">
                @php
                    $categories = [
                        ['name' => 'Raqamli texnologiyalar va sun\'iy intellekt', 'icon' => 'feature1-2.svg', 'text' => 'Al yechimlari, mobil ilovalar, dasturly mahsulotlar, kiberxavfsizlik.'],
                        ['name' => 'AgroTech va oziq-ovqat xavfsizligi', 'icon' => 'feature1-4.svg', 'text' => 'Aqlli qishloq xo\'jaligi, suv tejovchi texnologiyalar, agromonitoring.'],
                        ['name' => 'GreenTech va energetika', 'icon' => 'feature1-3.svg', 'text' => 'Qayta tiklanuvchi energiya, energiya tejamkorligi, chiqindini qayta ishlash.'],
                        ['name' => 'Ijtimoiy innovatsiyalar', 'icon' => 'feature1-5.svg', 'text' => 'EduTech, Health Tech, inklyuziv texnologiyalar, davlat xizmatlari.'],
                    ];
                @endphp
                @foreach ($categories as $cat)
                    <div class="col-lg-4 col-md-6">
                        <div class="feature_card_one h-100">
                            <div class="feature-content">
                                <img src="{{ asset('assets/images/icon/'.$cat['icon']) }}" alt="">
                                <h3 class="title v2">{{ $cat['name'] }}</h3>
                            </div>
                            <p class="px-3 pb-3 mb-0">{{ $cat['text'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Qadamlar + global block --}}
    <section class="main-sec2 space" id="qadamlar">
        <div class="working-process">
            <div class="carousel-container">
                <div class="sec-title">
                    <span class="sub-title">Jarayon</span>
                    <h2 class="title">Tanlov bosqichlari</h2>
                </div>
                <div class="working-info tanlov-bosqichlari-steps">
                    <div class="step-card step-card--bosqich">
                        <div class="step-card__img-wrap">
                            <img src="{{ asset('img/1.png') }}" alt="" class="step-card__img" width="70" height="70" loading="lazy">
                        </div>
                        <div class="working-content">
                            <h3 class="title">1-bosqich</h3>
                            <p>Platformada ro‘yxatdan o‘ting va startupingizni taqdim etish imkoniyatiga ega bo‘ling</p>
                        </div>
                    </div>
                    <div class="step-card step-card--bosqich">
                        <div class="step-card__img-wrap">
                            <img src="{{ asset('img/2.png') }}" alt="" class="step-card__img" width="70" height="70" loading="lazy">
                        </div>
                        <div class="working-content">
                            <h3 class="title">2-bosqich</h3>
                            <p>Loyihangizni yuklang va baholash jarayonida ishtirok eting</p>
                        </div>
                    </div>
                    <div class="step-card step-card--bosqich">
                        <div class="step-card__img-wrap">
                            <img src="{{ asset('img/3.png') }}" alt="" class="step-card__img" width="70" height="70" loading="lazy">
                        </div>
                        <div class="working-content">
                            <h3 class="title">3-bosqich</h3>
                            <p>Eng yaxshi startuplar saralanadi va g‘oliblar aniqlanadi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="global-reach space-top">
            <div class="carousel-container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="global-reach-content">
                            <div class="sec-title">
                                <span class="sub-title">Butun mamlakat</span>
                                <h2 class="title">Har bir viloyatdan startaplarni kutamiz</h2>
                                <p>Tanlov ochiq: o‘z g‘oyangizni respublika miqyosida tanitish, mentorlar bilan uchrashish va keyingi bosqichlarga chiqish imkoniyati.</p>
                            </div>
                            <a href="{{ route('project.submit.form') }}" class="btn-style1">
                                Ariza topshirish
                                <span>
                                    <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="global-img">
                            <img src="{{ asset('assets/images/event/global.png') }}" alt="" class="light">
                            <img src="{{ asset('assets/images/event/global-dark.png') }}" alt="" class="dark">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Nima uchun --}}
    <section class="choose-us-sec space">
        <div class="carousel-container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="choose-us-content">
                        <div class="sec-title">
                            <span class="sub-title">Afzalliklar</span>
                            <h2 class="title">Nima uchun aynan bu tanlov?</h2>
                        </div>
                        <div class="faq-box">
                            <div class="accordion vs-accordion" id="accordionChoose" data-aos="fade-up" data-aos-duration="900" data-aos-delay="500">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ch1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCh1" aria-expanded="true" aria-controls="collapseCh1">
                                            <span><img src="{{ asset('assets/images/icon/choose1-1.svg') }}" alt="">Kuchli ekspertlar jamoasi</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCh1" class="accordion-collapse collapse show" data-bs-parent="#accordionChoose">
                                        <div class="accordion-body">Soha mutaxassislari loyihangizni professional baholab, rivojlanish bo‘yicha tavsiyalar beradi.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ch2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCh2" aria-expanded="false" aria-controls="collapseCh2">
                                            <span><img src="{{ asset('assets/images/icon/choose1-2.svg') }}" alt="">Tezkor va shaffof jarayon</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCh2" class="accordion-collapse collapse" data-bs-parent="#accordionChoose">
                                        <div class="accordion-body">Barcha bosqichlar ochiq: ariza topshirishdan tortib natijalarni e’lon qilishgacha.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ch3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCh3" aria-expanded="false" aria-controls="collapseCh3">
                                            <span><img src="{{ asset('assets/images/icon/choose1-3.svg') }}" alt="">Investorlar va hamkorlar</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCh3" class="accordion-collapse collapse" data-bs-parent="#accordionChoose">
                                        <div class="accordion-body">G‘olib va finalchilar investorlar hamda akseleratorlar bilan uchrashuvlarga taklif etiladi.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ch4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCh4" aria-expanded="false" aria-controls="collapseCh4">
                                            <span><img src="{{ asset('assets/images/icon/choose1-4.svg') }}" alt="">Mentorlik dasturi</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCh4" class="accordion-collapse collapse" data-bs-parent="#accordionChoose">
                                        <div class="accordion-body">Tanlangan jamoalar pitch va biznes modelini mustahkamlash bo‘yicha mentorlik oladi.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="ch5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCh5" aria-expanded="false" aria-controls="collapseCh5">
                                            <span><img src="{{ asset('assets/images/icon/choose1-5.svg') }}" alt="">Hamjamiyat va tarmoq</span>
                                        </button>
                                    </h2>
                                    <div id="collapseCh5" class="accordion-collapse collapse" data-bs-parent="#accordionChoose">
                                        <div class="accordion-body">Boshqa startaplar va innovatorlar bilan aloqa o‘rnatib, hamkorlik imkoniyatlarini kengaytiring.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="choose-info">
                        <div class="inner-content">
                            <p>Kelajak Startuplari Tanlovi — g‘oyalaringizni amalga oshirish uchun zamonaviy startap musobaqasi.</p>
                            <a href="{{ route('project.submit.form') }}" class="btn-style1">
                                Hoziroq boshlash
                                <span>
                                    <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                                </span>
                            </a>
                        </div>
                        <div class="choose-img">
                            <img src="{{ asset('assets/images/event/choose1-1.png') }}" alt="" class="light">
                            <img src="{{ asset('assets/images/event/choose1-1-dark.png') }}" alt="" class="dark">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="faq-sec" id="savollar">
        <div class="carousel-container">
            <div class="faq-info">
                <div class="sec-title">
                    <span class="sub-title" data-aos="fade-up" data-aos-duration="900" data-aos-delay="300">Savollar</span>
                    <h2 class="title" data-aos="fade-up" data-aos-duration="900" data-aos-delay="400">Tez-tez beriladigan savollar</h2>
                    <p data-aos="fade-up" data-aos-duration="700" data-aos-delay="400">Tanlov qoidalari, ariza va baholash bo‘yicha qisqa javoblar.</p>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="faq-box v2">
                            <div class="accordion vs-accordion" id="accordionFaq" data-aos="fade-up" data-aos-duration="900" data-aos-delay="300">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq1">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqC1" aria-expanded="true" aria-controls="faqC1">
                                            <span>1. Tanlovda kimlar ishtirok etishi mumkin?</span>
                                        </button>
                                    </h2>
                                    <div id="faqC1" class="accordion-collapse collapse show" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Jismoniy va yuridik shaxslar, jamoalar hamda talabalar guruhlari o‘z innovatsion loyihalari bilan qatnashishlari mumkin.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqC2" aria-expanded="false" aria-controls="faqC2">
                                            <span>2. Arizani qanday topshiraman?</span>
                                        </button>
                                    </h2>
                                    <div id="faqC2" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Quyidagi “Ariza topshirish” formasi orqali ism, telefon, loyiha nomi, tavsif, fayl va ixtiyoriy video havolasini yuboring.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqC3" aria-expanded="false" aria-controls="faqC3">
                                            <span>3. Qanday fayl formatlari qabul qilinadi?</span>
                                        </button>
                                    </h2>
                                    <div id="faqC3" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">PDF, PPTX yoki ZIP (hajmi chegarasi talab qoidalarda ko‘rsatiladi). Video uchun YouTube yoki boshqa havola kifoya.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqC4" aria-expanded="false" aria-controls="faqC4">
                                            <span>4. Baholash mezonlari nimalardan iborat?</span>
                                        </button>
                                    </h2>
                                    <div id="faqC4" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Innovatsionlik, bozor potentsiali, jamoa, ijro va taqdimot sifati kabi mezonlar ekspertlar tomonidan baholanadi.</div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="faq5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqC5" aria-expanded="false" aria-controls="faqC5">
                                            <span>5. Natijalar qachon e’lon qilinadi?</span>
                                        </button>
                                    </h2>
                                    <div id="faqC5" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                                        <div class="accordion-body">Har bir bosqich muddati rasmiy e’lon va saytda yangilanadi; g‘oliblar bilan aloqa uchun ro‘yxatdan o‘tgan telefon ishlatiladi.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="faq-img" data-aos="fade-up" data-aos-duration="900" data-aos-delay="500">
                            <img src="{{ asset('assets/images/event/faq1-1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Ariza topshirish --}}
    <section class="project-submit-sec space" id="ariza-topshirish">
        <div class="carousel-container">
            <div class="sec-title text-center mb-5">
                <span class="sub-title" data-aos="fade-up" data-aos-duration="900">Ariza</span>
                <h2 class="title" data-aos="fade-up" data-aos-duration="900" data-aos-delay="100">Ariza topshirish</h2>
                <p data-aos="fade-up" data-aos-duration="900" data-aos-delay="200" class="mx-auto" style="max-width: 42rem;">Ma’lumotlarni to‘ldirib, musobaqaga ariza topshiring. Biz siz bilan tez orada bog‘lanamiz.</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-7">
                    <div class="price-card p-4 p-lg-5 text-center" style="border-radius: 16px;" data-aos="fade-up" data-aos-duration="900">
                        <p class="mb-4" style="max-width: 28rem; margin-left: auto; margin-right: auto;">
                            Loyiha nomi, byudjet, viloyat/tuman va taqdimot faylingizni alohida sahifada topshiring — tez va qulay.
                        </p>
                            <a href="{{ route('project.submit.form') }}" class="btn-style1 justify-content-center">
                            Ariza formasi
                            <span><img src="{{ asset('assets/images/icon/arrow.svg') }}" alt=""></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Yakuniy CTA + footer --}}
    <section class="main-sec3">
        <div class="platform-sec space">
            <div class="carousel-container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="platform-content" data-aos="fade-right" data-aos-duration="900" data-aos-delay="300">
                            <div class="sec-title">
                                <span class="sub-title">Kelajak siz bilan boshlanadi</span>
                                <h2 class="title">G‘oyangizni bugun yuboring</h2>
                                <p>Respublika startap ekotizimida o‘z o‘rningizni toping: mentorlik, investorlar va yangi hamkorlar kutmoqda.</p>
                            </div>
                            <a href="{{ route('project.submit.form') }}" class="btn-style1">
                                Ariza topshirish
                                <span>
                                    <img src="{{ asset('assets/images/icon/arrow.svg') }}" alt="">
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="platform-img" data-aos="fade-left" data-aos-duration="900" data-aos-delay="300">
                            <img src="{{ asset('assets/images/event/platform1-1.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.partials.site-footer')
    </section>
@endsection
<!-- 
    ===================================================
    11.09.2026 Rayimjonov Eldorbek tomonidan yaratildi
    ===================================================
-->