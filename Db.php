<?php

/**
 * Function to create connection.
 */
function getConnection() {
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bitcot";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    return null;
}

return $conn;
}

/**
 * Reset the privileges set in the db so that they can be changes.
 * Our logic is based on invalidating all the privilege data and then setting
 * it again.
 */
function resetUserRolePrivileges() {
    $connection = getConnection();
    if ($connection == null) {
        return;
    }
    $sql = "UPDATE userroles SET dashboard_access=\"\",managerList_access=\"\",salesPerson_access=\"\",aboutUs_access=\"\" where role_name != 'super_admin'";
    mysqli_query($connection, $sql);
    $connection->close();
}

/**
 * Update the priviliges by utilizing the checkboxes which are set.
 */
function updateTheUserRolesState($checkboxValue)
  {
    $connection = getConnection();

    if ($connection == null) {
        return;
    }
    $identifiers = explode('-', $checkboxValue);
    $user_role = "";
    if ($identifiers[2] == 1) {
      $user_role = "manager";
    } else if ($identifiers[2] == 2) {
      $user_role = "salesperson";
    } else {
      return;
    }

    $column_name = "";
    if ($identifiers[0] == 1) {
      $column_name = "dashboard_access";
    } else if ($identifiers[0] == 2) {
      $column_name = "aboutUs_access";
    } else if ($identifiers[0] == 3) {
      $column_name = "managerList_access";
    } else if ($identifiers[0] == 4) {
      $column_name = "salesPerson_access";
    }

    $currentPrivileges = "";
    $currentPrivilegeSql = "SELECT $column_name from userroles where role_name='$user_role'";
    $result = mysqli_query($connection, $currentPrivilegeSql);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $currentPrivileges = $row[$column_name];
      }
    }

    if ($identifiers[1] == 1) {
      $currentPrivileges = $currentPrivileges . " View";
    } else if ($identifiers[1] == 2) {
      $currentPrivileges = $currentPrivileges . " Add";
    } else if ($identifiers[1] == 3) {
      $currentPrivileges = $currentPrivileges . " Edit";
    } else if ($identifiers[1] == 4) {
      $currentPrivileges = $currentPrivileges . " Delete";
    }
    // update user roles in db
    $sql = "UPDATE userroles SET $column_name = '$currentPrivileges' where role_name='$user_role'";
    mysqli_query($connection, $sql);
    $connection->close();
  }

  /**
   * Get users which have a specific user_role
   */
  function getUsersForSpecificUserRole($user_role) {
    $connection = getConnection();

    if ($connection == null) {
        return;
    }
    $sql = "SELECT * FROM users where user_role='$user_role'";
    $result = mysqli_query($connection, $sql);
    $connection->close();
    return $result;
  }

  function getPrivilegesForUserRole($user_role) {
    $connection = getConnection();

    if ($connection == null) {
        return;
    }
    // Fetch data from the database
    $sql = "SELECT * FROM userroles where role_name='$user_role'";
    $result = mysqli_query($connection, $sql);
    $connection->close();
    return $result;
  }

  function getUserDetailsFromUserName($username) {
    $connection = getConnection();

    if ($connection == null) {
        return;
    }
    // SQL query to retrieve user data
    $sql = "SELECT password, user_role FROM users WHERE user_name='$username'";

    // Execute the query
    $result = $connection->query($sql);
    $connection->close();
    return $result;
  }
?>