<?php require_once('../../../private/initialize.php'); ?>

<?php

  $page_set = find_all_pages();

?>

<?php $page_title = 'Pages'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">
  <div class="subjects listing">
    <h1>Pages</h1>

    <div class="actions">
      <a class="action" href="<?php echo url_for('/staff/pages/new.php'); ?>">Create New Page</a>
    </div>

  	<table class="list">
  	  <tr>
        <th>ID</th>
        <th>Position</th>
        <th>Visible</th>
  	    <th>Name</th>
  	    <th>&nbsp;</th>
  	    <th>&nbsp;</th>
        <th>&nbsp;</th>
  	  </tr>

      <?php while($pages = mysqli_fetch_assoc($page_set)) { ?>
        <tr>
          <td><?php echo htmlspecialchars($pages['id']); ?></td>
          <td><?php echo htmlspecialchars($pages['subject_id']); ?></td>
          <td><?php echo htmlspecialchars($pages['position']); ?></td>
          <td><?php echo $pages['visible'] == 1 ? 'true' : 'false'; ?></td>
    	    <td><?php echo htmlspecialchars($pages['menu_name']); ?></td>
          <td><a class="action" href=
            "<?php echo url_for('/staff/pages/show.php?id=' . htmlspecialchars(urlencode($pages['id']))); ?>"
          >View</a></td>
          <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($pages['id']))); ?>">Edit</a></td>
          <td><a class="action" href="">Delete</a></td>
    	  </tr>
      <?php } ?>
  	</table>

    <?php
      mysqli_free_result($page_set);
    ?>

  </div>
</div>

<?php include(SHARED_PATH . '/staff_footer.php'); ?>
