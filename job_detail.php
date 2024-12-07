<?php
include('assets/include/header.php');
include('assets/include/db_connect.php');

$job_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query = "SELECT jobs.title, jobs.location, jobs.job_type, jobs.contract_type, jobs.deadline, jobs.description, jobs.apply_link, companies.company_name, companies.company_logo 
          FROM jobs 
          JOIN companies ON jobs.company_id = companies.company_id 
          WHERE jobs.id = $job_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $job = $result->fetch_assoc();
} else {
  echo "<p>Job details not available.</p>";
  exit;
}
?>
<title><?php echo $job['title']; ?> at <?php echo $job['company_name']; ?></title>

<section class="hero" style="background: url('assets/images/hero_bg.jpg') center/cover no-repeat; height:30vh">
  <div class="hero-overlay"></div>
  <div class="hero-content">
    <h3><?php echo $job['title']; ?> at <?php echo $job['company_name']; ?></h3>
  </div>
</section>

<div class="container my-5">
  <div class="job-details-card" data-aos="fade-right">
    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
    <p><strong>Job Type:</strong> <?php echo $job['job_type']; ?></p>
    <p><strong>Contract Type:</strong> <?php echo $job['contract_type']; ?></p>
    <p><strong>Deadline:</strong> <?php echo date("d F, Y", strtotime($job['deadline'])); ?></p>
    <p><strong>Description: <br></strong> <?php echo nl2br($job['description']); ?></p>
    <a href="<?php echo $job['apply_link']; ?>" target="_blank" class="btn btn-primary">Apply Now</a>
    <div class="share-buttons mt-3">
      Share:
      <a href="https://api.whatsapp.com/send?text=<?php echo urlencode($job['title'] . ' at ' . $job['company_name'] . ': ' . $_SERVER['REQUEST_URI']); ?>"
        target="_blank" class="btn" title="Share on WhatsApp">
        <img width="30" height="30" src="https://img.icons8.com/color/30/whatsapp.png" alt="whatsapp"/>
      </a>

      <a href="https://x.com/intent/tweet?text=<?php echo urlencode($job['title'] . ' at ' . $job['company_name'] . ': ' . $_SERVER['REQUEST_URI']); ?>"
        target="_blank" class="btn" title="Share on X">
        <img width="30" height="30" src="https://img.icons8.com/ios-filled/30/twitterx--v1.png" alt="twitterx--v1"/>
      </a>

      <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
        target="_blank" class="btn" title="Share on LinkedIn">
        <img width="30" height="30" src="https://img.icons8.com/fluency/30/linkedin.png" alt="linkedin"/>
      </a>

      <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
        target="_blank" class="btn" title="Share on Facebook">
        <img width="30" height="30" src="https://img.icons8.com/fluency/30/facebook.png" alt="facebook"/>
      </a>

      <a href="mailto:?subject=<?php echo urlencode('Job Opportunity: ' . $job['title'] . ' at ' . $job['company_name']); ?>&body=<?php echo urlencode($job['title'] . ' at ' . $job['company_name'] . ' - View details here: ' . $_SERVER['REQUEST_URI']); ?>"
        class="btn" title="Share via Email">
        <img width="30" height="30" src="https://img.icons8.com/ios-filled/30/new-post.png" alt="new-post"/>
      </a>
    </div>
  </div>
</div>

<?php
$conn->close();
include('assets/include/footer.php');
?>

<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
  });
</script>
</body>

</html>