
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Hospiweb</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Montserrat', Arial, sans-serif; background: #f8fafc; }
        .hero {
            background: linear-gradient(120deg, #e0f7fa 0%, #fff 100%);
            min-height: 60vh;
            display: flex;
            align-items: center;
        }
        .section-title { color: #005f73; font-weight: 700; letter-spacing: 1px; }
        .icon-card { transition: box-shadow .2s; }
        .icon-card:hover { box-shadow: 0 0 24px 0 #b2dfdb; }
        .why-card { background: #e0f2fe; border-radius: 1rem; }
        .footer { background: #005f73; color: #fff; }
        .btn-login { background: #0ea5e9; color: #fff; font-weight: 600; }
        .btn-login:hover { background: #0284c7; color: #fff; }
        .social-icon { color: #0ea5e9; font-size: 1.5rem; margin-right: 1rem; transition: color .2s; }
        .social-icon:hover { color: #005f73; }
    </style>
    <script src="https://kit.fontawesome.com/2d3c5f8e8b.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Bannière -->
    <section class="hero py-5">
        <div class="container text-center">
            <img src="{{ asset('images/hospital-logo.svg') }}" alt="Logo" class="mb-4" style="height:80px;">
            <h1 class="display-4 fw-bold mb-3">Bienvenue à <span style="color:#0ea5e9">Hospiweb</span></h1>
            <p class="lead mb-4">Votre plateforme moderne pour la gestion hospitalière</p>
            <a href="{{ route('login') }}" class="btn btn-login btn-lg shadow">Se connecter</a>
        </div>
    </section>

    <!-- Qui sommes-nous -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-3 text-center">Qui sommes-nous ?</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <p class="fs-5 text-center">L’Hôpital Hospiweb est un établissement de santé moderne, engagé pour le bien-être de ses patients. Notre équipe pluridisciplinaire met tout en œuvre pour offrir des soins de qualité, une prise en charge humaine et des services innovants adaptés à tous les besoins médicaux.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos services -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title mb-4 text-center">Nos services</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center icon-card p-3 h-100">
                        <i class="fas fa-ambulance fa-2x mb-2" style="color:#0ea5e9;"></i>
                        <h6 class="fw-bold">Urgences 24h/24</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center icon-card p-3 h-100">
                        <i class="fas fa-vials fa-2x mb-2" style="color:#0ea5e9;"></i>
                        <h6 class="fw-bold">Laboratoire</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center icon-card p-3 h-100">
                        <i class="fas fa-user-md fa-2x mb-2" style="color:#0ea5e9;"></i>
                        <h6 class="fw-bold">Consultations</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center icon-card p-3 h-100">
                        <i class="fas fa-procedures fa-2x mb-2" style="color:#0ea5e9;"></i>
                        <h6 class="fw-bold">Hospitalisation</h6>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card text-center icon-card p-3 h-100">
                        <i class="fas fa-pills fa-2x mb-2" style="color:#0ea5e9;"></i>
                        <h6 class="fw-bold">Pharmacie</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pourquoi nous choisir -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title mb-4 text-center">Pourquoi nous choisir ?</h2>
            <div class="row justify-content-center g-4">
                <div class="col-md-4">
                    <div class="why-card p-4 h-100 text-center">
                        <i class="fas fa-heartbeat fa-2x mb-2" style="color:#0284c7;"></i>
                        <h6 class="fw-bold mb-2">Soins personnalisés</h6>
                        <p>Chaque patient est unique. Nous adaptons nos soins à vos besoins et à votre situation.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card p-4 h-100 text-center">
                        <i class="fas fa-user-shield fa-2x mb-2" style="color:#0284c7;"></i>
                        <h6 class="fw-bold mb-2">Sécurité & Confidentialité</h6>
                        <p>Vos données et votre santé sont notre priorité, dans le respect du secret médical.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="why-card p-4 h-100 text-center">
                        <i class="fas fa-laptop-medical fa-2x mb-2" style="color:#0284c7;"></i>
                        <h6 class="fw-bold mb-2">Technologie avancée</h6>
                        <p>Plateforme intuitive, rendez-vous en ligne, accès rapide à vos résultats et dossiers.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title mb-4 text-center">Contact</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-4 shadow-sm">
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Avenue Santé, Ville, Pays</p>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> +33 1 23 45 67 89</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i> contact@hospiweb.fr</p>
                        <div class="mt-3">
                            <a href="#" class="social-icon"><i class="fab fa-facebook"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-icon"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer py-3 mt-4">
        <div class="container text-center">
            <small>&copy; {{ date('Y') }} Hospiweb. Tous droits réservés.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
