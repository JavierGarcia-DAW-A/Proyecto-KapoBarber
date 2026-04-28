<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico">

    <!-- CSS here -->
    <?php wp_head(); ?>
    <style>
        .nav-menu .nav-btn {
            font-size: 24px !important;
            padding: 10px 15px !important;
        }
    </style>
</head>
<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    <header>
        <!--? Header Start -->
        <div class="header-area header-transparent pt-20">
            <div class="main-header header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logotipo -->
                        <div class="col-auto">
                            <div class="logo">
                                <a href="<?php echo home_url('/'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo/logo.png" alt="Logo" style="max-width: 120px; height: auto;"></a>
                            </div>
                        </div>
                        <div class="col">
                            <div class="menu-main d-flex align-items-center justify-content-between" style="padding-left: 30px;">
                                <!-- Menú Principal -->
                                <div class="main-menu f-right d-none d-lg-block">
<?php get_template_part('nav'); ?>
                                </div>
                                <div class="header-right-btn f-right d-none d-lg-flex" style="align-items: center; gap: 15px;">
                                    <?php if (isset($_COOKIE['kapo_logged_in_user'])): ?>
                                        <a href="/Proyecto-KapoBarber/booking-backend/public/appointments/create" class="btn header-btn" style="margin-bottom: 0;">RESERVE YOUR HAIRCUT</a>

                                        <div style="text-align: center; position: relative;">
                                            <a href="javascript:void(0)" onclick="document.getElementById('user-dropdown-menu').toggleAttribute('hidden');" style="color: #fff; text-decoration: none; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#dcaa63" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user" style="margin-bottom: 5px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                                <div style="font-size: 14px; font-weight: bold; color: #dcaa63; text-transform: uppercase; white-space: nowrap;"><?php echo htmlspecialchars($_COOKIE['kapo_logged_in_user']); ?></div>
                                            </a>
                                            <!-- Dropdown Menu -->
                                            <div id="user-dropdown-menu" hidden style="position: absolute; top: 100%; right: 50%; transform: translateX(50%); background: #1a1a1a; border: 1px solid #333; border-radius: 8px; padding: 10px 0; margin-top: 15px; min-width: 150px; z-index: 1000; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
                                                <a href="/Proyecto-KapoBarber/booking-backend/public/dashboard" style="display: block; padding: 8px 20px; color: #fff; text-decoration: none; font-size: 14px; text-align: center; transition: background 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='transparent'">My Reservations</a>
                                                <div style="height: 1px; background: #333; margin: 5px 0;"></div>
                                                <a href="javascript:void(0)" onclick="handleLogout()" style="display: block; padding: 8px 20px; color: #f87171; text-decoration: none; font-size: 14px; text-align: center; transition: background 0.2s;" onmouseover="this.style.background='#333'" onmouseout="this.style.background='transparent'">Log out</a>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            document.addEventListener('click', function(event) {
                                                const dropdown = document.getElementById('user-dropdown-menu');
                                                if (dropdown) {
                                                    const toggleBtn = dropdown.previousElementSibling;
                                                    if (!dropdown.hasAttribute('hidden') && !dropdown.contains(event.target) && !toggleBtn.contains(event.target)) {
                                                        dropdown.setAttribute('hidden', true);
                                                    }
                                                }
                                            });

                                            function handleLogout() {
                                                fetch('/Proyecto-KapoBarber/booking-backend/public/index.php/logout-custom')
                                                    .then(response => {
                                                        // Fallback just in case
                                                        document.cookie = "kapo_logged_in_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                                        window.location.reload();
                                                    })
                                                    .catch(error => {
                                                        console.error('Error logging out:', error);
                                                        document.cookie = "kapo_logged_in_user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                                                        window.location.reload();
                                                    });
                                            }
                                        </script>
                                    <?php else: ?>
                                        <a href="/Proyecto-KapoBarber/booking-backend/public/login" class="btn header-btn" style="margin-bottom: 0;">RESERVE YOUR HAIRCUT</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>   
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fin de Encabezado -->
    </header>
