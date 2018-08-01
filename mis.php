<?php
session_start();
if(!isset($_SESSION['promo_uname']))
{
	header('Location : index.php');
}
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]>    <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]>    <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="">
<!--<![endif]-->
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Celledge Promo Panel</title>
<link href="boilerplate.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="index.php" rel="stylesheet" type="text/css">
<link href="/css/bootstrap.min.css" rel="stylesheet">
   
<script src="/js/bootstrap.min.js"></script>

<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="respond.min.js"></script>
</head>
<body>
<?php include('menu.php');?>
<!--<a href="logout.php" class="logout">Logout</a>-->
	<div class="gridContainer clearfix">
		<div id="div1" class="fluid">
        <div class="promo_panel">
        <h1>MIS Report</h1>
        <h4>Select Date: <input type="date" name="rdate" id="rdate" class="rpt_dt" value="<?php echo date("Y-m-d");?>"></h4> 
        <?php
		if(isset($_POST['rdate']))
		{
			$report_date=$_POST['rdate'];
		}
		else
		{
			$report_date=date("Y-m-d");
		}
/* ========================================= Successfull Activation Count ====================================== */
$res_act='ACT';
$succ_act_status=1;
$query_act_succ = $GLOBALS['CONN']->prepare("SELECT count(*),IFNULL(sum(rate), 0) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_act_succ->bind_param("sss", $res_act,$succ_act_status,$report_date);
$query_act_succ->execute();
$query_act_succ->bind_result($succ_act_cnt,$act_rev);
$query_act_succ->fetch();
$query_act_succ->close();

/* ========================================= Successfull Renew Count ========================================== */
$res_ren='REN';
$succ_ren_status=1;
$query_ren_succ = $GLOBALS['CONN']->prepare("SELECT count(*),IFNULL(sum(rate), 0) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_ren_succ->bind_param("sss", $res_ren,$succ_ren_status,$report_date);
$query_ren_succ->execute();
$query_ren_succ->bind_result($succ_ren_cnt,$ren_rev);
$query_ren_succ->fetch();
$query_ren_succ->close();

/* ====================================== Successfull Deactivation Count ====================================== */
$res_dct='DCT';
$succ_dct_status=1;
$query_dct_succ = $GLOBALS['CONN']->prepare("SELECT count(*) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_dct_succ->bind_param("sss", $res_dct,$succ_dct_status,$report_date);
$query_dct_succ->execute();
$query_dct_succ->bind_result($succ_dct_cnt);
$query_dct_succ->fetch();
$query_dct_succ->close();

/* ======================================== Successfull PARK/GRACE Count ====================================== */
$res_park='ACT';
$succ_park_status=8;
$query_park_succ = $GLOBALS['CONN']->prepare("SELECT count(*) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_park_succ->bind_param("sss", $res_park,$succ_park_status,$report_date);
$query_park_succ->execute();
$query_park_succ->bind_result($succ_park_cnt);
$query_park_succ->fetch();
$query_park_succ->close();

/* ========================================= Successfull PENDING Count ======================================= */
/*$res_pen='ACT';
$succ_pen_status=2;
$query_pen_succ = $GLOBALS['CONN']->prepare("SELECT count(*) FROM `sub_master_mtnlm` where status=? and date(start_date)=?");
$query_pen_succ->bind_param("ss", $succ_pen_status,$report_date);
$query_pen_succ->execute();
$query_pen_succ->bind_result($succ_pen_cnt);
$query_pen_succ->fetch();
$query_pen_succ->close();
*/
/* ========================================== Failed Activation Count ======================================= */

$fail_act_status=0;
$query_act_fail = $GLOBALS['CONN']->prepare("SELECT count(*) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_act_fail->bind_param("sss", $res_act,$fail_act_status,$report_date);
$query_act_fail->execute();
$query_act_fail->bind_result($fail_act_cnt);
$query_act_fail->fetch();
$query_act_fail->close();

/* ========================================== Failed Renew Count ============================================ */

$fail_ren_status=0;
$query_ren_fail = $GLOBALS['CONN']->prepare("SELECT count(*) FROM `sub_trans_mtnlm` where response_action=? and status=? and date(created_on)=?");
$query_ren_fail->bind_param("sss", $res_ren,$fail_ren_status,$report_date);
$query_ren_fail->execute();
$query_ren_fail->bind_result($fail_ren_cnt);
$query_ren_fail->fetch();
$query_ren_fail->close();
		?>
        <center>
        <ul class="mis">
        <li><strong>ID</strong></li>
        <li><strong>SUB_TYPE</strong></li>
        <li><strong>Successful Count</strong></li>
        <li><strong>Unsuccessful Count</strong></li>
        <li><strong>Revenue</strong></li>
        <li>1</li>
        <li>ACT</li>
        <li><a href="mis_details.php?f=act_succ&rdate=<?php echo $report_date; ?>"><?php echo $succ_act_cnt; ?></a></li>
        <li><a href="mis_details.php?f=act_fail&rdate=<?php echo $report_date; ?>"><?php echo $fail_act_cnt; ?></a></li>
        <li><a href="#"><?php echo $act_rev; ?></a></li>
        <li>2</li>
        <li>REN</li>
        <li><a href="mis_details.php?f=ren_succ&rdate=<?php echo $report_date; ?>"><?php echo $succ_ren_cnt; ?></a></li>
        <li><a href="mis_details.php?f=ren_fail&rdate=<?php echo $report_date; ?>"><?php echo $fail_ren_cnt; ?></a></li>
        <li><a href="#"><?php echo $ren_rev; ?></a></li>
        <li>3</li>
        <li>DCT</li>
        <li><a href="mis_details.php?f=dct_succ"><?php echo $succ_dct_cnt; ?></a></li>
        <li>N/A</li>
        <li>N/A</li>
        <li>4</li>
        <li>Park/Grace</li>
        <li><a href="mis_details.php?f=park_succ"><?php echo $succ_park_cnt; ?></a></li>
        <li>N/A</li>
        <li>N/A</li>
        <!--<li>5</li>
        <li>PEN</li>
        <li><?php echo $succ_pen_cnt; ?></li>
        <li>N/A</li>
        <li>dsfdsf</li>
        -->
        </ul>
         
        </center>
       
        </div>
        </div>
	</div>
</body>
</html>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script>
$(document).ready(function(e) {
	$('#bulk_promo').hide();
	$('#single_promo').hide();
	
	$('#single').click( function ()
	{
		$('#bulk_promo').hide();
		$('#single_promo').show();
	});
	
	$('#bulk').click( function ()
	{
		$('#bulk_promo').show();
		$('#single_promo').hide();
	});
	
	$('#rdate').change(function ()
	{
		var rdate=$('#rdate').val();
		$.post( "update_mis.php", { rdate: rdate} ).done(function( msg ) {
			//alert(msg);
			$('.mis').html(msg);
			
		});
	});
	
	
	$('#submit_form').click(function ()
	{
		var formData = new FormData();
		formData.append('file_name', $('#bulk_msisdn')[0].files[0]);
		formData.append('promo_msg', $('#promo_msg').val());
		formData.append('opr', $('#operator option:selected').text());
		$.ajax({
				type: "post",
				url: "post_file.php",
				data: formData,
				contentType: false, 
				processData: false,
				async:false,
				cache: true,
				success: function(data){
					alert(data);
				} 
				 
			});
			$('#remaining_txt').html(data);
	 	/*$.post( "post_file.php", { fname: fname} ).done(function( msg ) {
		alert(msg);
		});*/
	});
	 
});
			
			
			
</script>
