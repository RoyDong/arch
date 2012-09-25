<?php $h->stylesheet( '/css/index.css' )?>
<?php $h->javascript( '/js/index.js' )?>
<script type="text/javascript">
    var TITLES = <?php echo json_encode($titles)?>;
</script>
<div id="title"><?php echo $article['title']?><span id="ctime"><?php echo date('Y/g/d' , $article['ctime'])?></span></div>
<div id="content"><?php echo $article['content']?></div>
<div id="article-bar">
    <div id="bar-prev">上一篇</div>
    <div id="bar-list">Loading...</div>
    <div id="bar-next">下一篇</div>
</div>