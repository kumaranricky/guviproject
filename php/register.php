<?php

// get form data
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// validate form data
if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
  $response = array('success' => false, 'message' => 'Please fill in all fields.');
} elseif ($password != $confirm_password) {
  $response = array('success' => false, 'message' => 'Passwords do not match.');
} else {
  // connect to database
  $conn = new mysqli('localhost', 'username', 'password', 'database_name');

  // prepare query
  $stmt = $conn->prepare('INSERT INTO users (username, email, password) VALUES (?, ?, ?)');
  $stmt->bind_param('sss', $username, $email, $password);

  // execute query
  if ($stmt->execute()) {
    $response = array('success' => true);
  } else {
    $response = array('success' => false, 'message' => 'Error inserting data into database.');
  }

  // close database connection
  $stmt->close();
  $conn->close();
}

// send response to client
header('Content-Type: application/json');
echo json_encode($response);