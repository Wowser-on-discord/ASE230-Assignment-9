<?php

    function getAllItems() {
        echo file_get_contents("../../data/Info.txt");
    }


    function getItem() {
        $fileContents = file_get_contents("../../data/Info.txt");

        preg_match_all('/([A-Za-z\s]+):\s*([^:]+)(?=\n[A-Za-z\s]+:|$)/is', $fileContents, $matches, PREG_SET_ORDER);

        $data = [];

        foreach ($matches as $match) {
            $header = trim($match[1]);
            $description = trim($match[2]);
            $data[$header] = $description;
        }

        $informationType = isset($_POST['infoType']) ? $_POST['infoType'] : '';

        if (!empty($informationType)) {
            if (isset($data[$informationType])) {
                echo $informationType . ": " . $data[$informationType];
            } else {
                echo $informationType . " not found in the file.";
            }
        } else {
            echo "Please select a valid header.";
        }
    }


    function createItem() {
        if (!empty($_POST['createName']) && !empty($_POST['createDescription'])) {
            $filePath = "../../data/Info.txt";

            $value = $_POST['createName'] . ": " . $_POST['createDescription'] . "<br>" . "\n";

            if (file_put_contents($filePath, $value, FILE_APPEND)) {

            echo "The name and description has been added successfully!";
            } else {
                echo "The name and description has NOT been added successfully!";
            }
        }
    }

    function modifyItem() {
        if (!empty($_POST['originalName']) && !empty($_POST['modifiedName']) && !empty($_POST['modifiedDescription'])) {
            $originalName = trim($_POST['originalName']);
            $modifiedName = $_POST['modifiedName'];
            $modifiedDescription = $_POST['modifiedDescription'];
            $filePath = "../../data/Info.txt";

            $fileContents = file_get_contents($filePath);

            preg_match_all('/([A-Za-z\s]+):\s*([^:]+)(?=\n[A-Za-z\s]+:|$)/is', $fileContents, $matches, PREG_SET_ORDER);

            $modified = false;
            $modifiedFileContents = '';

            foreach ($matches as $match) {
                $header = trim($match[1]);
                $description = trim($match[2]);

                if ($header === $originalName) {
                    $header = $modifiedName;
                    $description = $modifiedDescription;
                    $modified = true;
                }

                $modifiedFileContents .= $header . ': ' . $description . "<br>\n";
            }

            if ($modified) {
                if (file_put_contents($filePath, $modifiedFileContents)) {
                    echo "The modification has been added successfully!";
                } else {
                    echo "Failed to write modifications to the file.";
                }
            } else {
                echo "Name does not exist.";
            }
        }
    }

    function deleteItem() {
        if (isset($_POST['deleteButton'])) {
            $deleted = false;
            $deleteName = trim($_POST['deleteName']);
            $filePath = "../../data/Info.txt";
            $fileReading = fopen($filePath, "r");
            $fileWriting = fopen("../../data/Info_temp.txt", "w");

            if ($fileReading !== false) {
                while (($line = fgets($fileReading)) !== false) {
                    $data = explode(":", $line, 2);
                    $name = trim($data[0]);

                    if ($name === $deleteName) {
                        $deleted = true;
                        continue; 
                    }

                    fwrite($fileWriting, $line);
                }
                fclose($fileReading);
                fclose($fileWriting);

                if ($deleted) {
                    if (rename("../../data/Info_temp.txt", $filePath)) {
                        echo "The deletion has been added successfully!";
                    }
                } else {
                    unlink("../../data/Info_temp.txt");
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
        } else if (isset($_POST['specificButton'])) {
            getItem();
            echo '<br /><br />';
        } else if (isset($_POST['originalName'])) {
            modifyItem();
            echo '<br /><br />';
        } else if (isset($_POST['createName']) && isset($_POST['createDescription'])) {
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
    <title>pages.php</title>
</head>
<body>
    <form method="POST">
        <strong>Print out all names:</strong><br /><br />
        <button type="submit" name="printAllButton">Print all names</button>
    </form><br />

    <form method="POST">
        <br /><strong>Print out specific person:</strong><br />
        Name:<br />
        <input type="text" name="infoType" required /><br /><br />
        <button type="submit" name="specificButton">Print specific value</button>
    </form><br />

    <form method="POST">
        <br /><strong>Item to be added:</strong><br />
        Name:<br />
        <input type="text" name="createName" required /><br /><br />
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
        New Description:<br />
        <input type="text" name="modifiedDescription" required /><br /><br />
        <button type="submit" name="modifyButton">Modify this value</button>
    </form>
</body>
</html>
