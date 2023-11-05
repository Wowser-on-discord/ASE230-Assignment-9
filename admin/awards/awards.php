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
