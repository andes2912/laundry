<!DOCTYPE html>
<html lang="id" data-theme="dark">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') · {{ $setpage->judul ?? 'E-Laundry' }}</title>
    <meta name="description" content="@yield('meta_description', 'E-Laundry — solusi manajemen laundry modern. Pelacakan order real-time, pembayaran fleksibel, laporan keuangan otomatis.')">
    <meta name="author" content="Andri Desmana">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* ===== FREST DASHBOARD PALETTE ===== */
        :root {
            /* Dark — match dashboard exactly */
            --bg:            #10163a;
            --bg-elev:       #262c49;
            --bg-elev-2:     #1e2447;
            --border:        #414561;
            --text:          #ebeefd;
            --text-muted:    #c2c6dc;
            --text-soft:     #b8c2cc;

            /* Frest brand colors (from dashboard) */
            --primary:       #7367f0;
            --primary-2:     #9c8cff;
            --success:       #28c76f;
            --info:          #00cfe8;
            --warning:       #ff9f43;
            --danger:        #ea5455;

            /* Composed */
            --gradient:      linear-gradient(135deg, #7367f0 0%, #9c8cff 100%);
            --gradient-soft: linear-gradient(135deg, rgba(115,103,240,.18) 0%, rgba(156,140,255,.10) 100%);
            --shadow-lg:     0 20px 60px rgba(115,103,240,.30);
            --radius:        12px;
        }

        [data-theme="light"] {
            /* Light — Frest light palette */
            --bg:         #f8f8f8;
            --bg-elev:    #ffffff;
            --bg-elev-2:  #f4f4f4;
            --border:     #ebe9f1;
            --text:       #6e6b7b;
            --text-muted: #b9b9c3;
            --text-soft:  #6e6b7b;
            --shadow-lg:  0 20px 60px rgba(115,103,240,.12);
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            font-family: 'Montserrat', sans-serif;
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
            background: rgba(16,22,58,.78);
            -webkit-backdrop-filter: saturate(180%) blur(14px);
            backdrop-filter: saturate(180%) blur(14px);
            border-bottom: 1px solid var(--border);
        }
        [data-theme="light"] .nav-wrap { background: rgba(255,255,255,.85); }
        .nav-inner { display:flex; align-items:center; justify-content:space-between; height:72px; }
        .nav-brand {
            font-weight: 700; font-size: 1.25rem; color: var(--text);
            display:flex; align-items:center; gap:.5rem;
        }
        .nav-brand .dot {
            width: 10px; height: 10px; border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 12px var(--primary);
        }
        .nav-brand:hover { color: var(--text); }
        .nav-links { display:flex; gap:1.75rem; align-items:center; }
        .nav-links a { color: var(--text-muted); font-weight: 500; font-size: .95rem; }
        .nav-links a:hover { color: var(--text); }
        .nav-cta { display:flex; gap:.5rem; align-items:center; }

        @media (max-width: 768px) { .nav-links { display: none; } }

        /* ===== BUTTONS ===== */
        .btn-x {
            display: inline-flex; align-items: center; gap:.5rem;
            padding: .65rem 1.25rem; border-radius: 8px;
            font-weight: 600; font-size: .95rem;
            border: 1px solid transparent;
            transition: transform .15s, box-shadow .2s;
            cursor: pointer; text-decoration: none;
        }
        .btn-x:hover { transform: translateY(-1px); }
        .btn-primary-x {
            background: var(--primary); color: #fff;
            box-shadow: 0 4px 14px rgba(115,103,240,.4);
        }
        .btn-primary-x:hover { color: #fff; background: var(--primary-2); box-shadow: 0 8px 22px rgba(115,103,240,.5); }
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
            background: radial-gradient(circle, rgba(115,103,240,.20) 0%, transparent 60%);
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
            background: var(--primary); color: #fff;
            padding: .15rem .5rem; border-radius: 6px;
            font-size: .7rem; font-weight: 700;
        }
        .hero h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2.25rem, 4.5vw, 3.75rem);
            font-weight: 800; line-height: 1.15;
            margin-bottom: 1.25rem; color: var(--text);
            letter-spacing: -.02em;
        }
        .hero h1 .grad {
            color: var(--primary);
        }
        .hero p.lead-x {
            font-size: 1.125rem; color: var(--text-muted);
            margin-bottom: 2rem; max-width: 540px; line-height: 1.6;
        }
        .hero-stats { display:flex; gap:2.5rem; margin-top:2.5rem; }
        .hero-stats .stat strong {
            font-size: 1.75rem; display: block; font-weight: 800;
            color: var(--primary);
        }
        .hero-stats .stat span { font-size: .85rem; color: var(--text-muted); }

        /* Tracking card */
        .track-card {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
        }
        .track-card h3 {
            font-size: 1.1rem; font-weight: 700; color: var(--text);
            margin-bottom: .25rem;
        }
        .track-card .small-muted {
            color: var(--text-muted); font-size: .9rem;
            margin-bottom: 1.25rem;
        }
        .track-input { display: flex; gap: .5rem; }
        .track-input input {
            flex: 1; background: var(--bg);
            border: 1px solid var(--border);
            color: var(--text);
            padding: .85rem 1rem; border-radius: 8px;
            font-size: 1rem;
            transition: border-color .2s, box-shadow .2s;
        }
        .track-input input:focus {
            outline: none; border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(115,103,240,.25);
        }
        .track-result {
            display: none; margin-top: 1.25rem;
            background: var(--bg); border:1px solid var(--border);
            border-radius: 8px; padding: 1rem;
        }
        .track-result.show { display: block; }
        .track-result .row-info { display:flex; justify-content:space-between; padding: .35rem 0; font-size: .9rem; }
        .track-result .row-info span:first-child { color: var(--text-muted); }
        .track-result .status-pill {
            display:inline-block; padding:.25rem .65rem; border-radius:999px;
            font-size:.75rem; font-weight:600;
            background: rgba(40,199,111,.15); color: var(--success);
        }

        /* ===== SECTIONS ===== */
        .section { padding: 5rem 0; position: relative; }
        .section-head { text-align:center; max-width: 720px; margin: 0 auto 3.5rem; }
        .section-tag {
            display: inline-block; padding: .3rem .85rem; border-radius: 999px;
            background: rgba(115,103,240,.15);
            color: var(--primary-2);
            font-size: .8rem; font-weight: 600;
            letter-spacing: .05em; text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .section-head h2 {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1.85rem, 3.5vw, 2.5rem);
            font-weight: 700; margin-bottom: 1rem; color: var(--text);
            letter-spacing: -.015em;
        }
        .section-head p { color: var(--text-muted); font-size: 1.05rem; }

        /* Features grid — uses dashboard's avatar pattern */
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
            box-shadow: 0 8px 24px rgba(115,103,240,.20);
        }
        /* Mimics dashboard's "avatar bg-rgba-*" pattern */
        .feature-icon {
            width: 42px; height: 42px; border-radius: 8px;
            display:flex; align-items:center; justify-content:center;
            margin-bottom: 1.15rem;
        }
        .ic-primary { background: rgba(115,103,240,.15); color: var(--primary); }
        .ic-success { background: rgba(40,199,111,.15); color: var(--success); }
        .ic-info    { background: rgba(0,207,232,.15);  color: var(--info); }
        .ic-warning { background: rgba(255,159,67,.15); color: var(--warning); }
        .ic-danger  { background: rgba(234,84,85,.15);  color: var(--danger); }

        .feature h4 { font-size: 1.1rem; font-weight: 700; margin-bottom:.5rem; color: var(--text); }
        .feature p { color: var(--text-muted); font-size: .95rem; line-height: 1.55; margin: 0; }

        /* Cara kerja */
        .steps-grid { display:grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
        @media (max-width: 768px) { .steps-grid { grid-template-columns: 1fr; } }
        .step { text-align:center; padding: 1.5rem; position: relative; }
        .step-num {
            width: 56px; height: 56px; border-radius: 50%;
            background: var(--primary); color:#fff;
            display:flex; align-items:center; justify-content:center;
            font-size: 1.5rem; font-weight: 700;
            margin: 0 auto 1.25rem;
            box-shadow: 0 6px 18px rgba(115,103,240,.45);
        }
        .step h4 { font-size: 1.15rem; font-weight: 700; margin-bottom:.5rem; color: var(--text); }
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
            box-shadow: 0 16px 40px rgba(115,103,240,.22);
        }
        .price-badge {
            position: absolute; top: -12px; left: 50%; transform: translateX(-50%);
            background: var(--primary); color:#fff;
            padding: .25rem .9rem; border-radius: 999px;
            font-size: .75rem; font-weight: 700;
        }
        .price-name { font-size: .9rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: .05em; }
        .price-amount { display:flex; align-items: baseline; gap:.35rem; margin: 1rem 0 .35rem; color: var(--text); }
        .price-amount strong { font-size: 2.5rem; font-weight: 800; letter-spacing: -.02em; }
        .price-amount small { color: var(--text-muted); font-size: .95rem; }
        .price-desc { color: var(--text-muted); font-size: .9rem; margin-bottom: 1.5rem; min-height: 2.5em; }
        .price-list { list-style: none; padding: 0; margin: 0 0 1.5rem; }
        .price-list li {
            padding: .5rem 0; font-size: .95rem; color: var(--text);
            display:flex; gap:.6rem; align-items: flex-start;
        }
        .price-list li svg { color: var(--success); flex-shrink: 0; margin-top: 3px; }
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
        .testi-quote { font-size: 1rem; line-height: 1.65; margin-bottom: 1.5rem; color: var(--text); }
        .testi-author { display:flex; align-items:center; gap: .85rem; }
        .testi-author .avatar {
            width: 44px; height: 44px; border-radius: 50%;
            background: var(--primary);
            display:flex; align-items:center; justify-content:center;
            color: #fff; font-weight: 700;
        }
        .testi-author strong { display:block; font-size:.95rem; color: var(--text); }
        .testi-author span { color: var(--text-muted); font-size: .85rem; }

        /* FAQ */
        .faq { max-width: 800px; margin: 0 auto; }
        .faq-item {
            background: var(--bg-elev);
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: .75rem;
            overflow: hidden;
        }
        .faq-q {
            padding: 1.15rem 1.25rem; cursor: pointer;
            display:flex; justify-content:space-between; align-items:center;
            font-weight: 600; font-size: 1rem; color: var(--text);
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
            background: var(--primary);
            border-radius: 16px;
            padding: 4rem 2rem; text-align:center;
            color: #fff;
            position: relative; overflow: hidden;
        }
        .cta-box::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,.15), transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255,255,255,.10), transparent 50%);
        }
        .cta-box > * { position: relative; }
        .cta-box h2 { font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 700; margin-bottom: 1rem; color: #fff; }
        .cta-box p { font-size: 1.1rem; opacity: .92; margin-bottom: 2rem; }
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
        @media (max-width: 768px) { .footer-grid { grid-template-columns: 1fr 1fr; } }
        .footer-grid h5 { font-size: .95rem; font-weight: 700; margin-bottom: 1rem; color: var(--text); }
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
            width: 40px; height: 40px; border-radius: 8px;
            display:flex; align-items:center; justify-content:center;
            cursor: pointer; transition: background .2s, border-color .2s;
        }
        .theme-toggle:hover { background: var(--bg-elev-2); border-color: var(--primary); }

        .reveal { opacity: 0; transform: translateY(20px); transition: opacity .6s, transform .6s; }
        .reveal.in  { opacity: 1; transform: translateY(0); }

        /* ===========================================================
           MOBILE OVERRIDES (<=768px)
           - Hero: center content, fix pill wrapping, slim track card
           - Sections (fitur, cara kerja, harga, testimoni): horizontal scroll
           =========================================================== */
        @media (max-width: 768px) {

            /* --- HERO --- */
            .hero { padding: 3rem 0 2.5rem; }
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 2.25rem;
                text-align: center;
            }
            .hero-pill {
                display: inline-flex;
                max-width: 100%;
                font-size: .78rem;
                padding: .35rem .75rem;
                white-space: normal;
                line-height: 1.35;
                text-align: center;
            }
            .hero h1 {
                font-size: 2rem;
                line-height: 1.2;
            }
            .hero h1 br { display: none; } /* let h1 flow naturally on narrow */
            .hero p.lead-x {
                margin-left: auto;
                margin-right: auto;
                font-size: 1rem;
            }
            .hero .d-flex.flex-wrap {
                justify-content: center;
            }
            .hero-stats {
                justify-content: center;
                gap: 1.5rem;
                margin-top: 2rem;
                flex-wrap: wrap;
            }
            .hero-stats .stat strong { font-size: 1.4rem; }

            /* --- TRACK CARD --- */
            .track-card {
                padding: 1.25rem;
                text-align: left;
                box-shadow: 0 10px 30px rgba(115,103,240,.18);
            }
            .track-card h3 { font-size: 1rem; }
            .track-input { flex-direction: column; }
            .track-input input { width: 100%; }
            .track-input button { justify-content: center; width: 100%; }

            /* --- SECTIONS HEAD --- */
            .section { padding: 3rem 0; }
            .section-head { margin-bottom: 2rem; }
            .section-head h2 { font-size: 1.6rem; }
            .section-head p { font-size: .95rem; }

            /* --- HORIZONTAL SCROLL CAROUSEL ---
               Cards: fixed width 80% viewport, snap-scroll, hide scrollbar
               Bleed to viewport edges with negative margin */
            .features-grid,
            .steps-grid,
            .pricing-grid,
            .testi-grid {
                display: flex;
                grid-template-columns: none; /* override desktop grid */
                gap: 1rem;
                overflow-x: auto;
                scroll-snap-type: x mandatory;
                -webkit-overflow-scrolling: touch;
                scroll-padding-left: 1.25rem;
                padding: .5rem 1.25rem 1.25rem;
                margin: 0 -1.25rem; /* bleed to viewport edges */
                scrollbar-width: none;            /* Firefox */
            }
            .features-grid::-webkit-scrollbar,
            .steps-grid::-webkit-scrollbar,
            .pricing-grid::-webkit-scrollbar,
            .testi-grid::-webkit-scrollbar { display: none; } /* Webkit */

            .features-grid > *,
            .steps-grid > *,
            .pricing-grid > *,
            .testi-grid > * {
                flex: 0 0 80%;
                scroll-snap-align: start;
                min-width: 0;
            }
            /* Last card spacer so the right edge has air */
            .features-grid > *:last-child,
            .steps-grid > *:last-child,
            .pricing-grid > *:last-child,
            .testi-grid > *:last-child {
                margin-right: .5rem;
            }
            /* Featured pricing card highlighted */
            .pricing-grid > .price-card.featured { flex: 0 0 85%; }

            /* Subtle hint that user can swipe — a small dotted indicator */
            .section .container-x > .features-grid::after,
            .section .container-x > .steps-grid::after,
            .section .container-x > .pricing-grid::after,
            .section .container-x > .testi-grid::after { content: none; }

            /* --- CTA & FOOTER --- */
            .cta-box { padding: 2.5rem 1.5rem; }
            .cta-box h2 { font-size: 1.5rem; }
            .cta-box p { font-size: 1rem; }
            .footer-grid { grid-template-columns: 1fr; gap: 1.5rem; }
        }

        /* Add a soft "swipe me" hint pill above each scrollable section on mobile */
        @media (max-width: 768px) {
            .swipe-hint {
                display: inline-flex; align-items: center; gap: .35rem;
                font-size: .75rem; color: var(--text-muted);
                padding: .25rem .65rem;
                background: var(--bg-elev); border: 1px solid var(--border);
                border-radius: 999px;
                margin-top: -1.5rem; margin-bottom: 1.5rem;
            }
        }
        @media (min-width: 769px) {
            .swipe-hint { display: none; }
        }
    </style>
