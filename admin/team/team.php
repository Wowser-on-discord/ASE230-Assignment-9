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
