<?php
require_once('class/function.php');
	global $fn;
	if(!$fn->checkLogin()){header('Location:'.URL_PATH.'login.php');}else{$fn->logOut();}
	
	if (isset($_SESSION['u_idsdp'])) {
		$u = PrivilegedUser::getByUsername($_SESSION['u_idsdp']);
	}
	

$page = new Page;
$page->setTitle('Role Management');
$page->startBody();
if (!$u->hasPrivilege("Role")) {
	$_SESSION['err']="Access Denied";
	 $fn->show_alert();
}else{
	$fn->show_alert();
	extract ($_GET);
    ?><h2>Role Management - Add Role</h2>
		 <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <form action="role/role.php" method="post" role="form">
                        <div class="form-group">
                            <label>Role Name</label>
                            <input class="form-control" type="text" value="" name="role_name" id="role_name">
                        </div>
                        <div class="form-group">
                            <input type="submit" name="Submit_role" id="Submit_role" class="btn btn-success " value="Add Role" >
                        </div>
                    </form>
                </div>
                <div class="col-lg-6">
                    <?php 
			$rows=$fn->selectData("v_roles" , "role_name", "", "",0);
			$i=1; 
			if($rows){?>
            <table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Roles</th>
				</tr>
			</thead>
            <tbody>
			<?php
			foreach($rows as $r){
				?>
				<tr>
                	<td><?php echo $i;$i++?></td><td><?php echo $r['role_name']?></td>
                </tr>
				<?php
				
				}?>
				</tbody></table>
				<?php }?>
                </div>
             </div>
         </div>
		<script type="text/javascript" src="<?php echo URL_PATH;?>js/jquery.js"></script>
        <script type="text/javascript">
        var jQuery_1_9_1 = $.noConflict(true);
        
        jQuery_1_9_1(document).ready(function($){
        
        $(document).on('click','#allchk', function(e){
        if(this.checked){
        $('.rp_chk').each(function(){
            this.checked = true;
        });
        }else{
         $('.rp_chk').each(function(){
            this.checked = false;
        });
        }
        });
        $(document).on('click','.rp_chk', function(e){
        if($('.rp_chk:checked').length == $('.rp_chk').length){
        $('#allchk').prop('checked',true);
        }else{
        $('#allchk').prop('checked',false);
        }
        });
        });
        </script>

<?php
}
$script="";
$page->addinscript($script);

$page->endBody();
echo $page->render('inc/template.php');