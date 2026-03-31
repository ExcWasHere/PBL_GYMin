<style>
    .step-circle {
        width: 56px; height: 56px;
        border-radius: 50%;
        background: var(--gym-dark);
        border: 1px solid var(--gym-border);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.4rem;
        color: var(--gym-red);
        margin: 0 auto 1rem;
        position: relative; z-index: 1;
    }
    .step-circle.active {
        background: var(--gym-red);
        color: white;
        border-color: var(--gym-red);
    }
</style>

@php
    $steps = [
        ['num' => '01', 'title' => 'Daftar Akun',     'desc' => 'Buat akun gratis dengan email atau nomor telepon. Proses cepat, kurang dari 1 menit.'],
        ['num' => '02', 'title' => 'Atur Profil',      'desc' => 'Isi target kebugaran, jadwal favorit, dan level fitness kamu. Sistem akan menyesuaikan rekomendasi.'],
        ['num' => '03', 'title' => 'Mulai Latihan',    'desc' => 'Cek kepadatan gym, masuk check-in, dan mulai sesi latihan. Streak kamu langsung tercatat!'],
    ];
@endphp

<section id="cara-pakai" class="py-24 px-6" style="background:var(--gym-dark);border-top:1px solid var(--gym-border);border-bottom:1px solid var(--gym-border);">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-16 reveal">
            <div class="section-tag" style="justify-content:center;">
                <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
                Cara Pakai
                <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
            </div>
            <h2 class="section-title">
                MULAI DALAM<br>
                <span style="color:var(--gym-red);">3 LANGKAH</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($steps as $i => $step)
                <div class="text-center reveal" style="transition-delay:{{ $i * 0.15 }}s;">
                    <div class="relative mb-6">
                        <div class="step-circle active">{{ $step['num'] }}</div>
                        @if(!$loop->last)
                            <div class="hidden md:block absolute top-7 left-1/2 w-full h-px" style="background:var(--gym-border);"></div>
                        @endif
                    </div>
                    <h3 style="font-family:'Bebas Neue',sans-serif;font-size:1.4rem;letter-spacing:0.05em;margin-bottom:0.5rem;">
                        {{ $step['title'] }}
                    </h3>
                    <p style="color:var(--gym-gray);font-size:0.875rem;line-height:1.65;font-weight:300;">
                        {{ $step['desc'] }}
                    </p>
                </div>
            @endforeach
        </div>

    </div>
</section>