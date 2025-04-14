<?php
include '../../database/connection.php';
include '../session_not_login.php';

$sql = "
    SELECT q.id AS question_id, 
           q.question_text, 
           GROUP_CONCAT(c.course_name ORDER BY c.course_name ASC SEPARATOR ', ') AS course_names, 
           q.created_at, 
           q.updated_at
    FROM tbl_questions q
    LEFT JOIN tbl_question_courses qc ON q.id = qc.question_id
    LEFT JOIN tbl_courses c ON qc.course_id = c.id
    GROUP BY q.id
    ORDER BY q.created_at DESC
";

$stmt = $conn->query($sql);
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #nav-bar {
            display: flex;
            align-items: center;
            padding: 15px;
        }

        .kll-logo {
            width: 105px;
            margin-right: 15px;
        }

        #school-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .sub-details {
            font-size: 14px;
        }

        .container {
            margin: 40px 30px;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .info-item {
            flex: 1;
            margin-right: 20px;
            font-size: 14px;
        }

        .info-item:last-child {
            margin-right: 0;
        }

        h2 {
            text-align: center;
            margin: 20px 0;
        }

        .instructions {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 10px 12px;
        }

        th {
            background-color: #f0f0f0;
            text-align: center;
        }

        td:nth-child(1) {
            width: 70%;
        }

        td:nth-child(2),
        td:nth-child(3) {
            text-align: center;
            width: 15%;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .print-button {
            margin: 20px 30px;
            padding: 10px 15px;
            background-color: #752738;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .print-button:hover {
            background-color: #5a1e2e;
        }

        @media print {
            .print-button {
                display: none;
            }

            @page {
                margin: 20mm;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>

    <!-- Print Button -->
    <button onclick="window.print();" class="print-button">🖨️ PRINT QUESTIONNARE</button>

    <!-- Header -->
    <div id="nav-bar">
        <img class="kll-logo" src="../assets/images/kll-logo.jpg" alt="KLL Logo" />
        <div>
            <div id="school-name">KOLEHIYO NG LUNGSOD NG LIPA</div>
            <div class="sub-details">Marawoy, Lipa City, Batangas</div>
            <div class="sub-details">kll_lipa@yahoo.com</div>
            <div class="sub-details">(043) 774 2420</div>
        </div>
    </div>

    <!-- Examinee Info -->
    <div class="container">
        <div class="info-container">
            <div class="info-item">Name: __________________________</div>
            <div class="info-item">Date: __________________________</div>
        </div>
        <div class="info-container">
            <div class="info-item">Age: __________________________</div>
            <div class="info-item">Strand: ________________________</div>
        </div>

        <br>
        <br>
        <!-- Title and Instructions -->
        <h2 style="text-align: left;">FUTURE: Facilitating University Track <br> Understanding and Recommendation Engine</h2>
        <div class="instructions">
            Direction: This is a course path examination. Please check "True" or "False" for each statement.
        </div>

        <!-- Questions Table -->
        <table>
            <thead>
                <tr>
                    <th>Question</th>
                    <th>True</th>
                    <th>False</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1;
                foreach ($questions as $question): ?>
                    <tr>
                        <td><?= $i++ ?>.) <?= htmlspecialchars($question['question_text']) ?></td>
                        <td></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>

</html>