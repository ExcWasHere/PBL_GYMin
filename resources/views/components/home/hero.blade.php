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

    /* Pills */
    .feature-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 2.5rem;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255, 255, 255, 0.04);
        border: 0.5px solid rgba(255, 255, 255, 0.12);
        border-radius: 100px;
        padding: 7px 14px;
        font-size: 0.78rem;
        font-weight: 400;
        color: rgba(245, 245, 240, 0.75);
        transition: all 0.2s;
    }

    .pill:hover {
        background: rgba(232, 41, 42, 0.1);
        border-color: rgba(232, 41, 42, 0.35);
        color: var(--gym-white);
    }

    .pill-dot {
        width: 5px;
        height: 5px;
        border-radius: 50%;
        background: var(--gym-red);
        flex-shrink: 0;
    }

    /* Stats */
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

    /* Carousel */
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

    /* Responsive */
    @media (max-width: 1024px) {
        .hero-carousel {
            width: 340px;
            height: 340px;
        }
    }

    @media (max-width: 768px) {
        .hero {
            padding-top: 80px;
            padding-bottom: 48px;
        }

        .hero::after {
            display: none;
        }

        .hero-title {
            font-size: clamp(3.2rem, 14vw, 5rem);
            margin-bottom: 1.2rem;
        }

        .feature-pills {
            gap: 8px;
            margin-bottom: 2rem;
        }

        .pill {
            font-size: 0.72rem;
            padding: 6px 12px;
        }

        .stat-number {
            font-size: 1.9rem;
        }
    }

    @media (max-width: 480px) {
        .hero {
            padding-top: 72px;
            padding-bottom: 40px;
        }

        .hero-title {
            font-size: clamp(2.8rem, 16vw, 4rem);
        }

        .stat-number {
            font-size: 1.6rem;
        }

        .stat-label {
            font-size: 0.62rem;
        }
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

                <div class="feature-pills">
                    <span class="pill"><span class="pill-dot"></span>Pantau kepadatan gym real-time</span>
                    <span class="pill"><span class="pill-dot"></span>Reservasi dengan QR</span>
                    <span class="pill"><span class="pill-dot"></span>Diary Latihan</span>
                    <span class="pill"><span class="pill-dot"></span>Reward setiap latihan</span>
                    <span class="pill"><span class="pill-dot"></span>Semua dalam satu app</span>
                </div>

                <div class="flex flex-wrap items-center gap-4 mb-12">
                    <a href="{{ route('register') }}" class="btn-primary" style="padding:14px 32px;font-size:0.9rem;">GYM Yuk!</a>
                    <a href="#features" class="btn-outline" style="padding:13px 28px;font-size:0.85rem;">Lihat Fitur</a>
                </div>

                <div class="flex gap-8 sm:gap-12 mt-4 flex-wrap">
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
                        <img src="/landingPage/gym1.jpg" class="carousel-img active" alt="Gym">
                        <img src="/landingPage/gym2.jpg" class="carousel-img" alt="Gym">
                        <img src="/landingPage/gym3.jpg" class="carousel-img" alt="Gym">
                    </div>
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