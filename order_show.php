<?php
session_start();
require_once 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Create an instance of the Database class
$database = new Database();

// Get the logged-in user's username
$username = $_SESSION['username'];


// Num of rows per page
$perPage = 2;


$totaltasks = $database->getReservationCountByUsername($username);


$totalPages = ceil($totaltasks / $perPage);


$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$currentPage = max(1, min($currentPage, $totalPages));


$offset = ($currentPage - 1) * $perPage;


$tasks = $database->getReservationDataByUsernameWithPagination($username, $perPage, $offset);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Task List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h1 {
            margin-bottom: 20px;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        
        .pagination a {
            padding: 8px 16px;
            text-decoration: none;
            color: #000;
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h1>Task List</h1>
    
    <table>
        <tr>
            <th>Task ID</th>
            <th>Task Type</th>
            <th>Task Area</th>
            <th>Task Item</th>
            <th>Task Content</th>
            <th>Task Status</th>
            <th>Creation Time</th>
            <th>Action</th>
        </tr>
        <?php foreach ($tasks as $task) { ?>
            <tr>
                <td><?php echo $task['task_num']; ?></td>
                <td><?php echo $task['service_type']; ?></td>
                <td><?php echo $task['service_area']; ?></td>
                <td><?php echo $task['service_item']; ?></td>
                <td><?php echo $task['service_content']; ?></td>
                <td><?php echo $task['Task_Status']; ?></td>
                <td><?php echo $task['Create_Date']; ?></td>
                <td>
                    <button onclick="editTask(<?php echo $task['task_num']; ?>)">Edit</button>
                    <button onclick="viewTask(<?php echo $task['task_num']; ?>)">View</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <div class="pagination">
        <?php if ($currentPage > 1) { ?>
            <a href="?username=<?php echo $username; ?>&page=<?php echo $currentPage - 1; ?>">Previous</a>
        <?php } ?>

        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <?php if ($i == $currentPage) { ?>
                <a href="?username=<?php echo $username; ?>&page=<?php echo $i; ?>" class="active"><?php echo $i; ?></a>
            <?php } else { ?>
                <a href="?username=<?php echo $username; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php } ?>
        <?php } ?>

        <?php if ($currentPage < $totalPages) { ?>
            <a href="?username=<?php echo $username; ?>&page=<?php echo $currentPage + 1; ?>">Next</a>
        <?php } ?>
    </div>

    <script>
        function editTask(task_num) {
            // Redirect to modify_reservation.php with the task ID parameter
            window.location.href = "modify_reservation.php?task_num=" + task_num + "&edit=true";
        }

        function viewTask(task_num) {
            // Handle view action
            window.location.href = "view_reservation.php?task_num=" + task_num;
        }
    </script>
</body>
</html>