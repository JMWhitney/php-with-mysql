<?php 

require_once('../../../private/initialize.php');

require_login();

//Make sure we have an id value. Otherwise redirect to previous page
if(!isset($_GET['id'])) {
    redirect_to(url_for('staff/admin/index.php'));
}
$id = $_GET['id'];

if(is_post_request()) {

  // Handle form values sent by new.php
  $admin = [];
  $admin['id'] = $id;
  $admin['first_name'] = $_POST['first_name'] ?? '';
  $admin['last_name'] = $_POST['last_name'] ?? '';
  $admin['email'] = $_POST['email'] ?? '';
  $admin['username'] = $_POST['username'] ?? '';
  $admin['password'] = $_POST['password'] ?? '';
  $admin['confirm_password'] = $_POST['confirm_password'] ?? '';
  
  $result = update_admin($admin);
  if($result === true) {
    $_SESSION['message'] = 'Admin updated.';
    redirect_to(url_for('/staff/admins/show.php?id=' . $id));
  } else {
    $errors = $result;
  }

} else {
  $admin = find_admin_by_id($id);
}

?>

<?php $admin_title = 'Edit Admin'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/admins/index.php'); ?>">&laquo; Back to List</a>

  <div class="admin edit">
    <h1>Edit Admin</h1>

    <?php echo display_errors($errors); ?>

    <form action="
    <?php echo url_for('/staff/admins/edit.php?id=' . htmlspecialchars(urlencode($id))); ?>" method="post">
      <dl>
        <dt>First name</dt>
        <dd>
          <input type="text" name="first_name" value="<?php echo htmlspecialchars($admin['first_name']); ?>" />
        </dd>
      </dl>

      <dl>
        <dt>Last name</dt>
        <dd>
          <input type="text" name="last_name" value="<?php echo htmlspecialchars($admin['last_name']); ?>" />
        </dd>
      </dl>

      <dl>
        <dt>Username</dt>
        <dd>
          <input type="text" name="username" value="<?php echo htmlspecialchars($admin['username']); ?>" />
        </dd>
      </dl>

      <dl>
        <dt>Email</dt>
        <dd>
          <input type="text" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" />
        </dd>
      </dl>

      <dl>
        <dt>Password</dt>
        <dd>
          <input type="text" name="password" value="" />
        </dd>
      </dl>

      <dl>
        <dt>Confirm Password</dt>
        <dd>
          <input type="text" name="confirm_password" value="" />
        </dd>
      </dl>

      <p>
        Passwords should be at least 12 characters and include at least one uppercase letter, lowercase letter, number, and symbol.
      </p>
      <br />

      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>