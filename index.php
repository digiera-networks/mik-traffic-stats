<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
$db = new SQLite3('mikstats.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);
// Traffic theo nam (yearly stats)
$yearly = $db->query("SELECT strftime('%Y', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%Y', timestamp);");
$monthly = $db->query("SELECT strftime('%Y-%m', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%Y-%m', timestamp);");
$daily = $db->query("SELECT strftime('%Y-%m-%d', timestamp), sum(tx), sum(rx), sum(tx)+sum(rx) FROM traffic GROUP BY strftime('%Y-%m-%d', timestamp);");

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Traffic Stats - Thống kê lưu lượng</title>
    </head>

    <body>
	<p style="text-align: center; font-size: 27px;"><span style="color: #0000ff;"><strong>Hệ thống thống k&ecirc; lưu lượng WAN Mikrotik</strong><br /><strong>Thiết kế v&agrave; vận h&agrave;nh bởi DigiEra Networks</strong><br /></span></p>
	
	<p style="text-align: center; font-size: 20px;"><span style="color: #ff0000;"><strong>Lưu lượng theo Năm</strong></span></p>
        <table width="800" border="2" cellpadding="3" cellspacing='2' align="center">

           <tr bgcolor="#2ECCFA">
                     <th>Năm</th>
                     <th>Tải lên (Upload)</th>
                     <th>Tải xuống (Download)</th>
					 <th>Tổng lưu lượng</th>
           </tr>
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
	   </table>
	  
	   <p style="text-align: center; font-size: 20px;"><span style="color: #ff0000;"><strong>Lưu lượng theo Tháng</strong></span></p>
	<table width="800" border="2" cellpadding="3" cellspacing='2' align="center">

           <tr bgcolor="#2ECCFA">
                     <th>Tháng</th>
                     <th>Tải lên (Upload)</th>
                     <th>Tải xuống (Download)</th>
					 <th>Tổng lưu lượng</th>
           </tr>
<?php

     while ($row = $monthly->fetchArray(SQLITE3_ASSOC)) {

           echo "<tr>";
               echo "<td>".$row["strftime('%Y-%m', timestamp)"]."</td>";
               echo "<td>".number_format($row["sum(tx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
               echo "<td>".number_format($row["sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
			   echo "<td>".number_format($row["sum(tx)+sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
           echo "</tr>";

     }
?>
        </table>
		<p style="text-align: center; font-size: 20px;"><span style="color: #ff0000;"><strong>Lưu lượng theo Ngày</strong></span></p>
	<table width="800" border="2" cellpadding="3" cellspacing='2' align="center">

           <tr bgcolor="#2ECCFA">
                     <th>Ngày</th>
                     <th>Tải lên (Upload)</th>
                     <th>Tải xuống (Download)</th>
					 <th>Tổng lưu lượng</th>
           </tr>
<?php

     while ($row = $daily->fetchArray(SQLITE3_ASSOC)) {

           echo "<tr>";
               echo "<td>".$row["strftime('%Y-%m-%d', timestamp)"]."</td>";
               echo "<td>".number_format($row["sum(tx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
               echo "<td>".number_format($row["sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
			   echo "<td>".number_format($row["sum(tx)+sum(rx)"]/1024/1024/1024,2,'.',' ')." GB </td>";
           echo "</tr>";

     }
?>
        </table>
   </body>

</html>

