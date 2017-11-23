<?php
require "database.php";
?>
<html>
	<body>
		<form action="form.php" method="post">
			<span>Name:</span> <input type="text" name="name"><br>
			<span>E-mail:</span> <input type="text" name="email"><br>
			<span>Telefon:</span> <input type="text" name="phone"><br>
		</form>
        <input type="submit" name="submit" value="submit">
	</body>
</html>
