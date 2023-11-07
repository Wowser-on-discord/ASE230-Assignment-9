<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
</head>
<body>

    <form method="POST">
        <br /><strong>Award to be added:</strong><br /><br />
        Award Name:<br />
        <input type="text" name="createYear" required /><br /><br />
        Award Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "awardsmanager.php";
                deleteItem();
                header("Location: index.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['printAllButton'])) {
                getAllItems();
                echo '<br /><br />';
            } else if (isset($_POST['getYear'])) {
                getItem();
                echo '<br /><br />';
            } else if (isset($_POST['originalYear'])) {
                modifyItem();
                echo '<br /><br />';
            } else if (isset($_POST['createYear']) && isset($_POST['createDescription']))  {
                include_once "awardsmanager.php";
                //createItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            }
        }
    ?>

    <a href="index.php">Back to awards Index<br /><br /></a>

</body>
</html>