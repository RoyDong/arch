<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $this->title; ?></title>
        <?php echo $this->getStylesheets(); ?>
        <script type="text/javascript" src="/js/jquery.min.js"></script>
        <?php echo $this->getScripts(); ?>
    </head>
    <body>
        <?php echo $_content; ?>
    </body>
</html>