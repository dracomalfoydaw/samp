<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hi, <?php echo  $Fullname ?></h2>
						   <p class="lead">We have successfully change your email. </p>
						   <p>To verify it use this code below : </p>			
						   <p>Code: <strong> <?php echo  $code ?></strong></p>
						   <p><i>*Note:Code will expire after 30 mins.</i></p>
						    
						   <br> Thanks.

						   <p style="color:red;font-size: 20px;"><i>*Note:this is auto generated email. Do not reply. If ever you are not requested on it, please disregard this message.</i></p>
						   <?php echo CNF_APPNAME ?> 
	</body>
</html>