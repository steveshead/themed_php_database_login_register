            <section class="shadow bg-body-tertiary rounded">
                <div class="py-3 bg-primary">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-8 mx-auto text-center">
                                <h2 class="my-3 text-white fw-light text-uppercase">Inspired by <span class="text-warning fw-normal">Genius</span> - Driven by <span class="text-warning fw-normal">Passion</span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class="container footer">
                <footer class="pt-5">
                    <div class="row">
                        <div class="col-6 col-md-2 mb-3">
                            <h5>About</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="/" class="nav-link p-0 text-body-secondary">Home</a></li>
                                <li class="nav-item mb-2"><a href="about.php" class="nav-link p-0 text-body-secondary">About</a></li>
                                <li class="nav-item mb-2"><a href="register.php" class="nav-link p-0 text-body-secondary">Register</a> </li>
                                <li class="nav-item mb-2"><a href="profile.php" class="nav-link p-0 text-body-secondary">Profile</a></li>
                                <li class="nav-item mb-2"><a href="contact.php" class="nav-link p-0 text-body-secondary">Contact</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-2 mb-3">
                            <h5>Company</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Products</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Features</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Pricing</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">FAQs</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Articles</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-2 mb-3">
                            <h5>Commerce</h5>
                            <ul class="nav flex-column">
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Store</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Templates</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Testimonials</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Reviews</a></li>
                                <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-body-secondary">Support</a></li>
                            </ul>
                        </div>
                        <div class="col-md-5 offset-md-1 mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <img class="img-fluid border shadow p-1 mb-1 float-end" src="https://picsum.photos/200?random=1" width="85%" alt="">
                                    <img class="img-fluid border shadow p-1 float-end" src="https://picsum.photos/200?random=2" width="85%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <img class="img-fluid border shadow p-1 mb-1" src="https://picsum.photos/200?random=3" width="85%" alt="">
                                    <img class="img-fluid border shadow p-1" src="https://picsum.photos/200?random=4" width="85%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <img class="img-fluid border shadow p-1 mb-1 float-end" src="https://picsum.photos/200?random=5" width="85%" alt="">
                                    <img class="img-fluid border shadow p-1 float-end" src="https://picsum.photos/200?random=6" width="85%" alt="">
                                </div>
                                <div class="col-md-3">
                                    <img class="img-fluid border shadow p-1 mb-1" src="https://picsum.photos/200?random=7" width="85%" alt="">
                                    <img class="img-fluid border shadow p-1" src="https://picsum.photos/200?random=8" width="85%" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column flex-sm-row justify-content-between pt-4 mt-4 border-top">
                        <a href="/">
                            <img src="assets/logos/novus/novus.png" height="36" alt="">
                        </a>
                        <p class="copyright mt-2">&copy; Copyright <?=date('Y')?> Company, Inc. All rights reserved.</p>
                        <ul class="list-unstyled d-flex">
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.facebook.com/<?= isset($_SESSION['facebook']) ? htmlspecialchars($_SESSION['facebook'], ENT_QUOTES) : '' ?>" aria-label="Facebook">
                                    <img src="assets/icons/facebook-blue.svg" alt="">
                                </a>
                            </li>
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.instagram.com/<?= isset($_SESSION['instagram']) ? htmlspecialchars($_SESSION['instagram'], ENT_QUOTES) : '' ?>" aria-label="Instagram">
                                    <img src="assets/icons/instagram-blue.svg" alt="">
                                </a>
                            </li>
                            <li class="ms-3">
                                <a class="link-body-emphasis" href="https://www.x.com/<?= isset($_SESSION['twitter']) ? htmlspecialchars($_SESSION['twitter'], ENT_QUOTES) : '' ?>" aria-label="Twitter">
                                    <img src="assets/icons/twitter-blue.svg" alt="">
                                </a>
                            </li>
                        </ul>
                    </div>
                </footer>
            </div>
        </div>
        <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
        <script src="js/main.js"></script>
        <script>
            const faviconTag = document.getElementById("faviconTag");
            const isDark = window.matchMedia("(prefers-color-scheme: dark)");

            const changeFavicon = () => {
                if (isDark.matches) faviconTag.href = "assets/favicon/favicon_dark_theme.svg";
                else faviconTag.href = "assets/favicon/favicon_light_theme.svg";
            };

            changeFavicon();

            setInterval(changeFavicon, 1000);

        </script>
        <?php
        // Flush the output buffer to ensure all content is sent to the browser
        if (ob_get_level()) ob_end_flush();
        ?>
    </body>
</html>
