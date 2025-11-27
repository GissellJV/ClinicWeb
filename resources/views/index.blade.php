@php
    //Determinar plantilla según tipo de usuario logueado

    if (session('tipo_usuario') === 'paciente') {
        $layout = 'layouts.plantilla';
    } elseif (session('tipo_usuario') === 'empleado') {
        switch (session('cargo')) {
        case 'Recepcionista':
        $layout = 'layouts.plantillaRecepcion';
        break;
        case 'Doctor':
        $layout = 'layouts.plantillaDoctor';
        break;
        case 'Enfermero':
        $layout = 'layouts.plantillaEnfermeria';
        break;
        default:
        $layout = 'layouts.plantilla'; // fallback
        }
        } else {
        $layout = 'layouts.plantilla'; // visitante
        }
@endphp

@extends($layout)

@section('contenido')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');
        /* Sistema de calificación con estrellas */
        .star-rating-input {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 8px;
            font-size: 2.5rem;
            margin: 20px 0;
        }

        .star-rating-input .star-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            transition: all 0.2s ease;
            color: #ddd;
        }

        .star-rating-input .star-btn:hover {
            transform: scale(1.2);
        }

        .star-rating-input .star-btn.active {
            color: #ffc107;
        }

        .star-rating-input .star-btn.hover {
            color: #ffc107;
        }

        /* Feedback visual */
        .rating-feedback {
            text-align: center;
            margin-top: 10px;
            font-weight: 600;
            color: #666;
            min-height: 24px;
        }

        /* Modal mejorado */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, #00D9C0 0%, #4EFFF5 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 20px 30px;
        }

        .modal-title {
            font-weight: 700;
            font-size: 1.3rem;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            border-top: 1px solid #e9ecef;
            padding: 20px 30px;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Alerta de acceso denegado */
        .alert-login {
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
        }

        .alert-login strong {
            font-size: 1.1rem;
        }
        :root {
            --primary: #00D9C0;
            --primary-dark: #00A896;
            --primary-light: #4EFFF5;
            --secondary: #FF6B9D;
            --accent: #FFC93C;
            --dark: #0A1828;
            --light: #F0FFFF;
            --text-dark: #1A1A2E;
            --text-light: #5A6C7D;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--white);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* HERO SECTION */
        .hero {
            position: relative;
            height: 100vh;
            min-height: 700px;
            display: flex;
            margin-top: -20px;
            justify-content: center;
            overflow: hidden;
            background: var(--dark);
            align-items: center;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background: url('https://images.unsplash.com/photo-1631217868264-e5b90bb7e133?w=1920&h=1080&fit=crop') center/cover;
            opacity: 0.6;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg,
            rgba(10, 24, 40, 0.75) 0%,
            rgba(0, 168, 150, 0.65) 50%,
            rgba(0, 217, 192, 0.55) 100%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: var(--white);
            padding: 40px 20px;
            max-width: 1200px;
            animation: fadeInUp 1s ease-out;
        }

        .hero-badges {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 10px 24px;
            border-radius: 30px;
            font-size: 0.95rem;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.25);
            transition: all 0.3s;
        }

        .badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-3px);
        }

        .hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 25px;
            line-height: 1.1;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #fff 0%, var(--primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.4rem;
            font-weight: 300;
            margin-bottom: 40px;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-cta {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 16px 45px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1.05rem;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--dark);
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 217, 192, 0.6);
        }

        .btn-secondary {
            background: transparent;
            color: var(--white);
            border: 2px solid var(--white);
        }

        .btn-secondary:hover {
            background: var(--white);
            color: var(--dark);
            transform: translateY(-4px);
        }

        /* STATS */
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            padding: 30px;
            border-radius: 20px;
            text-align: center;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.4s;
        }

        .stat:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-8px) scale(1.05);
            border-color: var(--primary);
            box-shadow: 0 15px 40px rgba(0, 217, 192, 0.3);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 12px;
            filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.2));
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-light);
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 217, 192, 0.5);
        }

        .stat-label {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        /* BOOKING */
        .booking {
            background: linear-gradient(135deg, var(--dark) 0%, #0D2137 100%);
            padding: 100px 20px;
        }

        .booking-form {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(15px);
            padding: 50px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .booking h2 {
            text-align: center;
            color: var(--white);
            font-size: 2.5rem;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .inputs {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .input-group label {
            color: var(--white);
            margin-bottom: 10px;
            font-weight: 500;
            display: block;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 14px 18px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            background: rgba(255, 255, 255, 0.12);
            color: var(--white);
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: var(--primary);
            background: rgba(255, 255, 255, 0.18);
            box-shadow: 0 0 0 3px rgba(0, 217, 192, 0.2);
        }

        .input-group select option {
            background: var(--dark);
        }

        .btn-search {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--dark);
            padding: 16px 60px;
            border: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.4s;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 auto;
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.4);
        }

        .btn-search:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 217, 192, 0.6);
        }

        /* SECTIONS */
        section {
            padding: 100px 20px;
        }

        .section-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .section-subtitle {
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .section-title {
            font-size: 3rem;
            color: var(--text-dark);
            font-weight: 800;
            margin-bottom: 20px;
        }

        .section-description {
            color: var(--text-light);
            font-size: 1.2rem;
            max-width: 650px;
            margin: 0 auto;
        }

        /* SERVICES */
        .services {
            background: linear-gradient(135deg, var(--light) 0%, #E0F7FA 100%);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background: var(--white);
            padding: 45px 35px;
            border-radius: 25px;
            text-align: center;
            transition: all 0.4s;
            border: 2px solid transparent;
            cursor: pointer;
            opacity: 0;
            transform: translateY(50px);
        }

        .service-card.show {
            opacity: 1;
            transform: translateY(0);
        }

        .service-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 45px rgba(0, 217, 192, 0.25);
            border-color: var(--primary);
        }

        .service-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(0, 217, 192, 0.3);
        }

        .service-card:hover .service-icon {
            transform: scale(1.15) rotate(10deg);
            box-shadow: 0 15px 40px rgba(255, 107, 157, 0.4);
        }

        .service-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 18px;
        }

        .service-description {
            color: var(--text-light);
            line-height: 1.7;
            font-size: 1rem;
        }

        /* FEATURES */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 45px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature {
            display: flex;
            gap: 25px;
            opacity: 0;
            transform: translateX(-50px);
        }

        .feature.show {
            opacity: 1;
            transform: translateX(0);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            flex-shrink: 0;
            color: var(--white);
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.3);
        }

        .feature h3 {
            font-size: 1.3rem;
            color: var(--text-dark);
            margin-bottom: 12px;
            font-weight: 700;
        }

        .feature p {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* DOCTORS */
        .doctors {
            background: linear-gradient(135deg, var(--light) 0%, #E0F7FA 100%);
        }

        .doctors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 45px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .doctor-card {
            background: var(--white);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s;
            cursor: pointer;
            opacity: 0;
            transform: scale(0.9);
        }

        .doctor-card.show {
            opacity: 1;
            transform: scale(1);
        }

        .doctor-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 217, 192, 0.3);
        }

        .doctor-img {
            width: 100%;
            height: 380px;
            object-fit: cover;
        }





        .doctor-info {
            padding: 35px;
        }

        .doctor-name {
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .doctor-specialty {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 18px;
            font-size: 1.1rem;
        }

        .doctor-rating {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .stars {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .rating-num {
            color: var(--text-light);
            font-weight: 600;
        }

        .doctor-stats {
            display: flex;
            gap: 25px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .doctor-stat {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
        }

        .btn-book {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--dark);
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 1.05rem;
        }

        .btn-book:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.4);
        }

        /* TESTIMONIALS */
        .testimonials-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .testimonial {
            background: var(--light);
            padding: 40px;
            border-radius: 25px;
            position: relative;
            transition: all 0.4s;
            opacity: 0;
            transform: translateY(30px);
        }

        .testimonial.show {
            opacity: 1;
            transform: translateY(0);
        }

        .testimonial:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 217, 192, 0.2);
        }

        .quote {
            font-size: 4rem;
            color: var(--primary);
            opacity: 0.2;
            position: absolute;
            top: 20px;
            right: 30px;
        }

        .testimonial-text {
            color: var(--text-dark);
            line-height: 1.9;
            margin-bottom: 30px;
            font-style: italic;
            font-size: 1.05rem;
        }

        .author {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .avatar {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            font-weight: 700;
            font-size: 1.3rem;
        }

        .author h4 {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .author p {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* PROMOS */
        .promos {
            background: linear-gradient(135deg, var(--light) 0%, #E0F7FA 100%);
        }

        .promos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .promo {
            background: var(--white);
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
            transition: all 0.4s;
            border: 2px solid transparent;
            opacity: 0;
            transform: scale(0.95);
        }

        .promo.show {
            opacity: 1;
            transform: scale(1);
        }

        .promo:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 217, 192, 0.25);
            border-color: var(--primary);
        }

        .promo-badge {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--white);
            padding: 15px 25px;
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
        }

        .promo-content {
            padding: 35px;
        }

        .promo-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 18px;
        }

        .promo-desc {
            color: var(--text-light);
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .promo-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 25px;
            border-top: 2px solid #e0e0e0;
        }

        .promo-brand {
            color: var(--primary);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .promo-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .promo-link:hover {
            color: var(--secondary);
        }

        /* CTA */
        .cta {
            background: linear-gradient(135deg, var(--dark) 0%, var(--primary-dark) 100%);
            padding: 100px 20px;
            text-align: center;
            color: var(--white);
        }

        .cta h2 {
            font-size: 3rem;
            margin-bottom: 25px;
            font-weight: 800;
        }

        .cta p {
            font-size: 1.4rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }

        /* ANIMATIONS */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.8rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

            .inputs {
                grid-template-columns: 1fr;
            }
        }

        /* Mantener el fondo oscuro */
        .promo-section {
            background: #0f0f0f;      /* <-- FONDO NEGRO COMO ANTES */
            padding: 50px 0;
        }

        /* Centrado y tamaño equilibrado */
        .promo-carousel {
            max-width: 900px;        /* tamaño correcto */
            width: 100%;
            margin: 0 auto;          /* centrado */
        }

        /* Card del carrusel */
        .promo-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #101010;      /* fondo interno */
            border: 4px solid transparent;
            transition: border-color 0.4s ease;
            box-shadow: 0 5px 20px rgba(0,0,0,0.35);
        }

        /* Imagen recortada */
        .promo-img {
            width: 100%;
            height: 330px;
            object-fit: cover;
            object-position: center;
            filter: brightness(0.80); /* más oscura = mejor texto encima */
        }

        /* Texto */
        .promo-text {
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 25px;
            background: linear-gradient(to top, rgba(0,0,0,0.85), transparent);
            color: #fff;
        }

        /* Efecto de iluminación */
        .glow {
            border-color: #4ecdc4 !important;
            box-shadow: 0 0 20px rgba(78,205,196,0.75);
        }

        .carousel-item {
            opacity: 0.8;
            transition: transform 0.6s ease, box-shadow 0.6s ease, opacity 0.6s ease;
            border-radius: 18px;
        }

        .carousel-item.active {
            transform: scale(1.03);
            opacity: 1;

            /* NUEVO EFECTO MÁS POTENTE */
            box-shadow:
                0 0 20px rgba(78, 205, 196, 0.7),
                0 0 45px rgba(78, 205, 196, 0.4),
                0 0 70px rgba(78, 205, 196, 0.25);
            animation: glowPulse 1.8s ease-in-out infinite alternate;
        }

        /* Animación de respiración luminosa */
        @keyframes glowPulse {
            0% {
                box-shadow:
                    0 0 22px rgba(78, 205, 196, 0.7),
                    0 0 40px rgba(78, 205, 196, 0.4),
                    0 0 60px rgba(78, 205, 196, 0.25);
            }
            100% {
                box-shadow:
                    0 0 35px rgba(78, 205, 196, 1),
                    0 0 65px rgba(78, 205, 196, 0.6),
                    0 0 90px rgba(78, 205, 196, 0.4);
            }
        }

        .slider-container {
            position: relative;
            width: 100%;
            display: flex;
            align-items: center;
        }

        .cards-wrapper {
            display: flex;
            gap: 2rem;
            overflow-x: hidden;
            scroll-behavior: smooth;
            padding: 1rem;
        }

        /* Botones */
        .slider-arrow {
            background: transparent;
            border: 2px solid #4ecdc4;
            color: #4ecdc4;
            padding: 12px 15px;
            border-radius: 50%;
            font-size: 1.4rem;
            cursor: pointer;
            transition: all .3s ease;
            box-shadow: 0 0 15px rgba(78,205,196,0.5);
        }

        .slider-arrow:hover {
            background: #4ecdc4;
            color: white;
            box-shadow: 0 0 20px #4ecdc4;
        }

        .left {
            margin-right: 15px;
        }

        .right {
            margin-left: 15px;
        }

        /* Asegura que las cards mantengan tu tamaño actual */
        .cards-wrapper .doctor-card {
            min-width: 360px; /* Ajustable si quieres más pequeño */
        }

        /* Sección */
        .testimonials-section {
            padding: 80px 0;
        }

        /* Carrusel */
        .testimonials-carousel {
            position: relative;
            max-width: 1400px;
            width: 100%;
            display: flex;
            align-items: center;
        }

        /* Botones */
        .carousel-btn {
            background: rgba(78, 205, 196, 0.25);
            border: 2px solid #4ecdc4;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .3s ease;
        }

        .carousel-btn:hover {
            background: #4ecdc4;
            transform: scale(1.12);
        }

        /* Track deslizante */
        .testimonials-track {
            display: flex;
            gap: 20px;
            overflow: hidden;
            width: 100%;
            scroll-behavior: smooth;
        }

        /* Tarjetas */
        .testimonial-card {
            min-width: 300px;
            background: #e8fefe;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.10);
            border: 2px solid transparent;
            transition: all .3s ease;
        }

        .testimonial-card:hover {
            border-color: #4ecdc4;
            transform: translateY(-4px);
        }

        /* Texto */
        .testimonial-text {
            font-size: 1rem;
            color: #333;
            margin-bottom: 25px;
        }

        /* Autor */
        .author {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4ecdc4, #34b5ad);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
        }

        .author-name {
            font-size: 1.1rem;
            margin: 0;
        }

        .author-info {
            font-size: .85rem;
            color: #555;
            margin: 0;
        }
        .service-icon {
            font-size: 2.4rem;
            color: #4ecdc4; /* tu color característico */
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-icon i {
            font-size: 2.6rem;
        }

        .doctor-stat i {
            color: #4ecdc4;
            margin-right: 6px;
            font-size: 1.1rem;
        }

        .doctor-stat i,
        .doctor-rating i {
            color: #4ecdc4;
            margin-right: 4px;
            font-size: 1.2rem;
            transition: 0.3s ease;
        }

        .doctor-rating i:hover {
            transform: scale(1.2);
            color: #34b5ad;
        }


        .testimonials-track {
            display: flex;
            gap: 20px;
            overflow: hidden;
        }
        .testimonial {
            min-width: 100%;
        }
        @media (min-width: 1024px) {
            .testimonial {
                min-width: calc(33.33% - 20px);
            }
        }


        .comentario-widget {
            margin-top: 30px;
            text-align: center;
        }

        /* Botón para abrir */
        .open-comentario-btn {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--dark);
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.4);
            border: none;
            padding: 12px 22px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: 0.25s;
        }

        .open-comentario-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(0, 217, 192, 0.6);
        }

        /* Tarjeta oculta */
        .comentario-card {
            width: 100%;
            max-width: 500px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.12);
            transform: translateY(10px);
            opacity: 0;
            pointer-events: none;
            transition: 0.3s ease;
        }

        .comentario-card.show {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }

        /* Encabezado con X */
        .comentario-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }

        .close-btn {
            background: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        /* Textarea */
        .comentario-card textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: none;
            font-size: 15px;
        }

        /* Botón Enviar */
        .send-comentario-btn {
            width: 100%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
            color: var(--dark);
            box-shadow: 0 8px 25px rgba(0, 217, 192, 0.4);
            padding: 10px 18px;
            border: none;
            font-size: 15px;
            cursor: pointer;
            border-radius: 8px;
            font-weight: 600;
            margin-top: 10px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 7px;
            transition: .25s;
        }

        .send-comentario-btn:hover {
            box-shadow: 0 12px 35px rgba(0, 217, 192, 0.6);
        }
        .hidden {
            display: none;
        }

    </style>

    <!-- HERO -->
    <section id="hero" class="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <div class="hero-badges">
                <span class="badge"> Salud Global</span>
                <span class="badge"> Cuidado del Corazón</span>
            </div>

            <h1>Reserva tu Cita Médica</h1>
            <p>Sigue esta guía simple para registrarte y comenzar a disfrutar de todas las características que ofrecemos
            </p>

            <div class="hero-cta">
                <a href="{{ route('agendarcitas') }}" class="btn btn-primary">Agendar Cita</a>
                <a href="#servicios" class="btn btn-secondary">Explorar Servicios</a>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-icon"></div>
                    <div class="stat-number" data-target="{{ $empleados->count() }}">0</div>
                    <div class="stat-label">Especialistas</div>
                </div>
                <div class="stat">
                    <div class="stat-icon"></div>
                    <div class="stat-number" data-target="{{ $pacientes->count() }}">0</div>
                    <div class="stat-label">Pacientes</div>
                </div>
                <div class="stat">
                    <div class="stat-icon"></div>
                    <div class="stat-number" data-target="{{ $citas->count() }}">0</div>
                    <div class="stat-label">Citas</div>
                </div>

            </div>
        </div>
    </section>

