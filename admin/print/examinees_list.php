<?php
include '../../database/connection.php';

$month = $_GET['month'] ?? '';
$year = $_GET['year'] ?? '';

// Build date filtering if filters are present
$where = '';
if (!empty($month) && !empty($year)) {
    $where = "AND MONTH(e.created_at) = :month AND YEAR(e.created_at) = :year";
}

$query = "
SELECT 
    e.default_id,
    e.fullname,
    e.gender,
    e.age,
    e.birthday,
    e.strand,
    c1.course_name AS course_1_name,
    c2.course_name AS course_2_name,
    c3.course_name AS course_3_name,
    e.created_at
FROM tbl_examiners e
LEFT JOIN tbl_preferred_courses pc ON e.id = pc.user_id
LEFT JOIN tbl_courses c1 ON pc.course_1 = c1.id
LEFT JOIN tbl_courses c2 ON pc.course_2 = c2.id
LEFT JOIN tbl_courses c3 ON pc.course_3 = c3.id
WHERE (pc.course_1 IS NOT NULL OR pc.course_2 IS NOT NULL OR pc.course_3 IS NOT NULL)
$where
";

$stmt = $conn->prepare($query);

if (!empty($month) && !empty($year)) {
    $stmt->bindParam(':month', $month);
    $stmt->bindParam(':year', $year);
}

$stmt->execute();
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Printable Examinees List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        #nav-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-bottom: 2px solid #ccc;
        }

        .logo-section {
            flex-shrink: 0;
            margin-right: 20px;
        }

        .kll-logo {
            width: 80px;
            height: auto;
        }

        .info-section {
            text-align: left;
            line-height: 1.5;
        }

        #school-name {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .sub-details {
            font-size: 14px;
            color: #555;
        }

        .print-btn {
            margin: 20px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        th {
            background-color: #eee;
        }

        h2 {
            text-align: center;
            margin-top: 10px;
        }

        @media print {
            .print-btn {
                display: none;
            }

            #nav-bar {
                border-bottom: none;
                margin-bottom: 0;
            }
        }
    </style>
</head>

<body>
    <!-- NAV HEADER -->
    <div id="nav-bar">
        <div class="logo-section">
            <img class="kll-logo" src="../../assets/images/kll-logo.jpg" alt="KLL Logo" />
        </div>
        <div class="info-section">
            <div id="school-name">KOLEHIYO NG LUNGSOD NG LIPA</div>
            <div class="sub-details">Marawoy, Lipa City, Batangas</div>
            <div class="sub-details">kll_lipa@yahoo.com</div>
            <div class="sub-details">(043) 774 2420</div>
        </div>
    </div>

    <!-- TITLE -->
    <h2>
        Examinees List
        <?php if (!empty($month) && !empty($year)): ?>
            for <?= date('F Y', mktime(0, 0, 0, $month, 1, $year)) ?>
        <?php endif; ?>
    </h2>

    <!-- PRINT BUTTON (hidden in print) -->
    <div class="print-btn">
        <button onclick="window.print()">Print This Page</button>
    </div>

    <!-- DATA TABLE -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fullname</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Birthday</th>
                <th>Strand</th>
                <th>Preferred Courses</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= htmlspecialchars($student['default_id']) ?></td>
                        <td><?= htmlspecialchars($student['fullname']) ?></td>
                        <td><?= htmlspecialchars($student['gender']) ?></td>
                        <td><?= htmlspecialchars($student['age']) ?></td>
                        <td><?= date('m/d/Y', strtotime($student['birthday'])) ?></td>
                        <td><?= htmlspecialchars($student['strand']) ?></td>
                        <td>
                            1) <?= htmlspecialchars($student['course_1_name'] ?? 'N/A') ?><br>
                            2) <?= htmlspecialchars($student['course_2_name'] ?? 'N/A') ?><br>
                            3) <?= htmlspecialchars($student['course_3_name'] ?? 'N/A') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No data available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>