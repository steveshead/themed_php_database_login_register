<?php
$page_title = "About Us";
$page = '';
// Include the main.php file
include 'main.php';
require_once 'header.php';

?>
        <!-- Hero Section -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h1 class="mb-3 fw-bold">Learn <span class="text-primary">more about</span><br>our company</h1>
                        <p class="lead">We are passionate about delivering exceptional solutions that transform businesses and create lasting impact in the digital world.</p>
                        <p class="lead">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                        <a class="btn btn-primary me-3" href="#">Learn More</a><a class="btn btn-outline-primary" href="#">Contact Us</a>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid rounded" src="assets/illustrations/financial-report.png" alt="About us hero image"/>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Content Section -->
        <section class="py-5 bg-primary text-white">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <h2 class="mb-3 fs-1 fw-bold text-center"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                            </svg> This is where we began...</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda temporibus harum unde! Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Mission & Values Section -->
        <section class="py-5 bg-light border">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <h2 class="fw-bold">Our Mission</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda temporibus harum unde! We strive to deliver innovative solutions that exceed expectations.</p>
                        <div class="d-flex align-content-center">
                            <img class="img-fluid rounded mt-3 mx-auto" src="assets/illustrations/work-tv.png" width="500" alt="Mission image"/>
                        </div>

                    </div>
                    <div class="col-lg-6 mb-4">
                        <h2 class="fw-bold">Our Values</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda temporibus harum unde! Integrity, innovation, and excellence guide everything we do.</p>
                        <div class="d-flex align-content-center">
                            <img class="img-fluid rounded mt-3 mx-auto" src="assets/illustrations/people-watching.png" width="500" alt="Values image"/>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Team Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5">Meet Our Team</h2>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-3 about-image shadow" src="images/avatar/default_avatar.png" alt="Team member 1" style="width: 200px; height: 200px;"/>
                            <h4>John Doe</h4>
                            <p class="text-muted">CEO & Founder</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-3 about-image shadow" src="images/avatar/avatar-1.jpg" alt="Team member 2" style="width: 200px; height: 200px;"/>
                            <h4>Jane Smith</h4>
                            <p class="text-muted">CTO</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-3 about-image shadow" src="images/avatar/avatar-2.jpg" alt="Team member 3" style="width: 200px; height: 200px;"/>
                            <h4>Mike Johnson</h4>
                            <p class="text-muted">Lead Developer</p>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Company Stats Section -->
        <section class="py-5 bg-primary text-white">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h1 class="display-4">100+</h1>
                        <p>Projects Completed</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h1 class="display-4">50+</h1>
                        <p>Happy Clients</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h1 class="display-4">5+</h1>
                        <p>Years Experience</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h1 class="display-4">24/7</h1>
                        <p>Support Available</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Call to Action Section -->
        <section class="py-5">
            <div class="container py-5">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2>Ready to Work With Us?</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ea sit eaque totam aliquid veritatis assumenda temporibus harum unde! Let's create something amazing together.</p>
                        <a class="btn btn-primary" href="#">Get Started</a>
                    </div>
                </div>
            </div>
        </section>

<?php require 'footer.php'; ?>
