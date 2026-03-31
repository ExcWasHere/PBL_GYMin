<style>
    .cta-section {
        background: var(--gym-dark);
        border-top: 1px solid var(--gym-border);
        border-bottom: 1px solid var(--gym-border);
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%; left: -10%;
        width: 500px; height: 500px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(232,41,42,0.08) 0%, transparent 70%);
        pointer-events: none;
    }
    .cta-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(2.5rem, 6vw, 5rem);
        line-height: 1;
        letter-spacing: 0.02em;
    }
</style>

<section class="cta-section py-24 px-6">
    <div class="max-w-7xl mx-auto text-center reveal">
        <div class="section-tag" style="justify-content:center;margin-bottom:1.25rem;">
            <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
            Bergabung Sekarang
            <span style="width:24px;height:1px;background:var(--gym-red);display:inline-block;"></span>
        </div>
        <h2 class="cta-title" style="margin-bottom:1.25rem;">
            SIAP LATIHAN<br>
            <span style="color:var(--gym-red);">LEBIH EFEKTIF?</span>
        </h2>
        <p style="color:var(--gym-gray);font-size:1rem;font-weight:300;max-width:480px;margin:0 auto 2.5rem;line-height:1.7;">
            Daftar gratis dan mulai gunakan Gym-In hari ini. Tidak perlu kartu kredit.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('register') }}" class="btn-primary" style="padding:16px 40px;font-size:1rem;">Mulai Gratis →</a>
            <a href="{{ route('login') }}"    class="btn-outline" style="padding:15px 36px;font-size:0.9rem;">Sudah Punya Akun</a>
        </div>
    </div>
</section>