</head>
<body>

    @yield('content')

    @if(!empty($setpage?->whatsapp))
        <a href="https://wa.me/{{ $setpage->whatsapp }}" target="_blank" class="wa-float" title="Chat WhatsApp">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17.498 14.382c-.301-.15-1.767-.867-2.04-.966-.273-.101-.473-.15-.673.15-.197.295-.771.964-.944 1.162-.175.195-.349.21-.646.075-.3-.15-1.263-.465-2.403-1.485-.888-.795-1.484-1.77-1.66-2.07-.174-.3-.019-.465.13-.615.136-.135.301-.345.451-.523.146-.181.194-.301.297-.496.1-.21.049-.375-.025-.524-.075-.15-.672-1.62-.922-2.206-.24-.584-.487-.51-.672-.51-.172-.015-.371-.015-.571-.015-.2 0-.523.074-.797.359-.273.3-1.045 1.02-1.045 2.475s1.07 2.865 1.219 3.075c.149.195 2.105 3.195 5.1 4.485.714.3 1.27.48 1.704.629.714.227 1.365.195 1.88.121.574-.091 1.767-.721 2.016-1.426.255-.705.255-1.29.18-1.425-.074-.135-.27-.21-.57-.345m-5.446 7.443h-.016c-1.77 0-3.524-.48-5.055-1.38l-.36-.214-3.75.975 1.005-3.645-.239-.375a9.869 9.869 0 0 1-1.516-5.26c0-5.445 4.455-9.885 9.942-9.885 2.654 0 5.145 1.035 7.021 2.91 1.875 1.886 2.909 4.371 2.909 7.021-.004 5.444-4.46 9.885-9.935 9.885M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652a12.062 12.062 0 0 0 5.71 1.447h.006c6.585 0 11.946-5.336 11.949-11.896 0-3.176-1.24-6.165-3.495-8.411"/>
            </svg>
        </a>
    @endif

    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.1/dist/feather.min.js"></script>
    <script>
        if (window.feather) feather.replace({ 'stroke-width': 1.75 });

        (function() {
            const root = document.documentElement;
            const saved = localStorage.getItem('landing-theme-v2') || 'dark';
            root.setAttribute('data-theme', saved);

            window.toggleTheme = function() {
                const curr = root.getAttribute('data-theme');
                const next = curr === 'dark' ? 'light' : 'dark';
                root.setAttribute('data-theme', next);
                localStorage.setItem('landing-theme-v2', next);
                document.querySelectorAll('.theme-toggle-icon').forEach(el => {
                    el.setAttribute('data-feather', next === 'dark' ? 'sun' : 'moon');
                });
                if (window.feather) feather.replace({ 'stroke-width': 1.75 });
            };
        })();

        document.querySelectorAll('.faq-q').forEach(q => {
            q.addEventListener('click', () => q.parentElement.classList.toggle('open'));
        });

        const io = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('in'); });
        }, { threshold: 0.15 });
        document.querySelectorAll('.reveal').forEach(el => io.observe(el));

        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    </script>
    @yield('scripts')
</body>
</html>
