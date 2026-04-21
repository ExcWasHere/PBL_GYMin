<x-layouts.dashboard title="Kepadatan Gym">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-label">Pengunjung Aktif</div>
            <div class="stat-value">{{ $activeVisitors }}<span class="stat-unit">orang</span></div>
            <div style="margin-top:8px;">
                @php
                    $pct = $activeVisitors / $maxCapacity * 100;
                    $badge = $pct < 40 ? ['Sepi','#34d399','rgba(52,211,153,.12)']
                           : ($pct < 75 ? ['Sedang','#fbbf24','rgba(251,191,36,.12)']
                           : ['Ramai','#E8292A','rgba(232,41,42,.12)']);
                @endphp
                <span style="display:inline-block;padding:2px 8px;font-size:.68rem;letter-spacing:.06em;text-transform:uppercase;font-weight:600;background:{{ $badge[2] }};color:{{ $badge[1] }};">
                    {{ $badge[0] }}
                </span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Kapasitas Maks</div>
            <div class="stat-value">{{ $maxCapacity }}<span class="stat-unit">orang</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Tingkat Kepadatan</div>
            <div class="stat-value">{{ round($pct) }}<span class="stat-unit">%</span></div>
            <div style="height:4px;background:var(--gym-border);margin-top:10px;">
                <div style="height:4px;background:{{ $badge[1] }};width:{{ round($pct) }}%;"></div>
            </div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
        <div class="card">
            <div class="card-title">Kepadatan Per Jam (Hari Ini)</div>
            @foreach($hourlyStats as $row)
                @php $barPct = $maxCapacity > 0 ? round($row['count'] / $maxCapacity * 100) : 0; @endphp
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                    <span style="font-size:.78rem;color:var(--gym-light);width:48px;flex-shrink:0;">{{ $row['hour'] }}</span>
                    <div style="flex:1;height:8px;background:var(--gym-border);">
                        <div style="height:8px;background:var(--gym-red);width:{{ $barPct }}%;"></div>
                    </div>
                    <span style="font-size:.78rem;color:var(--gym-gray);width:38px;text-align:right;">{{ $row['count'] }}</span>
                </div>
            @endforeach
        </div>
        <div>
            <div class="card" style="margin-bottom:16px;">
                <div class="card-title">Kepadatan Per Zona</div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    @foreach($zones as $zone)
                        @php
                            $zPct = $zone['max'] > 0 ? round($zone['current'] / $zone['max'] * 100) : 0;
                            $zColor = $zPct < 50 ? '#34d399' : ($zPct < 75 ? '#fbbf24' : '#E8292A');
                        @endphp
                        <div style="background:#0d0d0d;border:1px solid var(--gym-border);padding:14px;">
                            <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.08em;color:var(--gym-gray);margin-bottom:4px;">{{ $zone['name'] }}</div>
                            <div style="font-size:1.2rem;font-weight:600;">
                                {{ $zone['current'] }}
                                <span style="font-size:.72rem;color:var(--gym-gray);">/ {{ $zone['max'] }}</span>
                            </div>
                            <div style="height:4px;background:var(--gym-border);margin-top:8px;">
                                <div style="height:4px;background:{{ $zColor }};width:{{ $zPct }}%;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="card-title">Info Waktu Terbaik</div>
                <div style="font-size:.82rem;color:var(--gym-light);line-height:1.7;">
                    Waktu sepi biasanya
                    <strong style="color:var(--gym-white);">{{ $quietHours }}</strong>.<br>
                    Jam sibuk:
                    <strong style="color:var(--gym-red);">{{ $peakHours }}</strong>.
                </div>
            </div>
        </div>
    </div>
</x-layouts.dashboard>