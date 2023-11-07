<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item List</title>
</head>
<body>

<table border="1">
    <thead>
        <tr>
            <th>Year of Award</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $csvFilePath = '../../data/awards.csv';

            if (file_exists($csvFilePath)) {
                $csvData = array_map('str_getcsv', file($csvFilePath));

                if (count($csvData) > 0) {
                    array_shift($csvData); 
                }

                foreach ($csvData as $row) {
                    $name = $row[0]; 

                    echo "<tr>";
                    echo "<td><a href='detail.php?name=" . urlencode($name) . "'>$name</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "CSV file not found.";
            }
        ?>
    </tbody>
</table>
<br>
<br>
<br>
<a href="create.php">Create a new item<br /><br /></a>
</body>
</html>
