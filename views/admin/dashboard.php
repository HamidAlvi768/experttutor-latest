<?php

use app\components\Helper;
use app\models\JobApplications;
use app\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Admin Dashboard';
$this->params['breadcrumbs'][] = ['label' => 'Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
    .bar-chart > .chart > .item > .bar {
 
    background-color: hsla(126, 90%, 37%, 1);
 
}
    .stat-card {
        display: flex;
        align-items: center;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 20px 24px;
        min-width: 220px;
        margin-bottom: 20px;
    }
    .stat-icon {
        background: #f5f8fa;
        border-radius: 50%;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 16px;
    }
    .stat-icon i {
        color: #564FFD;
        font-size: 24px;
    }
    .stat-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .stat-title {
        color: #7b8a99;
        font-size: 18px;
        margin-bottom: 4px;
    }
    .stat-value {
        color: #222;
        font-size: 20px;
        font-weight: 500;
    }
</style>


<div class="page-wrapper">
    <div class="content">
        <!-- Statistics Cards -->
        <div class="row">
            <?php /*?>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-users"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Total Users</div>
                        <div class="stat-value"><?= $stats->totalUsers ?></div>
                    </div>
                </div>
            </div>
            <?php */?>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-graduation-cap"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Students</div>
                        <div class="stat-value"><?= $stats->totalStudents ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-id-badge"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Tutors</div>
                        <div class="stat-value"><?= $stats->totalTeachers ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-briefcase"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Total jobs</div>
                        <div class="stat-value"><?= $stats->totalPosts ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-money"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Total Coins</div>
                        <div class="stat-value"><?= $stats->totalcoins ?></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="stat-info">
                        <div class="stat-title">Coins spent</div>
                        <div class="stat-value"><?= $stats->consumedcoins ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Recent Job Posts</h4>
                            <span class="float-right"><i class="fa fa-caret-up"></i> Latest <?= count($all_posts) ?>
                                Jobs</span>
                        </div>
                        <canvas id="linegraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <div class="chart-title">
                            <h4>Users Distribution</h4>
                            <div class="float-right">
                                <ul class="chat-user-total">
                                    <li><i class="fa fa-circle current-users"></i> Students</li>
                                    <li><i class="fa fa-circle old-users"></i> Tutors</li>
                                </ul>
                            </div>
                        </div>
                        <canvas id="bargraph"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Job Posts & Top Tutors -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">Recent Job Activities</h4>
                        <a href="<?php echo Helper::baseUrl("/admin/joblist") ?>"
                            class="btn btn-primary float-right">View all</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                    <?php //print_r($all_posts); ?>
                                    <?php foreach (array_slice($all_posts, 0, 5) as $post): ?>
                                    <tr>
                                        <td style="min-width: 200px;">
                                            <a class="avatar bg-primary text-white" href="#"><img
                                                    src="https://ui-avatars.com/api/?name=<?php echo User::getusername($post->posted_by)?>"></a>
                                            <h2><a href="#"><?= Html::encode(User::getusername($post->posted_by)) ?></a>
                                            </h2>
                                        </td>
                                        <td>
                                            <h5 class="time-title p-0">
                                                <?= Html::encode(substr($post->details, 0, 50)) . '...' ?></h5>
                                        </td>
                                        <td>
                                            <h5 class="time-title p-0">Budget</h5>
                                            <p><?= Helper::getCurrency() ?> <?= Html::encode($post->budget) ?></p>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?php echo Helper::baseUrl("/post/view?id=$post->id") ?>"
                                                class="btn btn-outline-primary take-btn">View</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="card member-panel">
                    <div class="card-header bg-white">
                        <h4 class="card-title mb-0">Top Tutors</h4>
                    </div>
                    <div class="card-body">
                        <ul class="contact-list">
                            <?php foreach ( array_slice($tutors, 0, 5) as $tutor): ?>
                            <li>
                                <div class="contact-cont">
                                    <div class="float-left user-img m-r-10">
                                        <a href="#" title="<?= Html::encode($tutor->username) ?>">
                                            <img class="w-40 rounded-circle"
                                                src="https://ui-avatars.com/api/?name=<?php echo User::getusername($tutor->id)?>">
                                            <?php /*?><img src="<?= $tutor->image ?: '<?= Helper::baseUrl("/") ?>custom/theme/img/user.jpg' ?>"
                                                alt="" class="w-40 rounded-circle">
                                            <span class="status online"></span>
                                            <?php */?>
                                        </a>
                                    </div>
                                    <div class="contact-info">
                                        <span
                                            class="contact-name text-ellipsis"><?= Html::encode($tutor->username) ?></span>
                                        <span class="contact-date">
                                            <?= Html::encode(date('Y-m-d', strtotime($tutor->created_at))) ?>
                                        </span>

                                    </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="card-footer text-center bg-white">
                        <a href="<?php echo Helper::baseUrl("/manageusers/tutors") ?>" class="text-muted">View all Tutors</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- New Students & User Distribution -->
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8 col-xl-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title d-inline-block">New Students</h4>
                        <a href="<?php echo Helper::baseUrl("/manageusers/students") ?>" class="btn btn-primary float-right">View
                            all</a>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table mb-0 new-patient-table">
                                <tbody>
                                    <?php foreach ( array_slice( $students, 0, 5) as $student): ?>
                                    <tr>
                                        <td>
                                            <img width="28" height="28" class=" rounded-circle"
                                                src="https://ui-avatars.com/api/?name=<?php echo User::getusername($student->id)?>">
                                            <?php /*?><img width="28" height="28" class="rounded-circle"
                                                src="<?= $student->image ?: '<?= Helper::baseUrl("/") ?>custom/theme/img/user.jpg' ?>"
                                                alt=""><?php */?>
                                            <h2><?= Html::encode($student->username) ?></h2>
                                        </td>
                                        <td><?= Html::encode($student->email) ?></td>
                                        <td><?php /* Html::encode($student->phone_number) */?></td>
                                        <?php /*?>
                                        <td>
                                            <button class="btn btn-primary btn-primary-one float-right">
                                                <?= Html::encode($student->user_status)  ?>
                                            </button>
                                        </td>
                                        <?php */?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4 col-xl-4">
                <div class="hospital-barchart">
                    <h4 class="card-title d-inline-block">User Statistics</h4>
                </div>
                <div class="bar-chart">
                    <div class="legend">
                        <div class="item">
                            <h4>Total</h4>
                        </div>
                        <div class="item">
                            <h4>Tutors</h4>
                        </div>
                        <div class="item text-right">
                            <h4>Students</h4>
                        </div>
                        <div class="item text-right">
                            <h4>Verified</h4>
                        </div>
                    </div>
                    <div class="chart clearfix">
                        <!-- Total Users -->
                        <div class="item">
                            <div class="bar">
                                <span class="percent">100%</span>
                                <div class="item-progress" data-percent="100">
                                    <span class="title">Total Users</span>
                                </div>
                            </div>
                        </div>
                        <!-- Tutors -->
                        <div class="item">
                            <div class="bar">
                                <span
                                    class="percent"><?= round(($stats->totalTeachers / $stats->totalUsers) * 100) ?>%</span>
                                <div class="item-progress"
                                    data-percent="<?= round(($stats->totalTeachers / $stats->totalUsers) * 100) ?>">
                                    <span class="title">Tutors</span>
                                </div>
                            </div>
                        </div>
                        <!-- Students -->
                        <div class="item">
                            <div class="bar">
                                <span
                                    class="percent"><?= round(($stats->totalStudents / $stats->totalUsers) * 100) ?>%</span>
                                <div class="item-progress"
                                    data-percent="<?= round(($stats->totalStudents / $stats->totalUsers) * 100) ?>">
                                    <span class="title">Students</span>
                                </div>
                            </div>
                        </div>
                        <!-- Verified Users -->
                        <div class="item">
                            <div class="bar">
                                <span
                                    class="percent"><?= round(($stats->verifiedUsers / $stats->totalUsers) * 100) ?>%</span>
                                <div class="item-progress"
                                    data-percent="<?= round(($stats->verifiedUsers / $stats->totalUsers) * 100) ?>">
                                    <span class="title">Verified Users</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php //print_r($userDataByMonth) ?>
<script>
$(document).ready(function () {
    // Bar Chart - Student/Tutor Distribution
    const barCtx = document.getElementById('bargraph').getContext('2d');
    const barChartData = {

    
		labels: <?= json_encode($userDataByMonth['labels']) ?>,
		datasets: [{
			label: 'Students',
			backgroundColor: 'hsl(242, 98%, 65%, 0.5)',
			borderColor: 'hsl(242, 98%, 65%, 1)',
			borderWidth: 1,
			data: <?= json_encode($userDataByMonth['students']) ?>
		}, {
			label: 'Tutors',
			backgroundColor: 'hsla(126, 90%, 37%, 0.51)',
			borderColor: 'hsla(126, 90%, 37%, 1)',
			borderWidth: 1,
			data: <?= json_encode($userDataByMonth['tutors']) ?>
		}]
	

    };

    new Chart(barCtx, {
        type: 'bar',
        data: barChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Line Chart - Job Posts Over Time
    const lineCtx = document.getElementById('linegraph').getContext('2d');
    const lineChartData = {
        labels: <?= json_encode($jobDataByMonth['labels']) ?>,
        datasets: [{
            label: 'Job Posts',
            backgroundColor: 'rgba(35, 96, 131, 0.2)',
            borderColor: 'rgb(162, 226, 43)',
            borderWidth: 2,
            pointBackgroundColor: 'rgb(132, 147, 156)',
            pointRadius: 4,
            fill: true,
            tension: 0.3,
            data: <?= json_encode($jobDataByMonth['data']) ?>
        }]
    };

    new Chart(lineCtx, {
        type: 'line',
        data: lineChartData,
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });

    // Progress Bars
    barChart();

    $(window).resize(function () {
        barChart();
    });

    function barChart() {
        $('.bar-chart').find('.item-progress').each(function () {
            const itemProgress = $(this);
            const parentWidth = itemProgress.parent().width();
            const percent = itemProgress.data('percent');
            const itemProgressWidth = parentWidth * (percent / 100);
            itemProgress.css('width', itemProgressWidth);
        });
    }
});
</script>

<style>
.chart-container {
    position: relative;
    height: 250px;
}

.bar-chart .item-progress {
    transition: width 1s ease-in-out;
}
</style>