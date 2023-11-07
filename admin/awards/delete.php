<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item Page</title>
</head>
<body>

    <form method="POST">
        <br /><strong>Are you sure you want to delete an item?</strong><br />
        <br /><strong>Please re-enter the name of the item below to confirm its deletion.</strong><br />
        <input type="text" name="deleteName" required/><br /><br />
        <button type="submit" name="deleteButton">Delete this value</button>
    </form><br /><br />
    <a href="index.php">Back to awards Index<br /><br /></a>


    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "awardsmanager.php";
                //deleteItem($_POST['deleteName']);
                header("Location: index.php");
                exit();
            } else if (isset($_POST['printAllButton'])) {
                getAllItems();
                echo '<br /><br />';
            } else if (isset($_POST['getYear'])) {
                getItem();
                echo '<br /><br />';
            } else if (isset($_POST['originalYear'])) {
                modifyItem();
                echo '<br /><br />';
            } else if (isset($_POST['createYear']) && isset($_POST['createDescription'])) {
                include_once "awardsmanager.php";
                createItem();
                header("Location: edit.php");
                exit();
            }
        }

    ?>

</body>
</html>