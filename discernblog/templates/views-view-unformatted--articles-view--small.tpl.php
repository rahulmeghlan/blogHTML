<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<?php $s_count = 0;
$rowsCount = count($rows);

foreach ($rows as $id => $row): 
  if($s_count>0){ $small_article_css = ' box_margin'; }else{ $small_article_css = ''; }
?>
  <div class="box1<?php print $small_article_css; ?>">
	<?php print $row; ?>
  </div>

<?php $s_count++;
endforeach;
?>