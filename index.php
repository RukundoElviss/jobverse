<?php include('assets/include/header.php'); ?>
<?php include('assets/include/db_connect.php'); ?>
<title>Jobverse Uganda - Find Jobs, Build Futures</title>

<section class="hero" style="background: url('assets/images/hero_bg.jpg') center/cover no-repeat;">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Find Your Dream Job</h1>
        <p>Browse thousands of job listings from top employers</p>
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
    <h2 class="text-center mb-4">RECENT JOB LISTINGS</h2>
    <div class="row">
        <?php
        $sql = "SELECT j.*, c.company_name, c.company_logo 
                FROM jobs j
                JOIN companies c ON j.company_id = c.company_id
                ORDER BY j.created_at DESC
                LIMIT 12";

        if ($result = $conn->query($sql)) {
            if ($result->num_rows > 0) {
                while ($job = $result->fetch_assoc()) {
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
            } else {
                echo '<p class="text-center">No job listings found.</p>';
            }
            $result->free();
        } else {
            echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
        }
        ?>
        <div class="text-center">
            <a href="jobs.php"><button class="text-center btn btn-primary">VIEW MORE JOBS</button></a>
        </div>
    </div>
</section>

<section class="categories-section py-5" id="categories">
    <div class="container">
        <h2 class="text-center mb-4">BROWSE BY CATEGORY</h2>
        <div class="row g-3">
            <?php
            $query = "SELECT categories.category_id, categories.name, COUNT(jobs.id) AS job_count 
                      FROM categories 
                      LEFT JOIN jobs ON categories.category_id = jobs.category_id 
                      GROUP BY categories.category_id, categories.name";

            if ($result = $conn->query($query)) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="col-md-3 col-sm-6" id="category_card">
                                <a href="category.php?category_id=' . $row['category_id'] . '">
                                    <div class="card h-100 text-center">
                                        <div class="card-body">
                                            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                                            <p class="card-text">' . htmlspecialchars($row['job_count']) . ' jobs available</p>
                                        </div>
                                    </div>
                                </a>
                              </div>';
                    }
                } else {
                    echo '<p class="text-center">No categories found.</p>';
                }
                $result->free();
            } else {
                echo "<p>Error: " . htmlspecialchars($conn->error) . "</p>";
            }
            ?>
        </div>
    </div>
</section>

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
