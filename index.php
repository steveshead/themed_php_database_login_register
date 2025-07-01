<?php
$page_title = "Home";
$page = '';
// Include the main.php file
include 'main.php';
require_once 'header.php';

// Process form submission
$msg = '';
if (isset($_POST['submit'])) {
    // Validate form inputs
    if (empty($_POST['name'])) {
        $msg = '<div class="alert alert-danger">Please enter your name!</div>';
    } else if (empty($_POST['email'])) {
        $msg = '<div class="alert alert-danger">Please enter your email!</div>';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $msg = '<div class="alert alert-danger">Please enter a valid email!</div>';
    } else if (empty($_POST['subject'])) {
        $msg = '<div class="alert alert-danger">Please enter a subject!</div>';
    } else if (empty($_POST['message'])) {
        $msg = '<div class="alert alert-danger">Please enter your message!</div>';
    } else {
        // All inputs are valid, process the form
        // Send the email using the send_contact_email function from main.php
        $email_sent = send_contact_email($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']);

        if ($email_sent) {
            $msg = '<div class="alert alert-success">Your message has been sent successfully!</div>';
            // Clear form data after successful submission
            $_POST = array();
        } else {
            $msg = '<div class="alert alert-danger">There was a problem sending your message. Please try again later.</div>';
        }
    }
}
?>
      <section>
        <div class="container pb-5">
          <div class="row">
            <div class="col-12 col-lg-6 mx-auto text-center text-lg-start">
              <div class="col-md-8 col-lg-10 mx-auto mx-lg-0 pt-lg-5 pb-4">
                <h2 class="mb-3 fs-1 fw-bold">
                  <span>Welcome,</span>
                  <span class="text-primary"><?= $logged_in ? $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] : 'to our website' ?>. </span>
                  <span>We are very happy that you are here!</span>
                </h2>
                <p class="pe-lg-5 text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis. Quisque vitae nulla malesuada, auctor arcu vitae, luctus nisi.</p>
              </div>
              <div><a class="me-2 btn btn-primary" href="#">Check Now</a><a class="btn btn-outline-primary" href="#">Documentation</a></div>
            </div>
            <div class="col-12 col-lg-6 mt-5 mt-lg-0">
              <div>
                <img class="img-fluid" src="assets/illustrations/work-tv.png" alt="">
              </div>
            </div>
          </div>
        </div>
        <div class="d-none fixed-top top-0 bottom-0" id="sideMenuHeaders07">
          <div class="position-absolute top-0 end-0 bottom-0 start-0 bg-dark" style="opacity: 0.7"></div>
          <nav class="navbar navbar-light position-absolute top-0 bottom-0 start-0 w-75 pt-3 pb-4 px-4 bg-white" style="overflow-y: auto;">
            <div class="d-flex flex-column w-100 h-100">
              <div class="d-flex justify-content-between mb-4">
                <a href="#">
                  <img class="img-fluid" src="assets/logos/novus/novus.png" alt="" width="106">
                </a>
                <button class="btn-close" type="button" data-toggle="side-menu" data-target="#sideMenuHeaders07" aria-controls="sideMenuHeaders07" aria-label="Close"></button>
              </div>
              <div>
                <ul class="navbar-nav mb-4">
                  <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Company</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Features</a></li>
                </ul>
                <div class="border-top pt-4 mb-5"><a class="btn btn-outline-primary w-100 mb-2" href="#">Log in</a><a class="btn btn-primary w-100" href="#">Sign up</a></div>
              </div>
              <div class="mt-auto">
                <p>
                  <span>Get in Touch</span>
                  <a href="#">info@example.com</a>
                </p>
                <a class="me-2" href="#">
                  <img src="assets/icons/facebook-blue.svg" alt="">
                </a>
                <a class="me-2" href="#">
                  <img src="assets/icons/twitter-blue.svg" alt="">
                </a>
                <a class="me-2" href="#">
                  <img src="assets/icons/instagram-blue.svg" alt="">
                </a>
              </div>
            </div>
          </nav>
        </div>
      </section>
                        
      <section>
        <div class="py-5 bg-primary">
          <div class="container">
            <div class="row">
              <div class="col-12 col-md-8 col-lg-6 mx-auto text-center">
                <span class="badge rounded bg-warning">Lorem ipsum</span>
                <h2 class="my-3 fs-1 text-white">Lorem ipsum dolor sit amet consectutar domor</h2>
                <p class="mb-4 text-light">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis. Quisque vitae nulla malesuada, auctor arcu vitae, luctus nisi.</p>
                <div><a class="btn btn-light" href="#">Get Started</a></div>
              </div>
            </div>
          </div>
        </div>
      </section>
                        
      <section class="py-5 position-relative" style="overflow-x: hidden;">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-6">
              <div class="d-none d-lg-block" style="height: 512px;">
                <div class="position-absolute left-0" style="margin-left: -256px;">
                  <img class="img-fluid" src="assets/elements/macbook.png" alt="" style="height: 512px;">
                  <div class="position-absolute" style="top: 5.8%; left: 14.6%; width: 72.8%; height: 76.8%;">
                    <img class="h-100 w-100" style="object-fit: cover;" src="assets/placeholders/novus-dashboard-square.png" alt="">
                  </div>
                </div>
              </div>
              <div class="d-lg-none position-relative">
                <img class="img-fluid" src="assets/elements/macbook.png" alt="">
                <div class="position-absolute" style="top: 5.8%; left: 14.6%; width: 72.8%; height: 76.8%;">
                  <img class="h-100 w-100" style="object-fit: cover;" src="assets/placeholders/metis-dashboard-square.png" alt="">
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-6 mt-4 mt-lg-0">
              <div class="d-flex h-100">
                <div class="row my-auto pl-lg-5">
                  <div class="col-12 col-lg-10">
                    <h2 class="mb-4 fs-1 fw-bold">
                      <span class="fw-normal">Make your</span>
                      <span class="text-primary fw-normal">life easier</span>
                      <span class="fw-normal">for marketing sales and customer support</span>
                    </h2>
                    <p class="text-muted mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis.</p>
                    <a class="btn btn-primary" href="#">Learn more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
                        
      <section class="py-5 bg-light">
        <div class="container">
          <div class="row mb-5">
            <div class="col-12 col-lg-6">
              <h2 class="fs-1 fw-bold">
                <span class="fw-normal">Make your</span>
                <span class="text-primary fw-normal">life easier</span>
                <span class="fw-normal">for marketing sales and customer support</span>
              </h2>
            </div>
            <div class="col-12 col-lg-6 d-flex">
              <p class="my-auto text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis. Quisque vitae nulla malesuada, auctor arcu vitae, luctus nisi. Sed elementum vitae ligula id imperdiet.</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6 col-lg-4 mb-4">
              <div class="p-5 text-center bg-white shadow-sm rounded">
                <div class="d-inline-block py-3 px-4 bg-light rounded-circle text-primary fw-bold">1</div>
                <img class="img-fluid my-4" height="192" src="assets/illustrations/work-tv.png" alt="">
                <h5 class="mb-3">Donec fermentum</h5>
                <p class="text-muted">Sed ac magna sit amet risus tristique interdum at vel velit. In hac habitasse platea dictumst.</p>
              </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-4">
              <div class="p-5 text-center bg-white shadow-sm rounded">
                <div class="d-inline-block py-3 px-4 bg-light rounded-circle text-primary fw-bold">2</div>
                <img class="img-fluid my-4" height="192" src="assets/illustrations/people-watching.png" alt="">
                <h5 class="mb-3">Donec fermentum</h5>
                <p class="text-muted">Sed ac magna sit amet risus tristique interdum at vel velit. In hac habitasse platea dictumst.</p>
              </div>
            </div>
            <div class="col-12 col-lg-4 mb-4">
              <div class="p-5 text-center bg-white shadow-sm rounded">
                <div class="d-inline-block py-3 px-4 bg-light rounded-circle text-primary fw-bold">3</div>
                <img class="img-fluid my-4" height="192" src="assets/illustrations/financial-report.png" alt="">
                <h5 class="mb-3">Donec fermentum</h5>
                <p class="text-muted">Sed ac magna sit amet risus tristique interdum at vel velit. In hac habitasse platea dictumst.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
                        
      <section class="py-5">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-6 d-flex">
              <div class="my-auto">
                <h2 class="mb-4 fs-1 fw-normal">Sed ac magna sit amet risus tristique interdum, at vel velit in hac habitasse platea dictumst.</h2>
                <p class="mb-4 text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis, quam nec venenatis lobortis, mi risus tempus nulla, sed porttitor est nibh at nulla. Praesent placerat enim ut ex tincidunt vehicula. Fusce sit amet dui tellus.</p>
                <a class="btn btn-primary" href="#">Learn More</a>
              </div>
            </div>
            <div class="col-12 col-lg-6 mt-5 mt-lg-0 pt-3 pt-lg-0">
              <ul class="px-lg-5 list-unstyled">
                <li class="d-flex mb-3">
                  <div class="pe-4">
                      <img src="assets/icons/set2/advertisement.png" width="64" alt="">
                  </div>
                  <div>
                    <h4 class="fw-bold">Key Elements</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis.</p>
                  </div>
                </li>
                <li class="d-flex mb-3">
                  <div class="pe-4">
                      <img src="assets/icons/set2/analytics.png" width="64" alt="">
                  </div>
                  <div>
                    <h4 class="fw-bold">Flexible Elements</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis.</p>
                  </div>
                </li>
                <li class="d-flex">
                  <div class="pe-4">
                      <img src="assets/icons/set2/calculation.png" width="64" alt="">
                  </div>
                  <div>
                    <h4 class="fw-bold">Flexible Software</h4>
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed luctus eget justo et iaculis.</p>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>
                        
      <section class="position-relative py-5 bg-primary" style="overflow: hidden; z-index: 1;">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto mb-4 text-center text-lg-left">
              <h2 class="mb-3 fs-1 text-white fw-bold">
                <span class="fw-normal">Lorem ipsum</span>
                <span class="text-warning fw-normal">dolor sit</span>
                <span class="fw-normal">amet, consectetur adipiscing.</span>
              </h2>
              <p class="text-white-50 mb-0">Integer felis tellus, rhoncus ac pulvinar vitae.</p>
            </div>
              <div class="col-12 col-md-8 col-lg-6 mb-4">
                  <ul class="px-lg-5 list-unstyled">
                      <li class="d-flex mb-2">
                          <div class="pe-4">
                              <div class="d-inline-block py-2 px-3 bg-light rounded-circle text-primary fw-bold">1</div>
                          </div>
                          <div>
                              <h4 class="fw-light text-white mt-1">Lorem ipsum <span class="text-warning fw-normal">dolor</span> sit amet tellus pulvinar.</h4>
                          </div>
                      </li>
                      <li class="d-flex mb-2">
                          <div class="pe-4">
                              <div class="d-inline-block py-2 px-3 bg-light rounded-circle text-primary fw-bold">2</div>
                          </div>
                          <div>
                              <h4 class="fw-light text-white mt-1">Integer felis <span class="text-warning fw-normal">tellus</span> rhoncus integer felis elit.</h4>
                          </div>
                      </li>
                      <li class="d-flex mb-2">
                          <div class="pe-4">
                              <div class="d-inline-block py-2 px-3 bg-light rounded-circle text-primary fw-bold">3</div>
                          </div>
                          <div>
                              <h4 class="fw-light text-white mt-1">Rhoncus <span class="text-warning fw-normal">pulvinar</span> vitae lorem ipsum tellus.</h4>
                          </div>
                      </li>
                  </ul>
              </div>
          </div>
          <img class="d-none d-lg-block position-absolute img-fluid top-0 left-0" style="margin-top: -250px; margin-left: -150px; z-index: -5;" src="assets/elements/square-rotated.svg" alt="">
        </div>
      </section>
                        
      <section class="py-5" id="contact-form">
        <div class="container">
          <div class="row">
            <div class="col-12 col-lg-8 mx-auto text-center">
              <div class="row mb-5">
                <h2 class="fs-1 fw-normal">Get in touch!</h2>
                <p>We would love to hear from you</p>
              </div>
              <div class="row">
                <div class="col-6 col-lg-4 mb-5">
                  <span class="text-primary">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                  </span>
                  <h6 class="mb-2 mt-3 text-muted">Phone</h6>
                  <p class="mb-0">+ 1 (408) 555-0088</p>
                  <p>+ 1 (360) 555-8959</p>
                </div>
                <div class="col-6 col-lg-4 mb-5">
                  <span class="text-primary">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                  </span>
                  <h6 class="mb-2 mt-3 text-muted">E-mail</h6>
                  <p class="mb-0">contact@novus.com</p>
                  <p>support@novus.com</p>
                </div>
                <div class="col-12 col-lg-4 mb-5">
                  <span class="text-primary">
                    <svg width="32" height="32" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                  </span>
                  <h6 class="mb-2 mt-3 text-muted">Address</h6>
                  <p class="mb-0">5045 The High Street</p>
                  <p>Portland, OR 97206</p>
                </div>
              </div>
            </div>
          </div>
            <form class="form" method="post" action="index.php#contact-form">
                <div class="row">
                    <div class="col-12 col-lg-8 mx-auto">
                        <?=$msg?>
                        <div class="row">
                      <div class="col-12 col-lg-6 mb-3">
                        <div class="mb-3">
                            <input class="form-control py-2 px-3 bg-light border-0" type="text" name="subject" id="subject" placeholder="Subject" value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES) : '' ?>"/>
                        </div>
                        <div class="mb-3">
                            <input class="form-control py-2 px-3 bg-light border-0" type="text" name="name" id="name" placeholder="Name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : '' ?>"/>
                        </div>
                        <div class="mb-3">
                            <input class="form-control py-2 px-3 bg-light border-0" type="email" name="email" id="email" placeholder="Email Address" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : '' ?>" />
                        </div>
                      </div>
                      <div class="col-12 col-lg-6 mb-3">
                          <textarea class="form-control py-2 px-3 bg-light border-0 h-100" style="resize: none;" name="message" id="message" type="text" placeholder="Your Message" style="height:130px;"><?= isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES) : '' ?></textarea>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <input class="btn btn-primary" type="submit" name="submit" value="Send Message" />
                    </div>
                  </div>
            </div>
          </form>
        </div>
      </section>
                        
<?= require 'footer.php'; ?>
