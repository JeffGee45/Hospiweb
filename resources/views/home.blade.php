
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospiweb - Votre partenaire santé à Lomé</title>
    <meta name="description" content="Hospiweb est un centre médical de référence à Lomé offrant des soins de qualité avec une équipe médicale expérimentée et des équipements de pointe.">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/hospital-logo.svg') }}" type="image/svg+xml">
    
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body>
    <style>
        :root {
            --primary: #0d6efd;
            --secondary: #6c757d;
            --success: #198754;
            --light: #f8f9fa;
            --dark: #212529;
            --easing: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        /* Hero Section */
        .hero-section {
            background: url('{{ asset('images/hero-bg.jpg') }}');
            background-size: cover;
            background-position: center;
            color: #ffffff;
            padding: 120px 0;
            position: relative;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.8s var(--easing) 0.3s forwards;
        }
        
        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: #fff;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s var(--easing) 0.5s forwards;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            color: rgba(255, 255, 255, 0.9);
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s var(--easing) 0.7s forwards;
        }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .btn-primary {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s var(--easing);
            background-color: #0d6efd;
            border-color: #0d6efd;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s var(--easing) 0.9s forwards;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.6s var(--easing);
            z-index: -1;
        }
        
        .btn-primary:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn-primary:hover {
            background-color: #0b5ed7; /* Bleu légèrement plus foncé au survol */
            border-color: #0a58ca;
        }
        
        .btn-outline-light {
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.4s var(--easing);
            color: #ffffff;
            border-color: #ffffff;
            background-color: transparent;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.8s var(--easing) 1.1s forwards;
        }
        
        .btn-outline-light::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transform: scaleX(0);
            transform-origin: right;
            transition: transform 0.6s var(--easing);
            z-index: -1;
        }
        
        .btn-outline-light:hover::before {
            transform: scaleX(1);
            transform-origin: left;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1); /* Fond blanc légèrement transparent au survol */
            color: #ffffff;
        }
        
        /* Features Section */
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.5s var(--easing);
            height: 100%;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s var(--easing);
            z-index: -1;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(13, 110, 253, 0.1);
        }
        
        .feature-card:hover::before {
            transform: scaleX(1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 2rem;
            color: var(--primary);
        }
        
        /* About Section */
        .about-img {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            position: relative;
            transform: perspective(1000px) rotateY(15deg);
            transition: all 0.6s var(--easing);
        }
        
        .about-img::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(13, 110, 253, 0.2), transparent);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.6s var(--easing);
        }
        
        .about-img img {
            transition: all 0.8s var(--easing);
            width: 100%;
            height: auto;
            transform: scale(1.05);
        }
        
        .about-img:hover {
            transform: perspective(1000px) rotateY(0);
            box-shadow: 0 30px 60px rgba(13, 110, 253, 0.15);
        }
        
        .about-img:hover::before {
            opacity: 1;
        }
        
        .about-img:hover img {
            transform: scale(1.1);
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 2rem;
            font-weight: 700;
            color: var(--dark);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background: var(--primary);
        }
        
        /* Responsive */
        @media (max-width: 991.98px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
        }
        
        @media (max-width: 767.98px) {
            .hero-section {
                padding: 100px 0;
                text-align: center;
            }
            
            .hero-title {
                font-size: 2rem;
            }
            
            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin-bottom: 10px;
            }
        }
        /* Animation des sections au défilement */
        [data-aos] {
            transition: opacity 0.6s var(--easing), transform 0.6s var(--easing);
        }
        
        /* Animation des éléments de la navbar */
        .navbar-nav .nav-item {
            opacity: 0;
            animation: fadeIn 0.5s var(--easing) forwards;
        }
        
        .navbar-nav .nav-item:nth-child(1) { animation-delay: 0.2s; }
        .navbar-nav .nav-item:nth-child(2) { animation-delay: 0.3s; }
        .navbar-nav .nav-item:nth-child(3) { animation-delay: 0.4s; }
        .navbar-nav .nav-item:nth-child(4) { animation-delay: 0.5s; }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Animation des éléments de la grille de services */
        .feature-card {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s var(--easing);
        }
        
        .feature-card.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('images/hospital-logo.svg') }}" alt="Logo Hospiweb" height="40">
                <span class="ms-2 fw-bold"><span style="color: var(--primary);">Hospi</span><span style="color: #111;">web</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
                <div class="ms-lg-3">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
                        @endif
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">Tableau de bord</a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="hero-card p-4 rounded-4 d-flex flex-column align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.8); max-width: 410px; min-height: 270px; margin: 0 auto; border: 1px solid rgba(255, 255, 255, 0.9); backdrop-filter: blur(5px); text-align: center; box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);">
    <h1 class="mb-3 fw-bold" style="color: #111; font-size: 1.7rem; line-height: 1.18;">Bienvenue chez Hospiweb</h1>
    <p class="mb-4" style="color: #333; font-size: 1.08rem;">Votre centre de santé de confiance à Lomé. Accédez facilement à nos soins et services médicaux.</p>
    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-2 w-100">
        <a href="{{ route('login') }}" class="btn btn-primary px-4 py-2 flex-fill" style="font-size: 1rem; background: #0d6efd; border: none;">
            <i class="fas fa-calendar-plus me-2"></i>Prendre rendez-vous
        </a>
        <a href="#services" class="btn btn-outline-primary px-4 py-2 flex-fill" style="font-size: 1rem; background: white; border: 1px solid #0d6efd; color: #0d6efd;">Voir nos services</a>
    </div>
