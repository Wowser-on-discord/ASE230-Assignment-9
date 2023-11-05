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
                <th>Category</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $txtFilePath = '../../data/info.txt';

                if (file_exists($txtFilePath)) {
                    $lines = file($txtFilePath, FILE_IGNORE_NEW_LINES);

                    foreach ($lines as $line) {
                        $parts = explode(':', $line, 2);

                        if (count($parts) >= 2) {
                            $category = $parts[0];
                            $value = $parts[1];

                            echo "<tr>";
                            echo "<td><a href='detail.php?category=" . urlencode($category) . "'>$category</a></td>";
                            echo "<td>$value</td>";
                            echo "</tr>";
                        }
                    }
                } else {
                    echo "Text file not found.";
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
