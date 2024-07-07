
"use strict";
$(document).ready(function () {
    // Function to fetch user data from PHP and populate the table
	function fetchUsers() 
	<?php                
require 'database_connection.php'; 
$display_query = "select event_id,event_name,event_start_date,event_end_date from calendar_event_master";             
$results = mysqli_query($con,$display_query);   
$count = mysqli_num_rows($results);  
if($count>0) 
{
	$data_arr=array();
    $i=1;
	while($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	{	
		$data_arr[$i]['UserID'] = $data_row['UserID'];	
		$data_arr[$i]['OrganiserID'] = $data_row['OrganiserID'];	
		
		$data_arr[$i]['CategoryID'] = $data_row['CategoryID'];
		$data_arr[$i]['MeetingName'] = $data_row['MeetingName'];

		$data_arr[$i]['MeetingDetails'] = $data_row['MeetingDetails'];
		$data_arr[$i]['Location'] = $data_row['Location'];

		$data_arr[$i]['MeetingDetails'] = $data_row['MeetingDetails'];


		$data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['event_start_date']));
	$data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['event_end_date']));
	$data_arr[$i]['color'] = '#'.substr(uniqid(),-6); // 'green'; pass colour name
	$data_arr[$i]['url'] = 'https://www.shinerweb.com';
	$i++;
	}
	
	$data = array(
                'status' => true,
                'msg' => 'successfully!',
				'data' => $data_arr
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Error!'				
            );
}
echo json_encode($data);
?>
});


<?php                
require 'database_connection.php'; 
$display_query = "select event_id,event_name,event_start_date,event_end_date from calendar_event_master";             
$results = mysqli_query($con,$display_query);   
$count = mysqli_num_rows($results);  
if($count>0) 
{
	$data_arr=array();
    $i=1;
	while($data_row = mysqli_fetch_array($results, MYSQLI_ASSOC))
	{	
		$data_arr[$i]['UserID'] = $data_row['UserID'];	
		$data_arr[$i]['OrganiserID'] = $data_row['OrganiserID'];	
		
		$data_arr[$i]['CategoryID'] = $data_row['CategoryID'];
		$data_arr[$i]['MeetingName'] = $data_row['MeetingName'];

		$data_arr[$i]['MeetingDetails'] = $data_row['MeetingDetails'];
		$data_arr[$i]['Location'] = $data_row['Location'];

		$data_arr[$i]['MeetingDetails'] = $data_row['MeetingDetails'];


		$data_arr[$i]['start'] = date("Y-m-d", strtotime($data_row['event_start_date']));
	$data_arr[$i]['end'] = date("Y-m-d", strtotime($data_row['event_end_date']));
	$data_arr[$i]['color'] = '#'.substr(uniqid(),-6); // 'green'; pass colour name
	$data_arr[$i]['url'] = 'https://www.shinerweb.com';
	$i++;
	}
	
	$data = array(
                'status' => true,
                'msg' => 'successfully!',
				'data' => $data_arr
            );
}
else
{
	$data = array(
                'status' => false,
                'msg' => 'Error!'				
            );
}
}
echo json_encode($data);
?>