<?php 
	include_once($_SERVER['DOCUMENT_ROOT'] . '/newms/connection/sschecker.php'); 
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <script type="text/ecmascript" src="../../js/jquery.min.js"></script> 
    <script type="text/ecmascript" src="../../js/trirand/i18n/grid.locale-en.js"></script>
    <script type="text/ecmascript" src="../../js/trirand/jquery.jqGrid.min.js"></script>
    <script type="text/ecmascript" src="../../js/bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
    <script type="text/ecmascript" src="../../js/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
    <script type="text/ecmascript" src="../../js/AccordionMenu/dist/metisMenu.min.js"></script>
    <script type="text/ecmascript" src="../../js/jquery-ui.min.js"></script>
	<script type="text/ecmascript" src="../../js/form-validator/jquery.form-validator.min.js"></script>
    <script type="text/ecmascript" src="../../js/jquery.dialogextend.js"></script>
	
	
    <link rel="stylesheet" href="../../js/form-validator/theme-default.css" />
	<link rel="stylesheet" href="../../js/jquery-ui-1.11.4.custom/jquery-ui.css">
	<link rel="stylesheet" href="../../js/font-awesome-4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../js/ionicons-2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="../../js/AccordionMenu/dist/metisMenu.min.css"> 
	<link rel="stylesheet" href="../../js/bootstrap-3.3.5-dist/css/bootstrap.min.css"> 
	<link rel="stylesheet" href="../../js/jasny-bootstrap/css/jasny-bootstrap.min.css"> 
    <link rel="stylesheet" type="text/css" media="screen" href="../../js/css/trirand/ui.jqgrid-bootstrap.css" />
     <link rel="stylesheet" type="text/css" href="../../js/searchCSS/stylesSearch.css">
     
     <style>
		.wrap{
			word-wrap: break-word;
		}
		.ui-th-column{
			word-wrap: break-word;
			white-space: normal !important;
			vertical-align: top !important;
		}
		
		.radio-inline+.radio-inline {
			margin-left: 0;
		}
		
		.radio-inline {
			margin-right: 10px;
		}
	</style>
    
     <?php include("bankScript.php")?>
     
    
    <meta charset="utf-8" />
    <title>Finance - Bank</title>
</head>
<body>
	<div class="container" style="margin-bottom:1em">
            
            <form id="searchForm" style='width:99%'>
				<fieldset>
                    <div id="searchInContainer">
                            <div id="Scol">Search By : </div>
                   </div>
                
					<div style="padding-left: 65px;margin-top: 25px;padding-right: 60%;"><input id="Stext" name="Stext" type="search" placeholder="Search here ..." class="form-control text-uppercase"></div>
                 </fieldset>  
			</form>
		<br>
		
		<div class='row'>
			<div class='col-md-12'>
				<table id="jqGrid" class="table table-striped"></table>
				<div id="jqGridPager"></div>
			</div>
		</div>
        
       <div id="dialog" title="title">
         	 <form id="searchForm" style="width:99%">
				<fieldset>
                    <div id="searchInContainer">
                    	Search By : <div id="Dcol" style="float:right; margin-right: 80px;"></div>
                   
                   		<input  style="float:left; margin-left: 73px;" id="Dtext" type="search" placeholder="Search here ..." class="form-control text-uppercase">
                   </div>
				</fieldset>
			</form>
            
			<div class='col-xs-12' align="center">
            <br>
				<table id="gridDialog" class="table table-striped"></table>
				<div id="gridDialogPager"></div>
			</div>
		</div>
		
		
		<div id="dialogForm" title="Dialog Form" >
			<form class='form-horizontal' style='width:99%' id='formdata'>
				<div class="form-group">
				  <label class="col-md-2 control-label" for="bankcode">Bank Code</label>  
				  <div class="col-md-3">
					<input id="bankcode" name="bankcode" type="text" class="form-control input-sm" data-validation="required">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-2 control-label" for="bankname">Name</label>  
				  <div class="col-md-10">
				  <input id="bankname" name="bankname" type="text" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="address1">Address</label>  
				  <div class="col-md-10">
				  <input id="address1" name="address1" type="text" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
				
				<div class="form-group">
				  <div class="col-md-offset-2 col-md-10">
				  <input id="address2" name="address2" type="text" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <div class="col-md-offset-2 col-md-10">
				  <input id="address3" name="address3" type="text" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="statecode">State Code</label>  
				  <div class="col-md-4">
				  <input id="statecode" name="statecode" type="text" class="form-control input-sm" >
				  </div>
				  
				  <label class="col-md-2 control-label" for="postcode">Post Code</label>  
				  <div class="col-md-4">
				  <input id="postcode" name="postcode" type="text" class="form-control input-sm" data-validation="number">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="country">Standard Code</label>  
				  <div class="col-md-4">
				  <input id="country" name="country" type="text" class="form-control input-sm">
				  </div>
				  
				  <label class="col-md-2 control-label" for="contact">Contact Person</label>  
				  <div class="col-md-4">
				  <input id="contact" name="contact" type="text" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="telno">Telephone No.</label>  
				  <div class="col-md-4">
				  <input id="telno" name="telno" type="text" class="form-control input-sm" data-validation="required">
				  </div>
				  
				  <label class="col-md-2 control-label" for="clearday">Clearing Days</label>  
				  <div class="col-md-4">
				  <input id="clearday" name="clearday" type="text" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="faxno">Fax No.</label>  
				  <div class="col-md-4">
				  <input id="faxno" name="faxno" type="text" class="form-control input-sm">
				  </div>
				  
				  <label class="col-md-2 control-label" for="effectdate">Effective Date</label>  
				  <div class="col-md-4">
				  <input id="effectdate" name="effectdate" type="date" data-date="" data-date-format="DD MMMM YYYY" class="form-control input-sm"
                   data-validation="date" >
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="bankaccount">Bank Account No.</label>  
				  <div class="col-md-4">
				  <input id="bankaccount" name="bankaccount" type="text" class="form-control input-sm" data-validation="required">
				  </div>
				  
				  <label class="col-md-2 control-label" for="pctype">Petty Cash</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="pctype" value='1'>yes</label>
					<label class="radio-inline"><input type="radio" name="pctype" value='0' checked>no</label>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="glccode">Cost Center</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="glccode" name="glccode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				  
				  <label class="col-md-2 control-label" for="glaccno">GL Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="glaccno" name="glaccno" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				    </div>
                    
                    <div class="form-group">
                    <label class="col-md-2 control-label" for="pctype">Record Status</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="recstatus" value='Yes' checked>Yes</label>
					<label class="radio-inline"><input type="radio" name="recstatus" value='No' >No</label>
				  </div>
				</div>
                  
                  
		</form>
		
            
			
		
		</div>
	</div><!--/.container-->

    
</body>
</html>