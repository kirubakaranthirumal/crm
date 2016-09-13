<?php
/*******************
Mr. Suraj Thapaliya
PHP Programmer
http://www.surajthapaliya.com.np
version 1.2
*/
class connect
{
	var $Host = C_DB_HOST;			// Hostname of our MySQL server
	var $Database = C_DB_NAME;		// Logical database name on that server
	var $User = C_DB_USER;			// Database user
	var $Password = C_DB_PASS;		// Database user's password
	var $Link_ID = 0;				// Result of mysql_connect()
	var $Query_ID = 0;				// Result of most recent mysql_query()
	var $Record	= array();			// Current mysql_fetch_array()-result
	var $Row;						// Current row number
	var $Errno = 0;					// Error state of query
	var $Error = "";

	function halt($msg)
	{
		//echo("</TD></TR></TABLE><B>Database error:</B> $msg<BR>\n");
		//echo("<B>MySQL error</B>: $this->Errno ($this->Error)<BR>\n");
		//echo "Session halted.";
		//return $this->Error;
	}

	function connect()
	{
		if($this->Link_ID == 0)
		{
			$this->Link_ID = mysql_connect($this->Host, $this->User, $this->Password);
			if (!$this->Link_ID)
			{
				$this->halt("Link_ID == false, connect failed");
			}
			$SelectResult = mysql_select_db($this->Database, $this->Link_ID);
			if(!$SelectResult)
			{
				$this->Errno = mysql_errno($this->Link_ID);
				$this->Error = mysql_error($this->Link_ID);
				$this->halt("cannot select database <I>".$this->Database."</I>");
			}
		}
	}

	function query($Query_String)
	{
		$this->connect();
		$this->Query_ID = mysql_query($Query_String,$this->Link_ID);
		$this->Row = 0;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		if (!$this->Query_ID)
		{
			$this->halt("Invalid SQL: ".$Query_String);
		}
		return $this->Query_ID;
	}
	
function query_fetch($fetch=0)
{
	if($fetch==0) {
		$result=@mysql_fetch_assoc($this->Query_ID);
	} else {
		$result=@mysql_fetch_array($this->Query_ID);
	}
	
	if(!is_array($result)) 
	return false;
	$this->total_field=mysql_num_fields($this->Query_ID);

	foreach($result as $key=>$val){
		$result[$key]=trim(htmlspecialchars($val));
	}
	 return $result; 
}

function query_fetch_tr($css='',$col_name='no',$update='no',$delete='no',$add='no',$not_show='no',$total_rows=0)
{
	if(!empty($not_show)) {
		$val=0;
	 } else {
		$val=1;
	 }
	// For Add

		if($add=="yes") {
			if(!empty($update))  $c=$c+1;
			if(!empty($delete)) $c=$c+1;
			$colspan=$this->num_field()+$c;
			$tr_output="<tr><td colspan='$colspan'><a href='?mode=add'> Add New Data</a> </tr> ";
		}
	
	// End of Add
	if($col_name=="yes") {
		$tr_output.="<tr>";
		for($j=$val;$j<$this->num_field();$j++) {
			$tr_output.="<th>".ucwords(strtolower($this->get_field_name($j)));
		}
		// For Update 
		if($update=="yes") {
			$addNewTD="<th>Update</th>";
		} else {
			$addNewTD="";
		}
		// End of Update
		// For Delete 
		if($delete=="yes") {
			$addDelTD="<th>Delete</th>";
		} else {
			$addDelTD="";
		}
		
		// End of Delete
		$tr_output.="$addNewTD $addDelTD </tr>";
	}
	if($total_rows==0) {
		echo  $tr_output;
	} 
	
	while($result=$this->query_fetch(1))
    {
    	
        if(is_array($result))
		{
        	if($css!="")
            {
            	$css_val="class=".$css;
            }
            $tr_output.="<tr $css_val>";
			
            for($i=$val;$i<$this->num_field();$i++)
            {
            	if($result[$i]=="")
                {
                	$result[$i]="&nbsp;";
                }
                $tr_output.="<td>".$result[$i]."</td>";
            }
			if($update=="yes") {
				$tr_output.="<td><a href='?sn=$result[0]&mode=update'>Update</a></td>";
			}
			if($delete=="yes") {
				$tr_output.="<td><a href='?sn=$result[0]&mode=delete'> Delete</a> </td>";
			}
            $tr_output.="</tr>";
        }
            echo $tr_output;
            unset($tr_output);
    }
 }


function paging($sqlPaging="",$offSet=0) {
	$sqlPaging=$sqlPaging;
	$eu = ($start - 0); 
	$limit = $offSet;                             
	$a = $eu + $limit; 
	$back = $eu - $limit; 
	$next = $eu + $limit; 
	$mainQuery=$sqlPaging." limit $eu,$limit";
	$this->query($mainQuery);
	$nume=$this->num_rows();
echo "<table align = 'right' width='500' border=0>
<tr>
<td  align='right' width='50%'>";
if($back >=0) { 
print "<a href='$page_name?start=$back'><font face='arial' size='1'> << </font></a>"; 
} 
echo " Page ";
$i=0;
$l=1;
for($i=0;$i < $nume;$i=$i+$limit){
	if($i <> $eu){
		echo " <a href='$page_name?start=$i'><font face='arial' size='1'>$l</font></a> ";
	} else { 
		echo "<font face='arial' size='1' color=red> &nbsp;$l</font>";
	}     
	$l=$l+1;
	echo "&nbsp;";
}
	if($a < $nume) { 
		print "<a href='$page_name?start=$next'><font face='arial' size='1'> >> </font></a>";
	} 
	echo "</tr></table>";

	
}

function num_field()
{
	return mysql_num_fields($this->Query_ID);
}
function get_field_name($i)
{
	return mysql_field_name($this->Query_ID,$i);
}


/*
function fetch_field()
{
	return mysql_fetch_field($this->Query_ID,2);
}
*/

function next_record()
	{
		$this->Record = mysql_fetch_array($this->Query_ID);
		$this->Row += 1;
		$this->Errno = mysql_errno();
		$this->Error = mysql_error();
		$stat = is_array($this->Record);
		if (!$stat)
		{
			mysql_free_result($this->Query_ID);
			$this->Query_ID = 0;
		}
		return $this->Record;
	}

