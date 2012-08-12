<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-language" content="utf-8">
        <title><?php echo $this->title?></title>
        <?php echo $h->stylesheets?>
        <script type="text/javascript" src="/js/jquery.js"></script>
        <?php echo $h->javascripts?>
    </head>
    <body>
        <?php echo $content; ?>
    </body>
</html>