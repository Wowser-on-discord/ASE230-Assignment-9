<?php

    function getAllItems() {
        $fileReading = fopen("../../data/contacts.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $name = $data[0];
            $email = $data[1];
            $subject = $data[2];
            $message = $data[3];
            
            echo "$name:<br>";
            echo "$email<br>";
            echo "$subject<br>";
            echo "$message<br><br>";
        }

        fclose($fileReading);
    }


    function getItem() {
        $itemFound = false;
        $fileReading = fopen("../../data/contacts.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $name = $data[0];
            $email = $data[1];
            $subject = $data[2];
            $message = $data[3];

            if ($name === $_POST['getName']) {
                echo "$name:<br>";
                echo "$email<br>";
                echo "$subject<br>";
                echo "$message<br><br>";
                $itemFound = true;
            } 
        }
        
        if (!$itemFound) {
            echo "Name does not exist.";
        }

        fclose($fileReading);
    }


    function createItem() {
        if (!empty($_POST['createName']) && !empty($_POST['createEmail']) && !empty($_POST['createSubject']) && !empty($_POST['createMessage'])) {
            $fileWriting = fopen("../../data/contacts.csv", "a");

            fputcsv($fileWriting, [$_POST['createName'], $_POST['createEmail'], $_POST['createSubject'], $_POST['createMessage']]);

            fclose($fileWriting);

            echo "The name, email, subject, and message has been added successfully!";
            } else {
                echo "The name, email, subject, and message has NOT been added successfully!";
            }
    }


    function modifyItem() {
        if (!empty($_POST['originalName']) && !empty($_POST['modifiedName']) && !empty($_POST['modifiedEmail']) && !empty($_POST['modifiedSubject']) && !empty($_POST['modifiedMessage'])) {
            $originalName = $_POST['originalName']; 
            $modifiedName = $_POST['modifiedName']; 
            $modifiedEmail = $_POST['modifiedEmail']; 
            $modifiedSubject = $_POST['modifiedSubject']; 
            $modifiedMessage = $_POST['modifiedMessage'];
            $modified = false;
            $fileReading = fopen("../../data/contacts.csv", "r");
            $fileWriting = fopen("../../data/contacts_temp.csv", "w");

            if ($fileReading !== false) {
                while (($data = fgetcsv($fileReading)) !== false) {
                    if ($data[0] === $originalName) {
                        $data[0] = $modifiedName;
                        $data[1] = $modifiedEmail;
                        $data[2] = $modifiedSubject;
                        $data[3] = $modifiedMessage;
                        $modified = true;
                    }
                    fputcsv($fileWriting, $data);
                }
                fclose($fileReading);

                if ($modified) {
                    fclose($fileWriting);
                    if(rename("../../data/contacts_temp.csv", "../../data/contacts.csv")) {
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
            $fileReading = fopen("../../data/contacts.csv", "r");
            $fileWriting = fopen("../../data/contacts_temp.csv", "w");

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

                    if(rename("../../data/contacts_temp.csv", "../../data/contacts.csv")) {
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
        } else if (isset($_POST['createName']) && isset($_POST['createEmail']) && isset($_POST['createSubject']) && isset($_POST['createMessage'])) {
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
    <title>contacts.php</title>
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
        Email:<br />
        <input type="text" name="createEmail" required /><br /><br />
        Subject:<br />
        <input type="text" name="createSubject" required /><br /><br />
        Message:<br />
        <input type="text" name="createMessage" required /><br /><br />
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
        New Email:<br />
        <input type="text" name="modifiedEmail" required /><br /><br />
        New Subject:<br />
        <input type="text" name="modifiedSubject" required /><br /><br />
        New Message:<br />
        <input type="text" name="modifiedMessage" required /><br /><br />
        <button type="submit" name="modifyButton">Modify this value</button>
    </form>

</body>
</html>