	function num_rows()
	{
		return mysql_num_rows($this->Query_ID);
	}
	function getCheckBoxList($tablename,$col1,$col2,$cbname,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$opt='<div style="widt:100%">';
		while($row=mysql_fetch_array($result))
		{
		$opt.="<div style='float:left;width:20px;'><input type='checkbox'  name=$cbname value='
		".$row[$col1]."'></div><div style='float:left;width:50px;'>".$row[$col2]."</div>";
		}
		return "</div>".$opt;
	}
	function getCheckedCheckBoxList($tablename,$col1,$col2,$cbname,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$opt='<div style="widt:100%">';
		while($row=mysql_fetch_array($result))
		{
		$opt.="<div style='float:left;width:20px;'><input type='checkbox'  name=$cbname value='
		".$row[$col1]."' checked></div><div style='float:left;width:50px;'>".$row[$col2]."</div>";
		}
		return "</div>".$opt;
	}
	
	function getOptionAll($tablename,$col1,$col2,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$opt='';
		while($row=mysql_fetch_array($result))
		{
		$opt.="<option value=".$row[$col1].">".$row[$col2]."</option>";
		}
		return $opt;
	}
	function getOptionAllTwoColumn($tablename,$col1,$col2,$col3,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$opt='';
		while($row=mysql_fetch_array($result))
		{
		$opt.="<option value=".$row[$col1].">".$row[$col2]." ".$row[$col3]."</option>";
		}
		return $opt;
	}
	function getOptionAllTwoColumnExt($tablename,$col1,$col2,$col3,$col4,$condition)
	{
		$sql="select * from $tablename $condition";	
		$opt=$sql;
		$result=mysql_query($sql);	
		$opt='';
		$val1='test';
		$res[]='';
		while($row=mysql_fetch_array($result))
		{
		$sql1="select * from city where id=".$row[$col4];	
		$result1=mysql_query($sql1);	
		while($row1=mysql_fetch_array($result1))
		{
		$val1=$row[$col2];	
		$val2=$row1['ciname'];
		if (in_array($val1.$val2, $res))
			{
				$flag=1;
			}
		else
			{
			$flag=2;
			}
		if($flag==2)
			{		
		$opt.="<option value=".$row[$col1].">".$row[$col2]." ".$row[$col3]." - ".$row1['ciname']."</option>";		
			}	
			
		$res[].=$val1.$val2;

		}
		}
		return $opt;
	}
	function getOptionAllTwoColumnDistinct($tablename,$col1,$col2,$col3,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$opt='';
		while($row=mysql_fetch_array($result))
		{
		$opt.="<option value=".$row[$col1].">".$row[$col2]." ".$row[$col3]."</option>";
		}
		return $opt;
	}
	function getOptionAll2($tablename,$col1,$col2,$col3,$condition)
	{
		$sql="select * from $tablename $condition";	
		$opt=$sql;
		$result=mysql_query($sql);	
		$opt='';
		$val1='test';
		while($row=mysql_fetch_array($result))
		{
		$sql1="select * from city where id=".$row[$col3];	
		$result1=mysql_query($sql1);	
		while($row1=mysql_fetch_array($result1))
		{
		$val1=$row[$col2];	
		$val2=$row1['ciname'];
		if (in_array($val1.$val2, $res))
			{
				$flag=1;
			}
		else
			{
			$flag=2;
			}
		if($flag==2)
			{		
		$opt.="<option value=".$row[$col1].">".$row[$col2]."-".$row1['ciname']."</option>";		
			}	
			
		$res[].=$val1.$val2;
		}
		}
		return $opt;
	}
	function getOrderedList($tablename,$col1,$col2,$col4,$col3,$col5,$condition)
	{
		$sql="select * from $tablename $condition";	
		$opt=$sql;
		$result=mysql_query($sql);	
		$opt='';
		$val1='test';
		$res[]='';
		while($row=mysql_fetch_array($result))
		{
		$sql1="select * from city where id=".$row[$col3];	
		$result1=mysql_query($sql1);	
		while($row1=mysql_fetch_array($result1))
		{
		$val1=$row[$col2];	
		$val2=$row1['ciname'];
		if (in_array($val1.$val2, $res))
			{
				$flag=1;
			}
		else
			{
			$flag=2;
			}
		if($flag==2)
			{		
			if($row[$col5]!='0')
				{
				$opt.="<a href='javascript:getreceiverdatas(\"".$row[$col1]."\");' style='color:darkgreen;font-weight:bold'>".$row[$col2]." ".$row[$col4]." - ".$row1['ciname']." - ";
				
				$sql2="select * from bank where id='".$row[$col5]."'";	
				$result2=mysql_query($sql2);	
				while($row2=mysql_fetch_array($result2))
				{ $opt.=$row2['bank'];
				}
				$opt.="<hr>";	
				}
				else
				{
				$opt.="<a href='javascript:getreceiverdatas(\"".$row[$col1]."\");' style='color:darkgreen;font-weight:bold'>".$row[$col2]." ".$row[$col4]." - ".$row1['ciname']."<hr>";	
				}
			}	
			
		$res[].=$val1.$val2;

		}
		}
		return $opt;
	}
	function getList($tablename,$col,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$lst='';
		while($row=mysql_fetch_array($result))
		{
		$cname=$row[$col];
		$cid=$row['id'];
		$lst.="<a href=\"javascript:requestInfo('showProduct.php?starting=0&mode=list&category=$cname&cid=$cid','showProduct','')\"><li title='".$row[$col]."'>".$row[$col]."</a></li>";
		}
		return $lst;
	}
	function getList1($tablename,$col,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$lst='';
		while($row=mysql_fetch_array($result))
		{
		$cname=$row[$col];
		$cid=$row['id'];
		$lst.="<a href=\"javascript:requestInfo('showProduct.php?starting=0&mode=list&category=$cname&cid=$cid&page=blank','showProduct','')\"><li title='".$row[$col]."'>".$row[$col]."</a></li>";
		}
		return $lst;
	}
	function getList2($tablename,$col,$condition)
	{
		$sql="select * from $tablename $condition";	
		$result=mysql_query($sql);	
		$lst='';
		while($row=mysql_fetch_array($result))
		{
		$cname=$row[$col];
		$cid=$row['id'];
		$lst.="<a href=\"javascript:requestInfo('showProduct.php?starting=0&mode=list&category=$cname&cid=$cid&page=blank&fp=true','showProduct','')\"><li title='".$row[$col]."'>".$row[$col]."</a></li>";
		}
		return $lst;
	}

