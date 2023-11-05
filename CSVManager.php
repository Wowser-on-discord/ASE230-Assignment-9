<?php
class CSVManager
{
    private $csvFilePath;

    public function __construct($csvFilePath)
    {
        $this->csvFilePath = $csvFilePath;
    }

    public function handlePostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['printAllButton'])) {
                $this->getAllItems();
            } elseif (isset($_POST['getItemIdentifier'])) {
                $this->getItem($_POST['getItemIdentifier']);
            } elseif (isset($_POST['createData'])) {
                $this->createItem($_POST['createData']);
            } elseif (isset($_POST['modifyDataIdentifier'])) {
                $this->modifyItem($_POST['modifyDataIdentifier'], $_POST['modifyData']);
            } elseif (isset($_POST['deleteDataIdentifier'])) {
                $this->deleteItem($_POST['deleteDataIdentifier']);
            }
        }
    }

    public function getAllItems()
    {
        $fileReading = fopen($this->csvFilePath, "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            echo implode('<br>', $data) . '<br><br>';
        }

        fclose($fileReading);
    }

    public function getItem($getItemIdentifier)
    {
        $itemFound = false;
        $fileReading = fopen($this->csvFilePath, "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            if ($data[0] === $getItemIdentifier) {
                echo implode('<br>', $data) . '<br><br>';
                $itemFound = true;
            }
        }

        if (!$itemFound) {
            echo "Item not found.";
        }

        fclose($fileReading);
    }

    public function createItem($createData)
    {
        $fileWriting = fopen($this->csvFilePath, "a");
    
        if ($fileWriting === false) {
            echo "Failed to open the file for writing.";
            return;
        }
    
        if (!empty($createData)) {
            $data = explode(',', $createData);
            if (fputcsv($fileWriting, $data) === false) {
                echo "Failed to write data to the file.";
            } else {
                echo "Item has been added successfully!";
            }
            fclose($fileWriting);
        } else {
            echo "Item has NOT been added successfully!";
        }
    }
    
    public function modifyItem($modifyDataIdentifier, $modifyData)
    {
        if (!empty($modifyDataIdentifier) && !empty($modifyData)) {
            $modified = false;
            $fileReading = fopen($this->csvFilePath, "r");
            $fileWriting = fopen($this->csvFilePath . '_temp', "w");

            while (($data = fgetcsv($fileReading)) !== false) {
                if ($data[0] === $modifyDataIdentifier) {
                    $data = explode(',', $modifyData);
                    $modified = true;
                }
                fputcsv($fileWriting, $data);
            }

            fclose($fileReading);

            if ($modified) {
                fclose($fileWriting);
                if (rename($this->csvFilePath . '_temp', $this->csvFilePath)) {
                    echo "Item has been modified successfully!";
                }
            } else {
                fclose($fileWriting);
                echo "Item not found.";
            }
        }
    }

    public function deleteItem($deleteDataIdentifier)
    {
        if (!empty($deleteDataIdentifier)) {
            $deleted = false;
            $fileReading = fopen($this->csvFilePath, "r");
            $fileWriting = fopen($this->csvFilePath . '_temp', "w");

            while (($data = fgetcsv($fileReading)) !== false) {
                if ($data[0] === $deleteDataIdentifier) {
                    $deleted = true;
                    continue;
                }
                fputcsv($fileWriting, $data);
            }

            fclose($fileReading);

            if ($deleted) {
                fclose($fileWriting);
                if (rename($this->csvFilePath . '_temp', $this->csvFilePath)) {
                    echo "Item has been deleted successfully!";
                }
            } else {
                fclose($fileWriting);
                echo "Item not found.";
            }
        }
    }
}

$csvFilePath = "../data/awards.csv";
$csvManager = new CSVManager($csvFilePath);
$csvManager->handlePostRequest();
?>
