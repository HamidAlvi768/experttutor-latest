<?php
function renderStatItem($icon, $iconColor, $number, $suffix, $label) {
    if (empty($icon) || $number === '' || $label === '') {
        return;
    }
    ?>
    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
        <div class="stat-item">
            <div class="stat-icon">
                <i class="<?php echo htmlspecialchars($icon); ?>" style="color: <?php echo htmlspecialchars($iconColor); ?>;"></i>
            </div>
            <div class="stat-content">
                <h3>
                    <span class="stat-number" data-value="<?php echo htmlspecialchars($number); ?>" 
                          data-suffix="<?php echo htmlspecialchars($suffix); ?>">
                        <?php echo htmlspecialchars($number . $suffix); ?>
                    </span>
                </h3>
                <p><?php echo htmlspecialchars($label); ?></p>
            </div>
        </div>
    </div>
    <?php
}

function renderStatsSection($stats) {
    if (!is_array($stats) || empty($stats)) {
        return;
    }
    ?>
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <?php
                foreach ($stats as $stat) {
                    if (is_array($stat) && count($stat) >= 5) {
                        renderStatItem($stat[0], $stat[1], $stat[2], $stat[3], $stat[4]);
                    }
                }
                ?>
            </div>
        </div>
    </section>
    <?php
}