	function maxRow($tablename,$field,$condition)
	{
		$sql="select max($field) from $tablename $condition";
		$this->query($sql);
		$result=@mysql_fetch_array($this->Query_ID);
		return $result[0];
	}
	function numRow($tablename,$condition)
	{
		$sql="select * from $tablename $condition";
		$this->query($sql);
		$result=$this->num_rows();
		return $result;
	}
	function numRowMessages($eventid,$condition)
	{
		$sql="select fn_msg_photo.user_id, fn_msg_photo.set_image, fn_msg_photo.messages, fn_msg_photo.image_path ,fn_msg_photo.sent_LED,fn_msg_photo.interact_id,fn_register.user_name from fn_msg_photo join fn_register ON fn_msg_photo.user_id=fn_register.user_id and fn_msg_photo.event_id='".$eventid."' and ".$condition." order by fn_msg_photo.interact_id desc";
		$this->query($sql);
		$result=$this->num_rows();
		return $result;
	}
	function numRowPhotos($eventid,$condition)
	{
		$sql="SELECT * FROM fn_msg_photo where fn_msg_photo.event_id='".$eventid."' ".$condition." ORDER BY updated_datestamp DESC ";
		$this->query($sql);
		$result=$this->num_rows();
		return $result;
	}
	
	function getRow($tablename,$field,$condition)
	{
		$sql="select $field from $tablename $condition";
		$this->query($sql);
		$result=@mysql_fetch_array($this->Query_ID);
		return $result[0];
	}
	function getTotal($tablename,$field,$condition)
	{
		$sql="select SUM($field) from $tablename $condition";
		$this->query($sql);
		$result=@mysql_fetch_array($this->Query_ID);
		return $result[0];
	}
	function displayMonth($mon)
	{
		$marray=array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","dec");
		for($i=0;$i<12;$i++)
		{
		$s=$i+1;
		if($mon==$s)
			{
		$opt.="<option value='$s' selected>".$marray[$i]."</option>";
			}
			else
			{
		$opt.="<option value='$s'>".$marray[$i]."</option>";
			}
		}
		return $opt;
	}
	function displayYear($yr)
	{
		for($i=START_YEAR;$i<=END_YEAR;$i++)
		{
			if($yr==$i)
			{
		$opt.="<option value='$i' selected>$i</option>";
			}
			else
			{
		$opt.="<option value='$i'>$i</option>";
			}
		}
		return $opt;
	}
	function getMonthShort($month)
	{
		$m=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');		
		return strtoupper($m[$month-1]);
	}
	function getMonthLong($month)
	{
		$m=array('January','February','March','April','May','June','July','August','September','October','November','December');		
		return strtoupper($m[$month-1]);
	}
	function days($year, $month) {
		$num = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		return "31"; 
		}
	function affected_rows()
	{
		return mysql_affected_rows($this->Link_ID);
	}

