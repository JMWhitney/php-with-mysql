<?php 

require_once('../../../private/initialize.php'); 

require_login();

//id = isset($_GET['id']) ? $_GET['id'] : 1; //PHP < 7.0
$id = $_GET['id'] ?? 1; //PHP > 7.0

$admin = find_admin_by_id($id);

?>

<?php $admin_title = 'Show admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>
    

    <div class="admin show">
    <h1>Admin: <?php echo htmlspecialchars($admin['username']); ?></h1>

        <div class="actions"> 
            <a class="action" href="<?php echo url_for('/staff/admins/edit.php?id=' . htmlspecialchars(urlencode($admin['id']))); ?>">edit</a>
            <a class="action" href="<?php echo url_for('/staff/admins/delete.php?id=' . htmlspecialchars(urlencode($admin['id']))); ?>">delete</a>
        </div>

        <div class="attributes">
            <dl>
                <dt>First Name:</dt>
                <dd><?php echo htmlspecialchars($admin['first_name']); ?></dd>
            </dl>
            <dl>
                <dt>Last Name:</dt>
                <dd><?php echo htmlspecialchars($admin['last_name']); ?></dd>
            </dl>
            <dl>
                <dt>Email:</dt>
                <dd><?php echo htmlspecialchars($admin['email']); ?></dd>
            </dl>
            <dl>
                <dt>Username:</dt>
                <dd><?php echo htmlspecialchars($admin['username']); ?></dd>
            </dl>
        </div>
    </div>
</div>



