<?php

require('dbConnect.php');

$recordSet = mysql_query($db, 'SELECT * FROM goods ORDER BY id DESC');

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>一覧ページ</title>
</head>
<body>

</body>
</html>