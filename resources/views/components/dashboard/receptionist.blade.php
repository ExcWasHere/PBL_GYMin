<x-layouts.dashboard title="Dashboard Resepsionis">
    <div style="margin-bottom:24px;">
        <div style="font-size:0.75rem;letter-spacing:0.1em;text-transform:uppercase;color:var(--gym-gray);margin-bottom:8px;">Role</div>
        <div style="display:inline-block;background:rgba(96,165,250,0.15);border:1px solid rgba(96,165,250,0.4);color:#60a5fa;padding:4px 12px;font-size:0.78rem;letter-spacing:0.08em;text-transform:uppercase;">Resepsionis</div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:28px;">
        <div class="stat-card">
            <div class="stat-label">Total Member</div>
            <div class="stat-value">
                {{ \App\Models\User::where('role','member')->count() }}<span class="stat-unit">orang</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-title">Daftar Member</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\User::where('role','member')->orderBy('created_at','desc')->get() as $u)
                <tr>
                    <td style="color:var(--gym-gray)">{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td style="color:var(--gym-gray)">{{ $u->email }}</td>
                    <td style="color:var(--gym-gray)">{{ $u->created_at->format('d M Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.dashboard>
