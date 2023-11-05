<?php

    function getAllItems() {
        $fileContents = file_get_contents('../../data/info.json');
        $fileData = json_decode($fileContents, true);

        foreach ($fileData["information"] as $info) {
            $name = $info["name"] . " : ";
            $description = $info["description"];

            echo $name;
            echo $description;
            if (isset($info["applications"])) {
                echo "<br>Applications:<br>";
                foreach ($info["applications"] as $application => $description_2) {
                    echo "• $application: $description_2<br>";
                }
            } else {
                echo "No applications found<br>";
            }        
        }
    }


    function getItem() {
        if (isset($_POST['specificButton'])) {

            $itemFound = false;
            $itemName = $_POST['getName'];

            $fileContents = file_get_contents('../../data/info.json');
            $fileData = json_decode($fileContents, true);

            foreach ($fileData["information"] as $info) {
                if ($info["name"] === $itemName) {
                    $itemFound = true;
                    $name = $info["name"] . " : ";
                    $description = $info["description"];

                    echo $name;
                    echo $description;

                    if (isset($info["applications"])) {
                        echo "<br>Applications:<br>";
                        foreach ($info["applications"] as $application => $description_2) {
                            echo "• $application: $description_2<br>";
                        }
                    }
                }
            }

            if (!$itemFound) {
                echo "Item not found.";
            }
        }
    }


    function createItem() {
        if (!empty($_POST['createName']) && !empty($_POST['createDescription']) && !empty($_POST['createApplications']) && !empty($_POST['createApplicationsDesc']) && !empty($_POST['createSecondApplications']) && !empty($_POST['createSecondApplicationsDesc'])) {
            $filePath = '../../data/info.json';
            $fileContents = file_get_contents($filePath);
            $fileData = json_decode($fileContents, true);

            $createName = $_POST['createName'];
            $createDescription = $_POST['createDescription'];
            $createApplications = $_POST['createApplications'];
            $createApplicationsDesc = $_POST['createApplicationsDesc'];
            $createSecondApplications = $_POST['createSecondApplications'];
            $createSecondApplicationsDesc = $_POST['createSecondApplicationsDesc'];

            $newItem = [
                "name" => $createName,
                "description" => $createDescription,
                "applications" => [
                    $createApplications => $createApplicationsDesc,
                    $createSecondApplications => $createSecondApplicationsDesc,
                ],
            ];

            $fileData['information'][] = $newItem;

            $jsonData = json_encode($fileData);

            if (file_put_contents($filePath, $jsonData)) {
                echo "The item has been added successfully!";
            } else {
                echo "Failed to write data to the JSON file.";
            }
        } else {
            echo "Please fill in all fields.";
        }
    }

    function modifyItem() {
        if (
            !empty($_POST['originalName']) &&
            !empty($_POST['modifiedName']) &&
            !empty($_POST['modifiedDescription']) &&
            !empty($_POST['modifiedApplications']) &&
            !empty($_POST['modifiedApplicationsDesc']) &&
            !empty($_POST['modifiedSecondApplications']) &&
            !empty($_POST['modifiedSecondApplicationsDesc'])
        ) {
            $originalName = $_POST['originalName']; 
            $modifiedName = $_POST['modifiedName']; 
            $modifiedDescription = $_POST['modifiedDescription']; 
            $modifiedApplications = $_POST['modifiedApplications']; 
            $modifiedApplicationsDesc = $_POST['modifiedApplicationsDesc'];
            $modifiedSecondApplications = $_POST['modifiedSecondApplications'];
            $modifiedSecondApplicationsDesc = $_POST['modifiedSecondApplicationsDesc'];
            $modified = false;
            $filePath = '../../data/info.json';
            $fileContents = file_get_contents($filePath);
            $fileData = json_decode($fileContents, true);

            foreach ($fileData['information'] as &$info) {
                if ($info['name'] === $originalName) {
                    $info['name'] = $modifiedName;
                    $info['description'] = $modifiedDescription;
                    $info['applications'] = [
                        $modifiedApplications => $modifiedApplicationsDesc,
                        $modifiedSecondApplications => $modifiedSecondApplicationsDesc,
                    ];
                    $modified = true;
                    break;
                }
            }

            if ($modified) {
                $jsonData = json_encode($fileData);

                if (file_put_contents($filePath, $jsonData)) {
                    echo "The modification has been added successfully!";
                } else {
                    echo "Failed to write data to the JSON file.";
                }
            } else {
                echo "Name does not exist.";
            }
        }
    }


    function deleteItem() {
        if (isset($_POST['deleteButton'])) {
            $deleteName = $_POST['deleteName']; 
            $filePath = '../../data/info.json';
            $fileContents = file_get_contents($filePath);
            $fileData = json_decode($fileContents, true);

            $itemDeleted = false;

            foreach ($fileData['information'] as $key => $info) {
                if ($info['name'] === $deleteName) {
                    unset($fileData['information'][$key]);
                    $itemDeleted = true;
                    break;
                }
            }

            if ($itemDeleted) {
                $fileData['information'] = array_values($fileData['information']);

                $jsonData = json_encode($fileData);

                if (file_put_contents($filePath, $jsonData)) {
                    echo "The deletion has been added successfully!";
                } else {
                    echo "Failed to write data to the JSON file.";
                }
            } else {
                echo "Name does not exist.";
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
        } else if (isset($_POST['createName']) && isset($_POST['createDescription']) && isset($_POST['createApplications'])  && isset($_POST['createApplicationsDesc']) && isset($_POST['createSecondApplications'])  && isset($_POST['createSecondApplicationsDesc'])) {
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
    <title>products.php</title>
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
        New Applications:<br />
        <input type="text" name="modifiedApplications" required /><br /><br />
        New Applications Description:<br />
        <input type="text" name="modifiedApplicationsDesc" required /><br /><br />
        New Applications 2:<br />
        <input type="text" name="modifiedSecondApplications" required /><br /><br />
        New Applications 2 Description:<br />
        <input type="text" name="modifiedSecondApplicationsDesc" required /><br /><br />

        <button type="submit" name="modifyButton">Modify this value</button>
    </form>
    
</body>
</html>
