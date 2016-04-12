<?php 

	include("config.php"); 
	include("db/" . $dbtype . ".php"); 	

	include("lib/" . $dbtype . "/doctor.php");
	include("lib/" . $dbtype . "/patient.php");
	include("lib/" . $dbtype . "/calendar.php");
	include("lib/" . $dbtype . "/appointment.php");

	include("lib/" . $dbtype . "/inputCheck.php");
	
	// getting all possible and valid action URL
	$possible_url = array(
							"get_casetype",
							"get_all_doctor",
							"get_doctor_info",
							"get_all_patient",
							"get_patient_dtl",
							"get_appt_lst",
							"get_appt_dtl",
							"save_appt_dtl",
							"upd_appt_dtl",
							"get_all_calendar",
							"appt_cleanup"
						 );
	
	$value = "An error has occurred getting JSON value.";

	if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
	{
	  switch ($_GET["action"])
	    {
		    case "get_all_doctor":
		    	$DoctorModel = new DoctorModel($conn);
		    	$value = $DoctorModel->get_all_doctor($_GET["term"]);
		        break;
		    case "get_doctor_info":
		    	$DoctorModel = new DoctorModel($conn);
		    	$value = $DoctorModel->get_doctor_info($_GET["id"]);
		        break;
		    case "get_casetype":
		    	$DoctorModel = new DoctorModel($conn);
		    	$value = $DoctorModel->get_casetype($_GET["id"]);
		        break;
		    case "get_all_patient":
		    	$PatientModel = new PatientModel($conn);
		    	$value = $PatientModel->get_all_patient($_GET["typ"],$_GET["term"]);
		        break;
		    case "get_patient_dtl":
		    	$PatientModel = new PatientModel ($conn);
		    	
		    	$value = $PatientModel ->get_patient_dtl($_GET["patid"]);
		        break;
		    case "appt_cleanup":
		    	$CalendarModel = new CalendarModel ($conn);
		    	
		    	$value = $CalendarModel ->appt_cleanup();
		        break;
		    case "get_appt_lst":
		    	$ApptModel = new ApptModel ($conn);
		    	
		    	$value = $ApptModel ->get_appt_lst($_GET["docid"]);
		        break;
		    case "get_appt_dtl":
		    	$ApptModel = new ApptModel ($conn);
		    	
		    	$value = $ApptModel ->get_appt_dtl($_GET["apptid"]);
		        break;
		    case "save_appt_dtl":
		    	$ApptModel = new ApptModel ($conn);
		    	
		    	$value = $ApptModel ->save_appt_dtl($_REQUEST["icnum"],$_REQUEST["apptdate"],$_REQUEST["appttime"],$_REQUEST["mrn"],$_REQUEST["pat_name"],$_REQUEST["remarks"]);
		        break;
		    case "get_all_calendar":
		    	$CalendarModel = new CalendarModel ($conn);
		    	
				$start 	= $_GET["start"];
				$end 	= $_GET["end"];
				
				if($start == '') $start = '2016-01-01';
				if($end == '') $end = '2016-10-01';
				
		    	$value = $CalendarModel ->get_all_calendar($_GET["typ"],$_GET["id"],$start,$end);
		        break;
	    }
	}

	echo $value;

?>