<?php
require __DIR__ . '/Db.php';
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get the username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Get the user details
  $result = getUserDetailsFromUserName($username);

  $authenticated = false;
  $user_role = "none";
  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $userPassword = $row["password"];
    // Verify the password
    if ($password == $userPassword) {
      $user_role = $row["user_role"];
      $authenticated = true;
    } else {
      // Invalid credentials, display an error message
      $error = "Invalid username or password!";
    }
  } else {
    // Invalid username, display an error message
    $error = "Invalid username or password!";
  }
  if ($authenticated) {
    setDataForUser($user_role);
    // Successful login, redirect to a dashboard page
    header("Location: dashboard.php");
  } else {
    // Invalid credentials, display an error message
    $error = "Invalid username or password!";
  }
}

function setDataForUser($user_role)
{
  unset($_SESSION['dashboard']);
  unset($_SESSION['aboutUs']);
  unset($_SESSION['manager']);
  unset($_SESSION['sales']);
  $_SESSION["current_user_role"] = $user_role;

  // Get privileges fot the current user role and then set it in session
  $result = getPrivilegesForUserRole($user_role);

  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      echo $row["dashboard_access"];
      if (str_contains($row["dashboard_access"], 'View') == true) {
        $_SESSION["dashboard"] = true;
      } else {
        $_SESSION["dashboard"] = false;
      }
      if (str_contains($row["aboutUs_access"], 'View') == true) {
        $_SESSION["aboutUs"] = true;
      } else {
        $_SESSION["aboutUs"] = false;
      }
      if (str_contains($row["managerList_access"], 'View') == true) {
        $_SESSION["manager"] = true;
        $_SESSION["manager_access"] = $row["managerList_access"];
      } else {
        $_SESSION["manager"] = false;
      }
      if (str_contains($row["salesPerson_access"], 'View') == true) {
        $_SESSION["sales"] = true;
        $_SESSION["salesPerson_access"] = $row["salesPerson_access"];
      } else {
        $_SESSION["sales"] = false;
      }
    }
  }
}
?>

<html>

<head>
  <title>Login Result</title>
</head>

<body>
  <h2>Login Result</h2>
  <?php if (isset($error)): ?>
    <p>
      <?php echo $error; ?>
    </p>
  <?php endif; ?>
</body>

</html>