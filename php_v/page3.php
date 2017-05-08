<html>
<link rel="stylesheet" type="text/css" href="main.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
	<div class="one">
    <strong>聚会助手(Party Helper)-Jackling</strong>
    <br/>
	</div>
    <div class="two">
    <hr/>
        <b>The organiazer should remember the room number, get result by sending room number to official account.</b>
    <br/>
        <br/>
        <b>Room Number：</b>
<?php
echo $_GET['id'];
    ?>
        <br/><br/>
   <strong >Thanks for your using ,please wait for result</strong>    
    </div>
</body>
</html>

<?php
// Deal with data, send chosed time, location and room number to database, chosed is 'on', unchosed is none.
 $d_c_t1 = $_GET['choose_t1'];  
 $d_c_t2 = $_GET['choose_t2'];
 $d_c_t3 = $_GET['choose_t3'];
 $d_c_a1 = $_GET['choose_a1'];
 $d_c_a2 = $_GET['choose_a2'];
 $d_c_a3 = $_GET['choose_a3'];
 
if($d_c_t1 == null)
     $d_c_t1 = '0';

if($d_c_t2 == null)
     $d_c_t2 = '0';

if($d_c_t3 == null)
     $d_c_t3 = '0';

if($d_c_a1 == null)
     $d_c_a1 = '0';

if($d_c_a2 == null)
     $d_c_a2 = '0';

if($d_c_a3 == null)
     $d_c_a3 = '0';

include 'conn_sql.php';
$sql = "insert into party_data(room_num,msg_type,p_time_1,p_time_2,p_time_3,p_add_1,p_add_2,p_add_3)values($room_id,'1','$d_c_t1','$d_c_t2','$d_c_t3','$d_c_a1','$d_c_a2','$d_c_a3')"; 
mysql_query($sql,$conn); 
        

mysql_close($conn);
 
 ?>