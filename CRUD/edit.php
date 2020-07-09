<?php
require_once "pdo.php";
if(!isset($_SESSION['name'])){
    die("Not logged in");

}
session_start();

if ( isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])
     && isset($_POST['mileage']) && isset($_POST['auto_id']) ){

    // Data validation
    if ( strlen($_POST['make']) < 1 && strlen($_POST['model']) < 1 ){
        $_SESSION['error'] = 'Make must provided';
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }

    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = 'Year and mileage must be numeric';
        header("Location: edit.php?auto_id=".$_POST['auto_id']);
        return;
    }


    $sql = "UPDATE autos SET make = :make, model = :model,
            year = :year, mileage = :mileage
            WHERE auto_id = :auto_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index1.php' ) ;
    return;
}

// Guardian: Make sure that auto_id is present
if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index1.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index1.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$m = htmlentities($row['make']);
$md = htmlentities($row['model']);
$y = htmlentities($row['year']);
$i = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];
?>
<html>
    <head>
        <title>Tirth Patel</title>
    </head>
    <body>
<p>Edit User</p>
<form method="post">
<p>make:
<input type="text" name="make" value="<?= $m ?>"></p>
<p>model:
<input type="text" name="model" value="<?= $md ?>"></p>
<p>year:
<input type="text" name="year" value="<?= $y ?>"></p>
<p>mileage:
<input type="text" name="mileage" value="<?= $i ?>"></p>
<input type="hidden" name="auto_id" value="<?= $auto_id ?>">
<p><input type="submit" value="Save">
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>