<?php
/**
 * 工作日记
 * @author fotomxq <fotomxq.me>
 * @version 1
 * @package oa
 */
/**
 * 页面引用判断
 * @since 1
 */
if (isset($init_page) == false) {
    die();
}

/**
 * 初始化基础变量
 * @since 1
 */
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$max = 10;
$sort = 0;
$desc = true;
$post_type = 'text';
$post_status = 'private';

/**
 * 提示消息变量
 * @since 1
 */
$message = '';
$message_bool = false;

/**
 * 获取消息列表记录数
 * @since 1
 */
$table_list_row = $oapost->view_list_row($post_user, null, null, $post_status, $post_type);

/**
 * 计算页码
 * @since 1
 */
$page_max = ceil($table_list_row / $max);
if ($page < 1) {
    $page = 1;
} else {
    if ($page > $page_max) {
        $page = $page_max;
    }
}
$page_prev = $page - 1;
$page_next = $page + 1;

/**
 * 获取消息列表
 * @since 1
 */
//$table_list = $oapost->view_list($post_user, null, null, $post_status, $post_type, $page, $max, $sort, $desc);
$table_list = $oapost->view_list(null, null, null, $post_status, $post_type, $page, $max, $sort, $desc);
?>
<!-- 管理表格 -->
<h2>工作日记本</h2>
<table class="table table-hover table-bordered table-striped">
    <thead>
        <tr>
            <th><i class="icon-tag"></i> 日记标题</th>
            <th><i class="icon-calendar"></i> 创建时间</th>
            <th><i class="icon-asterisk"></i> 操作</th>
        </tr>
    </thead>
    <tbody id="message_list">
        <?php if ($table_list) {
            foreach ($table_list as $v) { ?>
                <tr>
                    <td><a href="<?php echo $page_url.'&view='.$v['id']; ?>" target="_self"><?php echo $v['post_title']; ?></a></td>
                    <td><?php echo $v['post_date']; ?></td>
                    <td><div class="btn-group"><a href="<?php echo $page_url.'&view='.$v['id']; ?>#view" class="btn"><i class="icon-search"></i> 查看</a></div></td>
                </tr>
        <?php } } ?>
    </tbody>
</table>

<?php if (isset($_GET['view']) == true) { $view_res = $oapost->view($_GET['view']); if($view_res){ ?>
<!-- 查看信息 -->
<h2>查看日记</h2>
<div id="view" class="form-actions">
    <p><?php echo $view_res['post_title']; ?> - <?php echo $view_res['post_date']; ?></p>
    <p>&nbsp;</p>
    <p><?php echo $view_res['post_content']; ?></p>
    <p>&nbsp;</p>
    <div class="control-group">
        <div class="controls">
            <a href="<?php echo $page_url; ?>" role="button" class="btn"><i class="icon-arrow-left"></i> 返回</a>
        </div>
    </div>
</div>
<?php } } ?>

<!-- Javascript -->
<script>
    $(document).ready(function() {
        var message = "<?php echo $message; ?>";
        var message_bool = "<?php echo $message_bool ? '2' : '1'; ?>";
        if (message != "") {
            msg(message_bool, message, message);
        }
    });
</script>

