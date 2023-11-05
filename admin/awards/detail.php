<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Award Details</title>
</head>
<body>

<?php
if (isset($_GET['name'])) {
    $selectedName = $_GET['name'];

    $csvFilePath = '../../data/awards.csv';
    $csvData = array_map('str_getcsv', file($csvFilePath));

    foreach ($csvData as $row) {
        if ($row[0] === $selectedName) {
            $name = $row[0];
            $description = $row[1];

            echo "<h2>$name</h2>";
            echo "<p><strong>Description:</strong> $description</p>";

            echo "<p><a href='edit.php?name=" . urlencode($row[0]) . "'>Edit</a> | <a href='delete.php?name=" . urlencode($row[0]) . "'>Delete</a></p>";


            
        }
    }
} else {
    echo "<p>No item selected.</p>";
}
?>

</body>
</html>
