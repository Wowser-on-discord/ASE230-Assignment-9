<?php

    function getAllItems() {
        $fileReading = fopen("../../data/awards.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $year = $data[0];
            $description = $data[1];
            
            echo "$year:<br>";
            echo "$description<br><br>";
        }

        fclose($fileReading);
    }


    function getItem() {
        $itemFound = false;
        $fileReading = fopen("../../data/awards.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $year = $data[0];
            $description = $data[1];
            
            if ($year === $_POST['getYear']) {
                echo "$year:<br>";
                echo "$description<br><br>";
                $itemFound = true;
            }
        }
        
        if (!$itemFound) {
            echo "Year does not exist.";
        }

        fclose($fileReading);
    }


    function createItem() {
        if (!empty($_POST['createYear']) && !empty($_POST['createDescription'])) {
            $fileWriting = fopen("../../data/awards.csv", "a");

            fputcsv($fileWriting, [$_POST['createYear'], $_POST['createDescription']]);

            fclose($fileWriting);

            echo "The year and description has been added successfully!";
            } else {
                echo "The year and description has NOT been added successfully!";
            }
    }


    function modifyItem() {
        if (!empty($_POST['originalYear']) && !empty($_POST['modifiedYear']) && !empty($_POST['modifiedDescription'])) {
            $originalYear = $_POST['originalYear']; 
            $modifiedYear = $_POST['modifiedYear']; 
            $modifiedDescription = $_POST['modifiedDescription']; 
            $modified = false;
            $fileReading = fopen("../../data/awards.csv", "r");
            $fileWriting = fopen("../../data/awards_temp.csv", "w");

            if ($fileReading !== false) {
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $originalYear) {
                        $data[0] = $modifiedYear;
                        $data[1] = $modifiedDescription;
                        $modified = true;
                    }
                    fputcsv($fileWriting, $data);
                }
                fclose($fileReading);

                if ($modified) {
                    fclose($fileWriting);
                    if(rename("../../data/awards_temp.csv", "../../data/awards.csv")) {
                        echo "The modification has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Year does not exist.";
                }
            }
        }
    }


    function deleteItem() {
        if (isset($_POST['deleteButton'])) {
            $deleted = false;
            $deleteYear = $_POST['deleteName']; 
            $fileReading = fopen("../../data/awards.csv", "r");
            $fileWriting = fopen("../../data/awards_temp.csv", "w");

            if ($fileReading !== false) {
                $items = [];
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $deleteYear) {
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

                    if(rename("../../data/awards_temp.csv", "../../data/awards.csv")) {
                        echo "The deletion has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Year does not exist.";
                }
            }
        }
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['deleteYear'])) {
            deleteItem();
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
        } else if (isset($_POST['createYear']) && isset($_POST['createDescription'])) {
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
    <title>awards.php</title>
</head>
<body>
    <form method="POST">
        <strong>Print out all items:</strong><br /><br />
        <button type="submit" name="printAllButton">Print all values</button>
    </form><br />

    <form method="POST">
        <br /><strong>Print out specific item:</strong><br />
        Year:<br />
        <input type="text" name="getYear" required /><br /><br />
        <button type="submit" name="specificButton">Print specific value</button>
    </form><br />

    <form method="POST">
        <br /><strong>Item to be added:</strong><br />
        Item Year:<br />
        <input type="text" name="createYear" required /><br /><br />
        Item Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        <button type="submit" name="createButton">Add these values</button>
    </form><br />

    <form method="POST">
        <br /><strong>Year of the value that you want to delete:</strong><br />
        <input type="text" name="deleteYear" required/><br /><br />
        <button type="submit" name="deleteButton">Delete this value</button>
    </form><br />

    <form method="POST">
        <br /><strong>Year of the value that you want to modify:</strong><br />
        Original Year:<br />
        <input type="text" name="originalYear" required /><br /><br />
        New Year:<br />
        <input type="text" name="modifiedYear" required /><br /><br />
        New Description:<br />
        <input type="text" name="modifiedDescription" required /><br /><br />
        <button type="submit" name="modifyButton">Modify this value</button>
    </form>
    
</body>
</html>
