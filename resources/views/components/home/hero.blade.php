<style>
    .hero {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
        padding-top: 100px;
        padding-bottom: 60px;
    }

    .hero::after {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 45%;
        height: 100%;
        background: linear-gradient(135deg, transparent 30%, rgba(232, 41, 42, 0.06) 100%);
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
        width: 32px;
        height: 1px;
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
        -webkit-text-stroke: 1px rgba(245, 245, 240, 0.3);
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

    .stat-item {
        border-left: 2px solid var(--gym-red);
        padding-left: 24px;
    }

    .stat-number {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.4rem;
        line-height: 1;
        color: var(--gym-white);
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 0.72rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gym-gray);
        margin-top: 4px;
    }

    .hero-carousel {
        width: 420px;
        height: 420px;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
        border: 1px solid var(--gym-border);
    }

    .carousel-track {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .carousel-img {
        position: absolute;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    .carousel-img.active {
        opacity: 1;
    }
</style>

<section class="hero">
    <div class="max-w-7xl mx-auto px-6 w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="hero-eyebrow">Gym Management Platform</div>
                <h1 class="hero-title">
                    LATIHAN<br>LEBIH<br><span class="outline">SMART</span>
                </h1>
                <p class="hero-desc">
                    Cek rame-sepinya gym, atur jadwal latihan, reservasi slot, catat progress sampai jaga streak, semua udah ada di satu tempat buat kamu.
                </p>

                <div class="flex flex-wrap items-center gap-4 mb-12">
                    <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;font-size:0.9rem;">GYM
                        Yuk</a>
                    <a href="#features" class="btn-outline" style="padding:13px 28px;font-size:0.85rem;">Lihat Fitur</a>
                </div>

                <div class="flex gap-12 mt-4">
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

            <div class="hidden lg:flex justify-center items-center" style="position:relative; transform: translateY(-100px);">
                <div class="hero-carousel">
                    <div class="carousel-track">
                        <img src="/landingPage/gym1.jpg" class="carousel-img active">
                        <img src="/landingPage/gym2.jpg" class="carousel-img">
                        <img src="/landingPage/gym3.jpg" class="carousel-img">
                    </div>
                </div>
            </div>
        </div>
</section>

<script>
    const images = document.querySelectorAll('.carousel-img');
    let index = 0;

    setInterval(() => {
        images[index].classList.remove('active');
        index = (index + 1) % images.length;
        images[index].classList.add('active');
    }, 3000);
</script>