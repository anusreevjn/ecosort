<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'header2.php';
?>

<main>
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text fade-in">
                    <h1>Sort Smarter for <span class="gradient-text">SDG 13</span></h1>
                    <p>EcoSort helps residents in Malaysia reduce landfill methane emissions by providing clear, local recycling rules. Join us in taking urgent action to combat climate change.</p>
                    
                    <div class="search-container mt-4">
                        <form action="directory.php" method="GET" class="custom-donation-form" style="max-width: 600px; margin: 0;">
                            <input type="text" name="search" placeholder="Search item (e.g., Pizza Box, Battery)..." required>
                            <button type="submit" class="btn-primary">Search Rules</button>
                        </form>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&w=600&h=400" alt="Recycling Waste" class="hero-img">
                </div>
            </div>
        </div>
    </section>

    <section class="causes-section">
        <div class="container">
            <div class="section-header">
                <h2>Item <span class="gradient-text">Directory</span></h2>
                <p>Confused about where it goes? Here are common items and how to prep them.</p>
            </div>
            <div class="causes-grid">
                <div class="cause-card">
                    <div class="cause-icon cause-icon-green">🥤</div>
                    <h3>Plastic Bottles</h3>
                    <p><strong>Bin:</strong> Blue / Recyclable</p>
                    <p><strong>Prep:</strong> Rinse and squash to save space.</p>
                    <p class="mb-0"><small><em>Impact: Prevents microplastic soil contamination.</em></small></p>
                </div>
                <div class="cause-card">
                    <div class="cause-icon cause-icon-blue">🍕</div>
                    <h3>Pizza Boxes</h3>
                    <p><strong>Bin:</strong> Brown / General Waste</p>
                    <p><strong>Prep:</strong> If greasy, it cannot be recycled.</p>
                    <p class="mb-0"><small><em>Impact: Avoids contaminating clean paper batches.</em></small></p>
                </div>
                <div class="cause-card" style="border: 1px solid #ef4444;">
                    <div class="cause-icon cause-icon-purple">🔋</div>
                    <h3>Used Batteries</h3>
                    <p><strong>Bin:</strong> E-Waste Drop-off</p>
                    <p><strong>Prep:</strong> Tape terminals; do not put in curbside bins.</p>
                    <p class="mb-0"><small><em>Impact: Prevents toxic heavy metal leakage.</em></small></p>
                </div>
            </div>
        </div>
    </section>

    <section class="progress-section" id="impact-dashboard">
        <div class="container">
            <div class="section-header">
                <h2>Climate <span class="gradient-text">Impact</span></h2>
                <p>Why sorting matters: Landfill waste produces Methane, a greenhouse gas 25x more potent than CO2.</p>
            </div>
            <div class="progress-card">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number">47%</div>
                        <p class="stat-label">Malaysian Waste is Organic</p>
                        <p><small>Primary source of landfill methane.</small></p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">SDG 13.3</div>
                        <p class="stat-label">Climate Education</p>
                        <p><small>Building institutional capacity on mitigation</small></p>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">5.2 Tons</div>
                        <p class="stat-label">CO2e Saved</p>
                        <p><small>Calculated from EcoSort user diversions.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Have Feedback?</h2>
                <p>Help us improve local recycling data. Connect with us on social media or send a message.</p>
                <div class="hero-buttons" style="justify-content: center;">
                    <a href="https://linktr.ee/ecosort" class="btn-white">Visit our Linktree</a>
                    <a href="https://instagram.com/ecosortc" class="btn-secondary" style="color: black; border-color: white;">Instagram</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function updateSchedule() {
    const state = document.getElementById('stateSelect').value;
    const result = document.getElementById('scheduleResult');
    const gen = document.getElementById('genDays');
    const rec = document.getElementById('recDays');

    if(state) {
        result.style.display = 'block';
        // Mock data logic - in production, this would be a fetch() to your SQL
        if(state === 'johor') {
            gen.innerText = "Sunday, Tuesday, Thursday";
            rec.innerText = "Wednesday";
        } else {
            gen.innerText = "Monday, Wednesday, Friday";
            rec.innerText = "Saturday";
        }
    } else {
        result.style.display = 'none';
    }
}

<script>
async function updateSchedule() {
    const state = document.getElementById('stateSelect').value;
    const result = document.getElementById('scheduleResult');
    
    if(!state) {
        result.style.display = 'none';
        return;
    }

    // You would create a small 'fetch_schedule.php' or use this simple logic:
    // For the project demo, we can pre-load the data into a JS object using PHP
    const schedules = <?php 
        $all = $pdo->query("SELECT * FROM recycling_schedules")->fetchAll();
        echo json_encode($all); 
    ?>;

    const data = schedules.find(s => s.state_name === state);
    if(data) {
        result.style.display = 'block';
        document.getElementById('genDays').innerText = data.general_waste_days;
        document.getElementById('recDays').innerText = data.recyclable_days;
    }
}

</script>

<?php include 'footer.php'; ?>