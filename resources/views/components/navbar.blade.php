<style>
    #navbar {
        position: fixed;
        top: 0; left: 0; right: 0;
        z-index: 100;
        transition: background 0.4s ease, border-color 0.4s ease;
        border-bottom: 1px solid transparent;
    }
    #navbar.scrolled {
        background: rgba(10, 10, 10, 0.92);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom-color: var(--gym-border);
    }

    .nav-link {
        color: var(--gym-gray);
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        text-decoration: none;
        transition: color 0.2s;
        position: relative;
    }
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: -4px; left: 0;
        width: 0; height: 1px;
        background: var(--gym-red);
        transition: width 0.3s ease;
    }
    .nav-link:hover { color: var(--gym-white); }
    .nav-link:hover::after { width: 100%; }

    .logo {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: 0.05em;
        color: var(--gym-white);
        text-decoration: none;
    }
    .logo span { color: var(--gym-red); }

    .hamburger {
        width: 28px; height: 20px;
        display: flex; flex-direction: column;
        justify-content: space-between;
        cursor: pointer;
        background: none; border: none; padding: 0;
    }
    .hamburger span {
        display: block; width: 100%; height: 1.5px;
        background: var(--gym-white);
        transition: all 0.3s ease;
        transform-origin: center;
    }
    .hamburger.open span:nth-child(1) { transform: translateY(9px) rotate(45deg); }
    .hamburger.open span:nth-child(2) { opacity: 0; }
    .hamburger.open span:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

    #mobile-menu {
        display: none;
        background: rgba(10, 10, 10, 0.98);
        backdrop-filter: blur(20px);
        border-top: 1px solid var(--gym-border);
    }
    #mobile-menu.open { display: block; }
</style>

<nav id="navbar">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between h-20">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="logo">GYM<span>-IN</span></a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-10">
                <a href="#features"   class="nav-link">Fitur</a>
                <a href="#cara-pakai" class="nav-link">Cara Pakai</a>
                <a href="#kepadatan"  class="nav-link">Kepadatan</a>
                <a href="#tentang"    class="nav-link">Tentang</a>
            </div>

            {{-- Desktop CTA --}}
            <div class="hidden md:flex items-center gap-4">
                <a href="{{ route('login') }}"    class="btn-outline" style="padding:9px 20px;font-size:0.78rem;">Masuk</a>
                <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
            </div>

            {{-- Hamburger --}}
            <button class="hamburger md:hidden" id="hamburger-btn" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu">
        <div class="max-w-7xl mx-auto px-6 py-6 flex flex-col gap-5">
            <a href="#features"   class="nav-link" style="font-size:1rem;letter-spacing:0.05em;text-transform:none;">Fitur</a>
            <a href="#cara-pakai" class="nav-link" style="font-size:1rem;letter-spacing:0.05em;text-transform:none;">Cara Pakai</a>
            <a href="#kepadatan"  class="nav-link" style="font-size:1rem;letter-spacing:0.05em;text-transform:none;">Kepadatan</a>
            <a href="#tentang"    class="nav-link" style="font-size:1rem;letter-spacing:0.05em;text-transform:none;">Tentang</a>
            <div class="divider"></div>
            <a href="{{ route('login') }}"    class="btn-outline" style="text-align:center;">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary"  style="text-align:center;">Daftar Sekarang</a>
        </div>
    </div>
</nav>