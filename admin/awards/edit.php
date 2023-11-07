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
    <input type="text" name="originalYear" id="originalNameTextBox" required /><br /><br />
    New Name:<br />
    <input type="text" name="modifiedYear" required /><br /><br />
    New Description:<br />
    <input type="text" name="modifiedDescription" required /><br /><br />

    <button type="submit" name="modifyButton">Save Changes</button></form>
    <br>

    <a href="../awards">Back to awards Index<br /><br /></a>

<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['deleteName'])) {
        include_once "awardsmanager.php";
        deleteItem();
        header("Location: index.php");
        exit();
        echo '<br /><br />';
    } else if (isset($_POST['printAllButton'])) {
        include_once "awardsmanager.php";
        //getAllItems();
        echo '<br /><br />';
    } else if (isset($_POST['getYear'])) {
        include "awardsmanager.php";
        //getItem();
        echo '<br /><br />';
    } else if (isset($_POST['originalYear'])) {
        include_once "awardsmanager.php";
        //modifyItem();
        header("Location: edit.php");
        exit();
        echo '<br /><br />';
    } else if (isset($_POST['createYear']) && isset($_POST['createDescription'])) {
        include_once "awardsmanager.php";
        createItem();
        header("Location: edit.php");
        exit();
        echo '<br /><br />';
    }
}

if (isset($_GET['name'])) {
    $selectedName = $_GET['name'];
    $csvFilePath = '../../data/awards.csv';
    $csvData = array_map('str_getcsv', file($csvFilePath));

    foreach ($csvData as $row) {
        if ($row[0] === $selectedName) {
            $name = $row[0];
            $selectedName = $_GET['name'];

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
    }
}
    ?>
</body>
</html>