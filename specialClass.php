<?php
class specialClass
{
    private $csvFilePath;

    public function __construct($csvFilePath)
    {
        $this->csvFilePath = $csvFilePath;
    }

    public function handlePostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['dataType'])) {
                $dataType = $_POST['dataType'];

                if ($dataType === 'awards') {
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
        if (!empty($createData)) {
            $fileWriting = fopen($this->csvFilePath, "a");

            $data = explode(',', $createData);
            fputcsv($fileWriting, $data);

            fclose($fileWriting);

            echo "Item has been added successfully!";
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

$awardsCsvFilePath = "../../data/awards.csv";
$awardsDataHandler = new CSVManager($awardsCsvFilePath);
$awardsDataHandler->handlePostRequest();

$teamCsvFilePath = "../../data/team.csv";
$teamDataHandler = new specialClass($teamCsvFilePath);
$teamDataHandler->handlePostRequest();
?>