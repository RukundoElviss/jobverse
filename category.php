<?php include('assets/include/header.php'); ?>
<?php include('assets/include/db_connect.php'); ?>

<?php
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

if ($category_id > 0) {
    $category_query = "SELECT name FROM categories WHERE category_id = $category_id";
    $category_result = $conn->query($category_query);

    if ($category_result && $category_result->num_rows > 0) {
        $category = $category_result->fetch_assoc();
        $category_name = htmlspecialchars($category['name']);
        
        echo '<title>' . $category_name . ' Jobs - Jobverse Uganda</title>';

        echo '<section class="hero" style="background: url(\'assets/images/hero_bg.jpg\') center/cover no-repeat; height:30vh">
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <h3>' . $category_name . ' Jobs</h3>
                </div>
              </section>';

        $job_query = "SELECT j.*, c.company_name, c.company_logo 
                      FROM jobs j
                      JOIN companies c ON j.company_id = c.company_id
                      WHERE j.category_id = $category_id
                      ORDER BY j.created_at DESC";

        $job_result = $conn->query($job_query);
        if ($job_result && $job_result->num_rows > 0) {
            echo '<section class="category-jobs container my-5">
                    <div class="row">';

            while ($job = $job_result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-4" data-aos="fade-right">
                        <div class="job-card p-3">
                            <div class="d-flex align-items-center mb-3">
                                <img src="' . htmlspecialchars($job['company_logo']) . '" alt="Company Logo" class="company-logo" />
                                <div>
                                    <h5 class="job-title">' . htmlspecialchars($job['title']) . '</h5>
                                    <p class="company-name mb-1"><strong>' . htmlspecialchars($job['company_name']) . '</strong></p>
                                </div>
                            </div>
                            <p class="location">
                                <i class="fas fa-map-marker-alt me-2"></i>' . htmlspecialchars($job['location']) . '
                            </p>
                            <p class="job-type"><i class="fas fa-clock me-2"></i>' . htmlspecialchars($job['job_type']) . '</p>
                            <p class="contract-type">
                                <i class="fas fa-briefcase me-2"></i>' . htmlspecialchars($job['contract_type']) . '
                            </p>
                            <p class="deadline">
                                <i class="fas fa-calendar-alt me-2"></i>Deadline: ' . date('d F, Y', strtotime($job['deadline'])) . '
                            </p>
                            <a href="job_detail.php?id=' . $job['id'] . '" class="btn btn-outline-dark btn-details">Job Details</a>
                        </div>
                    </div>';
            }

            echo '</div>
                </section>';
        } else {
            echo '<p class="text-center">No jobs found in this category.</p>';
        }
        $job_result->free();
    } else {
        echo "<p>Error: Category not found.</p>";
    }
    $category_result->free();
} else {
    echo "<p>Invalid category.</p>";
}

$conn->close();
?>

<?php include('assets/include/footer.php'); ?>

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