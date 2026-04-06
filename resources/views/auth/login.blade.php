<x-layouts.auth title="Masuk — Gym-In">
    <p class="auth-title">Masuk ke Akun</p>

    @if ($errors->any())
        <div style="background:rgba(232,41,42,0.1);border:1px solid rgba(232,41,42,0.3);color:#f87171;padding:10px 14px;font-size:0.82rem;margin-bottom:16px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf
        <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-input" required placeholder="e.g. prabowo@monokotilmail.com">
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required placeholder="**********">
        </div>
        <div class="form-group">
            <label class="checkbox-row">
                <input type="checkbox" name="remember"> Ingat saya
            </label>
        </div>
        <button type="submit" class="btn-primary">Masuk</button>
    </form>

    <p class="auth-footer">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
</x-layouts.auth>
