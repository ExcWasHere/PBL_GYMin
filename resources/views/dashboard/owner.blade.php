<x-layouts.dashboard title="Dashboard Owner">
    <div style="margin-bottom:24px;">
        <div style="font-size:0.75rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--gym-gray);margin-bottom:8px;">Role</div>
        <div style="display:inline-block;background:rgba(232,41,42,0.15);border:1px solid rgba(232,41,42,0.4);color:#f87171;padding:4px 12px;font-size:0.78rem;letter-spacing:0.08em;text-transform:uppercase;">Owner</div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-label">Total Member</div>
            <div class="stat-value">
                {{ \App\Models\User::where('role','member')->count() }}<span class="stat-unit">orang</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Resepsionis</div>
            <div class="stat-value">
                {{ \App\Models\User::where('role','receptionist')->count() }}<span class="stat-unit">orang</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Daftar Semua User</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::orderBy('created_at','desc')->get() as $u)
                <tr>
                    <td style="color:var(--gym-gray)">{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td style="color:var(--gym-gray)">{{ $u->email }}</td>
                    <td>
                        <span style="font-size:0.72rem;letter-spacing:0.06em;text-transform:uppercase;
                            color:{{ $u->role === 'owner' ? '#fbbf24' : ($u->role === 'receptionist' ? '#60a5fa' : '#4ade80') }}">
                            {{ $u->role }}
                        </span>
                    </td>
                    <td style="color:var(--gym-gray)">{{ $u->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.dashboard>
