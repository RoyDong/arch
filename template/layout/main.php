<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8">
        <meta http-equiv="content-language" content="utf8">
        <title><?php echo $this->title; ?></title>
        <?php echo $this->getStylesheets(); ?>
        <script type="text/javascript" src="/js/jquery.js"></script>
        <?php echo $this->getJavascripts(); ?>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>