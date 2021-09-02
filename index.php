<?php

require("init.php");
// Traffic theo nam (yearly stats)
$yearly = $db->query("SELECT strftime('%Y', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%Y', timestamp) ORDER BY timestamp DESC;");
$monthly = $db->query("SELECT strftime('%m-%Y', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%m-%Y', timestamp) ORDER BY timestamp DESC;");
$daily = $db->query("SELECT strftime('%d-%m-%Y', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%d-%m-%Y', timestamp) ORDER BY timestamp DESC;");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Traffic Stats - Thống kê lưu lượng</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
      .title {
          font-size: 30px;
          font-weight: 600;
          text-align:center;
          color:blue;
          margin: 50px 0 50px 0;
      }
      .table-title {
          font-size: 20px;
          font-weight: 600;
          text-align:center;
          color:red;
      }
      .table{
          margin-bottom: 50px;
      }
      .footer{
        font-size:12px;
        font-weight:500;
        text-align:center;
      }
  </style>
</head>
<body>
        <div class="container">
            <div class="title">
                <div>Hệ thống thống kê lưu lượng WAN Mikrotik</div>
	            <div>Router: Home - Trương Anh Tuấn</div>
	            
            </div>
            <div class="table-title">Lưu lượng theo Năm</div>
            <table class="table table-striped">
				<thead>
					<th>Năm</th>
					<th>Tải lên (Upload)</th>
					<th>Tải xuống (Download)</th>
					<th>Tổng lưu lượng</th>
				</thead>
				<tbody>
				<?php
					
					 while ($row = $yearly->fetchArray(SQLITE3_ASSOC)) {

						   echo "<tr>";
							   echo "<td>".$row["strftime('%Y', timestamp)"]."</td>";
							   echo "<td>".number_format($row["sum(tx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(tx)+sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
						   echo "</tr>";

					 }
				?>
				</tbody>
		   </table>
	  
		   <div class="table-title">Lưu lượng theo Tháng</div>
			<table class="table table-striped">
					<thead>
						<th>Tháng</th>
						<th>Tải lên (Upload)</th>
						<th>Tải xuống (Download)</th>
						<th>Tổng lưu lượng</th>
					</thead>
					<tbody>
					<?php
                     
					 while ($row = $monthly->fetchArray(SQLITE3_ASSOC)) {

						   echo "<tr>";
							   echo "<td>".$row["strftime('%m-%Y', timestamp)"]."</td>";
							   echo "<td>".number_format($row["sum(tx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(tx)+sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
						   echo "</tr>";

					 }
					?>
					</tbody>
				</table>
			<div class="table-title">Lưu lượng theo Ngày</div>
			<table class="table table-striped">
					<thead>
						<th>Ngày</th>
						<th>Tải lên (Upload)</th>
						<th>Tải xuống (Download)</th>
						<th>Tổng lưu lượng</th>
					</thead>
					<tbody>
				<?php

					 while ($row = $daily->fetchArray(SQLITE3_ASSOC)) {

						   echo "<tr>";
							   echo "<td>".$row["strftime('%d-%m-%Y', timestamp)"]."</td>";
							   echo "<td>".number_format($row["sum(tx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
							   echo "<td>".number_format($row["sum(tx)+sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
						   echo "</tr>";

					 }
				?>
				</tbody>
			</table>
		</div>
</body>
<footer>
    <div class="footer">Thiết kế và vận hành bởi DigiEra Networks</div>
</footer>
</html>

