<x-layouts.dashboard title="Progress Tracker">

@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:28px;">

    <div class="card">
        <div class="card-title">Tambah / Update Log Harian</div>
        <form method="POST" action="{{ route('progress.store') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Tanggal</label>
                <input type="date" name="log_date" class="form-input" required>
                @error('log_date') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
                <div class="form-group">
                    <label class="form-label">Berat Badan (kg)</label>
                    <input type="number" name="weight_kg" class="form-input" step="0.1" min="1" max="300" placeholder="e.g. 72.5">
                    @error('weight_kg') <div class="form-error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label class="form-label">Massa Otot (kg)</label>
                    <input type="number" name="muscle_mass_kg" class="form-input" step="0.1" min="1" max="200" placeholder="e.g. 35.0">
                    @error('muscle_mass_kg') <div class="form-error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">% Lemak Tubuh</label>
                <input type="number" name="body_fat_pct" class="form-input" step="0.1" min="0" max="100" placeholder="e.g. 18.5">
                @error('body_fat_pct') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">Catatan Latihan</label>
                <textarea name="workout_notes" class="form-input" placeholder="3x10 bilang antek-antek asing">{{ old('workout_notes') }}</textarea>
                @error('workout_notes') 
                <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <button type="submit" class="btn-primary">Simpan Log</button>
        </form>
    </div>

    <div style="display:flex;flex-direction:column;gap:16px;">
        @php
            $latest = $logs->last();
            $first  = $logs->first();
            $weightDiff = ($latest && $first && $latest->weight_kg && $first->weight_kg)
                ? round($latest->weight_kg - $first->weight_kg, 1) : null;
        @endphp
        <div class="stat-card">
            <div class="stat-label">Berat Terkini</div>
            <div class="stat-value">{{ $latest?->weight_kg ?? '—' }}<span class="stat-unit">kg</span></div>
            @if($weightDiff !== null)
                <div style="font-size:0.78rem;margin-top:4px;color:{{ $weightDiff <= 0 ? '#4ade80' : '#f87171' }}">
                    {{ $weightDiff > 0 ? '+' : '' }}{{ $weightDiff }} kg sejak awal
                </div>
            @endif
        </div>
        <div class="stat-card">
            <div class="stat-label">Massa Otot Terkini</div>
            <div class="stat-value">{{ $latest?->muscle_mass_kg ?? '—' }}<span class="stat-unit">kg</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">% Lemak Terkini</div>
            <div class="stat-value">{{ $latest?->body_fat_pct ?? '—' }}<span class="stat-unit">%</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total Entri</div>
            <div class="stat-value">{{ $logs->count() }}<span class="stat-unit">hari</span></div>
        </div>
    </div>
</div>

{{-- grafik --}}
@if($logs->count() > 1)
<div class="card" style="margin-bottom:28px;">
    <div class="card-title">Grafik Perkembangan</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;">
        <div><canvas id="chartWeight" height="180"></canvas></div>
        <div><canvas id="chartMuscle" height="180"></canvas></div>
    </div>
</div>
@endif

<div class="card">
    <div class="card-title">Riwayat Log</div>
    @if($logs->isEmpty())
        <p style="color:var(--gym-gray);font-size:0.85rem;">Belum ada log. Mulai catat progress kamu hari ini!</p>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Berat (kg)</th>
                    <th>Otot (kg)</th>
                    <th>Lemak (%)</th>
                    <th>Catatan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs->sortByDesc('log_date') as $log)
                <tr>
                    <td>{{ $log->log_date->format('d M Y') }}</td>
                    <td>{{ $log->weight_kg ?? '—' }}</td>
                    <td>{{ $log->muscle_mass_kg ?? '—' }}</td>
                    <td>{{ $log->body_fat_pct ?? '—' }}</td>
                    <td style="max-width:200px;color:var(--gym-gray)">{{ $log->workout_notes ?? '—' }}</td>
                    <td>
                        <form method="POST" action="{{ route('progress.destroy', $log) }}"
                              onsubmit="return confirm('Hapus log ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@push('scripts')
@if($logs->count() > 1)
<script>
    const labels  = @json($logs->pluck('log_date')->map(fn($d) => $d->format('d/m')));
    const weights = @json($logs->pluck('weight_kg'));
    const muscles = @json($logs->pluck('muscle_mass_kg'));

    const chartDefaults = {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: '#888', font: { size: 11 } }, grid: { color: '#1e1e1e' } },
            y: { ticks: { color: '#888', font: { size: 11 } }, grid: { color: '#1e1e1e' } }
        }
    };

    new Chart(document.getElementById('chartWeight'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Berat (kg)',
                data: weights,
                borderColor: '#E8292A',
                backgroundColor: 'rgba(232,41,42,0.08)',
                tension: 0.4, fill: true, pointRadius: 4,
                pointBackgroundColor: '#E8292A'
            }]
        },
        options: { ...chartDefaults, plugins: { ...chartDefaults.plugins, title: { display: true, text: 'Berat Badan (kg)', color: '#888', font: { size: 11 } } } }
    });

    new Chart(document.getElementById('chartMuscle'), {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Massa Otot (kg)',
                data: muscles,
                borderColor: '#60a5fa',
                backgroundColor: 'rgba(96,165,250,0.08)',
                tension: 0.4, fill: true, pointRadius: 4,
                pointBackgroundColor: '#60a5fa'
            }]
        },
        options: { ...chartDefaults, plugins: { ...chartDefaults.plugins, title: { display: true, text: 'Massa Otot (kg)', color: '#888', font: { size: 11 } } } }
    });
</script>
@endif
@endpush

</x-layouts.dashboard>
