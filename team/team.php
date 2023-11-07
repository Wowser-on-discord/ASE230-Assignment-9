<?php

    function getAllItems() {
        $fileReading = fopen("../../data/team.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $name = $data[0];
            $role = $data[1];
            $description = $data[2];
            
            echo "$name:<br>";
            echo "$role<br>";
            echo "$description<br><br>";
        }

        fclose($fileReading);
    }


    function getItem() {
        $itemFound = false;
        $fileReading = fopen("../../data/team.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $name = $data[0];
            $role = $data[1];
            $description = $data[2];

            if ($name === $_POST['getName']) {
                echo "$name:<br>";
                echo "$role<br>";
                echo "$description<br><br>";
                $itemFound = true;
            } 
        }
        
        if (!$itemFound) {
            echo "Name does not exist.";
        }

        fclose($fileReading);
    }


    function createItem() {
    if (!empty($_POST['createName']) && !empty($_POST['createRole']) && !empty($_POST['createDescription'])) {
        $fileWriting = fopen("../../data/team.csv", "a");

        fputcsv($fileWriting, [$_POST['createName'], $_POST['createRole'], $_POST['createDescription']]);

        fclose($fileWriting);

        echo "The name, role, and description has been added successfully!";
        } else {
            echo "The name, role, and description has NOT been added successfully!";
        }
    }


    function modifyItem() {
        if (!empty($_POST['originalName']) && !empty($_POST['modifiedName']) && !empty($_POST['modifiedRole']) && !empty($_POST['modifiedDescription'])) {
            $originalName = $_POST['originalName']; 
            $modifiedName = $_POST['modifiedName']; 
            $modifiedRole = $_POST['modifiedRole']; 
            $modifiedDescription = $_POST['modifiedDescription']; 
            $modified = false;
            $fileReading = fopen("../../data/team.csv", "r");
            $fileWriting = fopen("../../data/team_temp.csv", "w");

            if ($fileReading !== false) {
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $originalName) {
                        $data[0] = $modifiedName;
                        $data[1] = $modifiedRole;
                        $data[2] = $modifiedDescription;
                        $modified = true;
                    }
                    fputcsv($fileWriting, $data);
                }
                fclose($fileReading);

                if ($modified) {
                    fclose($fileWriting);
                    if(rename("../../data/team_temp.csv", "../../data/team.csv")) {
                        echo "The modification has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Name does not exist.";
                }
            }
        }
    }


    function deleteItem() {
        if (isset($_POST['deleteButton'])) {
            $deleted = false;
            $deleteName = $_POST['deleteName']; 
            $fileReading = fopen("../../data/team.csv", "r");
            $fileWriting = fopen("../../data/team_temp.csv", "w");

            if ($fileReading !== false) {
                $items = [];
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $deleteName) {
                        $deleted = true;
                        continue;
                    }
                    $items[] = $data;
                }
                fclose($fileReading);

                if ($deleted) {
                    foreach ($items as $item) {
                        fputcsv($fileWriting, $item);
                    }
                    fclose($fileWriting);

                    if(rename("../../data/team_temp.csv", "../../data/team.csv")) {
                        echo "The deletion has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Name does not exist.";
                }
            }
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleteName'])) {
            deleteItem();
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
        } else if (isset($_POST['createName']) && isset($_POST['createRole']) && isset($_POST['createDescription'])) {
            createItem();
            echo '<br /><br />';
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>team.php</title>
</head>
<body>
    <form method="POST">
        <strong>Print out all names:</strong><br /><br />
        <button type="submit" name="printAllButton">Print all names</button>
    </form><br />

    <form method="POST">
        <br /><strong>Print out specific person:</strong><br />
        Name:<br />
        <input type="text" name="getName" required /><br /><br />
        <button type="submit" name="specificButton">Print specific value</button>
    </form><br />

    <form method="POST">
        <br /><strong>Item to be added:</strong><br />
        Name:<br />
        <input type="text" name="createName" required /><br /><br />
        Role:<br />
        <input type="text" name="createRole" required /><br /><br />
        Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <form method="POST">
        <br /><strong>Name of the value that you want to delete:</strong><br />
        <input type="text" name="deleteName" required/><br /><br />
        <button type="submit" name="deleteButton">Delete this value</button>
    </form><br />

    <form method="POST">
        <br /><strong>Name of the value that you want to modify:</strong><br />
        Original Name:<br />
        <input type="text" name="originalName" required /><br /><br />
        New Name:<br />
        <input type="text" name="modifiedName" required /><br /><br />
        New Role:<br />
        <input type="text" name="modifiedRole" required /><br /><br />
        New Description:<br />
        <input type="text" name="modifiedDescription" required /><br /><br />
        <button type="submit" name="modifyButton">Modify this value</button>
    </form>

</body>
</html>
