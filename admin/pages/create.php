<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Page</title>
</head>
<body>

    <form method="POST">
        <br /><strong>Info to be added:</strong><br /><br />
        Category Name:<br />
        <input type="text" name="createName" required /><br /><br />
        New Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "pages.php";
                deleteItem();
                header("Location: index.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['printAllButton'])) {
                getAllItems();
                echo '<br /><br />';
            } else if (isset($_POST['getName'])) {
                getItem();
                echo '<br /><br />';
            } else if (isset($_POST['originalName'])) {
                modifyItem();
                echo '<br /><br />';
            } else if (isset($_POST['createName']) && isset($_POST['createDescription']))  {
                include_once "pages.php";
                //createItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            }
        }
    ?>

    <a href="index.php">Back to Company Info Index<br /><br /></a>

</body>
</html>