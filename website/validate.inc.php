<?php
require_once('database.php');
$emailAddress = $_POST['emailAddress'];
$password = $_POST['password'];
$query = "SELECT firstName, lastName, pronouns FROM TechCityManagers " .
        "WHERE emailAddress = ? AND password = SHA2(?,256)";
$db = getDB();
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $emailAddress, $password);
$stmt->execute();
$stmt->bind_result($firstName, $lastName, $pronouns);
$fetched = $stmt->fetch();
$name = "$firstName $lastName";
if ($fetched && $firstName && $lastName && $pronouns) {
   echo "<h2>Welcome to TechCity Inventory Helper $name</h2>\n";
   $_SESSION['login'] = true;
   $_SESSION['name'] = "$firstName $lastName";
   $_SESSION['firstName'] = $firstName;
   $_SESSION['lastName'] = $lastName;
   $_SESSION['pronouns'] = "$pronouns";
   
   header("Location: index.php");
} else {
   echo "<h2>Sorry, you cannot access the TechCity Inventory Helper because your login is incorrect.</h2>\n";
   echo "<a href=\"index.php\">Please try again</a>\n";
}
?>
