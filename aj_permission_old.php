<?php
//print_r($_POST);die;
	require_once('class/function.php');
	global $fn;
	if(!$fn->checkLogin()){header('Location:'.URL_PATH.'login.php');}else{$fn->logOut();}
	if (isset($_SESSION['u_idsdp'])) {
		$u = PrivilegedUser::getByUsername($_SESSION['u_idsdp']);
	}
if($_POST["ajax_opt"]=="select_role"){
	if (!$u->hasPrivilege("Permission")) {
		$_SESSION['err']="Access Denied";
		 $fn->show_alert();
	}else{
		extract($_POST);
		$sql="SELECT rp.id AS rp_id, r.role_id, r.role_name, p.perm_id, p.perm_desc FROM v_role_perm AS rp INNER JOIN v_roles AS r ON r.role_id = rp.role_id INNER JOIN v_permissions AS p ON p.perm_id = rp.perm_id where r.role_id='".$erole_id."' ORDER BY p.perm_id desc ";
		$rows=$fn->raw_selectData($sql);
		
		?>
        <form action="permission/permission.php" method="post">
        <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Select Roles &amp; Permissions
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" value="" name="allchk" id="allchk"></th>
                                            <th>#</th>
                                            <th>Role</th>
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
									$i=1;
                                    foreach($rows as $r)
                                    {
										if($r['role_id']==1){$changable="disabled checked ";$pre="no_";}else{$changable="";$pre="";}
									?>
                                        <tr>
                                            <td><input  <?php echo $changable;?> type="checkbox" value="<?php echo $r['rp_id'] ?>" name="<?php echo $pre;?>rp_id[]" id="rp_id_<?php echo $r['rp_id'] ?>" class="rp_chk"></td>
                                            <td><?php echo $i; $i++;?></td>
                                            <td><?php echo $r['role_name'] ?></td>
                                            <td><?php echo $r['perm_desc'] ?></td>
                                        </tr>

                                    <?php
                                    }
									?>
                                        <tr>
                                            <td colspan="4"><input type="submit" name="Submit_del" id="Submit_del" class="btn btn-danger" value="Remove Permission" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                                    </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
		</form>
	<?php }?>
<?php }
?>