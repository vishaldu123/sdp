<?php
//print_r($_POST);die;
	require_once('class/function.php');
	global $fn;
	if(!$fn->checkLogin()){header('Location:'.URL_PATH.'login.php');}else{$fn->logOut();}
	if (isset($_SESSION['u_idsdp'])) {
		$u = PrivilegedUser::getByUsername($_SESSION['u_idsdp']);
	}
if($_POST["ajax_opt"]=="select_role"){
	$page = new Page;
	$page->setTitle('Permission Management');
	$page->startBody();
	if (!$u->hasPrivilege("Permission")) {
		$_SESSION['err']="Access Denied";
		 $fn->show_alert();
	}else{
		
		?>
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th><input type="checkbox" value="" name="allchk" id="allchk"></th>
					<th>#</th>
					<th>Permission</th>
				</tr>
			</thead>
            <tbody>
			<?php
			if(@$_POST['r_id']!=""){
			$sql="SELECT p.perm_id, p.perm_desc FROM v_permissions AS p WHERE perm_id not in (select perm_id from v_role_perm where role_id = ".$_POST['r_id']." ) ";
			$rows=$fn->raw_selectData($sql);
			$i=1; 
			if($rows){
			foreach($rows as $r)
			{
			?>
				<tr>
					<td><input type="checkbox" value="<?php echo $r['perm_id'] ?>" name="perm_id[]" id="perm_id_<?php echo $r['perm_id'] ?>" class="rp_chk"></td>
					<td><?php echo $i; $i++;?></td>
					
					<td><?php echo $r['perm_desc'] ?></td>
				</tr>
			<?php
			}}else{?><tr>
					<td colspan="4"><strong>Not Available</strong></td>
				</tr><?php }
			?>
				<tr>
					<td colspan="4"><input type="submit" name="Submit_add" id="Submit_add" class="btn btn-success" value="Assign Permission"></td>
				</tr>
             <?php }else{?>
			 <tr>
					<td colspan="4"><strong>Not Available</strong></td>
				</tr>
			 <?php }?>
			</tbody>
		</table>
	<?php }?>
<?php }
?>