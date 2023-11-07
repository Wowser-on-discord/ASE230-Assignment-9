<?php

class Award
{
    private $year;
    private $name;
    private $description;

    public function __construct($year, $name, $description)
    {
        $this->year = $year;
        $this->name = $name;
        $this->description = $description;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getDescription()
    {
        return $this->description;
    }
}

class AwardsManager
{
    public static function handlePostRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['printAllButton'])) {
                self::getAllItems();
            } elseif (isset($_POST['getYear'])) {
                self::getItem($_POST['getYear']);
            } elseif (isset($_POST['createYear']) && isset($_POST['createDescription'])) {
                self::createItem(new Award($_POST['createYear'], "Award Name", $_POST['createDescription']));
            } elseif (isset($_POST['originalYear'])) {
                self::modifyItem($_POST['originalYear'], $_POST['modifiedYear'], $_POST['modifiedDescription']);
            } elseif (isset($_POST['deleteName'])) {
                self::deleteItem($_POST['deleteName']);
            }
        }
    }

    public static function getAllItems()
    {
        $fileReading = fopen("../../data/awards.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $year = $data[0];
            $description = $data[1];

            echo "$year:<br>";
            echo "$description<br><br>";
        }

        fclose($fileReading);
    }

    public static function getItem($getYear)
    {
        $itemFound = false;
        $fileReading = fopen("../../data/awards.csv", "r");

        while (($data = fgetcsv($fileReading)) !== false) {
            $year = $data[0];
            $description = $data[1];

            if ($year === $getYear) {
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

    public static function createItem(Award $award)
    {
        if (!empty($award)) {
            $fileWriting = fopen("../../data/awards.csv", "a");

            fputcsv($fileWriting, [$award->getYear(), $award->getName(), $award->getDescription()]);

            fclose($fileWriting);

            echo "The award has been added successfully!";
        } else {
            echo "The award has NOT been added successfully!";
        }
    }

    public static function modifyItem($originalYear, $modifiedYear, $modifiedDescription)
    {
        if (!empty($originalYear) && !empty($modifiedYear) && !empty($modifiedDescription)) {
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
                    if (rename("../../data/awards_temp.csv", "../../data/awards.csv")) {
                        echo "The modification has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Year does not exist.";
                }
            }
        }
    }

    public static function deleteItem($deleteName)
    {
        if (!empty($deleteName)) {
            $deleted = false;
            $fileReading = fopen("../../data/awards.csv", "r");
            $fileWriting = fopen("../../data/awards_temp.csv", "w");

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

                    if (rename("../../data/awards_temp.csv", "../../data/awards.csv")) {
                        echo "The deletion has been added successfully!";
                    }
                } else {
                    fclose($fileWriting);
                    echo "Year does not exist.";
                }
            }
        }
    }
}

AwardsManager::handlePostRequest();
?>
