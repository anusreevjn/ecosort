<?php
include 'header2.php'; // Includes session and db_connect.php automatically
?>

<main>
    <section class="causes-section">
        <div class="container">
            <div class="section-header">
                <h2>Waste <span class="gradient-text">Directory</span></h2>
                <p>Find out exactly how to dispose of your household items to support SDG 13.</p>
                
                <div class="search-container mt-4">
                    <form action="directory.php" method="GET" class="custom-donation-form" style="max-width: 600px; margin: 0 auto;">
                        <input type="text" name="search" placeholder="Search item (e.g., Plastic, Paper)..." 
                               value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                        <button type="submit" class="btn-primary">Search</button>
                    </form>
                </div>
            </div>

            <div class="causes-grid">
                <?php
                // 1. Database Connection via the $pdo object from db_connect.php
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                
                try {
                    if (!empty($searchTerm)) {
                        $stmt = $pdo->prepare("SELECT * FROM waste_items WHERE item_name LIKE ? OR category LIKE ?");
                        $stmt->execute(["%$searchTerm%", "%$searchTerm%"]);
                    } else {
                        $stmt = $pdo->query("SELECT * FROM waste_items LIMIT 12");
                    }
                    
                    $items = $stmt->fetchAll();

                    if ($items) {
                        foreach ($items as $item) {
                            ?>
                            <div class="cause-card fade-in">
                                <div class="cause-icon <?php 
                                    echo (strpos(strtolower($item['bin_color']), 'blue') !== false) ? 'cause-icon-blue' : 
                                         ((strpos(strtolower($item['bin_color']), 'green') !== false) ? 'cause-icon-green' : 'cause-icon-purple'); 
                                ?>">
                                    ♻️
                                </div>
                                <h3><?php echo htmlspecialchars($item['item_name']); ?></h3>
                                <p><strong>Bin Color:</strong> <?php echo htmlspecialchars($item['bin_color']); ?></p>
                                <p><strong>Preparation:</strong> <?php echo htmlspecialchars($item['preparation_steps']); ?></p>
                                <hr style="margin: 1rem 0; border: 0; border-top: 1px solid var(--gray-100);">
                                <p class="mb-0"><small><strong>Climate Impact:</strong> <?php echo htmlspecialchars($item['impact_description']); ?></small></p>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<div class='text-center' style='grid-column: 1/-1;'>
                                <p>No items found matching '" . htmlspecialchars($searchTerm) . "'. Try searching for 'Plastic' or 'Paper'.</p>
                                <a href='directory.php' class='btn-secondary'>View All Items</a>
                              </div>";
                    }
                } catch (PDOException $e) {
                    echo "Error fetching data: " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>