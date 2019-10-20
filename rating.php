<?php
$userid = htmlspecialchars($_GET["userid"]);
// Connect to MySQL
$servername = "localhost";
$username = "";
$password = "";
$dbname = "";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql1 = "SELECT rating FROM AFRRanks WHERE userid=" . $userid . " ORDER BY datetime DESC LIMIT 1";
$result = mysqli_query($conn, $sql1);

// All good?
if ( !$result ) {
  // Nope
  $message  = 'Invalid query: ' . $link->error . "n";
  $message .= 'Whole query: ' . $query;
  die( $message );
}

// Set proper HTTP response headers
header( 'Content-Type: application/json' );

// Print out rows
$data = array();
while ( $row = $result->fetch_assoc() ) {
  $data[] = $row;
}
echo json_encode( $data );

// Close the connection
mysqli_close($link);
?>
