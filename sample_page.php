<?php
require_once('class/function.php');
$page = new Page;
$page->setTitle('Home');
$page->startBody();
?>
<h2>Home</h2>
<?php
$page->endBody();
echo $page->render('inc/template.php');