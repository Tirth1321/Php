
<?php
session_start();

require_once "pdo.php";


if ( isset($_POST['make'])  && isset($_POST['model']) && isset($_POST['year'])
     && isset($_POST['mileage'])) {

    // Data validation
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
        $_SESSION['error'] = 'All values are required';
        header("Location:add.php");
        return;
    }

    if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) {
        $_SESSION['error'] = 'Year and mileage must be numeric';
        header("Location:add.php");
        return;
    }

    $sql = "INSERT INTO autos (make,model, year, mileage)
              VALUES (:make,:model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index1.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<html>
    <head>
        <title>Tirth Patel</title>
    </head>
    <body>

    <p>Add A New Auto</p>
<form method="post">
<p>make:
<input type="text" name="make"></p>
<p>model:
<input type="text" name="model"></p>
<p>year:
<input type="text" name="year"></p>
<p>mileage:
<input type="mileage" name="mileage"></p>
<p><input type="submit" value="Add"/>
<a href="index.php">Cancel</a></p>
</form>
            
    </body>
</html>
