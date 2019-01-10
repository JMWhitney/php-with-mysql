<?php

// This guide demonstrates the five fundamental steps
// of database interaction using PHP.

// Credentials
$dbhost = 'localhost';
$dbuser = 'webuser';
$dbpass = 'secretpassword';
$dbname = 'globe_bank';

// 1. Create a database connection
$connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

//Test if connection succeeded
//Note: mysqli_connect_errno() is slightly faster than mysql_connect_error()
if(mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " (" .mysqli_connect_errno() . ")";
    exit($msg);
}

// 2. Perform database query
// ** MAKE SURE TO SANITIZE AND DELIMIT (single quotes around data)
// ALL DYNAMIC QUERIES TO PREVENT SQL INJECTION ATTACKS. **
// You can also use prepared statements to prevent SQL injection
// e.g. mysqli_real_escape_string($connection, $string);

$query = "SELECT * FROM subjects";
$result_set = mysqli_query($connection, $query);

//2.5 Prepared statement example

$sql = "SELECT id, first_name,last_name ";
$sql .= "FROM users ";
$sql .= "WHERE username = ? AND password = ?";
$stmt = mysqli_prepare($connection, $sql);

mysqli_stmt_bind_param($stmt, 'ss', $username, $password);

mysqli_stmt_execute($stmt);

mysqli_stmt_bind_result($stmt, $id, $first_name, $last_name);

mysqli_stmt_fetch($stmt);

mysqli_stmt_close($stmt);

// End prepared statement example

//Test if query succeeded
if(!$result_set) {
    exit("Database query failed.");
}

// 3. Use returned data (if any)
while($subject = mysqli_fetch_assoc($result_set)) {
    echo $subject["menu_name"] . "<br />";
}

// 4. Release returned data
mysqli_free_result($result_set);

// 5. Close database connection
mysqli_close($connection);

?>
