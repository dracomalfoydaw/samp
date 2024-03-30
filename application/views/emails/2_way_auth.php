<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hello <?php echo $Fullname ;?> , </h2>
		<p>You may now sign in now using the information below : </p>		
		<p>
			<p>Email Verification Code: <strong> <?php echo  $code ?></strong></p>
		</p>
		<p style="color:red;font-size: 20px;"><i>*Note:this is auto generated email. Do not reply</i></p>
						   <?php echo CNF_APPNAME ?> 
	</body>
</html>