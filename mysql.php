<?php
// Database Connection Details
$host = 'cmvz624va03yv01qk4qtg3cbh-addon-mysql';
$db   = 'ethiodeploy';
$user = 'ethiodeploy';
$pass = 'f8c490a515dc2ad5cd39684c22c4423b82f99c90a670fcb4';

// Connection banayein
$conn = new mysqli($host, $user, $pass, $db);

// Agar connection fail ho jaye to error dikhayein
if ($conn->connect_error) {
    die("<h1 style='color:red;'>Database Connection Failed: " . $conn->connect_error . "</h1>");
}

echo "<h2>Database se connect ho gaya! Ab import shuru ho raha hai...</h2>";

// Yahan apni SQL file ka exact naam daalein (agar extension .sql hai to wahan .sql laga dein)
// Dhyaan rahe: File usi folder mein honi chahiye jahan ye import.php hai
$sqlFile = 'portfolio_cms.sql'; 

// Check karein ki file exist karti hai ya nahi
if (!file_exists($sqlFile)) {
    die("<h1 style='color:red;'>Error: File nahi mili!</h1><p>Check karein ki '$sqlFile' naam ki file public folder mein upload hui hai ya nahi.</p>");
}

$sql = file_get_contents($sqlFile);

// Import execute karein
if ($conn->multi_query($sql)) {
    // Agar file mein multiple queries hain, to sabko execute hone dein
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());

    echo "<h1 style='color:green;'>Success! Database imported successfully.</h1>";
    echo "<p><b>Zaroori kaam:</b> Ab turant GitHub se <b>import.php</b> aur <b>SQL file</b> ko delete kar dein taaki aapka database secure rahe.</p>";
} else {
    echo "<h1 style='color:red;'>Import Error: " . $conn->error . "</h1>";
}

$conn->close();
?>