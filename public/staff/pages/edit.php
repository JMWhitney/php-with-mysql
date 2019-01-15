<?php 
require_once('../../../private/initialize.php');

require_login();

//Make sure we have an id value. Otherwise redirect to previous page
if(!isset($_GET['id'])) {
    redirect_to(url_for('staff/pages/index.php'));
}
$id = $_GET['id'];
if(is_post_request()) {

  // Handle form values sent by new.php

  $page = [];
  $page['id'] = $id;
  $page['subject_id'] = $_POST['subject_id'] ?? '';
  $page['menu_name'] = $_POST['menu_name'] ?? '';
  $page['position'] = $_POST['position'] ?? '';
  $page['visible'] = $_POST['visible'] ?? '';
  $page['content'] = $_POST['content'] ?? '';
  
  $result = update_page($page);
  if($result === true) {
    $_SESSION['message'] = 'The page was updated successfully.';
    redirect_to(url_for('/staff/pages/show.php?id=' . $id));
  } else {
    $errors = $result;
  }
} else {
  $page = find_page_by_id($id);
}

$page_count = count_pages_by_subject_id($page['subject_id']);

?>

<?php $page_title = 'Edit Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

  <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . htmlspecialchars(urlencode($page['subject_id']))); ?>">&laquo; Back to subject page</a>

  <div class="page edit">
    <h1>Edit Page</h1>

    <?php echo display_errors($errors); ?>

    <form action="
    <?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($id))); ?>" method="post">
      <dl>
        <dt>Subject</dt>
        <dd>
          <select name="subject_id">
            <?php
              $subject_set = find_all_subjects(); 
              while($subject = mysqli_fetch_assoc($subject_set)) {
                echo "<option value=\"" . htmlspecialchars($subject['id']) . "\"";
                if($page["subject_id"] == $subject['id']) {
                  echo " selected";
                }
                echo ">" . htmlspecialchars($subject['menu_name']) . "</option>";
              }
              mysqli_free_result($subject_set);
            ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Menu Name</dt>
        <dd><input type="text" name="menu_name" value="<?php echo htmlspecialchars($page['menu_name']) ?>" /></dd>
      </dl>
      <dl>
        <dt>Position</dt>
        <dd>
          <select name="position">
            <option value="1"
            <?php 
              for($i = 1; $i <= $page_count; $i++) {
                echo "<option value=\"{$i}\"";
                if($page["position"] == $i) {
                  echo " selected";
                }
                echo ">{$i}</option>";
              }
            ?>
            >1</option>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>Visible</dt>
        <dd>
          <input type="hidden" name="visible" value="0" />
          <input type="checkbox" name="visible" value="1" 
          <?php if($page['visible'] == "1") { echo " checked"; } ?>
          />
        </dd>
      </dl>
      <dl>
          <dt>Content</dt>
          <dd>
            <textarea name="content" cols="60" rows="10"><?php echo htmlspecialchars($page['content']); ?></textarea>
          </dd>
      </dl>
      <div id="operations">
        <input type="submit" value="Edit Page" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
