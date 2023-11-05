<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details</title>
</head>
<body>

    <?php
        if (isset($_GET['name'])) {
            $selectedName = $_GET['name'];

            $fileContents = file_get_contents('../../data/info.json');
            $fileData = json_decode($fileContents, true);

            foreach ($fileData["information"] as $info) {
                if ($info["name"] === $selectedName) {
                    echo "<h2>{$info['name']}</h2>";
                    echo "<p>{$info['description']}</p>";

                    if (isset($info['applications'])) {
                        echo "<h3>Applications:</h3>";
                        echo "<ul>";
                        foreach ($info['applications'] as $application => $description) {
                            echo "<li>$application: $description</li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>No applications found.</p>";
                    }
                    
                    echo "<p><a href='edit.php?name={$info['name']}'>Edit</a> | <a href='delete.php?name={$info['name']}'>Delete</a></p>";

                    break;
                }
            }
        } else {
            echo "<p>No item selected.</p>";
        }
    ?>

</body>
</html>
