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
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --primary-color: #b5c99a;
            --primary-hover: #d8f6b1;
            --secondary-color: #092519;
            --bg-color: #f8fafc;
            --white: #ffffff;
            --text-heading: #101828;
            --text-body: #475569;
            --border-color: #e2e8f0;
            --font-main: "Figtree", sans-serif;
            --sidebar-width: 280px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-color);
            color: var(--text-body);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary-color);
            color: #fff;
            position: fixed;
            height: 100vh;
            padding: 40px 24px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 50px;
            padding: 0 10px;
        }

        .sidebar-brand img {
            height: 40px;
        }

        .sidebar-brand span {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--primary-color);
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: var(--transition);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }

        .nav-link.active {
            background: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 700;
        }

        .logout-link {
            color: #fda4af;
            margin-top: auto;
        }

        .logout-link:hover {
            background: rgba(244, 63, 94, 0.1);
            color: #f43f5e;
        }

        /* Main Content */
        .main-wrapper {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 40px 60px;
            max-width: 1400px;
        }

        header.top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }

        h1 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-heading);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02), 0 2px 4px -1px rgba(0,0,0,0.01);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
        .stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }

        .stat-info h3 {
            margin: 0;
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-info p {
            margin: 4px 0 0 0;
            font-size: 28px;
            font-weight: 800;
            color: var(--text-heading);
        }

        /* Table Card */
        .data-card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.01);
            border: 1px solid var(--border-color);
            margin-bottom: 40px;
            overflow: hidden;
        }

        .card-header {
            padding: 24px 32px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h2 {
            font-size: 20px;
            font-weight: 700;
            color: var(--text-heading);
            margin: 0;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 16px 32px;
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            background: #f8fafc;
        }

        td {
            padding: 20px 32px;
            font-size: 15px;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-heading);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #fbfcfd;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-date { background: #f1f5f9; color: #475569; }
        .badge-time { background: #fff7ed; color: #ea580c; }

        .empty-state {
            padding: 60px;
            text-align: center;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            display: block;
        }

        @media (max-width: 1024px) {
            .sidebar { width: 80px; padding: 40px 15px; }
            .sidebar-brand span, .nav-link span { display: none; }
            .nav-link { justify-content: center; padding: 14px; }
            .main-wrapper { margin-left: 80px; padding: 30px; }
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-brand">
            <img src="../Manokamna Logo.png" alt="Logo">
            <span>Manokamna</span>
        </div>
        
        <nav class="nav-menu">
            <a href="#" class="nav-link active">
                <i class="fas fa-th-large"></i>
                <span>Summary</span>
            </a>
            <a href="logout.php" class="nav-link logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <main class="main-wrapper">
        <header class="top-bar">
            <h1>Workspace Overview</h1>
            <div style="font-size: 14px; color: #64748b; font-weight: 500;">
                <i class="far fa-calendar-alt"></i> <?php echo date('l, F j, Y'); ?>
            </div>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
                <div class="stat-info">
                    <h3>Enquiries</h3>
                    <p><?php echo count($enquiries); ?></p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon purple">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Site Visits</h3>
                    <p><?php echo count($site_visits); ?></p>
                </div>
            </div>
        </section>

        <section class="data-card">
            <div class="card-header">
                <h2>Recent General Enquiries</h2>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Received On</th>
                            <th>Lead Name</th>
                            <th>Contact Info</th>
                            <th>Property of Interest</th>
                            <th>Message Snippet</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($enquiries)): ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    No enquiries found yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($enquiries as $row): ?>
                            <tr>
                                <td><span class="badge badge-date"><?php echo date('d M, Y', strtotime($row['created_at'])); ?></span></td>
                                <td style="font-weight: 600;"><?php echo htmlspecialchars($row['name'] ?? ''); ?></td>
                                <td>
                                    <div style="font-size: 14px;"><?php echo htmlspecialchars($row['phone'] ?? ''); ?></div>
                                    <div style="font-size: 12px; color: #64748b;"><?php echo htmlspecialchars($row['email'] ?? ''); ?></div>
                                </td>
                                <td><span style="color: var(--secondary-color); font-weight: 600;"><?php echo htmlspecialchars($row['property_interest'] ?? ''); ?></span></td>
                                <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; color: #64748b;">
                                    <?php echo htmlspecialchars($row['message'] ?? ''); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="data-card">
            <div class="card-header">
                <h2>Site Visit Requests</h2>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Preferred Date</th>
                            <th>Lead Name</th>
                            <th>Contact Info</th>
                            <th>Property</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($site_visits)): ?>
                            <tr>
                                <td colspan="5" class="empty-state">
                                    <i class="fas fa-calendar-times"></i>
                                    No visit requests found yet.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($site_visits as $row): ?>
                            <tr>
                                <td>
                                    <span class="badge badge-date"><?php echo date('d M, Y', strtotime($row['preferred_date'])); ?></span>
                                    <span class="badge badge-time"><?php echo htmlspecialchars($row['preferred_time'] ?? ''); ?></span>
                                </td>
                                <td style="font-weight: 600;"><?php echo htmlspecialchars($row['name'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'] ?? ''); ?></td>
                                <td><span style="color: var(--secondary-color); font-weight: 600;"><?php echo htmlspecialchars($row['property_interest'] ?? ''); ?></span></td>
                                <td><span class="badge" style="background: #ecfdf5; color: #059669;">New Request</span></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>