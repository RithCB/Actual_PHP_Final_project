<?php 
session_start();
$view = $_GET['view'] ?? 'borrow';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}


?>


<?php
include("Database.php"); 

// Query to fetch student data
$query = "SELECT id, username, email FROM Client"; 
$result = mysqli_query($conn, $query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      display: flex;
      min-height: 100vh;
    }
    .sidebar {
      width: 250px;
      background-color: #343a40;
      color: white;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 15px;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main {
      flex-grow: 1;
      padding: 20px;
    }
    .table-responsive {
      max-height: 500px;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar p-3">
    <h4 class="text-center mb-4">Admin Panel</h4>
    <a href="admin_dashboard.php?view=borrow">Borrow Records</a>
    <a href="admin_dashboard.php?view=students">Student Information</a>
    <a href="index.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main">
    <?php if ($view === 'students'): ?>
      <h2>Student Information</h2>
      <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>Student ID</th>
              <th>Username</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['username']}</td>
                      <td>{$row['email']}</td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>

    <?php else: ?>
      <h2>Borrow Records</h2>
      <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped">
          <thead class="table-dark">
            <tr>
              <th>Record ID</th>
              <th>Student Name</th>
              <th>Book Title</th>
              <th>Borrowed Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // Replace this query with your actual borrow records query
            $borrowResult = mysqli_query($conn, "SELECT * FROM student_borrow");
            while ($row = mysqli_fetch_assoc($borrowResult)) {
              echo "<tr>
                      <td>{$row['borrowID']}</td>
                      <td>{$row['student_name']}</td>
                      <td>{$row['book_title']}</td>
                      <td>{$row['borrow_date']}</td>
                      <td>
                        <form action='delete_record.php' method='POST' onsubmit='return confirm(\"Are you sure?\");'>
                          <input type='hidden' name='record_id' value='{$row['borrowID']}'>
                          <button class='btn btn-sm btn-danger' type='submit'>Delete</button>
                        </form>
                      </td>
                    </tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

 

</body>
</html>
<?php 
mysqli_close($conn); 
// session_destroy();
?>
