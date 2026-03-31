<style>
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding-top: 80px;
    }
    .hero::after {
        content: '';
        position: absolute;
        top: 0; right: 0;
        width: 45%; height: 100%;
        background: linear-gradient(135deg, transparent 30%, rgba(232,41,42,0.06) 100%);
        clip-path: polygon(25% 0, 100% 0, 100% 100%, 0% 100%);
        pointer-events: none;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-size: 0.72rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--gym-red);
        margin-bottom: 1.5rem;
    }
    .hero-eyebrow::before {
        content: '';
        display: block;
        width: 32px; height: 1px;
        background: var(--gym-red);
    }

    .hero-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: clamp(4rem, 10vw, 9rem);
        line-height: 0.92;
        letter-spacing: 0.02em;
        margin-bottom: 1.8rem;
    }
    .hero-title .outline {
        -webkit-text-stroke: 1px rgba(245,245,240,0.3);
        color: transparent;
    }

    .hero-desc {
        color: var(--gym-gray);
        font-size: 1rem;
        line-height: 1.75;
        max-width: 420px;
        margin-bottom: 2.5rem;
        font-weight: 300;
    }

    .stat-item { border-left: 2px solid var(--gym-red); padding-left: 16px; }
    .stat-number {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.4rem;
        line-height: 1;
        color: var(--gym-white);
    }
    .stat-label {
        font-size: 0.72rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gym-gray);
        margin-top: 4px;
    }

    /* Hero visual */
    .hero-circle {
        width: 420px; height: 420px;
        border-radius: 50%;
        background: radial-gradient(circle at 40% 40%, rgba(232,41,42,0.15), transparent 65%),
                    conic-gradient(from 0deg, var(--gym-border), #1a1a1a, var(--gym-border));
        border: 1px solid var(--gym-border);
        display: flex; align-items: center; justify-content: center;
        animation: spin-slow 30s linear infinite;
    }
    .hero-inner-circle {
        width: 300px; height: 300px;
        border-radius: 50%;
        background: var(--gym-dark);
        border: 1px solid #2a2a2a;
        display: flex; align-items: center; justify-content: center;
        animation: spin-slow 30s linear infinite reverse;
    }
    .hero-icon-center {
        font-size: 5rem;
        animation: spin-slow 30s linear infinite;
    }

    .badge-float {
        position: absolute;
        background: var(--gym-card);
        border: 1px solid var(--gym-border);
        padding: 12px 16px;
        font-size: 0.75rem;
    }
    .badge-float .badge-val { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; color: var(--gym-red); display: block; }
    .badge-float .badge-lbl { color: var(--gym-gray); letter-spacing: 0.08em; text-transform: uppercase; }
</style>

<section class="hero">
    <div class="max-w-7xl mx-auto px-6 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- Left: Copy --}}
            <div>
                <div class="hero-eyebrow">Gym Management Platform</div>
                <h1 class="hero-title">
                    LATIHAN<br>LEBIH<br><span class="outline">SMART</span>
                </h1>
                <p class="hero-desc">
                    Pantau kepadatan gym, atur jadwal latihan, catat progres, dan kumpulkan streak — semua dalam satu platform yang dirancang untuk kamu.
                </p>

                <div class="flex flex-wrap items-center gap-4 mb-12">
                    <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;font-size:0.9rem;">Mulai Gratis</a>
                    <a href="#features" class="btn-outline" style="padding:13px 28px;font-size:0.85rem;">Lihat Fitur →</a>
                </div>

                <div class="flex gap-8">
                    <div class="stat-item">
                        <div class="stat-number">2.4K+</div>
                        <div class="stat-label">Member Aktif</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">98%</div>
                        <div class="stat-label">Kepuasan User</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Live Monitor</div>
                    </div>
                </div>
            </div>

            {{-- Right: Visual --}}
            <div class="hidden lg:flex justify-center items-center" style="position:relative;">
                <div class="hero-circle">
                    <div class="hero-inner-circle">
                        <div class="hero-icon-center">🏋️</div>
                    </div>
                </div>

                <div class="badge-float" style="top:10%;left:0;clip-path:polygon(0 0,calc(100% - 6px) 0,100% 6px,100% 100%,0 100%);">
                    <span class="badge-val">🔥 12</span>
                    <span class="badge-lbl">Hari Streak</span>
                </div>
                <div class="badge-float" style="bottom:15%;right:0;clip-path:polygon(0 0,100% 0,100% calc(100% - 6px),calc(100% - 6px) 100%,0 100%);">
                    <span class="badge-val" style="color:#22c55e;">47%</span>
                    <span class="badge-lbl">Gym Capacity</span>
                </div>
                <div class="badge-float" style="bottom:40%;left:-20px;clip-path:polygon(6px 0,100% 0,100% 100%,0 100%,0 6px);">
                    <span class="badge-val" style="color:#f59e0b;">+2kg</span>
                    <span class="badge-lbl">Muscle Gain</span>
                </div>
            </div>

        </div>
    </div>
</section>