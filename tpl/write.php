<?php $h->javascript(['/markitup/jquery.markitup.js', '/js/markitup.js'])?>
<?php $h->stylesheet(['/markitup/skins/markitup/style.css', '/markitup/sets/default/style.css'])?>
<script type="text/javascript" >
   $(document).ready(function() {
      $("#markItUp").markItUp(mySettings);
   });
</script>
<textarea id="markItUp"></textarea>