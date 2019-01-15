<?php require_once('../../../private/initialize.php'); ?>
<?php 

require_login();

//id = isset($_GET['id']) ? $_GET['id'] : 1; //PHP < 7.0
$id = $_GET['id'] ?? 1; //PHP > 7.0

$page = find_page_by_id($id);

?>

<?php $page_title = 'Show Page'; ?>
<?php include(SHARED_PATH . '/staff_header.php'); ?>

<div id="content">

    <a class="back-link" href="<?php echo url_for('/staff/subjects/show.php?id=' . htmlspecialchars(urlencode($page['subject_id']))); ?>">&laquo; Back to subject page</a>
    

    <div class="page show">
    <h1>Page: <?php echo htmlspecialchars($page['menu_name']); ?></h1>

        <div class="actions"> 
            <a class="action" href="<?php echo url_for('/index.php?id=' .htmlspecialchars(urlencode($page['id'])) . '&preview=true'); ?>" target="_blank">Preview page</a>
        </div>

        <div class="attributes">
            <?php $subject = find_subject_by_id($page['subject_id']); ?>
            <dl>
                <dt>Subject:</dt>
                <dd><?php echo htmlspecialchars($subject['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Menu Name:</dt>
                <dd><?php echo htmlspecialchars($page['menu_name']); ?></dd>
            </dl>
            <dl>
                <dt>Position:</dt>
                <dd><?php echo htmlspecialchars($page['position']); ?></dd>
            </dl>
            <dl>
                <dt>Visible:</dt>
                <dd><?php echo $page['visible'] == '1' ? 'true' : 'false'; ?></dd>
            </dl>
            <dl>
                <dt>Content:</dt>
                <dd><?php echo htmlspecialchars($page['content']); ?></dd>
            </dl>
        </div>
    </div>
</div>



