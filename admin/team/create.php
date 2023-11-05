<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
</head>
<body>

    <form method="POST">
        <br /><strong>Item to be added:</strong><br />
        Title:<br />
        <input type="text" name="createTitle" required /><br /><br />
        Job Position:<br />
        <input type="text" name="createRole" required /><br /><br />
        Employee Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['createButton'])) {
            include_once "../CSVManager.php";
            $teamCsvFilePath = "../../data/team.csv";
            $teamDataHandler = new CSVManager($teamCsvFilePath);

            $createData = $_POST['createTitle'] . ',' . $_POST['createRole'] . ',' . $_POST['createDescription'];
            $teamDataHandler->createItem($createData);
            header("Location: index.php");
            exit();
            echo '<br /><br />';
        }
    }
    ?>

    <a href="index.php">Back to Team Index<br /><br /></a>

</body>
</html>
