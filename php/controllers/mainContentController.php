<?php
$rootName = "./root";
if (isset($_GET["searchValue"])) {
  echo createTableTitle("sear");
  echo searchItems($_GET["searchValue"]);
  echo "</table>";
} else if (isset($_GET["deleteUrl"])) {
  removeItem($rootName . $_GET["deleteUrl"]);
  $positionToCut = strripos($_GET["deleteUrl"], "/");
  $url = substr($_GET["deleteUrl"], 0, $positionToCut);
  $head = $url == "" ? "Refresh: 0; URL=index.php" : "Refresh: 0; URL=index.php?dir=$url";
  header($head);
} else if (isset($_GET["renameUrl"])) {
  echo renameItem($_GET["renameUrl"], $_GET["newName"]);
  $positionToCut = strripos($_GET["renameUrl"], "/");
  $url = substr($_GET["renameUrl"], 0, $positionToCut);
  $head = $url == "" ? "Refresh: 0; URL=index.php" : "Refresh: 0; URL=index.php?dir=$url";
  header($head);
} else if (isset($_GET["fileToMove"])) {
  echo moveItem($_GET["fileToMove"], $_GET["urlToMove"]);
  $positionToCut = strripos($_GET["fileToMove"], "/");
  $url = substr($_GET["fileToMove"], 0, $positionToCut);
  $head = $url == "" ? "Refresh: 0; URL=index.php" : "Refresh: 0; URL=index.php?dir=$url";
  header($head);
} else if (isset($_GET["newFolderUrl"])) {
  $folderName = $_GET["newFolderName"];
  $url = $_GET["newFolderUrl"];
  $url = substr($url, 6);
  $head = $url == "" ? "Refresh: 0; URL=index.php" : "Refresh: 0; URL=index.php?dir=$url";

  if (createFolder($folderName, $url)) {
    echo createFolder($folderName, $url);
  }

  header($head);
} else if (isset($_POST["uploadUrl"])) {
  $url = $_POST["uploadUrl"];
  $url = substr($url, 6);

  chdir("root/$url");
  $uploadFile = basename($_FILES["uploadFile"]["name"]);
  $head = $url == "" ? "Refresh: 0; URL=index.php" : "Refresh: 0; URL=index.php?dir=$url";

  if (uploadFile($uploadFile)) {
    echo uploadFile($uploadFile);
  }

  header($head);
} else if (empty($_GET["dir"])) {
  $directory = "";

  echo createTableTitle("nav", $rootName . $directory);
  echo printTableContent($rootName, $directory, "nav");
  echo "</table>";
} else {
  $directory = $_GET["dir"];

  if (strpos($directory, "/") == 0 && strpos($directory, ".") == 1) {
    echo "<script>alert('This is not a valid path');</script>";
    header("Refresh: 0; URL=index.php");
  } else {
    echo createTableTitle("nav", $rootName . $directory);
    echo printTableContent($rootName, $directory, "nav");
    echo "</table>";
  }
}
