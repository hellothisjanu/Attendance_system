<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'attendance_system');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=attendance_report.csv');

    $from_date = $_GET['from_date'] ?? null;
    $to_date = $_GET['to_date'] ?? null;
    $sql = "SELECT students.name, attendance.date, attendance.status 
            FROM attendance 
            JOIN students ON attendance.student_id = students.id";

    if ($from_date && $to_date) {
        $sql .= " WHERE attendance.date BETWEEN '$from_date' AND '$to_date'";
    }

    $result = $conn->query($sql);
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Student Name', 'Date', 'Status']);

    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }

    fclose($output);
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generate Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 50%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77aacc 3px solid;
        }
        header a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        .main {
            padding: 30px;
            background: #fff;
            margin-top: 30px;
        }
        label, input, button {
            display: block;
            margin: 10px 0;
        }
        button {
            padding: 10px;
            background: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #555;
        }
        .links a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background: #333;
            color: #fff;
            text-decoration: none;
            text-align: center;
        }
        .links a:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Generate Report</h1>
        </div>
    </header>
    <div class="container main">
        <form action="generate_report.php" method="GET">
            <label for="from_date">From Date:</label>
            <input type="date" name="from_date" required>
            <label for="to_date">To Date:</label>
            <input type="date" name="to_date" required>
            <button type="submit">Generate Report</button>
        </form>
        <div class="links">
            <a href="index.php">Back to Main Page</a>
        </div>
    </div>
</body>
</html>
