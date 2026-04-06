<x-layouts.auth title="Daftar — Gym-In">
    <p class="auth-title">Buat Akun Baru</p>

    @if ($errors->any())
        <div style="background:rgba(232,41,42,0.1);border:1px solid rgba(232,41,42,0.3);color:#f87171;padding:10px 14px;font-size:0.82rem;margin-bottom:16px;">
            <ul style="list-style:none;padding:0;margin:0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/register">
        @csrf
        <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-input" placeholder="Prabowo Okegas">
        </div>
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" placeholder="prabowo@bijisatumail.com" required>
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" placeholder="**********" required>
        </div>
        <div class="form-group">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-input" placeholder="**********" required>
        </div>
        <button type="submit" class="btn-primary">Daftar</button>
    </form>

    <p class="auth-footer">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
</x-layouts.auth>
