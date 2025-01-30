<?php
	session_start();
	ob_start();
	
	if(isset($_GET['logout']))
	{
		session_unset();
		session_destroy();
		header("location:index.php");
		exit();
	}
	require("lib/coreFunction.php");
	$f = new coreFunction();
	require("config/path.php");
    require("partial/Header.php");
	require("config/route.php");
?>
				
		<div class="row content">
			
			<?php
    if(!isset($_GET['page'])){
		$page ="";
	}
	else{
		$page = $_GET['page'];
	}
	foreach ($route as $r => $val)
	{
		if($r == $page)
		{
			require($val);
		}
	}
?>

		</div>	


<?php
    require("partial/Footer.php");
?>


