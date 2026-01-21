<?php
include 'header2.php';
?>
<style>
    .form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* Modern styling for the search input */
#stateSearch {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    font-size: var(--font-size-base);
    transition: all var(--transition-normal);
}

#stateSearch:focus {
    border-color: var(--primary-green);
    box-shadow: 0 0 0 4px var(--primary-light);
}

/* Modern styling for the select/list box */
#stateSelect {
    width: 100%;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    padding: 8px;
    font-size: var(--font-size-base);
    color: var(--gray-700);
    outline: none;
    transition: all var(--transition-normal);
    cursor: pointer;
    background-color: var(--white);
    /* Custom scrollbar for a cleaner look */
    scrollbar-width: thin;
    scrollbar-color: var(--primary-green) var(--gray-100);
}

#stateSelect:focus {
    border-color: var(--primary-green);
}

/* Individual list items */
#stateSelect option {
    padding: 12px 15px;
    margin-bottom: 4px;
    border-radius: var(--radius-md);
    transition: background 0.2s ease;
}

#stateSelect option:hover {
    background-color: var(--primary-light);
    color: var(--primary-dark);
}

/* Styling the selected item */
#stateSelect option:checked {
    background: var(--gradient-primary) !important;
    color: var(--white);
}
    </style>
<main>
    <section class="causes-section" style="background: var(--gray-50); padding-bottom: 2rem;">
        <div class="container">
            <div class="section-header">
                <h2>Local <span class="gradient-text">Collection Schedules</span></h2>
                <p>Stay updated with the local waste collection timings across Malaysia to reduce landfill contamination and support SDG 13.</p>
            </div>
        </div>
    </section>

    <section class="progress-section" style="padding-top: 0;">
        <div class="container">
            <div class="custom-donation" style="max-width: 800px; margin: 0 auto; background: var(--white); border: 2px solid var(--primary-green);">
                <div class="form-group">
                    <h3 class="text-center mb-4">Quick <span class="gradient-text">Schedule Search</span></h3>
                    <label for="stateSearch">Type your state name:</label>
                    <input type="text" id="stateSearch" placeholder="e.g. Johor, Selangor, Sabah..." 
                           onkeyup="filterStates()" class="mb-2">
                    
                    <select id="stateSelect" onchange="updateSchedule()" size="4" style="height: auto; border-radius: var(--radius-lg);">
                        <option value="" disabled selected>-- Select from results --</option>
                        <?php
                        // Fetching all states from your recycling_schedules table
                        $stmt = $pdo->query("SELECT DISTINCT state_name FROM recycling_schedules ORDER BY state_name ASC");
                        while ($row = $stmt->fetch()) {
                            echo "<option value='" . htmlspecialchars($row['state_name']) . "'>" . htmlspecialchars($row['state_name']) . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div id="scheduleResult" class="mt-4" style="display: none; border-top: 2px solid var(--primary-green); padding-top: 1rem;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <tr>
                            <th style="padding: 10px; color: var(--gray-700);">Waste Type</th>
                            <th style="padding: 10px; color: var(--gray-700);">Collection Days</th>
                        </tr>
                        <tr style="background: var(--gray-50);">
                            <td style="padding: 10px;">🗑️ General Waste</td>
                            <td style="padding: 10px; font-weight: 600;" id="genDays">-</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px;">♻️ Recyclables</td>
                            <td style="padding: 10px; font-weight: 600; color: var(--primary-green);" id="recDays">-</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h3>Full State <span class="gradient-text">Directory</span></h3>
            </div>
            
            <div class="custom-donation" style="max-width: 1000px; margin: 0 auto; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
                    <thead>
                        <tr style="background: var(--gradient-primary); color: var(--white);">
                            <th style="padding: 15px; text-align: left;">State / Territory</th>
                            <th style="padding: 15px; text-align: left;">🗑️ General Waste Days</th>
                            <th style="padding: 15px; text-align: left;">♻️ Recyclable Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            $stmt = $pdo->query("SELECT * FROM recycling_schedules ORDER BY state_name ASC");
                            $schedules = $stmt->fetchAll();

                            foreach ($schedules as $row) {
                                echo "<tr style='border-bottom: 1px solid var(--gray-200);'>";
                                echo "<td style='padding: 15px; font-weight: 600; color: var(--primary-dark);'>" . htmlspecialchars($row['state_name']) . "</td>";
                                echo "<td style='padding: 15px;'>" . htmlspecialchars($row['general_waste_days']) . "</td>";
                                echo "<td style='padding: 15px;'>" . htmlspecialchars($row['recyclable_days']) . "</td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='3' style='padding: 20px; color: red;'>Error fetching database.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<script>
// Filter functionality for the select box
function filterStates() {
    const input = document.getElementById('stateSearch').value.toLowerCase();
    const select = document.getElementById('stateSelect');
    const options = select.options;

    for (let i = 1; i < options.length; i++) {
        const txt = options[i].text.toLowerCase();
        options[i].style.display = txt.includes(input) ? "" : "none";
    }
}

// AJAX fetch functionality
async function updateSchedule() {
    const state = document.getElementById('stateSelect').value;
    const result = document.getElementById('scheduleResult');
    
    if(!state) return;

    try {
        const response = await fetch(`get_schedule.php?state=${encodeURIComponent(state)}`);
        const data = await response.json();

        if(data) {
            result.style.display = 'block';
            document.getElementById('genDays').innerText = data.general_waste_days;
            document.getElementById('recDays').innerText = data.recyclable_days;
            document.getElementById('stateSearch').value = state;
        }
    } catch (error) {
        console.error("Error fetching schedule:", error);
    }
}
</script>
<?php include 'footer.php'; ?>