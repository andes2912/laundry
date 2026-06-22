<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') · {{ $setpage->judul ?? 'E-Laundry' }}</title>
    <meta name="description" content="@yield('meta_description', 'E-Laundry — solusi manajemen laundry modern. Pelacakan order real-time, pembayaran fleksibel, laporan keuangan otomatis.')">
    <meta name="keywords" content="laundry, e-laundry, aplikasi laundry, manajemen laundry">
    <meta name="author" content="Andri Desmana">

    {{-- Preconnects --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 4 + Feather icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --bg:            #0e1117;
            --bg-elev:       #161b22;
            --bg-elev-2:     #1c2230;
            --border:        #2a3142;
            --text:          #e6edf3;
            --text-muted:    #8b949e;
            --primary:       #7367f0;
            --primary-2:     #9c8cff;
            --accent:        #00d4aa;
            --danger:        #ef4444;
            --warning:       #f59e0b;
            --gradient:      linear-gradient(135deg, #7367f0 0%, #00d4aa 100%);
            --gradient-soft: linear-gradient(135deg, rgba(115,103,240,.15) 0%, rgba(0,212,170,.10) 100%);
            --shadow-lg:     0 20px 60px rgba(115,103,240,.25);
            --radius:        16px;
        }

        [data-theme="light"] {
            --bg:         #ffffff;
            --bg-elev:    #f8fafc;
            --bg-elev-2:  #f1f5f9;
            --border:     #e2e8f0;
            --text:       #0f172a;
            --text-muted: #64748b;
            --shadow-lg:  0 20px 60px rgba(15,23,42,.10);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }
        a { color: var(--primary-2); text-decoration: none; transition: opacity .2s; }
        a:hover { opacity: .85; color: var(--primary-2); }
        .text-muted-c { color: var(--text-muted) !important; }
        .container-x { max-width: 1200px; margin: 0 auto; padding: 0 1.25rem; }

        /* ===== NAVBAR ===== */
        .nav-wrap {
            position: sticky; top: 0; z-index: 100;
            background: rgba(14,17,23,.75);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            backdrop-filter: saturate(180%) blur(14px);
            border-bottom: 1px solid var(--border);
        }
        [data-theme="light"] .nav-wrap { background: rgba(255,255,255,.75); }
        .nav-inner { display:flex; align-items:center; justify-content:space-between; height:72px; }
        .nav-brand {
            font-weight: 800; font-size: 1.25rem; color: var(--text);
            display:flex; align-items:center; gap:.5rem;
        }
        .nav-brand .dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--gradient);
            box-shadow: 0 0 12px var(--primary);
        }
        .nav-brand:hover { color: var(--text); }
        .nav-links { display:flex; gap:1.75rem; align-items:center; }
        .nav-links a { color: var(--text-muted); font-weight: 500; font-size: .95rem; }
        .nav-links a:hover { color: var(--text); }
        .nav-cta { display:flex; gap:.5rem; align-items:center; }

        @media (max-width: 768px) {
            .nav-links { display: none; }
        }

        /* ===== BUTTONS ===== */
        .btn-x {
            display: inline-flex; align-items: center; gap:.5rem;
            padding: .65rem 1.25rem; border-radius: 10px;
            font-weight: 600; font-size: .95rem;
            border: 1px solid transparent;
            transition: transform .15s ease, box-shadow .2s;
            cursor: pointer; text-decoration: none;
        }
        .btn-x:hover { transform: translateY(-1px); }
        .btn-primary-x {
            background: var(--gradient); color: #fff;
            box-shadow: 0 6px 20px rgba(115,103,240,.35);
        }
        .btn-primary-x:hover { color: #fff; box-shadow: 0 10px 28px rgba(115,103,240,.5); }
        .btn-ghost-x {
            background: transparent; color: var(--text);
            border-color: var(--border);
        }
        .btn-ghost-x:hover { background: var(--bg-elev); color: var(--text); }

        /* ===== HERO ===== */
        .hero {
            position: relative; padding: 5rem 0 4rem;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute; top: -200px; left: 50%; transform: translateX(-50%);
            width: 900px; height: 900px;
            background: radial-gradient(circle, rgba(115,103,240,.18) 0%, transparent 60%);
            pointer-events: none;
        }
        .hero-grid {
            display: grid; grid-template-columns: 1.1fr 1fr;
            gap: 4rem; align-items: center; position: relative;
        }
        @media (max-width: 992px) {
            .hero-grid { grid-template-columns: 1fr; gap: 3rem; }
        }
        .hero-pill {
            display: inline-flex; align-items: center; gap:.5rem;
            background: var(--gradient-soft);
            border: 1px solid var(--border);
            padding: .4rem 1rem; border-radius: 999px;
            font-size: .85rem; color: var(--text-muted);
            margin-bottom: 1.5rem;
        }
        .hero-pill .badge-new {
            background: var(--gradient); color: #fff;
            padding: .15rem .5rem; border-radius: 6px;
            font-size: .7rem; font-weight: 700;
        }
        .hero h1 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(2.25rem, 4.5vw, 3.75rem);
            font-weight: 800; line-height: 1.1;
            margin-bottom: 1.25rem;
            letter-spacing: -.02em;
        }
        .hero h1 .grad {
            background: var(--gradient);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero p.lead-x {
            font-size: 1.125rem; color: var(--text-muted);
            margin-bottom: 2rem; max-width: 540px; line-height: 1.6;
        }
        .hero-stats { display:flex; gap:2.5rem; margin-top:2.5rem; }
        .hero-stats .stat strong {
            font-size: 1.75rem; display: block; font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hero-stats .stat span { font-size: .85rem; color: var(--text-muted); }

        /* Tracking card */
        .track-card {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }
        .track-card h3 {
            font-size: 1.1rem; font-weight: 700;
            margin-bottom: .25rem;
        }
        .track-card .small-muted {
            color: var(--text-muted); font-size: .9rem;
            margin-bottom: 1.25rem;
        }
        .track-input {
            display: flex; gap: .5rem;
        }
        .track-input input {
            flex: 1; background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text);
            padding: .85rem 1rem; border-radius: 10px;
            font-size: 1rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .track-input input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(115,103,240,.2);
        }
        .track-result {
            display: none; margin-top: 1.25rem;
            background: var(--bg); border:1px solid var(--border);
            border-radius: 12px; padding: 1rem;
        }
        .track-result.show { display: block; }
        .track-result .row-info { display:flex; justify-content:space-between; padding: .35rem 0; font-size: .9rem; }
        .track-result .row-info span:first-child { color: var(--text-muted); }
        .track-result .status-pill {
            display:inline-block; padding:.25rem .65rem; border-radius:999px;
            font-size:.75rem; font-weight:600;
            background: var(--gradient-soft); color: var(--accent);
        }

        /* ===== SECTIONS ===== */
        .section { padding: 5rem 0; position: relative; }
        .section-head { text-align:center; max-width: 720px; margin: 0 auto 3.5rem; }
        .section-tag {
            display: inline-block; padding: .3rem .85rem; border-radius: 999px;
            background: var(--gradient-soft);
            color: var(--primary-2);
            font-size: .8rem; font-weight: 600;
            letter-spacing: .05em; text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .section-head h2 {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: clamp(1.85rem, 3.5vw, 2.5rem);
            font-weight: 800; margin-bottom: 1rem;
            letter-spacing: -.015em;
        }
        .section-head p { color: var(--text-muted); font-size: 1.05rem; }

        /* Features grid */
        .features-grid { display:grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        @media (max-width: 992px) { .features-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 576px) { .features-grid { grid-template-columns: 1fr; } }
        .feature {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.75rem;
            transition: transform .2s, border-color .2s, box-shadow .2s;
        }
        .feature:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: 0 12px 30px rgba(115,103,240,.15);
        }
        .feature-icon {
            width: 48px; height: 48px; border-radius: 12px;
            background: var(--gradient-soft);
            display:flex; align-items:center; justify-content:center;
            margin-bottom: 1.15rem;
            color: var(--primary-2);
        }
        .feature h4 { font-size: 1.1rem; font-weight: 700; margin-bottom:.5rem; }
        .feature p { color: var(--text-muted); font-size: .95rem; line-height: 1.55; margin: 0; }

        /* Cara kerja */
        .steps-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }
        .step {
            text-align:center; padding: 1.5rem;
            position: relative;
        }
        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--gradient); color:#fff;
            display:flex; align-items:center; justify-content:center;
            font-size: 1.5rem; font-weight: 800;
            margin: 0 auto 1.25rem;
            box-shadow: 0 8px 20px rgba(115,103,240,.4);
        }
        .step h4 { font-size: 1.15rem; font-weight: 700; margin-bottom:.5rem; }
        .step p { color: var(--text-muted); }

        /* Pricing */
        .pricing-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        @media (max-width: 992px) { .pricing-grid { grid-template-columns: 1fr; } }
        .price-card {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 2rem;
            position: relative;
            transition: transform .2s, border-color .2s;
        }
        .price-card:hover { transform: translateY(-4px); }
        .price-card.featured {
            border-color: var(--primary);
            background: linear-gradient(180deg, var(--bg-elev) 0%, rgba(115,103,240,.08) 100%);
            box-shadow: 0 20px 50px rgba(115,103,240,.2);
        }
        .price-badge {
            position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
            background: var(--gradient); color:#fff;
            padding: .25rem .9rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700;
        }
        .price-name { font-size: 1rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; }
        .price-amount { display:flex; align-items: baseline; gap:.35rem; margin: 1rem 0 .35rem; }
        .price-amount strong { font-size: 2.5rem; font-weight: 800; letter-spacing: -.02em; }
        .price-amount small { color: var(--text-muted); font-size: .95rem; }
        .price-desc { color: var(--text-muted); font-size: .9rem; margin-bottom: 1.5rem; min-height: 2.5em; }
        .price-list { list-style: none; padding: 0; margin: 0 0 1.5rem; }
        .price-list li {
            padding: .5rem 0; font-size: .95rem;
            display:flex; gap:.6rem; align-items: flex-start;
        }
        .price-list li svg { color: var(--accent); flex-shrink: 0; margin-top: 3px; }
        .price-list li.dim { color: var(--text-muted); }
        .price-list li.dim svg { color: var(--text-muted); opacity: .5; }

        /* Testimoni */
        .testi-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        @media (max-width: 992px) { .testi-grid { grid-template-columns: 1fr; } }
        .testi {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.75rem;
        }
        .testi-stars { color: var(--warning); margin-bottom: .75rem; font-size: .9rem; }
        .testi-quote { font-size: 1rem; line-height: 1.65; margin-bottom: 1.5rem; }
        .testi-author { display:flex; align-items:center; gap: .85rem; }
        .testi-author .avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--gradient);
            display:flex; align-items:center; justify-content:center;
            color: #fff; font-weight: 700;
        }
        .testi-author strong { display:block; font-size:.95rem; }
        .testi-author span { color: var(--text-muted); font-size: .85rem; }

        /* FAQ */
        .faq { max-width: 800px; margin: 0 auto; }
        .faq-item {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: 12px;
            margin-bottom: .75rem;
            overflow: hidden;
        }
        .faq-q {
            padding: 1.15rem 1.25rem; cursor: pointer;
            display:flex; justify-content:space-between; align-items:center;
            font-weight: 600; font-size: 1rem;
        }
        .faq-q .chev { transition: transform .25s; color: var(--text-muted); }
        .faq-item.open .faq-q .chev { transform: rotate(180deg); color: var(--primary); }
        .faq-a {
            max-height: 0; overflow: hidden;
            transition: max-height .3s ease;
            color: var(--text-muted); padding: 0 1.25rem;
        }
        .faq-item.open .faq-a { max-height: 500px; padding-bottom: 1.25rem; }

        /* CTA */
        .cta-box {
            background: var(--gradient);
            border-radius: 24px;
            padding: 4rem 2rem; text-align:center;
            color: #fff;
            position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,.15), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255,255,255,.1), transparent 50%);
        }
        .cta-box > * { position: relative; }
        .cta-box h2 { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; margin-bottom: 1rem; }
        .cta-box p { font-size: 1.1rem; opacity: .9; margin-bottom: 2rem; }
        .cta-box .btn-x {
            background: #fff; color: var(--primary);
            box-shadow: 0 6px 20px rgba(0,0,0,.15);
        }

        /* Footer */
        .footer-x {
            background: var(--bg-elev);
            border-top: 1px solid var(--border);
            padding: 3rem 0 1.5rem;
        }
        .footer-grid {
            display:grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2rem;
            margin-bottom: 2.5rem;
        }
        @media (max-width: 768px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        .footer-grid h5 { font-size: .95rem; font-weight: 700; margin-bottom: 1rem; }
        .footer-grid p, .footer-grid a { color: var(--text-muted); font-size: .9rem; }
        .footer-grid ul { list-style: none; padding: 0; margin: 0; }
        .footer-grid ul li { padding: .35rem 0; }
        .footer-copy {
            border-top: 1px solid var(--border);
            padding-top: 1.25rem; text-align: center;
            color: var(--text-muted); font-size: .85rem;
        }

        /* WhatsApp float */
        .wa-float {
            position: fixed; right: 20px; bottom: 20px; z-index: 90;
            width: 56px; height: 56px; border-radius: 50%;
            background: #25d366;
            display:flex; align-items:center; justify-content:center;
            box-shadow: 0 8px 24px rgba(37,211,102,.4);
            transition: transform .2s;
        }
        .wa-float:hover { transform: scale(1.08); }
        .wa-float svg { color: #fff; }

        /* Theme toggle button */
        .theme-toggle {
            background: var(--bg-elev); border: 1px solid var(--border);
            color: var(--text);
            width: 40px; height: 40px; border-radius: 10px;
            display:flex; align-items:center; justify-content:center;
            cursor: pointer; transition: background .2s, border-color .2s;
        }
        .theme-toggle:hover { background: var(--bg-elev-2); border-color: var(--primary); }

        /* Reveal animation */
        .reveal { opacity: 0; transform: translateY(20px); transition: opacity .6s, transform .6s; }
        .reveal.in  { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body>

    @yield('content')

    {{-- WhatsApp Float --}}
    @if(!empty($setpage?->whatsapp))
        <a href="https://wa.me/{{ $setpage->whatsapp }}" target="_blank" class="wa-float" title="Chat WhatsApp">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345m-5.446 7.443h-.016c-1.77 0-3.524-.48-5.055-1.38l-.36-.214-3.75.975 1.005-3.645-.239-.375a9.869 9.869 0 0 1-1.516-5.26c0-5.445 4.455-9.885 9.942-9.885 2.654 0 5.145 1.035 7.021 2.91 1.875 1.886 2.909 4.371 2.909 7.021-.004 5.444-4.46 9.885-9.935 9.885M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652a12.062 12.062 0 0 0 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411"/>
            </svg>
        </a>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.1/dist/feather.min.js"></script>

    <script>
        // Init feather icons
        if (window.feather) feather.replace({ 'stroke-width': 1.75 });

        // Theme toggle (localStorage)
        (function() {
            const root = document.documentElement;
            const saved = localStorage.getItem('landing-theme') || 'dark';
            root.setAttribute('data-theme', saved);

            window.toggleTheme = function() {
                const curr = root.getAttribute('data-theme');
                const next = curr === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                localStorage.setItem('landing-theme', next);
                document.querySelectorAll('.theme-toggle-icon').forEach(el => {
                    el.setAttribute('data-feather', next === 'dark' ? 'sun' : 'moon');
                });
                if (window.feather) feather.replace({ 'stroke-width': 1.75 });
            };
        })();

        // FAQ accordion
        document.querySelectorAll('.faq-q').forEach(q => {
            q.addEventListener('click', () => {
                q.parentElement.classList.toggle('open');
            });
        });

        // Reveal on scroll
        const io = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        // CSRF default
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    </script>
    @yield('scripts')
</body>
</html>
