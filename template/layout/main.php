<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->title; ?></title>
        <?php echo $this->getStylesheets(); ?>
        <script type="text/javascript" src="/js/jquery.js"></script>
        <?php echo $this->getJavascripts(); ?>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>