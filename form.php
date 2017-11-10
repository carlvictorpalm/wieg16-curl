<?php
require "database.php";
?>
<html>
	<body>
		<form action="form.php" method="post">
			<p>Name</p> <input type="text" name="name">
			<p>E-mail:</p> <input type="text" name="email">
			<p>Telefon:</p> <input type="text" name="phone"><br>
			<br>
		<input type="submit" name="submit" value="submit">
		</form>
	</body>
</html>
