{{--
    Startup tanlovi — loyiha holati vaqti chizig‘i (Tailwind CSS v4).

    Dashboard sahifasida:
        @vite(['resources/css/app.css'])

    Foydalanish:
        <x-project-status-timeline
            variant="vertical"
            :step1-status="'completed'"
            :step2-status="'current'"
            :step3-status="'pending'"
            :step4-status="'pending'"
            :rejection-reason="$reason"
            :district-at="$model->district_at"
            :region-at="$model->region_at"
        />

    Statuslar: completed | current | pending | rejected
--}}
@props([
    'variant' => 'vertical',
    'step1Status' => 'completed',
    'step2Status' => 'pending',
    'step3Status' => 'pending',
    'step4Status' => 'pending',
    'rejectionReason' => null,
    'districtAt' => null,
    'regionAt' => null,
])

@php
    use Illuminate\Support\Carbon;

    $formatDt = static function ($value): ?string {
        if ($value === null || $value === '') {
            return null;
        }

        return Carbon::parse($value)->timezone(config('app.timezone', 'Asia/Tashkent'))->format('d.m.Y H:i');
    };

    $districtLabel = $formatDt($districtAt);
    $regionLabel = $formatDt($regionAt);

    $step2Title = match (true) {
        $step2Status === 'rejected' => 'Rad etildi',
        in_array($step2Status, ['completed', 'current'], true) => 'Qabul qilindi',
        default => 'Qabul qilindi / rad etildi',
    };

    $statusRing = static function (string $status): string {
        return match ($status) {
            'completed' => 'bg-emerald-500 text-white shadow-[0_0_0_4px_rgba(16,185,129,0.25)]',
            'current' => 'bg-amber-400 text-amber-950 shadow-[0_0_0_4px_rgba(251,191,36,0.35)] ring-2 ring-amber-300/80',
            'rejected' => 'bg-red-500 text-white shadow-[0_0_0_4px_rgba(239,68,68,0.25)]',
            default => 'bg-neutral-200 text-neutral-500 dark:bg-white/10 dark:text-neutral-400',
        };
    };

    $statusTitleClass = static function (string $status): string {
        return match ($status) {
            'completed' => 'text-emerald-700 dark:text-emerald-400',
            'current' => 'text-amber-700 dark:text-amber-300',
            'rejected' => 'text-red-600 dark:text-red-400',
            default => 'text-neutral-500 dark:text-neutral-400',
        };
    };

    $linePercent = (float) match (true) {
        $step4Status === 'completed' => 100,
        $step4Status === 'current' => 88,
        $step3Status === 'completed' => 72,
        $step3Status === 'current' => 58,
        $step2Status === 'rejected' => 42,
        $step2Status === 'completed' => 48,
        $step2Status === 'current' => 36,
        $step1Status === 'completed' => 22,
        $step1Status === 'current' => 12,
        default => 4,
    };

    $isHorizontal = $variant === 'horizontal';

    $steps = [
        [
            'status' => $step1Status,
            'title' => 'Ariza yuborildi',
            'subtitle' => null,
            'icon' => 'paper',
        ],
        [
            'status' => $step2Status,
            'title' => $step2Title,
            'subtitle' => $step2Status === 'rejected' && $rejectionReason ? (string) $rejectionReason : null,
            'icon' => $step2Status === 'rejected' ? 'reject' : 'check',
        ],
        [
            'status' => $step3Status,
            'title' => 'Tuman bosqichi',
            'subtitle' => $districtLabel,
            'icon' => 'district',
        ],
        [
            'status' => $step4Status,
            'title' => 'Viloyat bosqichi',
            'subtitle' => $regionLabel,
            'icon' => 'region',
        ],
    ];

    $iconSvg = static function (string $icon): string {
        return match ($icon) {
            'paper' => '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg>',
            'reject' => '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>',
            'check' => '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg>',
            'district' => '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>',
            default => '<svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" /></svg>',
        };
    };
@endphp