	function optimize($tbl_name)
	{
		$this->connect();
		$this->Query_ID = @mysql_query("OPTIMIZE TABLE $tbl_name",$this->Link_ID);
	}

	function clean_results()
	{
		if($this->Query_ID != 0) mysql_free_result($this->Query_ID);
	}

	function close()
	{
		if($this->Link_ID != 0) mysql_close($this->Link_ID);
	}
	function getDMY($date)
	{
	list($year, $month, $day) = split('[/.-]', $date);
	$fdate=$day."-".$month."-".$year;
	return $fdate;
	}
	function getDMYHIS($date)
	{
	list($year, $month, $day) = split('[/.-]', $date);
	$fdate=$day."/".$month."/".$year;
	$ndate=date("H:i:s");
	return $fdate." ".$ndate;
	}
	function getYMD($date)
	{
	list($day, $month, $year) = split('[/.-]', $date);
	$fdate=$year."-".$month."-".$day;
	return $fdate;
	}
function checkField($tableName,$columnName)
{
//Getting table fields through mysql built in function, passing db name and table name
$tableFields = mysql_list_fields('a4515g521545r', $tableName);
//loop to traverse tableFields result set
for($i=0;$i<mysql_num_fields($tableFields);$i++){
//	return $i;
//Using mysql_field_name function to compare with column name passed. If they are same function returns 1
if(mysql_field_name($tableFields, $i)==$columnName)
	{
return 1;
	}
else
	{
	return 0;
	}
}

	//end of loop
}

function getDifference($startDate,$endDate,$format = 1)
{
    list($date,$time) = explode(' ',$endDate);
    $startdate = explode("-",$date);
    $starttime = explode(":",$time);

    list($date,$time) = explode(' ',$startDate);
    $enddate = explode("-",$date);
    $endtime = explode(":",$time);

    $secondsDifference = mktime($endtime[0],$endtime[1],$endtime[2],
        $enddate[1],$enddate[2],$enddate[0]) - mktime($starttime[0],
            $starttime[1],$starttime[2],$startdate[1],$startdate[2],$startdate[0]);
    
    switch($format){
        // Difference in Minutes
        case 1: 
            return floor($secondsDifference/60);
        // Difference in Hours    
        case 2:
            return floor($secondsDifference/60/60);
        // Difference in Days    
        case 3:
            return floor($secondsDifference/60/60/24);
        // Difference in Weeks    
        case 4:
            return floor($secondsDifference/60/60/24/7);
        // Difference in Months    
        case 5:
            return floor($secondsDifference/60/60/24/7/4);
        // Difference in Years    
        default:
            return floor($secondsDifference/365/60/60/24);
    }                
}
}
?>