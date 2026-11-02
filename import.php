<?php
$host = 'cmvz624va03yv01qk4qtg3cbh-addon-mysql';
$db   = 'ethiodeploy';
$user = 'ethiodeploy';
$pass = 'f8c490a515dc2ad5cd39684c22c4423b82f99c90a670fcb4';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Yahan apni file ka exact naam daalein (agar extension .sql hai to wahan .sql laga dein)
$sqlFile = 'portfolio_cms.sql'; 

if (!file_exists($sqlFile)) {
    die("File nahi mili. Check karein naam sahi hai ya nahi.");
}

$sql = file_get_contents($sqlFile);

if ($conn->multi_query($sql)) {
    echo "<h1>Database imported successfully!</h1>";
    echo "<p>Ab aap is file ko delete kar sakte hain.</p>";
} else {
    echo "Error: " . $conn->error;
}
$conn->close();
?>