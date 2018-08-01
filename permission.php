<?php
require_once('class/function.php');
	global $fn;
	if(!$fn->checkLogin()){header('Location:'.URL_PATH.'login.php');}else{$fn->logOut();}
	
	
	if (isset($_SESSION['u_idsdp'])) {
		$u = PrivilegedUser::getByUsername($_SESSION['u_idsdp']);
	}
	

$page = new Page;
$page->setTitle('Permission Management');
$page->startBody();

if (!$u->hasPrivilege("Permission")) {
	$_SESSION['err']="Access Denied";
	 $fn->show_alert();
}else{
	extract ($_GET);
	if(!isset($task))
	{
		$task = "add";
	}
	 $fn->show_alert();
	 
	if($task == "delete")
	{
		?>
        <h2>Permission Management - Delete Permission</h2>
        <div class="panel-body">
        <div class="row">
        <div class="col-lg-6">
        <div class="panel-heading">
            Select Roles &nbsp;&nbsp;&nbsp;
            <select class="select_role form-control" required placeholder="SelectRole" id="drole_id" name="drole_id">
                <option value="" >Select</option>
            <?php
					$sql1="SELECT r.role_id, r.role_name FROM v_roles as r ORDER BY r.role_id ASC ";
		$rows2=$fn->raw_selectData($sql1);

            foreach($rows2 as $r1)
                    { ?>
                <option value="<?php echo $r1['role_id']; ?>"><?php echo $r1['role_name']; ?></option>
                <?php } ?>
            </select>
        </div>
		</div></div></div>
		<div class="drefresh_tr"><strong>Select Role for Delete Permission</strong></div>
		<?php
	}
	else if($task =='add'){
		$sql1="SELECT r.role_id, r.role_name FROM v_roles as r ORDER BY r.role_id ASC ";
		$rows1=$fn->raw_selectData($sql1);
		?>
    <h2>Permission Management - Add Permission</h2>
		<form action="permission/permission.php" method="post">
        <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Select Roles &nbsp;&nbsp;&nbsp;
                            <select class="select_role" id="role_id" name="role_id">
                                <option value="" >Select</option>
							<?php
                            foreach($rows1 as $r1)
                                    { ?>
                            	<option value="<?php echo $r1['role_id']; ?>"><?php echo $r1['role_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body ">
                            <div class="table-responsive">
                            <div class="div_ajax_send">
                            <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" value="" name="allchk" id="allchk"></th>
                                            <th>#</th>
                                            <th>Permission</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="4"><strong>Not Available</strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
        <?php
	}
}?>
<script type="text/javascript" src="<?php echo URL_PATH;?>js/jquery.js"></script>
<script type="text/javascript">
var jQuery_1_9_1 = $.noConflict(true);

jQuery_1_9_1(document).ready(function($){
		$(document).on('change', '.select_role', function (e) {
				
		var dataString = "r_id="+$('#role_id').val()+"&ajax_opt=select_role";
			$(".div_ajax_send").fadeIn(400).html('<span class="load">Loading..</span>');
			  $.ajax({
				type: "post",
				url: "aj_submit.php",
				dataType: "html",
				data: dataString,
				async:false,
				cache: true,
				success: function(html){
					$(".div_ajax_send").html(html);
				}  
			})
	});
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
$script="";
$page->addinscript($script);
$page->addJavascript(URL_PATH."js/edit_permission.js");
$page->endBody();
echo $page->render('inc/template.php');