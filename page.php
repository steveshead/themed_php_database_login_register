<?php
$page_title = "Blog";
$page = '';
// Include the main.php file
include 'main.php';
require_once 'header.php';
// Check if logged in. If not, redirect to index using function
check_loggedin($pdo);
?>

<section class="blog">
    <div class="container py-5">
        <div class="row mb-3">
            <div class="col-8">
                <span class="text-muted">Internal Page</span>
                <h2 class="fs-1 fw-bold">Internal page only visible if logged in!</h2>
            </div>
        </div>
        <div class="row">
            <!-- Blog entries-->
            <div class="col-lg-8">
                <!-- Featured blog post-->
                <div class="card shadow-sm mb-4">
                    <a href="#!"><img class="card-img-top p-2" src="https://picsum.photos/850/350?random=1" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted">January 1, 2025</div>
                        <h2 class="card-title">Featured Post Title</h2>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam. Dicta expedita corporis animi vero voluptate voluptatibus possimus, veniam magni quis! Dolor sit amet consectetur adipisicing.</p>
                        <a class="btn btn-primary" href="#!">Read more →</a>
                    </div>
                </div>
                <!-- Nested row for non-featured blog posts-->
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Blog post-->
                        <div class="card shadow-sm mb-4">
                            <a href="#!"><img class="card-img-top p-2" src="https://picsum.photos/700/350?random=2" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">February 1, 2025</div>
                                <h2 class="card-title h4">Post Title</h2>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                                <a class="btn btn-primary" href="#!">Read more →</a>
                            </div>
                        </div>
                        <!-- Blog post-->
                        <div class="card shadow-sm mb-4">
                            <a href="#!"><img class="card-img-top p-2" src="https://picsum.photos/700/350?random=3" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">March 1, 2025</div>
                                <h2 class="card-title h4">Post Title</h2>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                                <a class="btn btn-primary" href="#!">Read more →</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Blog post-->
                        <div class="card shadow-sm mb-4">
                            <a href="#!"><img class="card-img-top p-2" src="https://picsum.photos/700/350?random=4" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">April 1, 2025</div>
                                <h2 class="card-title h4">Post Title</h2>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                                <a class="btn btn-primary" href="#!">Read more →</a>
                            </div>
                        </div>
                        <!-- Blog post-->
                        <div class="card shadow-sm   mb-4">
                            <a href="#!"><img class="card-img-top p-2" src="https://picsum.photos/700/350?random=5" alt="..." /></a>
                            <div class="card-body">
                                <div class="small text-muted">May 1, 2025</div>
                                <h2 class="card-title h4">Post Title</h2>
                                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Reiciendis aliquid atque, nulla? Quos cum ex quis soluta, a laboriosam.</p>
                                <a class="btn btn-primary" href="#!">Read more →</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Pagination-->
                <nav aria-label="Pagination">
                    <hr class="my-0" />
                    <ul class="pagination justify-content-center my-4">
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Newer</a></li>
                        <li class="page-item active" aria-current="page"><a class="page-link" href="#!">1</a></li>
                        <li class="page-item"><a class="page-link" href="#!">2</a></li>
                        <li class="page-item"><a class="page-link" href="#!">3</a></li>
                        <li class="page-item disabled"><a class="page-link" href="#!">...</a></li>
                        <li class="page-item"><a class="page-link" href="#!">15</a></li>
                        <li class="page-item"><a class="page-link" href="#!">Older</a></li>
                    </ul>
                </nav>
            </div>
            <!-- Side widgets-->
            <div class="col-lg-4">
                <!-- Search widget-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <div class="input-group">
                            <input class="form-control" type="text" id="searchInput" placeholder="Enter search term..." />
                            <button class="btn btn-primary" id="button-search" type="button">Go!</button>
                        </div>
                    </div>
                </div>

                <div id="searchResults"></div>

                <!-- Categories widget-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Categories</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">Web Design</a></li>
                                    <li><a href="#!">HTML</a></li>
                                    <li><a href="#!">Freebies</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#!">JavaScript</a></li>
                                    <li><a href="#!">CSS</a></li>
                                    <li><a href="#!">Tutorials</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Side widget-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Side Widget One</div>
                    <div class="card-body">You can put anything you want inside of these side widgets. They are easy to use, and feature the Bootstrap 5 card component!</div>
                </div>
                <!-- Side widget-->
                <div class="card shadow-sm mb-4">
                    <div class="card-header">Side Widget Two</div>
                    <div class="card-body">
                        <img class="img-fluid border shadow p-1 me-1  float-end" src="https://picsum.photos/82?random=9" alt="">
                        <img class="img-fluid border shadow p-1 me-1 float-end" src="https://picsum.photos/82?random=10" alt="">
                        <img class="img-fluid border shadow p-1 me-1 float-end" src="https://picsum.photos/82?random=11" alt="">
                        <img class="img-fluid border shadow p-1 mb-1 float-end" src="https://picsum.photos/82?random=12" alt="">
                        <img class="img-fluid border shadow p-1 me-1 mt-1 float-end" src="https://picsum.photos/82?random=13" alt="">
                        <img class="img-fluid border shadow p-1 me-1 mt-1 float-end" src="https://picsum.photos/82?random=14" alt="">
                        <img class="img-fluid border shadow p-1 me-1 mt-1 float-end" src="https://picsum.photos/82?random=15" alt="">
                        <img class="img-fluid border shadow p-1 mb-1 mt-1 float-end" src="https://picsum.photos/82?random=16" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
