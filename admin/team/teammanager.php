<?php

class TeamMember
{
    public $name;
    public $role;
    public $description;

    public function __construct($name, $role, $description)
    {
        $this->name = $name;
        $this->role = $role;
        $this->description = $description;
    }
}

class TeamManager
{
    public static function handlePostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['printAllButton'])) {
                self::getAllItems();
            } elseif (isset($_POST['getName'])) {
                self::getItems($_POST['getName']);
            } elseif (isset($_POST['createName']) && isset($_POST['createRole']) && isset($_POST['createDescription'])) {
                self::createItem($_POST['createName'], $_POST['createRole'], $_POST['createDescription']);
            } elseif (isset($_POST['originalName'])) {
                self::modifyItem(
                    $_POST['originalName'],
                    $_POST['modifiedName'],
                    $_POST['modifiedRole'],
                    $_POST['modifiedDescription']
                );
            } elseif (isset($_POST['deleteName'])) {
                self::deleteItem($_POST['deleteName']);
            }
        }
    }

    public static function getAllItems()
    {
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

    public static function getItem($name)
    {
        $itemFound = false;
        $fileReading = fopen("../../data/team.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $nameFromFile = $data[0];
            $role = $data[1];
            $description = $data[2];

            if ($nameFromFile === $name) {
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

    public static function createItem($name, $role, $description)
    {
        if (!empty($name) && !empty($role) && !empty($description)) {
            $fileWriting = fopen("../../data/team.csv", "a");

            fputcsv($fileWriting, [$name, $role, $description]);

            fclose($fileWriting);

            echo "The name, role, and description have been added successfully!";
        } else {
            echo "The name, role, and description have NOT been added successfully!";
        }
    }

    public static function modifyItem($originalName, $modifiedName, $modifiedRole, $modifiedDescription)
    {
        if (!empty($originalName) && !empty($modifiedName) && !empty($modifiedRole) && !empty($modifiedDescription)) {
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
                    if (rename("../../data/team_temp.csv", "../../data/team.csv")) {
                        echo "The modification has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Name does not exist.";
                }
            }
        }
    }

    public static function deleteItem($name)
    {
        if (!empty($name)) {
            $deleted = false;
            $fileReading = fopen("../../data/team.csv", "r");
            $fileWriting = fopen("../../data/team_temp.csv", "w");

            if ($fileReading !== false) {
                $items = [];
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $name) {
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

                    if (rename("../../data/team_temp.csv", "../../data/team.csv")) {
                        echo "The deletion has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Name does not exist.";
                }
            }
        }
    }
}

TeamManager::handlePostRequest();

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
        <input type="text" name "createRole" required /><br /><br /> <!-- Added "createRole" field -->
        Description:<br />
        <input type="text" name="createDescription" required /><br /><br />
        <button type
