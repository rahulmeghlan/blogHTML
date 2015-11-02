<?php

/**
 * @file
 * Bartik's theme implementation to display a single Drupal page.
 *
 * The doctype, html, head and body tags are not in this template. Instead they
 * can be found in the html.tpl.php template normally located in the
 * modules/system directory.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $directory: The directory the template is located in, e.g. modules/system
 *   or themes/bartik.
 * - $is_front: TRUE if the current page is the front page.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or
 *   prefix.
 * - $logo: The path to the logo image, as defined in theme configuration.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 * - $site_slogan: The slogan of the site, empty when display has been disabled
 *   in theme settings.
 * - $hide_site_name: TRUE if the site name has been toggled off on the theme
 *   settings page. If hidden, the "element-invisible" class is added to make
 *   the site name visually hidden, but still accessible.
 * - $hide_site_slogan: TRUE if the site slogan has been toggled off on the
 *   theme settings page. If hidden, the "element-invisible" class is added to
 *   make the site slogan visually hidden, but still accessible.
 *
 * Navigation:
 * - $main_menu (array): An array containing the Main menu links for the
 *   site, if they have been configured.
 * - $secondary_menu (array): An array containing the Secondary menu links for
 *   the site, if they have been configured.
 * - $breadcrumb: The breadcrumb trail for the current page.
 *
 * Page content (in order of occurrence in the default page.tpl.php):
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title: The page title, for use in the actual HTML content.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 * - $messages: HTML for status and error messages. Should be displayed
 *   prominently.
 * - $tabs (array): Tabs linking to any sub-pages beneath the current page
 *   (e.g., the view and edit tabs when displaying a node).
 * - $action_links (array): Actions local to the page, such as 'Add menu' on the
 *   menu administration interface.
 * - $feed_icons: A string of all feed icons for the current page.
 * - $node: The node object, if there is an automatically-loaded node
 *   associated with the page, and the node ID is the second argument
 *   in the page's path (e.g. node/12345 and node/12345/revisions, but not
 *   comment/reply/12345).
 *
 * Regions:
 * - $page['header']: Items for the header region.
 * - $page['featured']: Items for the featured region.
 * - $page['highlighted']: Items for the highlighted content region.
 * - $page['help']: Dynamic help text, mostly for admin pages.
 * - $page['content']: The main content of the current page.
 * - $page['sidebar_first']: Items for the first sidebar.
 * - $page['triptych_first']: Items for the first triptych.
 * - $page['triptych_middle']: Items for the middle triptych.
 * - $page['triptych_last']: Items for the last triptych.
 * - $page['footer_firstcolumn']: Items for the first footer column.
 * - $page['footer_secondcolumn']: Items for the second footer column.
 * - $page['footer_thirdcolumn']: Items for the third footer column.
 * - $page['footer_fourthcolumn']: Items for the fourth footer column.
 * - $page['footer']: Items for the footer region.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 * @see template_process()
 * @see bartik_process_page()
 * @see html.tpl.php
 */
?>

<?php /*Start Max pageer value*/
$query = db_select('node', 'n');
$query->join('field_data_field_featured_article', 'fa', 'n.nid = fa.entity_id');
$query->fields('n', array('nid', 'title', 'created'));
$query->condition('n.type','article','=');
$query->condition('n.status',1,'=');
$query->condition('fa.field_featured_article_value',0,'=');
$result = $query->execute();
$num_of_results = $result->rowCount();
$max_pages= floor( ($num_of_results-1)/5 );
/*End */
?>

