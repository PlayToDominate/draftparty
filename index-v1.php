<?php
$servername = "localhost";
$username = "teschsco";
$password = "G0disgood!";

try {
    $conn = new PDO("mysql:host=$servername;dbname=teschsco_draftparty", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>

<?php 
$genericText="Hello World";
?>
<html>
<head>
<title>2019 Tesch NFL Draft Party</title>
</head>
<body>
<p><?= $genericText ?></p>
</body>
</html>