@once
    @push('styles')
        <style>
            @keyframes pst-step-in {
                from {
                    opacity: 0;
                    transform: translateY(12px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            @keyframes pst-step-in-h {
                from {
                    opacity: 0;
                    transform: translateX(-10px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }
            @keyframes pst-line-fill-v {
                from {
                    transform: scaleY(0);
                }
                to {
                    transform: scaleY(calc(var(--pst-line-p, 100) / 100));
                }
            }
            @keyframes pst-line-fill-h {
                from {
                    transform: scaleX(0);
                }
                to {
                    transform: scaleX(calc(var(--pst-line-p, 100) / 100));
                }
            }
            .pst-step-animate {
                animation: pst-step-in 0.55s ease-out both;
            }
            .pst-timeline--horizontal .pst-step-animate {
                animation-name: pst-step-in-h;
            }
            .pst-line-fill-v {
                transform-origin: top;
                animation: pst-line-fill-v 0.9s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
            }
            .pst-line-fill-h {
                transform-origin: left;
                animation: pst-line-fill-h 0.9s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
            }
        </style>
    @endpush
@endonce

<div
    {{ $attributes->class([
        'pst-timeline rounded-2xl border border-neutral-200/80 bg-white p-6 shadow-sm ring-1 ring-black/[0.04] dark:border-white/10 dark:bg-[#161615]/95 dark:ring-white/[0.06]',
        'pst-timeline--horizontal' => $isHorizontal,
    ]) }}
>
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h3 class="text-lg font-semibold tracking-tight text-neutral-900 dark:text-white">
            Ariza jarayoni
        </h3>
        <span class="rounded-full bg-[#f53003]/10 px-3 py-1 text-xs font-semibold text-[#f53003] dark:bg-[#ff6b4a]/15 dark:text-[#ff8a6a]">
            Tanlov
        </span>
    </div>

    @if ($isHorizontal)
        <div class="relative flex w-full flex-col gap-8 md:flex-row md:items-start md:justify-between md:gap-2">
            <div
                class="pointer-events-none absolute left-0 right-0 top-7 hidden h-1 rounded-full bg-neutral-200 dark:bg-white/10 md:block"
                aria-hidden="true"
            ></div>
            <div
                class="pst-line-fill-h pointer-events-none absolute left-0 top-7 hidden h-1 w-full rounded-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-amber-400 dark:from-emerald-500 dark:via-emerald-400 dark:to-amber-300 md:block"
                style="--pst-line-p: {{ $linePercent }};"
                aria-hidden="true"
            ></div>

            @foreach ($steps as $index => $step)
                <div
                    class="pst-step-animate relative z-[1] flex flex-1 flex-col items-center text-center md:min-w-0 md:px-1"
                    style="animation-delay: {{ $index * 90 }}ms"
                >
                    <div
                        class="mb-3 flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl transition-transform duration-300 hover:scale-105 {{ $statusRing($step['status']) }}"
                    >
                        {!! $iconSvg($step['icon']) !!}
                    </div>
                    <h4 class="text-sm font-semibold leading-snug {{ $statusTitleClass($step['status']) }}">
                        {{ $step['title'] }}
                    </h4>
                    @if (! empty($step['subtitle']))
                        <p class="mt-1.5 max-w-[14rem] text-xs leading-relaxed text-neutral-500 dark:text-neutral-400">
                            {{ $step['subtitle'] }}
                        </p>
                    @elseif (in_array($step['icon'], ['district', 'region'], true))
                        <p class="mt-1.5 text-xs italic text-neutral-400 dark:text-neutral-500">
                            Sana belgilanmagan
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="relative pl-1">
            <div
                class="absolute bottom-10 left-[1.75rem] top-10 w-1 rounded-full bg-neutral-200 dark:bg-white/10"
                aria-hidden="true"
            ></div>
            <div
                class="pst-line-fill-v absolute bottom-10 left-[1.75rem] top-10 w-1 rounded-full bg-gradient-to-b from-emerald-500 via-emerald-400 to-amber-400 dark:from-emerald-500 dark:via-emerald-400 dark:to-amber-300"
                style="--pst-line-p: {{ $linePercent }};"
                aria-hidden="true"
            ></div>

            <ol class="relative m-0 list-none space-y-10 p-0">
                @foreach ($steps as $index => $step)
                    <li
                        class="pst-step-animate relative flex gap-5"
                        style="animation-delay: {{ $index * 100 }}ms"
                    >
                        <div class="relative z-[1] flex shrink-0 flex-col items-center">
                            <div
                                class="flex h-14 w-14 items-center justify-center rounded-2xl transition-transform duration-300 hover:scale-105 {{ $statusRing($step['status']) }}"
                            >
                                {!! $iconSvg($step['icon']) !!}
                            </div>
                        </div>
                        <div class="min-w-0 flex-1 pb-0.5 pt-0.5">
                            <h4 class="text-base font-semibold leading-snug {{ $statusTitleClass($step['status']) }}">
                                {{ $step['title'] }}
                            </h4>
                            @if (! empty($step['subtitle']))
                                <p class="mt-1.5 text-sm leading-relaxed text-neutral-600 dark:text-neutral-300">
                                    {{ $step['subtitle'] }}
                                </p>
                            @elseif (in_array($step['icon'], ['district', 'region'], true))
                                <p class="mt-1.5 text-sm italic text-neutral-400 dark:text-neutral-500">
                                    Sana belgilanmagan
                                </p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif
</div>
