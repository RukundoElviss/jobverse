<?php
include('assets/include/db_connect.php');

$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

$limit = 30;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = "SELECT jobs.id, jobs.title, jobs.location, jobs.job_type, jobs.contract_type, jobs.deadline, companies.company_name, companies.company_logo 
          FROM jobs 
          JOIN companies ON jobs.company_id = companies.company_id 
          WHERE jobs.title LIKE ? OR companies.company_name LIKE ? 
          ORDER BY jobs.created_at DESC 
          LIMIT $start, $limit";

$stmt = $conn->prepare($query);
$search_param = "%" . $search_query . "%";
$stmt->bind_param("ss", $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();

$total_query = "SELECT COUNT(*) as total FROM jobs 
                JOIN companies ON jobs.company_id = companies.company_id 
                WHERE jobs.title LIKE ? OR companies.company_name LIKE ?";
$total_stmt = $conn->prepare($total_query);
$total_stmt->bind_param("ss", $search_param, $search_param);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_jobs = $total_row['total'];
$total_pages = ceil($total_jobs / $limit);
?>

<title><?php echo "for " . (isset($_GET['search_query']) ? $_GET['search_query'] : ''); ?></title>

<?php include('assets/include/header.php'); ?>

<section class="hero" style="background: url('assets/images/hero_bg.jpg') center/cover no-repeat;">
  <div class="hero-overlay"></div>
  <div class="hero-content">
  <h1>Search Results <?php echo "for " . (isset($_GET['search_query']) ? $_GET['search_query'] : ''); ?></h1>
      <div class="search-bar">
        <form method="GET" action="search_results.php">
          <div class="input-group">
            <input type="text" name="search_query" placeholder="Job title, company or keywords" value="<?php echo isset($_GET['search_query']) ? $_GET['search_query'] : ''; ?>" required/>
            <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
          </div>
        </form>
      </div>
  </div>
</section>

<section class="job-cards container my-5">
  <div class="row">
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
    ?>
        <div class="col-md-4 mb-4" data-aos="fade-right">
          <div class="job-card p-3">
            <div class="d-flex align-items-center mb-3">
              <img src="<?php echo $row['company_logo']; ?>" alt="Company Logo" class="company-logo" />
              <div>
                <h5 class="job-title"><?php echo $row['title']; ?></h5>
                <p class="company-name mb-1"><strong><?php echo $row['company_name']; ?></strong></p>
              </div>
            </div>
            <p class="location"><i class="fas fa-map-marker-alt me-2"></i> <?php echo $row['location']; ?></p>
            <p class="job-type"><i class="fas fa-clock me-2"></i> <?php echo $row['job_type']; ?></p>
            <p class="contract-type"><i class="fas fa-briefcase me-2"></i> <?php echo $row['contract_type']; ?></p>
            <p class="deadline"><i class="fas fa-calendar-alt me-2"></i> Deadline: <?php echo date("d F, Y", strtotime($row['deadline'])); ?></p>
            <a href="job_detail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-dark btn-details">Job Details</a>
          </div>
        </div>
    <?php
      }
    } else {
      echo "<p>No job listings available matching your search criteria.</p>";
    }
    ?>
  </div>

  <nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
      <?php if($page > 1): ?>
        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search_query=<?php echo urlencode($search_query); ?>">Previous</a></li>
      <?php endif; ?>
      
      <?php for($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
          <a class="page-link" href="?page=<?php echo $i; ?>&search_query=<?php echo urlencode($search_query); ?>"><?php echo $i; ?></a>
        </li>
      <?php endfor; ?>
      
      <?php if($page < $total_pages): ?>
        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search_query=<?php echo urlencode($search_query); ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</section>

<?php $conn->close(); ?>

<?php include('assets/include/footer.php'); ?>

<script src="assets/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script>
  AOS.init({
    duration: 800,
    once: true,
  });
</script>

</body>
</html>