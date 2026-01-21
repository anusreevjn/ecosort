<?php
include 'header.php'; // Includes session, database connection, and access control
?>
<style>
<style>
    /* Layout styling to match screenshot */
    .about-grid-container {
        display: flex;
        gap: 40px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .team-side {
        flex: 2;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .faq-side {
        flex: 1;
        min-width: 300px;
    }

    /* Card Styling from screenshot */
    .team-card {
        background: linear-gradient(145deg, #fff5f6, #ffffff);
        border-radius: 24px;
        padding: 40px 20px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: transform 0.3s ease;
        border: 1px solid rgba(0,0,0,0.02);
    }

    .team-card:hover {
        transform: translateY(-5px);
    }

    .member-photo-container img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #28a745; /* Green border from image */
        padding: 3px;
        background: white;
    }

    .team-card h4 {
        font-size: 1.4rem;
        margin: 15px 0 5px;
        color: #1a1a1a;
    }

    .matric-text {
        color: #777;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .phone-link {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        color: #d63384; /* Pinkish/Red icon color from image */
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 20px;
    }

    .role-text {
        font-style: italic;
        color: #555;
        font-size: 1rem;
        border-top: 1px solid rgba(0,0,0,0.05);
        padding-top: 15px;
    }

    /* FAQ Styling */
    .faq-side h2 {
        font-size: 2.5rem;
        line-height: 1.2;
        margin-bottom: 30px;
    }

    .faq-item {
        border-bottom: 1px solid #eee;
        padding: 15px 0;
    }

    .faq-item summary {
        list-style: none;
        cursor: pointer;
        font-weight: 600;
        color: #004d40;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .faq-item summary::before {
        content: '▶';
        font-size: 0.7rem;
        color: #28a745;
    }

    .faq-item[open] summary::before {
        content: '▼';
    }
</style>

</style>
<main>
    <section class="causes-section" style="background: var(--gray-50); padding: 60px 0;">
        <div class="container">
            <div class="section-header">
                <h2>About <span class="gradient-text">EcoSort</span></h2>
                <p>Developing a digital solution for <strong>SDG 13: Climate Action</strong> to help Malaysian residents navigate complex recycling rules.</p>
            </div>
            <div class="custom-donation" style="max-width: 900px; margin: 0 auto; text-align: center;">
                <p>Our mission is to reduce methane emissions from landfills by providing clear, local recycling rules and collection schedules. By sorting waste correctly at the source, we contribute to a more sustainable future for Malaysia.</p>
            </div>
        </div>
    </section>

    <section class="testimonials-section" style="padding: 80px 0;">
        <div class="container">
            <div class="about-grid-container">
                
                <div class="team-side">
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM team_members ORDER BY member_id ASC");
                        $members = $stmt->fetchAll();

                        foreach($members as $member): ?>
                        <div class="team-card">
                            <div class="member-photo-container">
                                <img src="<?php echo htmlspecialchars($member['photo_path']); ?>" 
                                     alt="<?php echo htmlspecialchars($member['full_name']); ?>">
                            </div>
                            <h4><?php echo htmlspecialchars($member['full_name']); ?></h4>
                            <p class="matric-text">Matric: <?php echo htmlspecialchars($member['matric_number']); ?></p>
                            
                            <?php if (!empty($member['phone_number'])): ?>
                                <a href="tel:<?php echo $member['phone_number']; ?>" class="phone-link">
                                    <span>📞</span> <?php echo htmlspecialchars($member['phone_number']); ?>
                                </a>
                            <?php endif; ?>

                            <p class="role-text"><?php echo htmlspecialchars($member['role']); ?></p>
                        </div>
                    <?php endforeach; 
                    } catch (PDOException $e) {
                        echo "<p>Error loading team members.</p>";
                    } ?>
                </div>

                <div class="faq-side">
                    <h2><br><br>Frequently Asked <span class="gradient-text">Questions</span></h2>
                    
                    <div class="faq-list">
                        <?php
                       $faqs = [
                    "What is EcoSort?" => "A digital tool to help Malaysians sort waste correctly based on local council rules.",
                    "Why focus on SDG 13?" => "Correct recycling reduces landfill methane, a major driver of climate change.",
                    "Do I need to wash my recyclables?" => "Yes, food residue contaminates paper and plastic, making them unrecyclable.",
                    "Where do I send e-waste?" => "E-waste contains heavy metals and must go to specialized drop-off centers, not curbside bins.",
                    "Can I recycle pizza boxes?" => "Only the clean parts. Greasy cardboard is compostable or general waste.",
                    "What is the '2+1' collection system?" => "A common Malaysian system: 2 days for general waste, 1 day for recyclables/bulky waste.",
                    "Does EcoSort work for all states?" => "We cover all major states including Johor, Selangor, and Penang.",
                    "Is the schedule data official?" => "We pull data from SWCorp and local municipal websites.",
                    "How can I help more?" => "Reduce consumption first, then reuse, and finally recycle correctly using EcoSort.",
                    "Who created this?" => "This is a student project for the Information Technology in Business course."
                ];
                        foreach($faqs as $q => $a): ?>
                            <details class="faq-item">
                                <summary><?php echo $q; ?></summary>
                                <p style="margin-top: 10px; color: var(--gray-600); padding-left: 20px;">
                                    <?php echo $a; ?>
                                </p>
                            </details>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Have Feedback?</h2>
                <p>Help us improve local recycling data. Connect with us via our socials or feedback form.</p>
                <div class="hero-buttons" style="justify-content: center; display: flex; gap: 15px; margin-top: 20px;">
                    <a href="https://linktr.ee/ecosort" class="btn-white" target="_blank" style="padding: 12px 25px; background: white; border-radius: 30px; text-decoration: none; color: black; font-weight: 600;">Linktree</a>
                    <a href="https://instagram.com/ecosortc" class="btn-secondary" target="_blank" style="padding: 12px 25px; border: 2px solid white; border-radius: 30px; text-decoration: none; color: black; font-weight: 600;">Instagram</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>