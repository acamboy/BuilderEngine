<html>
	<head>
		<title>Realex Payments HPP - PHP Sample Code - Response Script</title>
	</head>
	<body bgcolor="#FFFFFF">
		<font face=verdana,helvetica,arial size=2>
			<?php
			$this->show->disable_full_wrapper();
			if(isset($status_code))
				$this->load->view('realex/ipn/'.$status_code.'.php');
			else
				$this->load->view('realex/ipn/default_error.php');
			?>
		</font>

	</body>
</html>