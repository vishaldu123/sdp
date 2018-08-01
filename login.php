<?php
require_once('class/function.php');
	global $fn;
	if($fn->checkLogin()){
		header('Location:'.URL_PATH.'dashboard.php');
	}


$page = new Page;
$page->setTitle('Login');
$page->startBody();
?>
<?php $fn->show_alert();?>
<form role="form" class="form-signin" method="post" action="index.php">
    <fieldset>
        <div class="form-group">
            <input class="form-control" placeholder="User Name/Email address" type="text" name="uname" id="uname" autofocus>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Password" type="password" name="password" id="password">
        </div>
        <!-- Change this to a button or input when using this as a form -->
        <button class="btn btn-large btn-primary" name="commit" type="submit">Sign in</button>
    </fieldset>
</form>

<?php
$page->endBody();
echo $page->render('inc/blank_template.php');