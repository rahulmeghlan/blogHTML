<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<script type="text/javascript">
(function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
}(document));
</script>

<?php foreach ($rows as $id => $row): ?>
  <?php $large = $row; ?>
<?php endforeach; ?>

<?php
if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
  $r_css = 'blog_right';
  $l_css = 'pinterest';
  $right_data = $large;
  //$left_data = token_replace('[powr-pinterest-feed label="Enter a Label"]');
  $left_data = '<a href="https://www.pinterest.com/pinterest/official-news/" data-pin-do="embedBoard" data-pin-board-width="230"
   data-pin-scale-height="530" data-pin-scale-width="72"></a>';
  $_SESSION['flag']=0;
}else{
  $_SESSION['flag'] = $_SESSION['flag']+1;
  if($_SESSION['flag']%2!=0){
	$r_css = 'blog_left';
	$l_css = 'blog_right';
	$right_data = views_embed_view('articles_view', 'vertical');
	$left_data = $large;
  }else{
	$r_css = 'blog_right';
	$l_css = 'blog_left';
	$right_data = $large;
	$left_data = views_embed_view('articles_view', 'vertical');
  }
}
?>

<div class="major-blog_right">
  <div class="<?php print $r_css;?> blog_margin">
  <?php print $right_data; ?>
  </div>

  <div class="<?php print $l_css;?>">
  <?php print $left_data; ?>
  </div>

  <div style="display: inline-block;">
  <?php print views_embed_view('articles_view', 'small'); ?>
  </div>
</div>