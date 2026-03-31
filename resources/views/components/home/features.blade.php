<style>
    .section-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--gym-red);
        margin-bottom: 1rem;
    }
    .section-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2.5rem, 5vw, 4rem);
        line-height: 1;
        letter-spacing: 0.02em;
    }

    .feature-card {
        background: var(--gym-card);
        border: 1px solid var(--gym-border);
        padding: 2rem;
        transition: border-color 0.3s, transform 0.3s;
        position: relative;
        overflow: hidden;
    }
    .feature-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 3px; height: 0;
        background: var(--gym-red);
        transition: height 0.4s ease;
    }
    .feature-card:hover { border-color: #333; transform: translateY(-4px); }
    .feature-card:hover::before { height: 100%; }

    .feature-icon {
        width: 48px; height: 48px;
        background: rgba(232,41,42,0.1);
        border: 1px solid rgba(232,41,42,0.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem;
        margin-bottom: 1.25rem;
    }
    .feature-num {
        position: absolute;
        top: 1.5rem; right: 1.5rem;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 3rem;
        color: var(--gym-border);
        line-height: 1;
    }
    .feature-title { font-weight: 600; font-size: 1.05rem; margin-bottom: 0.6rem; color: var(--gym-white); }
    .feature-desc  { font-size: 0.875rem; color: var(--gym-gray); line-height: 1.65; font-weight: 300; }
</style>

@php
    $features = [
        ['num' => '01', 'icon' => '📊', 'title' => 'Monitor Kepadatan',  'desc' => 'Pantau seberapa ramai gym secara real-time. Pilih waktu terbaik untuk latihan tanpa antri alat.'],
        ['num' => '02', 'icon' => '📅', 'title' => 'Jadwal Latihan',     'desc' => 'Buat dan atur jadwal latihan mingguan kamu. Dapatkan reminder sebelum sesi dimulai.'],
        ['num' => '03', 'icon' => '🔥', 'title' => 'Streak & Reward',    'desc' => 'Kumpulkan streak kehadiran dan raih poin reward setiap kali kamu konsisten datang latihan.'],
        ['num' => '04', 'icon' => '📈', 'title' => 'Progress Tracker',   'desc' => 'Catat berat badan, set, dan rep latihan kamu. Visualisasikan perkembangan dari waktu ke waktu.'],
        ['num' => '05', 'icon' => '💪', 'title' => 'Program Workout',    'desc' => 'Ikuti program latihan terstruktur yang disesuaikan dengan target dan level kebugaranmu.'],
        ['num' => '06', 'icon' => '🔔', 'title' => 'Notifikasi Pintar',  'desc' => 'Dapat notifikasi ketika gym mulai sepi — waktu terbaik buat kamu yang suka latihan fokus.'],
    ];
@endphp

<section id="features" class="py-28 px-6">
    <div class="max-w-7xl mx-auto">

        <div class="max-w-2xl mb-16 reveal">
            <div class="section-tag">
                <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
                Fitur Unggulan
            </div>
            <h2 class="section-title">
                SEMUA YANG KAMU<br>
                <span style="color:var(--gym-red);">BUTUHKAN</span>
            </h2>
            <p style="color:var(--gym-gray);margin-top:1rem;font-size:0.95rem;line-height:1.7;font-weight:300;">
                Gym-In hadir dengan fitur lengkap untuk memaksimalkan pengalaman gym kamu — dari pantau kepadatan hingga tracking progres harian.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($features as $i => $f)
                <div class="feature-card reveal" style="transition-delay:{{ ($i % 3) * 0.1 }}s;">
                    <div class="feature-num">{{ $f['num'] }}</div>
                    <div class="feature-icon">{{ $f['icon'] }}</div>
                    <div class="feature-title">{{ $f['title'] }}</div>
                    <div class="feature-desc">{{ $f['desc'] }}</div>
                </div>
            @endforeach
        </div>

    </div>
</section>