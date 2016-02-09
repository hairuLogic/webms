<?php 

	include("config.php"); 
	include("db/" . $dbtype . ".php"); 	

	include("lib/" . $dbtype . "/profile.php"); 
	include("lib/" . $dbtype . "/company.php");
	include("lib/" . $dbtype . "/menu.php"); 
	include("lib/" . $dbtype . "/get_table_default.php"); 
	include("lib/" . $dbtype . "/save_table_default.php"); 
	include("lib/" . $dbtype . "/inputCheck.php");
	
	
	// getting all possible and valid action URL
	$possible_url = array(
							"signing_in",
							"get_profile_data",
							"get_all_companies",
							"create_menu",
							"get_table_default",
							"save_table_default",
							"input_check"
						 );
	
	$value = "An error has occurred getting JSON value.";

	if (isset($_GET["action"]) && in_array($_GET["action"], $possible_url))
	{
	  switch ($_GET["action"])
	    {
	    	case "signing_in":
	    		$ProfileModel = new ProfileModel($conn);
		        $value = $ProfileModel->login_detail_check($_GET["usrid"], $_GET["pwd"], $_GET["comp"]);
		        break;
		    case "get_profile_data":
		    	$ProfileModel = new ProfileModel($conn);
		        $value = $ProfileModel->get_profile_data();
		        break;
		    case "get_all_companies":
		    	$CompanyModel = new CompanyModel($conn);
		    	$value = $CompanyModel->get_all_companies();
		        break;
		    case "create_menu":
		    	$MenuModel = new MenuModel($conn);
		    	$value = $MenuModel->create_main_menu();
		        break;
			case "get_table_default":
				$TableModel = new TableModel($conn,$_GET);
				$value = $TableModel->get_table();
		        break;
			case "save_table_default":
				$EditTableModel = new EditTable($conn,$_GET,$_POST);
				$value = $EditTableModel->edit_table();
		        break;
			case "input_check":
				$inputCheck = new InputCheck($conn);
				$value = $inputCheck->check();
		        break;
	    }
	}

	echo $value;

?>