<?php require_once('../../../private/initialize.php'); ?>
<a href="<?php echo url_for('/staff/pages/index.php'); ?>"> << Back to List</a> <br><br>
<span>Page ID: </span>
<?php 

//id = isset($_GET['id']) ? $_GET['id'] : 1; //PHP < 7.0

$id = $_GET['id'] ?? 1; //PHP > 7.0

echo htmlspecialchars($id);

?>
