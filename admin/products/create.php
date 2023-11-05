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
        Name:<br />
        <input type="text" name="createName" required /><br /><br />
        Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        First Applications:<br />
        <input type="text" name="createApplications" required /><br /><br />
        First Application Description:<br />
        <input type="text" name="createApplicationsDesc" required /><br /><br />
        Second Application:<br />
        <input type="text" name="createSecondApplications" required /><br /><br />
        Second Application Description:<br />
        <input type="text" name="createSecondApplicationsDesc" required /><br /><br />
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "products.php";
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
            } else if (isset($_POST['createName']) && isset($_POST['createDescription']) && isset($_POST['createApplications']) && isset($_POST['createApplicationsDesc'])) {
                include_once "products.php";
                //createItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            }
        }
    ?>


</body>
</html>