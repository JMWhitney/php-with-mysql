<?php require_once('../../../private/initialize.php'); ?>

<?php 

require_login();

//id = isset($_GET['id']) ? $_GET['id'] : 1; //PHP < 7.0
$id = $_GET['id'] ?? 1; //PHP > 7.0

$subject = find_subject_by_id($id);
$page_set = find_pages_by_subject_id($id);

?>

<?php $page_title = 'Show Subject'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/index.php'); ?>">&laquo; Back to List</a>

    <div class="subject show">
    <h1>Subject: <?php echo htmlspecialchars($subject['menu_name']); ?></h1>

        <div class="attributes">
            <dl>
                <dt>Menu Name</dt>
                <dd><?php echo htmlspecialchars($subject['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Position</dt>
                <dd><?php echo htmlspecialchars($subject['position']); ?></dd>
            </dl>
            <dl>
                <dt>Visible</dt>
                <dd><?php echo $subject['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
            <dl>
                <dt>Subject ID:</dt>
                <dd><?php echo htmlspecialchars($id); ?></dd>
            </dl>
        </div>

        <hr />

        <div class="pages listing">
        <h2>Pages</h2>

        <div class="actions">
            <a class="action" href="<?php echo url_for('/staff/pages/new.php?subject_id=' . htmlspecialchars(urlencode($subject['id']))); ?>">Create New Page</a>
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

            <?php while($page = mysqli_fetch_assoc($page_set)) { ?>
            <?php $subject = find_subject_by_id($page['subject_id']); ?>
            <tr>
                <td><?php echo htmlspecialchars($page['id']); ?></td>
                <td><?php echo htmlspecialchars($page['position']); ?></td>
                <td><?php echo $page['visible'] == 1 ? 'true' : 'false'; ?></td>
                <td><?php echo htmlspecialchars($page['menu_name']); ?></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/show.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">View</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/edit.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">Edit</a></td>
                <td><a class="action" href="<?php echo url_for('/staff/pages/delete.php?id=' . htmlspecialchars(urlencode($page['id']))); ?>">Delete</a></td>
            </tr>
            <?php } ?>
        </table>

        <?php mysqli_free_result($page_set); ?>

        </div>

    </div>
</div>


