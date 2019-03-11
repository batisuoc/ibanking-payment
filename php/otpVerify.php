<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Verify OTP Code</title>
	<!--Bootsrap 4 CDN-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!--Fontawesome CDN-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!--Custom styles-->
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<?php

	$msg = "";
	if(isset($_POST['verify']) and !empty($_POST['otp']))
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://localhost:8080/iBankingPayment/rest/payment/verifyOTP/" .$_POST['otp']);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$resp = curl_exec($ch);
		curl_close($ch);
		if($resp == "true")
		{
			$_SESSION['otp'] = $_POST['otp'];
			header("location: action_after_verified.php");
			die();
		}
		else
		{
			$msg = "Verify failed , please send another OTP to verify again.";
		}
	}

	?>

	<div class="container">
		<div class="d-flex justify-content-center h-100">
			<div class="card">
				<div class="card-header">
					<h3 class="text-center">Verify otpcode</h3>
				</div>
				<div class="card-body">
					<form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
						<div class="input-group form-group">
							<div class="input-group-prepend"></div>
							<input type="text" name="otp" placeholder="Enter your otp code" class="form-control" required autofocus/>
						</div>
						<div class="form-group">
							<input type="submit" name="verify" value="verify" class="btn float-right login-btn"></input>
							<p class="btn-link"><a href="#">Send OTP again</a></p>
						</div>
					</form>
				</div>
				<div class="card-footer">
					<p class="alert"><? $msg ?></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>