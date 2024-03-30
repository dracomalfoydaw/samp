<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Hi, <?php echo  $Fullname ?></h2>
						   <p class="lead">We regret to inform that your account has been temporary lock due of many attempts.</p>
                           <p>Here are the details of the transaction : </p>    


                           <p>Date/Time Transacted: <strong> <?php echo date("Y-m-d H:i:s"); ?>	</strong></p>
                            <p>Browser: <?php echo $this->agent->browser() ?> <?php echo $this->agent->version() ?>, Operating System used: <?php echo $this->agent->platform() ?> , Mobile used: <?php echo  $this->agent->mobile() ?> , Robot: <?php echo $this->agent->robot() ?>  </p>
                          
                           
                            
                           

                           <p><i>*Note:this is auto generated email</i></p>
	</body>
</html>