</div>
                                {{-- <i class="fas fa-stethoscope me-2"></i>Découvrir nos services
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="py-5 bg-light" id="services">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="section-title d-inline-block">Nos Services Médicaux</h2>
                <p class="text-muted">Découvrez notre gamme complète de services de santé</p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-stethoscope"></i>
                        </div>
                        <h4>Consultation médicale</h4>
                        <p class="text-muted">Des consultations complètes avec nos médecins spécialistes pour un diagnostic précis.</p>
                        <a href="#" class="btn btn-link p-0">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-flask"></i>
                        </div>
                        <h4>Analyse médicale</h4>
                        <p class="text-muted">Des analyses de laboratoire précises et rapides pour un diagnostic fiable.</p>
                        <a href="#" class="btn btn-link p-0">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-x-ray"></i>
                        </div>
                        <h4>Imagerie médicale</h4>
                        <p class="text-muted">Équipements d'imagerie de pointe pour des examens précis et fiables.</p>
                        <a href="#" class="btn btn-link p-0">En savoir plus <i class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- À propos Section -->
    <section class="py-5" id="about">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="{{ asset('images/about.jpg') }}" alt="À propos de nous" class="img-fluid rounded-3 shadow-sm">
                </div>
                <div class="col-lg-6 ps-lg-5">
                    <h2 class="fw-bold mb-4">À propos de nous</h2>
                    <p class="lead text-muted mb-4">Hospiweb est votre centre médical de confiance à Lomé, offrant des soins de qualité depuis plus de 15 ans.</p>
                    
                    <ul class="list-unstyled mb-4">
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold">Équipe qualifiée</h5>
                                    <p class="text-muted mb-0">Des médecins expérimentés à votre écoute</p>
                                </div>
                            </div>
                        </li>
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle text-primary mt-1 me-3"></i>
                                <div>
                                    <h5 class="mb-1 fw-bold">Équipements modernes</h5>
                                    <p class="text-muted mb-0">Technologie médicale de pointe</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="d-flex gap-3">
                        <a href="#contact" class="btn btn-primary px-4">
                            <i class="fas fa-phone-alt me-2"></i>Contact
                        </a>
                        <a href="#services" class="btn btn-outline-primary px-4">
                            Nos services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section class="py-5 bg-light" id="contact">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <h2 class="section-title mb-4">Contactez-nous</h2>
                    <p class="mb-4">Notre équipe est à votre disposition pour répondre à toutes vos questions et prendre rendez-vous.</p>
                    
                    <div class="mb-4">
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                            </div>
                            <div>
                                <h5>Adresse</h5>
                                <p class="mb-0 text-muted">123 Rue de la Santé, Lomé, Togo</p>
                            </div>
                        </div>
                        
                        <div class="d-flex mb-3">
                            <div class="me-3 text-primary">
                                <i class="fas fa-phone-alt fa-2x"></i>
                            </div>
                            <div>
                                <h5>Téléphone</h5>
                                <p class="mb-0 text-muted">+228 90 00 00 00</p>
                            </div>
                        </div>
                        
                        <div class="d-flex">
                            <div class="me-3 text-primary">
                                <i class="fas fa-envelope fa-2x"></i>
                            </div>
                            <div>
                                <h5>Email</h5>
                                <p class="mb-0 text-muted">contact@hospiweb.tg</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="social-links mt-4">
                        <a href="#" class="text-primary me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                        <a href="#" class="text-primary me-3"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-primary me-3"><i class="fab fa-instagram fa-lg"></i></a>
                        <a href="#" class="text-primary"><i class="fab fa-linkedin-in fa-lg"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="bg-white p-4 p-lg-5 rounded shadow-sm">
                        <h3 class="mb-4">Envoyez-nous un message</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nom complet</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Sujet</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Envoyer le message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Hospiweb</h5>
                    <p class="mb-0">Votre partenaire santé de confiance à Lomé, offrant des soins médicaux de qualité avec une équipe dévouée et des équipements de pointe.</p>
                </div>
                <div class="col-md-3">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home" class="text-white-50 text-decoration-none">Accueil</a></li>
                        <li><a href="#services" class="text-white-50 text-decoration-none">Services</a></li>
                        <li><a href="#about" class="text-white-50 text-decoration-none">À propos</a></li>
                        <li><a href="#contact" class="text-white-50 text-decoration-none">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled text-white-50">
                        <li><i class="fas fa-map-marker-alt me-2"></i> 123 Rue de la Santé, Lomé</li>
                        <li><i class="fas fa-phone-alt me-2"></i> +228 90 00 00 00</li>
                        <li><i class="fas fa-envelope me-2"></i> contact@hospiweb.tg</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} Hospiweb. Tous droits réservés.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white-50"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->

    <script>
        // Ajout de la classe 'scrolled' à la navbar lors du défilement
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
        
        // Animation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Ajout de la classe 'loaded' au body pour l'animation de fondu
            document.body.classList.add('loaded');
            
            // Ajout de la classe 'scrolled' à la navbar si on est déjà en défilement
            if (window.scrollY > 50) {
                document.querySelector('.navbar').classList.add('scrolled');
            }
        });
    </script>
    <script>
        AOS.init();
    </script>
    <script>
        // Animation des cartes de fonctionnalités au défilement
        document.addEventListener('DOMContentLoaded', function() {
            const featureCards = document.querySelectorAll('.feature-card');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            featureCards.forEach(card => {
                observer.observe(card);
                // Ajouter un délai progressif pour chaque carte
                card.style.transitionDelay = `${0.1 * Array.from(card.parentElement.children).indexOf(card)}s`;
            });
            
            // Animation du bouton de défilement vers le haut
            const scrollTopBtn = document.createElement('button');
            scrollTopBtn.innerHTML = '↑';
            scrollTopBtn.className = 'btn btn-primary btn-lg rounded-circle position-fixed bottom-0 end-0 m-4 d-flex align-items-center justify-content-center';
            scrollTopBtn.style.width = '50px';
            scrollTopBtn.style.height = '50px';
            scrollTopBtn.style.opacity = '0';
            scrollTopBtn.style.transition = 'opacity 0.3s ease';
            scrollTopBtn.style.zIndex = '9999';
            document.body.appendChild(scrollTopBtn);
            
            window.addEventListener('scroll', () => {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.style.opacity = '1';
                } else {
                    scrollTopBtn.style.opacity = '0';
                }
            });
            
            scrollTopBtn.addEventListener('click', () => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>

</html>