<div class="menu_header">
  <div class="menu">
	<div class="logo">
	<?php if ($logo): ?>
	  <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
		<img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
	  </a>
	<?php endif; ?>
	</div>

	<?php if ($main_menu): ?>
	  <div id="main-menu">
		<?php print theme('links__system_main_menu', array(
		  'links' => $main_menu,
		  'attributes' => array(
			'id' => 'main-menu-links',
			'class' => array('links nav', 'clearfix'),
		  ),
		  'heading' => array(
			'text' => t('Main menu'),
			'level' => 'h2',
			'class' => array('element-invisible'),
		  ),
		)); ?>
	  </div> <!-- /#main-menu -->
	<?php endif; ?>

	<?php if ($secondary_menu): ?>
	  <div id="secondary-menu" class="navigation">
		<?php print theme('links__system_secondary_menu', array(
		  'links' => $secondary_menu,
		  'attributes' => array(
			'id' => 'secondary-menu-links',
			'class' => array('links', 'inline', 'clearfix'),
		  ),
		  'heading' => array(
			'text' => t('Secondary menu'),
			'level' => 'h2',
			'class' => array('element-invisible'),
		  ),
		)); ?>
	  </div> <!-- /#secondary-menu -->
	<?php endif; ?>

	<?php print render($page['header']); ?>
  </div>
</div>
<div class="menu_shadow"></div>
<!-- menu header end -->


<div class="container">
  <?php $query = db_select('node', 'n');
	$query->join('field_data_field_article_types', 'at', 'n.nid = at.entity_id');
	$query->join('taxonomy_term_data', 't', 'at.field_article_types_tid = t.tid');
	$query->join('field_data_field_featured_article', 'fa', 'n.nid = fa.entity_id');
	$query->join('field_data_field_featured_image', 'fi', 'n.nid = fi.entity_id');
	$query->join('file_managed', 'fm', 'fm.fid = fi.field_featured_image_fid');
	$query->fields('n', array('nid', 'title', 'created'));
	$query->fields('t', array('name'));
	$query->fields('fm', array('filename', 'uri'));
	$query->condition('n.type','article','=');
	$query->condition('n.status',1,'=');
	$query->condition('fa.field_featured_article_value',1,'=');

	$result = $query->execute();
	while($record = $result->fetchAssoc()) {
	  $node_records[] = $record['nid'].'~'.$record['name'].'~'.$record['created'].'~'.$record['title'];
	  $img[] = image_style_url('article_banners', $record['uri']);
	}
  ?>
  <div class="slider">
	<div id="slider" class="owl-carousel">
	<?php foreach($img as $img_path): ?>
		<div class="item"><img src="<?php print $img_path; ?>" alt=""></div>
	<?php endforeach; ?>
	</div>

	<div class="whiteWrap">
	  <div id="whiteslider" class="owl-carousel">
	  <?php foreach($node_records as $node_val): 
			  $val = explode('~', $node_val);
	  ?>
		<div class="item bannerContent">
		  <h1><?php print $val[1]; ?></h1>
		  <span class="date">Posted - <?php print format_date($val[2], 'custom', 'j F, Y'); ?></span>
		  <p><?php print $val[3]; ?></p>
		  <a href="<?php print drupal_get_path_alias('node/' . $val[0]); ?>" class="linkOne">read on</a>
		</div>
	  <?php endforeach; ?>
	  </div>
	</div>
  </div>

  <div class="show_me_form">
	<span>Show me </span>
	<span>
	  <select>
		<option>Select</option>
		<option>Popular</option>
		<option>new</option>
	  </select>
	</span>
	<span><input type="checkbox" name="checkbox1" id="checkbox1" class="styled" /> all</span>
	<span><input type="checkbox" name="checkbox1" id="checkbox1" class="styled" /> Videos</span>
	<span><input type="checkbox" name="checkbox1" id="checkbox1" class="styled" /> Articles</span>
	<span><input type="checkbox" name="checkbox1" id="checkbox1" class="styled" /> Galleries</span>
  </div>

  <div class="blog_container">
    <?php drupal_add_js(drupal_get_path('theme', 'discernblog') . '/js/load_more.js'); ?>
	<?php drupal_add_js(array('discernblog' => array('max_pages' => $max_pages)), array('type' => 'setting'));?>
	<?php print views_embed_view('articles_view', 'large'); ?>
  </div>
</div>
