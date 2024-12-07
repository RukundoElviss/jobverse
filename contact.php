<?php 
include('assets/include/header.php'); 
include('assets/include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
    
    if (mysqli_query($conn, $query)) {
        $success_message = "Your message has been sent successfully!";
    } else {
        $error_message = "There was an error sending your message. Please try again.";
    }
}
?>

<title>Contact Us - Jobverse Uganda</title>

<section class="hero" style="background: url('assets/images/hero_bg.jpg') center/cover no-repeat;">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h1>Contact Us</h1>
  </div>
</section>

<section id="contact" class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-4">
        <div class="card shadow-lg border-0 rounded-lg" data-bs-aos="fade-up" data-bs-aos-delay="400">
          <div class="card-body p-4">
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php elseif (isset($error_message)): ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <h5 class="card-title text-center"></h5>
            <div class="col text-center">
              <p class="lead">We'd love to hear from you. Send Us a message for any queries or support!</p>
            </div>
            <form action="contact.php" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
              </div>
              <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="15" placeholder="Write your message" required></textarea>
              </div>
              <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include('assets/include/footer.php'); ?>

<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>