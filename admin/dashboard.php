<?php
require_once 'auth.php';
require_once '../db.php';
checkLogin();

// Fetch Enquiries
$enquiries_stmt = $pdo->query("SELECT * FROM enquiries ORDER BY created_at DESC");
$enquiries = $enquiries_stmt->fetchAll();

// Fetch Site Visits
$site_visits_stmt = $pdo->query("SELECT * FROM site_visits ORDER BY created_at DESC");
$site_visits = $site_visits_stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manokamna Marketing</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            margin: 0;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #0d3b24;
            color: white;
            height: 100vh;
            position: fixed;
            padding: 20px;
            box-sizing: border-box;
        }

        .main-content {
            margin-left: 250px;
            padding: 40px;
            width: 100%;
            box-sizing: border-box;
        }

        h1,
        h2 {
            color: #0d3b24;
        }

        .sidebar h2 {
            color: #d4af37;
            margin-bottom: 30px;
        }

        .nav-item {
            padding: 12px;
            color: #ddd;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 4px;
            transition: 0.3s;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item.active {
            background: #d4af37;
            color: #0d3b24;
            font-weight: bold;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            text-align: left;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #fdfdfd;
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
        }

        .status-pill {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .enquiry-pill {
            background: #e3f2fd;
            color: #1976d2;
        }

        .visit-pill {
            background: #f3e5f5;
            color: #7b1fa2;
        }

        .logout-btn {
            margin-top: auto;
            color: #ffab91;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="#" class="nav-item active"><i class="fas fa-chart-line"></i> Dashboard</a>
        <a href="logout.php" class="nav-item logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="main-content">
        <h1>Overview</h1>

        <div class="card">
            <h2>Recent Enquiries <span class="status-pill enquiry-pill">
                    <?php echo count($enquiries); ?> Total
                </span></h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Property</th>
                        <th>Message</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($enquiries as $row): ?>
                        <tr>
                            <td>
                                <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['phone']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['property_interest']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['message']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2>Site Visit Requests <span class="status-pill visit-pill">
                    <?php echo count($site_visits); ?> Total
                </span></h2>
            <table>
                <thead>
                    <tr>
                        <th>Date Requested</th>
                        <th>Visit Date</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Property</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($site_visits as $row): ?>
                        <tr>
                            <td>
                                <?php echo date('d M, Y', strtotime($row['created_at'])); ?>
                            </td>
                            <td>
                                <?php echo date('d M, Y', strtotime($row['preferred_date'])); ?> (
                                <?php echo htmlspecialchars($row['preferred_time']); ?>)
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['phone']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['property_interest']); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>