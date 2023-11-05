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
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $fileContents = file_get_contents('../../data/info.json');
                $fileData = json_decode($fileContents, true);

                foreach ($fileData["information"] as $info) {
                    echo "<tr>";
                    echo "<td><a href='detail.php?name=" . urlencode($info["name"]) . "'>" . $info["name"] . "</a></td>";
                    echo "</tr>";
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
