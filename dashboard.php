<!DOCTYPE html>
<html>

<head>
  <title>Dashboard</title>
  <style>
    input[type="checkbox"] {
      width: 20px;
      height: 20px;
    }

    .tab-container {
      display: flex;
      align-items: center;
    }

    .custom-checkbox:checked {
      background-color: green;
    }

    .tab {
      flex-grow: 1;
      text-align: center;
      padding: 10px;
      background-color: #f2f2f2;
      cursor: pointer;
    }

    .tab.active {
      background-color: #ccc;
    }

    .content-container {
      margin-top: 20px;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
    }

    th,
    button,
    td {
      border: 1px solid #ccc;
      padding: 8px;
    }

    th {
      background-color: #f1f1f1;
      font-weight: bold;
    }
    body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

  footer {
  margin-top: auto;
  text-align: center;
  background-color: black;
  color: white;
}
  </style>
</head>

<body>
  <?php
  require __DIR__ . '/Db.php';
  session_start();

  // Checkboxes are checked or unchecked  then this gets called
  if (isset($_POST['checkboxes'])) {
    resetUserRolePrivileges();
    $selectedCheckboxes = $_POST['checkboxes']; // Get the selected checkboxes
    foreach ($selectedCheckboxes as $checkboxValue) {
      updateTheUserRolesState($checkboxValue);
    }
  }

  // Function to echo a tab
  function echoTab($tabName, $activeTab)
  {
    $class = ($tabName === $activeTab) ? 'tab active' : 'tab';
    echo '<a class="' . $class . '" href="?tab=' . $tabName . '">' . $tabName . '</a>';
  }

  // Function to echo content of setPrivilige tab
  function echoSetPriviligeContent()
  {
    // Generate the table
    echo '<h6>Please note : As of now due to time limitation have not added the default state handling of already selected
    priviliges so user has to select the priviliges all at once in the 1st load of this page and that will be selected priviliges.
    </h6>';
    echo '<form method="post">';
    echo '<h2> Manager Privileges </h2>';
    echo '<table>';
    echo '<tr>';
    echo '<th>Modules</th>';
    echo '<th>Access</th>';
    echo '<th>Add</th>';
    echo '<th>Update</th>';
    echo '<th>Delete</th>';
    echo '</tr>';
    for ($row = 1; $row <= 4; $row++) {
      echo '<tr>';
      echo '<th>' . getLabelBasedOnRow($row) . '</th>';
      $colEndRange = 1;
      if ($row == 1 || $row == 2) {
        $colEndRange = 1;
      } else {
        $colEndRange = 4;
      }
      for ($col = 1; $col <= 4; $col++) {
        $cellValue = "" . $row . "-" . $col . "-" . 1;
        echo '<td>';
        if ($col <= $colEndRange) {
          echo '<input type="checkbox" name="checkboxes[]" value="' . $cellValue . '" onchange="this.form.submit()"';

          if (isset($_POST['checkboxes']) && in_array($cellValue, $_POST['checkboxes'])) {
            echo ' checked';
          }

          echo '>';
        } else {
          // Do nothing in this cell
        }
        echo '</td>';
      }
      echo '</tr>';
    }

    echo '</table>';
    echo '<h2> Salesperson Privileges </h2>';
    echo '<table>';
    echo '<tr>';
    echo '<th>Modules</th>';
    echo '<th>Access</th>';
    echo '<th>Add</th>';
    echo '<th>Update</th>';
    echo '<th>Delete</th>';
    echo '</tr>';
    for ($row = 1; $row <= 4; $row++) {
      echo '<tr>';
      echo '<th>' . getLabelBasedOnRow($row) . '</th>';
      $colEndRange = 1;
      if ($row == 1 || $row == 2) {
        $colEndRange = 1;
      } else {
        $colEndRange = 4;
      }
      for ($col = 1; $col <= 4; $col++) {
        $cellValue = "" . $row . "-" . $col . "-" . 2;
        echo '<td>';
        if ($col <= $colEndRange) {
          echo '<input type="checkbox" name="checkboxes[]" value="' . $cellValue . '" onchange="this.form.submit()"';

          if (isset($_POST['checkboxes']) && in_array($cellValue, $_POST['checkboxes'])) {
            echo ' checked';
          }

          echo '>';
        } else {
          // Do nothing in this cell
        }
        echo '</td>';
      }
      echo '</tr>';
    }

    echo '</table>';

    echo '</form>';
  }

  function getLabelBasedOnRow($rowNumber)
  {
    if ($rowNumber == 1) {
      return "Dashboard";
    } else if ($rowNumber == 2) {
      return "About Us";
    } else if ($rowNumber == 3) {
      return "Manager List";
    } else {
      return "Salesperson List";
    }
  }

  /**
   * This function echoes the user table which contains the users for a specific role.
   */
  function echoTableContent($user_role)
  {
    $result = getUsersForSpecificUserRole($user_role);
    // Display the table
    if (mysqli_num_rows($result) > 0) {
      echo '<table>';
      echo '<thead>';
      echo '<tr>';
      echo '<th>First Name</th>';
      echo '<th>Last Name</th>';
      echo '<th>Email</th>';
      echo '<th>Action</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      $action = "";
      if ($user_role == "manager") {
        $action = $_SESSION["manager_access"];
      } else if ($user_role == "salesperson") {
        $action = $_SESSION["salesPerson_access"];
      }
      // Output data of each row
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row["first_name"] . '</td>';
        echo '<td>' . $row["last_name"] . '</td>';
        echo '<td>' . $row["email"] . '</td>';
        echo '<td>' . $action . '</td>';
        echo '</tr>';
      }

      echo '</tbody>';
      echo '</table>';
    } else {
      echo '<p>No data available.</p>';
    }
  }

  function echoDashboardContent()
  {
    echo '<h2> Dashboard</h2>';
    echo '<p>Welcome to the dashboard and I hope you will find this useful</p>';
  }

  function echoAboutUsContent()
  {
    echo '<h2>About us</h2>';
    echo '<p>As an eager learner I love seeking opportunities to keep growing. Currently in final year of B.Tech CS program of SVVV Indore and working as backend developer intern at EASYECOM , where my responsibilities include modifying the backend for the eCommerce website. I am responsible for integration of different marketplaces . I have done several customizations as per the requirements so that it can run smoothly and efficiently. Prior to joining EASYECOM I was Java Intern at Affimintus Technologies where I was responsible for creating the registration module for grocery shopping website using java. Worked on cart functionality in which user can perform crud operations (CREATE,DELETE,UPDATE,). Apart from my work experience , I have also worked on several projects during my academic session using data science which includes stock market prediction,credit card , movie recommendation system and chatbot application. In addition to my technical skills , I am a quick learner, team player and consider myself as focussed person and possess strong communication skills.</p>';
  }

  // Check the active tab and display the corresponding content
  $activeTab = $_GET['tab'] ?? "";

  echo '<div class="tab-container">';

  if ($_SESSION["dashboard"] == true) {
    echoTab('Dashboard', $activeTab);
    if ($activeTab == "") {
      $activeTab = 'Dashboard';
    }
  }

  if ($_SESSION["aboutUs"] == true) {
    echoTab('About us', $activeTab);
    if ($activeTab == "") {
      $activeTab = 'About us';
    }
  }

  if ($_SESSION["manager"] == true) {
    echoTab('Manager List', $activeTab);
    if ($activeTab == "") {
      $activeTab = 'Manager List';
    }
  }

  if ($_SESSION["sales"] == true) {
    echoTab('Salesperson List', $activeTab);
    if ($activeTab == "") {
      $activeTab = 'Salesperson List';
    }
  }

  if ($_SESSION["current_user_role"] == "super_admin") {
    echoTab('Set Privilige', $activeTab);
  }
  echo '</div>';

  if ($activeTab === 'Dashboard') {
    echoDashboardContent();
  } else if ($activeTab === 'About us') {
    echoAboutUsContent();
  } else if ($activeTab === 'Manager List') {
    echoTableContent("manager");
  } else if ($activeTab === 'Salesperson List') {
    echoTableContent("salesperson");
  } else if ($_SESSION["current_user_role"] == "super_admin"){
    echoSetPriviligeContent();
  } else {
    // If no tab is enabled for a user.
    echo "<h2>Sorry no content is available to you. Please contact admin!!!</h2>";
  }
  ?>

</body>

<footer>
  <p>Author: Deepesh Acharya</p>
  <p><a href="mailto:deepeshac280@gmail.com">deepeshac280@gmail.com</a></p>
</footer>
</html>