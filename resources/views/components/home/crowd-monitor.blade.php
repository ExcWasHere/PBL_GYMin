<style>
    .crowd-bar {
        height: 6px;
        border-radius: 3px;
        background: var(--gym-border);
        overflow: hidden;
    }
    .crowd-fill {
        height: 100%;
        border-radius: 3px;
        background: #22c55e;
        transition: width 1s ease;
    }
</style>

@php
    $benefits = [
        'Indikator kepadatan per jam',
        'Notifikasi saat gym mulai sepi',
        'Riwayat pola keramaian mingguan',
        'Estimasi ketersediaan alat utama',
    ];

    $hours = ['06','08','10','12','14','16','18','20','22'];
    $pcts  = [30, 55, 40, 70, 45, 85, 47, 60, 25];
    $colors= ['#22c55e','#f59e0b','#22c55e','#ef4444','#22c55e','#ef4444','#22c55e','#f59e0b','#22c55e'];
@endphp

<section id="kepadatan" class="section">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="reveal">
                <div class="section-tag">
                    <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
                    Kepadatan Realtime
                </div>
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    TAU KAPAN<br><span style="color:var(--gym-red);">GYM SEPI</span>
                </h2>
                <p style="color:var(--gym-gray);font-size:0.95rem;line-height:1.75;font-weight:300;margin-bottom:2rem;">
                    Ga perlu datang ke gym cuma buat kena php, ternyata semua alat lagi dipakai. Pantau tingkat kepadatan per jam dan pilih waktu terbaik untuk latihan kamu.
                </p>
                <ul style="display:flex;flex-direction:column;gap:12px;">
                    @foreach($benefits as $item)
                        <li style="display:flex;align-items:center;gap:10px;color:var(--gym-light);font-size:0.9rem;">
                            <span style="color:var(--gym-red);font-size:1rem;">→</span>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="reveal" style="transition-delay:0.15s;">
                <div style="background:var(--gym-card);border:1px solid var(--gym-border);padding:2rem;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
                        <div>
                            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.3rem;letter-spacing:0.05em;">Status Gym Hari Ini</div>
                            <div style="font-size:0.72rem;color:var(--gym-gray);letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">Live 18:30 WIB</div>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;color:#22c55e;font-weight:500;">
                            <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;animation:pulse 2s infinite;"></span>
                            Tersedia
                        </div>
                    </div>
                    <div style="text-align:center;padding:1.5rem 0;border-top:1px solid var(--gym-border);border-bottom:1px solid var(--gym-border);margin-bottom:1.5rem;">
                        <div style="font-family:'Bebas Neue',sans-serif;font-size:4.5rem;line-height:1;color:#22c55e;">47%</div>
                        <div style="font-size:0.78rem;color:var(--gym-gray);text-transform:uppercase;letter-spacing:0.12em;margin-top:4px;">Kapasitas Terpakai</div>
                        <div class="crowd-bar" style="margin-top:1rem;max-width:200px;margin-left:auto;margin-right:auto;">
                            <div class="crowd-fill" style="width:47%;"></div>
                        </div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--gym-gray);letter-spacing:0.12em;text-transform:uppercase;margin-bottom:1rem;">Prediksi Per Jam</div>
                        <div style="display:flex;align-items:flex-end;gap:6px;height:60px;">
                            @foreach($hours as $i => $h)
                                <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                                    <div style="width:100%;background:{{ $colors[$i] }};height:{{ $pcts[$i] * 0.55 }}px;opacity:{{ $h === '18' ? 1 : 0.4 }};border-radius:2px 2px 0 0;"
                                         title="{{ $h }}:00 — {{ $pcts[$i] }}%">
                                    </div>
                                    <div style="font-size:0.58rem;color:var(--gym-gray);">{{ $h }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    const crowdFill = document.querySelector('.crowd-fill');
    if (crowdFill) {
        const targetWidth = crowdFill.style.width;
        crowdFill.style.width = '0';
        const fillObserver = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
                crowdFill.style.width = targetWidth;
                fillObserver.disconnect();
            }
        }, { threshold: 0.3 });
        fillObserver.observe(crowdFill);
    }
</script>
@endpush