<!-- BOOKING -->
    <!-- BOOKING -->
    <section class="booking">
        <div id="promoCarousel" class="carousel slide promo-carousel" data-bs-ride="carousel">

            <div class="carousel-inner">
                @if(isset($promociones) && count($promociones) > 0)
                    @foreach($promociones as $index => $promocion)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="promo-card glow-target">

                                @if($promocion->imagen)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($promocion->imagen) }}"
                                         class="promo-img"
                                         alt="{{ $promocion->titulo }}">
                                @else
                                    <img src="https://via.placeholder.com/600x400?text=Sin+Imagen"
                                         class="promo-img"
                                         alt="Sin imagen">
                                @endif

                                <div class="promo-text">
                                    <h3>{{ $promocion->titulo }}</h3>
                                    <p>{{ $promocion->descripcion }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="carousel-item active">
                        <div class="promo-card glow-target">
                            <img src="https://via.placeholder.com/600x400?text=No+hay+promociones" class="promo-img">
                            <div class="promo-text">
                                <h3>No hay promociones disponibles</h3>
                                <p>Pronto tendremos nuevas promociones para ti.</p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Controles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#promoCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#promoCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

<!-- SERVICES -->
<section id="servicios" class="services">
    <div class="section-header">
        <p class="section-subtitle">Nuestros Servicios</p>
        <h2 class="section-title">Atención Médica Integral</h2>
        <p class="section-description">Ofrecemos una amplia gama de servicios médicos de alta calidad para cuidar tu
            salud y la de tu familia</p>
    </div>

        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon"><i class="bi bi-heart-pulse-fill"></i></div>
                <h3 class="service-title">Cardiología</h3>
                <p class="service-description">Cuidado especializado del corazón con tecnología de punta y profesionales
                    experimentados</p>
            </div>

            <div class="service-card">
                <div class="service-icon"><i class="bi bi-emoji-smile-fill"></i></div>
                <h3 class="service-title">Pediatría</h3>
                <p class="service-description">Atención integral para el desarrollo y salud de tus hijos desde el
                    nacimiento</p>
            </div>

            <div class="service-card">
                <div class="service-icon"><i class="bi bi-eyedropper"></i></div>
                <h3 class="service-title">Laboratorio Clínico</h3>
                <p class="service-description">Análisis clínicos precisos con equipos modernos y resultados rápidos</p>
            </div>

            <div class="service-card">
                <div class="service-icon"><i class="bi bi-clipboard2-pulse"></i></div>
                <h3 class="service-title">Medicina General</h3>
                <p class="service-description">Consultas médicas generales para diagnóstico y tratamiento de
                    enfermedades comunes</p>
            </div>

            <div class="service-card">
                <div class="service-icon"><i class="bi bi-person-heart"></i></i>
                </div>
                <h3 class="service-title">Odontología</h3>
                <p class="service-description">Cuidado dental completo para mantener tu sonrisa saludable y radiante</p>
            </div>

            <div class="service-card">
                <div class="service-icon"><i class="bi bi-eye-fill"></i></div>
                <h3 class="service-title">Oftalmología</h3>
                <p class="service-description">Exámenes visuales y tratamiento de enfermedades oculares con
                    especialistas</p>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section>
        <div class="section-header">
            <p class="section-subtitle">¿Por Qué Elegirnos?</p>
            <h2 class="section-title">Experiencia y Calidad en Salud</h2>
        </div>

        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon"><i class="bi bi-phone"></i></div>
                <div>
                    <h3>Reservas en Línea</h3>
                    <p>Agenda tus citas fácilmente desde cualquier dispositivo, 24/7</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon"><i class="bi bi-patch-check-fill"></i>
                </div>
                <div>
                    <h3>Profesionales Certificados</h3>
                    <p>Equipo médico altamente calificado con años de experiencia</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                <div>
                    <h3>Atención Rápida</h3>
                    <p>Tiempos de espera mínimos y atención prioritaria</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon"><i class="bi bi-cash-stack"></i></div>
                <div>
                    <h3>Precios Accesibles</h3>
                    <p>Planes de pago flexibles y promociones especiales</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon"><i class="bi bi-shield-lock-fill"></i></div>
                <div>
                    <h3>Privacidad Garantizada</h3>
                    <p>Tus datos médicos están protegidos y seguros</p>
                </div>
            </div>

            <div class="feature">
                <div class="feature-icon"><i class="bi bi-building"></i></div>
                <div>
                    <h3>Instalaciones Modernas</h3>
                    <p>Equipamiento de última generación para tu comodidad</p>
                </div>
            </div>
        </div>
    </section>



    <!-- SECCIÓN DOCTORES -->
    <section id="doctors" class="doctors">
        <div class="section-header">
            <p class="section-subtitle">Nuestro Equipo</p>
            <h2 class="section-title">Conoce a Nuestros Especialistas</h2>
            <p class="section-description">Profesionales de la salud comprometidos con tu bienestar</p>
        </div>

        <div class="slider-container" style="max-width: 1800px; margin: 0 auto; padding: 0 20px; display: flex; align-items: center; gap: 15px;">
            <!-- Botón Izquierda -->
            <button class="slider-arrow left" onclick="scrollDoctors(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>

            <!-- DOCTOR CON SU CALIFICACION -->
        <!-- Contenedor deslizable -->
        <div class="cards-wrapper"  id="doctorsWrapper" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; padding: 1rem 0; scrollbar-width: none; -ms-overflow-style: none;">
            @forelse($doctores as $doctor)
            <div class="doctor-card"  style="min-width: 360px; max-width: 390px; flex-shrink: 0;">
                @if($doctor->foto)
                    <img src="data:image/jpeg;base64,{{ base64_encode($doctor->foto) }}"
                         alt="Foto {{ $doctor->nombre }}"
                         class="doctor-img">
                @else
                    <div class="doctor-photo-placeholder">
                        <i class="bi bi-person-circle"></i>
                    </div>
                @endif

                <div class="doctor-info">
                    <h3 class="doctor-name">{{ $doctor->genero === 'Femenino' ? 'Dra.' : 'Dr.' }} {{ $doctor->nombre }} {{ $doctor->apellido }}</h3>
                    <p class="doctor-specialty">{{ $doctor->departamento === 'Medicina General'
                    ? 'Medicina General'
                    : 'Especialista en ' . $doctor->departamento }}</p>
                    <div class="doctor-rating">
                            <span class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($doctor->promedio_calificacion >= $i)
                                        <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                                    @elseif ($doctor->promedio_calificacion >= $i - 0.5)
                                        <i class="bi bi-star-half" style="color: #ffc107;"></i>
                                    @else
                                        <i class="bi bi-star" style="color: #ddd;"></i>
                                    @endif
                                @endfor
                            </span>
                        <span class="rating-num">{{ number_format($doctor->promedio_calificacion, 1) }} ({{ $doctor->total_calificaciones }} reseñas)</span>
                    </div>
                    <div class="doctor-stats">
                        <span class="doctor-stat"><i class="bi bi-people-fill"></i> 1,200+ pacientes</span>
                        <span class="doctor-stat"><i class="bi bi-calendar-check"></i> 15 años exp.</span>
                    </div>

                    <!-- Botón calificar -->
                    @php $esPaciente = session('tipo_usuario') === 'paciente'; @endphp
                    @if($esPaciente && !$doctor->ya_califico)
                        <button type="button" class="btn-book" data-bs-toggle="modal" data-bs-target="#calificarModal{{ $doctor->id }}">
                            <i class="bi bi-star"></i> Calificar Doctor
                        </button>
                    @elseif($doctor->ya_califico)
                        <button type="button" class="btn-book" disabled style="opacity: 0.6; cursor: not-allowed;">
                            <i class="bi bi-check-circle"></i> Ya calificaste
                        </button>
                    @else
                        <button type="button" class="btn-book" data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                            <i class="bi bi-star"></i> Calificar Doctor
                        </button>
                    @endif
                </div>
            </div>

                    <!-- Modal para calificar (solo pacientes que no han calificado) -->
                    @if($esPaciente && !$doctor->ya_califico)
                        <div class="modal fade" id="calificarModal{{ $doctor->id }}" tabindex="-1" aria-labelledby="calificarModalLabel{{ $doctor->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ route('calificar') }}" method="POST" id="formCalificar{{ $doctor->id }}">
                                        @csrf
                                        <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                                        <input type="hidden" name="estrellas" id="estrellasInput{{ $doctor->id }}" value="0">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="calificarModalLabel{{ $doctor->id }}">
                                                <i class="bi bi-star-fill"></i> Calificar a Dr. {{ $doctor->nombre }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                        </div>

                                        <div class="modal-body">
                                            <label class="form-label text-center d-block mb-3" style="font-size: 1.1rem; font-weight: 600;">
                                                ¿Cómo calificarías tu experiencia?
                                            </label>

                                            <div class="star-rating-input" id="starRating{{ $doctor->id }}">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <button type="button" class="star-btn" data-value="{{ $i }}" data-modal="{{ $doctor->id }}">
                                                        <i class="bi bi-star-fill"></i>
                                                    </button>
                                                @endfor
                                            </div>
                                            <div class="rating-feedback" id="ratingFeedback{{ $doctor->id }}">Selecciona una calificación</div>

                                            <label for="comentario{{ $doctor->id }}" class="form-label mt-3" style="font-weight: 600;">
                                                <i class="bi bi-chat-left-text"></i> Comentario (opcional)
                                            </label>
                                            <textarea class="form-control" id="comentario{{ $doctor->id }}" name="comentario" rows="4"
                                                      placeholder="Cuéntanos sobre tu experiencia..." maxlength="500"
                                                      style="border-radius: 12px; border: 2px solid #e9ecef;"></textarea>
                                            <small class="text-muted">Máximo 500 caracteres</small>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary" id="btnSubmit{{ $doctor->id }}" disabled>
                                                <i class="bi bi-send-fill"></i> Enviar Calificación
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                @empty
                    <div class="alert alert-warning text-center" style="width: 100%; margin: 2rem auto;">
                        <h5>No hay doctores disponibles en este momento.</h5>
                    </div>
                @endforelse
            </div>

            <!-- Botón derecha -->
            <button class="slider-arrow right" onclick="scrollDoctors(1)">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </section>

    <!-- Modal para usuarios no pacientes -->
    <div class="modal fade" id="loginRequiredModal" tabindex="-1" aria-labelledby="loginRequiredModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 100%);">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill"></i> Acceso Restringido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="bi bi-lock-fill" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p><strong>Solo los pacientes pueden calificar doctores</strong></p>
                    <p>Debes iniciar sesión como paciente para poder calificar a nuestros especialistas.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="{{ route('inicioSesion', ['redirect_to' => 'doctors']) }}" class="btn btn-primary">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- ESTILOS ADICIONALES -->
    <style>
        #doctorsWrapper::-webkit-scrollbar { display: none; }
        .doctor-card { flex: 0 0 320px; }
    </style>

    <!-- JS INTERACTIVO -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const feedbackMessages = {
                1: 'Muy insatisfecho',
                2: 'Insatisfecho',
                3: 'Aceptable',
                4: 'Bueno',
                5: 'Excelente'
            };

            // Seleccionar todos los sistemas de estrellas
            const starRatings = document.querySelectorAll('.star-rating-input');

            starRatings.forEach(container => {
                const stars = container.querySelectorAll('.star-btn');
                let selectedRating = 0; // Valor final

                stars.forEach(star => {
                    const value = parseInt(star.dataset.value);
                    const modalId = star.dataset.modal;

                    // Click: seleccionar calificación
                    star.addEventListener('click', function() {
                        selectedRating = value;

                        // Actualizar input hidden
                        const inputEstrellas = document.getElementById(`estrellasInput${modalId}`);
                        inputEstrellas.value = selectedRating;

                        // Actualizar feedback
                        const feedback = document.getElementById(`ratingFeedback${modalId}`);
                        feedback.textContent = feedbackMessages[selectedRating];

                        // Activar botón submit
                        const btnSubmit = document.getElementById(`btnSubmit${modalId}`);
                        btnSubmit.disabled = false;

                        // Actualizar apariencia de estrellas
                        updateStars(stars, selectedRating);
                    });

                    // Hover para preview
                    star.addEventListener('mouseenter', function() {
                        updateStars(stars, value, true);
                    });
                });

                // Mouseleave: restaurar selección
                container.addEventListener('mouseleave', function() {
                    updateStars(container.querySelectorAll('.star-btn'), selectedRating);
                });
            });

            // Función para actualizar las estrellas visualmente
            function updateStars(stars, rating, isHover = false) {
                stars.forEach(star => {
                    const value = parseInt(star.dataset.value);
                    if (value <= rating) {
                        star.classList.add('active');
                        if (isHover) star.classList.add('hover');
                    } else {
                        star.classList.remove('active', 'hover');
                    }
                });
            }

            // Reiniciar formulario al cerrar modal
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function() {
                    const modalId = this.id.replace('calificarModal', '');
                    if (!modalId || modalId === 'loginRequired') return;

                    const stars = this.querySelectorAll('.star-btn');
                    stars.forEach(star => star.classList.remove('active','hover'));

                    const inputEstrellas = document.getElementById(`estrellasInput${modalId}`);
                    const feedback = document.getElementById(`ratingFeedback${modalId}`);
                    const btnSubmit = document.getElementById(`btnSubmit${modalId}`);
                    const comentario = document.getElementById(`comentario${modalId}`);

                    if (inputEstrellas) inputEstrellas.value = '0';
                    if (feedback) feedback.textContent = 'Selecciona una calificación';
                    if (btnSubmit) btnSubmit.disabled = true;
                    if (comentario) comentario.value = '';
                });
            });

        });

    // Slider
        function scrollDoctors(direction){
            const wrapper = document.getElementById("doctorsWrapper");
            const cardWidth = 320 + 32;
            wrapper.scrollBy({ left: direction*cardWidth, behavior:'smooth' });
        }
    </script>


    <!-- TESTIMONIALS -->
    <section id="comentarios" class="testimonials-section">

        <div class="section-header">
            <p class="section-subtitle">Testimonios</p>
            <h2 class="section-title">Lo Que Dicen Nuestros Pacientes</h2>
        </div>

        <!-- Carrusel -->
        <div class="testimonials-carousel">

            <!-- Botón Izquierdo -->
            <button class="carousel-btn left" onclick="moveTestimonial(-1)">
                <i class="bi bi-chevron-left"></i>
            </button>

            <!-- Contenedor deslizable -->
            <div class="testimonials-track">

                @if($comentarios->isEmpty())
                    <!-- Mensaje cuando no hay comentarios -->
                    <div class="testimonial">
                        <div class="quote">"</div>
                        <p class="testimonial-text">Aún no hay testimonios. ¡Sé el primero en dejar el tuyo!</p>
                        <div class="author">
                            <div class="avatar">PT</div>
                            <div>
                                <h4>Nuestros Pacientes</h4>
                                <p>Comparte tu experiencia</p>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($comentarios as $c)
                        <div class="testimonial">
                            <div class="quote">"</div>

                            <p class="testimonial-text">{{ $c->comentario }}</p>

                            <div class="author">
                                <div class="avatar">{{ $c->iniciales }}</div>
                                <div>
                                    <h4>{{ $c->usuario }}</h4>
                                    <p>{{ $c->tiempo }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>

            <!-- Botón Derecho -->
            <button class="carousel-btn right" onclick="moveTestimonial(1)">
                <i class="bi bi-chevron-right"></i>
            </button>

        </div>

        <div class="comentario-area">
            @if(session('tipo_usuario') === 'paciente')

                <div class="comentario-widget">

                    <!-- Botón de abrir -->
                    <button class="open-comentario-btn" onclick="toggleComentario(true)">
                        <i class="bi bi-chat-dots"></i> Agregar comentario
                    </button>

                    <!-- Tarjeta oculta -->
                    <div id="comentarioCard" class="comentario-card hidden">
                        <div class="comentario-card-header">
                            <h4>Nuevo comentario</h4>
                            <button class="close-btn" onclick="toggleComentario(false)">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <form id="formComentario" onsubmit="enviarComentario(event)">
                            @csrf
                            <textarea id="comentarioTextarea" name="comentario" required placeholder="Escribe tu comentario..." rows="3"></textarea>

                            <button type="submit" class="send-comentario-btn" onclick="enviarComentario(event)">
                                <i class="bi bi-send-fill"></i> Publicar
                            </button>
                        </form>
                    </div>

                </div>

            @else
                <p class="text-center mt-3">Debes iniciar sesión como paciente para dejar un comentario.</p>
            @endif
        </div>
    </section>


    <!-- PROMOS -->
    <section class="promos">
        <div class="section-header">
            <p class="section-subtitle">Promociones</p>
            <h2 class="section-title">Ofertas Especiales</h2>
            <p class="section-description">Aprovecha nuestras promociones vigentes y cuida tu salud</p>
        </div>

        <div class="order-controls" style="text-align:right; margin-bottom:20px;">
            <a href="{{ url()->current() }}?orden={{ $orden === 'asc' ? 'desc' : 'asc' }}"
               class="promo-link"
               style="padding:0.5rem 1.5rem; font-size:0.95rem; display:inline-block; text-decoration-line: none; color: #00bfa6 ">
                Ordenar por título: {{ $orden === 'asc' ? 'Z → A' : 'A → Z' }}
            </a>
        </div>

        <!-- Swiper Container -->
        <div class="swiper myPromosSwiper">
            <div class="swiper-wrapper">

                @foreach($publicidades as $pub)
                    <div class="swiper-slide">
                        <div class="promo">
                            <div class="promo-badge">{{ $pub->titulo }}</div>

                            <div class="promo-content">
                                <h3 class="promo-title">{{ $pub->subtitulo }}</h3>
                                <p class="promo-desc">{{ $pub->descripcion }}</p>

                                <div class="promo-footer">
                                    <span class="promo-brand">ClinicWeb</span>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Controles -->
            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </section>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        new Swiper(".myPromosSwiper", {
            loop: true,
            slidesPerView: 1,
            spaceBetween: 20,
            autoplay: {
                delay: 4000,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    </script>

    <!-- CTA -->
    <section class="cta">
        <h2>¿Listo para Cuidar tu Salud?</h2>
        <p>Agenda tu cita hoy y recibe atención médica de calidad</p>
        <a href="{{ route('agendarcitas') }}" class="btn btn-primary">Agendar Cita Ahora</a>
    </section>

    <script>
        // Counter Animation
        function animateCounter(el) {
            const target = parseInt(el.dataset.target);
            const duration = 2000;
            const step = target / (duration / 16);
            let current = 0;

            const timer = setInterval(() => {
                current += step;
                if (current >= target) {
                    el.textContent = target;
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current);
                }
            }, 16);
        }

        // Scroll Reveal
        function reveal() {
            const elements = document.querySelectorAll('.service-card, .feature, .doctor-card, .testimonial, .promo');

            elements.forEach((el, index) => {
                const rect = el.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight - 100;

                if (isVisible) {
                    setTimeout(() => {
                        el.classList.add('show');
                    }, index * 100);
                }
            });
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            // Animate counters
            const counters = document.querySelectorAll('.stat-number[data-target]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounter(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            counters.forEach(counter => observer.observe(counter));

            // Scroll reveal
            window.addEventListener('scroll', reveal);
            reveal();

            // Smooth scroll
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(anchor.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carousel = document.getElementById('promoCarousel');

            carousel.addEventListener('slid.bs.carousel', function () {
                const activeItem = carousel.querySelector('.carousel-item.active .glow-target');

                // Añadir iluminación
                activeItem.classList.add('glow');

                // Quitarla después de 900ms
                setTimeout(() => {
                    activeItem.classList.remove('glow');
                }, 900);
            });
        });
    </script>
    <script>
        const wrapper = document.querySelector(".cards-wrapper");
        const cards = document.querySelectorAll(".doctor-card");
        const cardWidth = cards[0].offsetWidth + 32; // tamaño + gap

        document.querySelector(".right").addEventListener("click", () => {
            wrapper.scrollLeft += cardWidth;
        });

        document.querySelector(".left").addEventListener("click", () => {
            wrapper.scrollLeft -= cardWidth;
        });
    </script>
    <script>
        let pos = 0;

        function moveTestimonial(direction) {
            const track = document.querySelector(".testimonials-track");
            const card = document.querySelector(".testimonial");

            if (!card) return;

            const cardWidth = card.getBoundingClientRect().width + 20;  // +20 por gap

            pos += direction * cardWidth;

            // límite izquierdo
            if (pos < 0) pos = 0;

            // límite derecho
            const maxScroll = track.scrollWidth - track.clientWidth;

            if (pos > maxScroll) pos = maxScroll;

            track.scrollTo({
                left: pos,
                behavior: 'smooth'
            });
        }
    </script>

    <script>
        function toggleComentario(abrir) {
            const card = document.getElementById('comentarioCard');

            if (abrir) {
                card.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.add('show');
                }, 10);
            } else {
                card.classList.remove('show');
                setTimeout(() => {
                    card.classList.add('hidden');
                }, 250);
            }
        }
    </script>

    <script>
        async function enviarComentario(e) {
            e.preventDefault();

            const texto = document.querySelector("#comentarioTextarea").value;

            const formData = new FormData();
            formData.append("comentario", texto);

            const response = await fetch("{{ route('comentarios.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            const data = await response.json();

            if (data.error) {
                alert(data.error);
                return;
            }

            agregarTestimonio(data);
            document.querySelector("#comentarioTextarea").value = "";
            toggleComentario(false);
        }

        function agregarTestimonio(c) {
            const track = document.querySelector(".testimonials-track");

            const card = document.createElement("div");
            card.classList.add("testimonial");

            card.innerHTML = `
        <div class="quote">"</div>
        <p class="testimonial-text">${c.comentario}</p>

        <div class="author">
            <div class="avatar">
                ${c.usuario.substring(0,1).toUpperCase()}
                ${c.usuario.split(" ")[1]?.substring(0,1).toUpperCase() ?? ""}
            </div>
            <div>
                <h4>${c.usuario}</h4>
                <p>${c.tiempo}</p>
            </div>
        </div>
    `;

            track.prepend(card); // Lo agrega al inicio sin recargar
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('scroll_to') === 'doctors')
            setTimeout(function() {
                const doctorsSection = document.getElementById('doctors');
                if (doctorsSection) {
                    doctorsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 500);
            @endif
        });
    </script>
@endsection
