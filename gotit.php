
<?php
require_once('class/function.php');
	global $fn;
	if(!$fn->checkLogin()){header('Location:'.URL_PATH.'login.php');}else{$fn->logOut();}
	
	if (isset($_SESSION['u_idsdp'])&& ($_SESSION['u_idsdp'])!="") {
		$u = PrivilegedUser::getByUsername($_SESSION['u_idsdp']);
	}else{$fn->logOut();}
	

$page = new Page;
$page->setTitle('Dashboard');
$page->startBody();
	if (!$u->hasPrivilege("Dashboard")) {
		$_SESSION['err']="Access Denied";
	}else{
	?>
        <?php $cls=(get_class_methods('functions'));?><pre>
			$args=array("name"=>"myModal3","title"=>"Edit Content Type","str"=>$str);
			$fn->modal_window($args);
		</pre>
<?php $fn->show_alert();?>
<?php
}
$page->endBody();
echo $page->render('inc/template.php');