<!DOCTYPE html>
<html>
<head>
    <title>View Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
            <h1>View Attendance</h1>
        </div>
    </header>
    <div class="container main">
        <form action="view_attendance.php" method="GET">
            <label for="from_date">From Date:</label>
            <input type="date" name="from_date" required>
            <label for="to_date">To Date:</label>
            <input type="date" name="to_date" required>
            <button type="submit">Filter</button>
        </form>
        <table>
            <tr>
                <th>Student Name</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
            <?php
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'attendance_system');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $from_date = $_GET['from_date'] ?? null;
            $to_date = $_GET['to_date'] ?? null;
            $sql = "SELECT students.name, attendance.date, attendance.status 
                    FROM attendance 
                    JOIN students ON attendance.student_id = students.id";

            if ($from_date && $to_date) {
                $sql .= " WHERE attendance.date BETWEEN '$from_date' AND '$to_date'";
            }

            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['status']}</td>
                      </tr>";
            }

            $conn->close();
            ?>
        </table>
        <div class="links">
            <a href="index.php">Back to Main Page</a>
        </div>
    </div>
</body>
</html>
