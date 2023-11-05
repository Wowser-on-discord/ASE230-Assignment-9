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
        New Description:<br />
        <input type="text" name="modifiedDescription" required /><br /><br />
        New Applications:<br />
        <input type="text" name="modifiedApplications" required /><br /><br />
        New Applications Description:<br />
        <input type="text" name="modifiedApplicationsDesc" required /><br /><br />
        New Applications 2:<br />
        <input type="text" name="modifiedSecondApplications" required /><br /><br />
        New Applications 2 Description:<br />
        <input type="text" name="modifiedSecondApplicationsDesc" required /><br /><br />

        <button type="submit" name="modifyButton">Save Changes</button>
    </form><br>

    <a href="index.php">Go back to products<br /><br /></a>

    <?php 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['deleteName'])) {
                include_once "products.php";
                deleteItem();
                header("Location: index.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['printAllButton'])) {
                include_once "products.php";
                echo '<br /><br />';
            } else if (isset($_POST['getName'])) {
                include "products.php";
                echo '<br /><br />';
            } else if (isset($_POST['originalName'])) {
                include_once "products.php";
                modifyItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            } else if (isset($_POST['createName']) && isset($_POST['createDescription']) && isset($_POST['createApplications']) && isset($_POST['createApplicationsDesc'])) {
                include_once "products.php";
                createItem();
                header("Location: edit.php");
                exit();
                echo '<br /><br />';
            }
        }

        if (isset($_GET['name'])) {
            $selectedName = $_GET['name'];
            $jsonFilePath = '../../data/info.json';

            $jsonData = file_get_contents($jsonFilePath);

            $products = json_decode($jsonData, true);

            foreach ($products['information'] as $product) {
                if ($product['name'] === $selectedName) {
                    $name = $product['name'];
                    break;
                }
            }
        }
    ?>

    <script>
        window.onload = function() {
            var originalNameTextBox = document.getElementById("originalNameTextBox");
            var selectedName = "<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>"; 

            if (selectedName !== '') {
                var jsonData = <?php echo $jsonData; ?>;

                for (var i = 0; i < jsonData.information.length; i++) {
                    if (jsonData.information[i].name === selectedName) {
                        originalNameTextBox.value = selectedName;
                        break; 
                    }
                }
            }
        };
    </script>


</body>
</html>
