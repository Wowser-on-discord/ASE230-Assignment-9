<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
</head>
<body>

    <?php
        if (isset($_GET['category'])) {
            $selectedCategory = $_GET['category'];

            $txtFilePath = '../../data/info.txt';

            if (file_exists($txtFilePath)) {
                $lines = file($txtFilePath, FILE_IGNORE_NEW_LINES);

                $found = false;
                foreach ($lines as $line) {
                    $parts = explode(':', $line, 2);

                    if (count($parts) >= 2) {
                        $category = $parts[0];
                        $value = $parts[1];

                        if ($category === $selectedCategory) {
                            echo "<h2>$category</h2>";
                            echo "<p>$value</p>";

                            echo "<p><a href='edit.php?category=" . urlencode($category) . "'>Edit</a> | <a href='delete.php?category=" . urlencode($category) . "'>Delete</a></p>";

                            $found = true;
                            break;
                        }
                    }
                }

                if (!$found) {
                    echo "<p>Category not found.</p>";
                }
            } else {
                echo "Text file not found.";
            }
        } else {
            echo "<p>No category selected.</p>";
        }
    ?>

</body>
</html>
