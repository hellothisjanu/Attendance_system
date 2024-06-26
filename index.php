<!DOCTYPE html>
<html>
<head>
    <title>Attendance Management System</title>
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
        label, select, button {
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
        .links {
            margin-top: 20px;
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
            <h1>Attendance Management System</h1>
        </div>
    </header>
    <div class="container main">
        <form action="mark_attendance.php" method="POST">
            <label for="student">Select Student:</label>
            <select name="student_id" required>
                <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'attendance_system');

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch students from the database
                $result = $conn->query("SELECT id, name FROM students");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                $conn->close();
                ?>
            </select>
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Late">Late</option>
            </select>
            <button type="submit">Mark Attendance</button>
        </form>
        <div class="links">
            <a href="view_attendance.php">View Attendance</a>
            <a href="generate_report.php">Generate Report</a>
        </div>
    </div>
</body>
</html>
