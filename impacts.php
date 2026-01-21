<?php
include 'header.php'; // Includes session and database connection
?>

<style>
    /* Styling for the Game Section */
    .game-section {
        padding: 60px 0;
        background: #ffffff;
    }

    .game-container {
        max-width: 1000px;
        margin: 0 auto;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        border: 1px solid var(--gray-200);
        background: #f0f9ff;
    }

    /* The iframe hosting your recycling-3d.html */
    .game-container iframe {
        width: 100%;
        height: 600px; /* Fixed height for the game area */
        border: none;
        display: block;
    }

    .game-header {
        text-align: center;
        margin-bottom: 30px;
    }
</style>
<main>
    <section class="causes-section" style="background: var(--primary-light);">
        <div class="container">
            <div class="section-header">
                <h2>Climate <span class="gradient-text">Impact Dashboard</span></h2>
               <p>Visualizing the vital link between proper waste sorting and <strong>SDG 13: Climate Action</strong>.</p>
            </div>
        </div>
    </section>

    <section class="progress-section">
        <div class="container">
            <div class="stats-grid">
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM sdg_impact_stats");
                    $stats = $stmt->fetchAll();

                    foreach ($stats as $stat): ?>
                        <div class="progress-card" style="text-align: center; border: 1px solid var(--gray-200);">
                            <div class="stat-number" style="font-size: var(--font-size-2xl); color: var(--primary-green);">
                                <?php echo htmlspecialchars($stat['stat_value']) . htmlspecialchars($stat['unit']); ?>
                            </div>
                            <h4 class="stat-label"><?php echo htmlspecialchars($stat['metric_name']); ?></h4>
                            <p style="font-size: var(--font-size-sm); margin-top: 1rem;">
                                <?php echo htmlspecialchars($stat['description']); ?>
                            </p>
                        </div>
                    <?php endforeach;
                } catch (PDOException $e) {
                    echo "<p>Error loading impact data.</p>";
                } ?>
            </div>
        </div>
    </section>
    <section class="game-section">
        <div class="container">
            <div class="game-header">
                <h3>Interactive <span class="gradient-text">Sorting Lab</span></h3>
                <p>Put your knowledge into practice. Drag items to their correct climate-friendly bin!</p>
            </div>
            
            <div class="game-container">
                <iframe src="recycling-3d.html" title="EcoSorter 3D Game"></iframe>
            </div>
        </div>
    </section>
    <section class="testimonials-section" style="background: var(--white);">
        <div class="container">
            <div class="custom-donation" style="max-width: 900px; margin: 0 auto; border-left: 5px solid var(--primary-green);">
                <h3>Why it Matters for SDG 13</h3>
                <p>When organic waste is trapped in landfills without oxygen, it undergoes anaerobic decomposition, releasing <strong>Methane (CH4)</strong>. By using the EcoSort Directory and Schedule, residents can divert organic waste and recyclables, directly mitigating local greenhouse gas emissions.</p>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>