@php
    use App\Models\Reservation;
    use Carbon\Carbon;

    $maxCapacity = 80;
    $now         = Carbon::now();
    $time        = $now->format('H:i');

    $activeVisitors = Reservation::where('session_date', today())
        ->where('status', 'confirmed')
        ->where('session_start', '<=', $time)
        ->where('session_end',   '>',  $time)
        ->count();

    $pct = $maxCapacity > 0 ? round($activeVisitors / $maxCapacity * 100) : 0;
    $statusColor = $pct < 40 ? '#22c55e' : ($pct < 75 ? '#f59e0b' : '#E8292A');
    $statusLabel = $pct < 40 ? 'Sepi'    : ($pct < 75 ? 'Sedang'  : 'Ramai');
    $hourlyCounts = Reservation::where('session_date', today())
        ->where('status', 'confirmed')
        ->selectRaw('session_start, COUNT(*) as count')
        ->groupBy('session_start')
        ->pluck('count', 'session_start')
        ->toArray();
    $displaySlots = [
        ['hour' => '06', 'key' => '06:00'],
        ['hour' => '08', 'key' => '08:00'],
        ['hour' => '10', 'key' => '10:00'],
        ['hour' => '12', 'key' => '12:00'],
        ['hour' => '14', 'key' => '14:00'],
        ['hour' => '16', 'key' => '16:00'],
        ['hour' => '18', 'key' => '18:00'],
        ['hour' => '20', 'key' => '20:00'],
        ['hour' => '22', 'key' => '22:00'],
    ];

    $currentHour = (int) $now->format('H');

    $benefits = [
        'Indikator kepadatan per jam secara live',
        'Riwayat pola keramaian mingguan',
        'Estimasi ketersediaan alat utama',
    ];
@endphp

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
        transition: width 1.2s cubic-bezier(.4,0,.2,1);
    }
    .live-pulse {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        animation: livePulse 2s ease-in-out infinite;
    }
    @keyframes livePulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50%       { opacity: 0.4; transform: scale(1.5); }
    }
    .mini-bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }
    .mini-bar {
        width: 100%;
        border-radius: 2px 2px 0 0;
        transition: height 1s ease, opacity 1s ease;
    }
    .lp-density-card {
        background: var(--gym-card);
        border: 1px solid var(--gym-border);
        padding: 2rem;
    }
    .lp-big-pct {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 4.5rem;
        line-height: 1;
        transition: color .6s ease;
    }
</style>

<section id="kepadatan" class="section">
    <div class="container-custom">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div class="reveal">
                <h2 class="section-title" style="margin-bottom:1.25rem;">
                    TAHU KAPAN<br><span style="color:var(--gym-red);">GYM SEPI</span>
                </h2>
                <p style="color:var(--gym-gray);font-size:0.95rem;line-height:1.75;font-weight:300;margin-bottom:2rem;">
                    Sudah dateng di lokasi tapi kena PHP? Mau pakai alat tapi sudah terpakai semua?
                    Tenang, fitur kepadatan dari GYM-in siap bantu kamu pantau tingkat
                    kepadatan per jam dan pilih waktu terbaik untuk latihan kamu.
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
                <div class="lp-density-card">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
                        <div>
                            <div style="font-family:'Bebas Neue',sans-serif;font-size:1.3rem;letter-spacing:0.05em;">
                                Status Hari Ini
                            </div>
                            <div style="font-size:0.72rem;color:var(--gym-gray);letter-spacing:0.1em;text-transform:uppercase;margin-top:2px;">
                                Live {{ $now->format('H:i') }} WIB
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:0.78rem;font-weight:600;color:{{ $statusColor }};">
                            <span class="live-pulse" style="background:{{ $statusColor }};"></span>
                            {{ $statusLabel }}
                        </div>
                    </div>
                    <div style="text-align:center;padding:1.5rem 0;border-top:1px solid var(--gym-border);border-bottom:1px solid var(--gym-border);margin-bottom:1.5rem;">
                        <div class="lp-big-pct" style="color:{{ $statusColor }};">
                            {{ $pct }}%
                        </div>
                        <div style="font-size:0.78rem;color:var(--gym-gray);text-transform:uppercase;letter-spacing:0.12em;margin-top:4px;">
                            Kapasitas Terpakai
                        </div>
                        <div class="crowd-bar" style="margin-top:1rem;max-width:200px;margin-left:auto;margin-right:auto;">
                            <div class="crowd-fill" id="lp-crowd-fill"
                                 style="width:0%;background:{{ $statusColor }};"
                                 data-target="{{ $pct }}">
                            </div>
                        </div>
                        <div style="font-size:0.68rem;color:var(--gym-gray);margin-top:10px;letter-spacing:.08em;">
                            {{ $activeVisitors }} dari {{ $maxCapacity }} kapasitas terisi
                        </div>
                    </div>
                    <div>
                        <div style="font-size:0.7rem;color:var(--gym-gray);letter-spacing:0.12em;text-transform:uppercase;margin-bottom:1rem;">
                            Kepadatan Per Jam
                        </div>
                        <div style="display:flex;align-items:flex-end;gap:5px;height:64px;">
                            @foreach($displaySlots as $slot)
                                @php
                                    $c       = $hourlyCounts[$slot['key']] ?? 0;
                                    $slotPct = $maxCapacity > 0 ? round($c / $maxCapacity * 100) : 0;
                                    $slotH   = (int) $slot['hour'];
                                    $isNow   = ($slotH <= $currentHour && $currentHour < $slotH + 2);
                                    $barH    = max(3, round($slotPct * 0.58)); // max ~58px
                                    $clr     = $slotPct < 40 ? '#22c55e' : ($slotPct < 75 ? '#f59e0b' : '#E8292A');
                                @endphp
                                <div class="mini-bar-col">
                                    <div class="mini-bar"
                                         style="height:{{ $barH }}px;background:{{ $clr }};opacity:{{ $isNow ? 1 : 0.38 }};"
                                         title="{{ $slot['hour'] }}:00 — {{ $c }} orang ({{ $slotPct }}%)">
                                    </div>
                                    <div style="font-size:0.58rem;color:var(--gym-gray);">{{ $slot['hour'] }}</div>
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
    (function () {
        const fill = document.getElementById('lp-crowd-fill');
        if (!fill) return;
        const target = fill.dataset.target + '%';
        const observer = new IntersectionObserver(entries => {
            if (entries[0].isIntersecting) {
                fill.style.width = target;
                observer.disconnect();
            }
        }, { threshold: 0.3 });
        observer.observe(fill);
    })();
</script>
@endpush