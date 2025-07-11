<?php
$page_title = "Contact Us";
$page = '';
// Include the main.php file
include 'main.php';
require_once 'header.php';
// Template code below

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

<section class="py-5">
    <div class="container p-5">
        <div class="row">
            <div class="col-12 col-lg-6 mb-5">
                <div class="row mb-5">
                    <div class="col-8">
                        <span class="text-muted">Contact Us</span>
                        <h2 class="fs-1 fw-bold">We would love to hear from you!</h2>
                    </div>
                </div>
                <div class="mb-4">
                    <h5 class="text-muted">Phone</h5>
                    <p>+ 1 (408) 555-0088</p>
                </div>
                <div class="mb-4">
                    <h5 class="text-muted">E-mail</h5>
                    <p>info@novus.com</p>
                </div>
                <div>
                    <h5 class="text-muted">Address</h5>
                    <p>5045 The High Street,<br>Portland, OR, 97206</p>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <h2 class="fs-1 fw-bold py-4">Send Us A Message</h2>
                <form class="form" method="post" action="contact.php">
                    <?=$msg?>

                    <div class="mb-3">
                        <input class="form-control py-2 px-3 bg-light border" type="text" name="name" id="name" placeholder="Name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES) : '' ?>"/>
                    </div>
                    <div class="mb-3">
                        <input class="form-control py-2 px-3 bg-light border" type="email" name="email" id="email" placeholder="Email Address" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : '' ?>" />
                    </div>
                    <div class="mb-3">
                        <input class="form-control py-2 px-3 bg-light border" type="text" name="subject" id="subject" placeholder="Subject" value="<?= isset($_POST['subject']) ? htmlspecialchars($_POST['subject'], ENT_QUOTES) : '' ?>"/>
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control py-2 px-3 bg-light border" name="message" id="message" type="text" placeholder="Your Message" style="height:130px;"><?= isset($_POST['message']) ? htmlspecialchars($_POST['message'], ENT_QUOTES) : '' ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <input class="btn btn-primary" type="submit" name="submit" value="Send Message" />
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require 'footer.php'; ?>
