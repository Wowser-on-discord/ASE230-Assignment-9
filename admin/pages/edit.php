<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>
<body>
    <form method="POST">
        <br /><strong>Name of the value that you want to modify:</strong><br />
        Original Name:<br />
        <input type="text" name="originalName" id="originalNameTextBox" required /><br /><br />
        New Name:<br />
        <input type="text" name="modifiedName" required /><br /><br />
        New Role:<br />
        <input type="text" name="modifiedRole" required /><br /><br />
        New Description:<br />
        <input type="text" name="modifiedDescription" required /><br /><br />

        <button type="submit" name="modifyButton">Save Changes</button>
    </form><br>

    <a href="index.php">Back to Team Index<br /><br /></a>

    <?php 
        function getItem($header) {
            $fileContents = file_get_contents("../../data/Info.txt");

            preg_match_all('/([A-Za-z\s]+):\s*([^:]+)(?=\n[A-Za-z\s]+:|$)/is', $fileContents, $matches, PREG_SET_ORDER);

            $data = [];

            foreach ($matches as $match) {
                $key = trim($match[1]);
                $value = trim($match[2]);
                $data[$key] = $value;
            }

            if (isset($data[$header])) {
                return $data[$header];
            } else {
                return '';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "team.php";
                deleteItem();
                header("Location: index.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['printAllButton'])) {
                include_once "team.php";
                //getAllItems();
                echo '<br /><br />';
            } else if (isset($_POST['getName'])) {
                include "team.php";
                //getItem();
                echo '<br /><br />';
            } else if (isset($_POST['originalName'])) {
                include_once "team.php";
                modifyItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['createName']) && isset($_POST['createRole']) && isset($_POST['createDescription'])) {
                include_once "team.php";
                createItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            }
        }

        if (isset($_GET['name'])) {
            $selectedName = $_GET['name'];

            if (!empty($selectedName)) {
                $name = getItem($selectedName);
            }
    ?>

    <script>
        window.onload = function() {
            var originalNameTextBox = document.getElementById("originalNameTextBox");

            if (<?php echo isset($name) ? 'true' : 'false'; ?>) {
                originalNameTextBox.value = "<?php echo $name; ?>";
            }
        };
    </script>
    <?php
        }
    ?>
</body>
</html>
