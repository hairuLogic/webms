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
	
    <?php include("productScript.php")?>
    
    <meta charset="utf-8" />
    <title>Material - Product</title>
</head>
<body>
	  
	<div class="container" style="margin-bottom:1em">
		<div class='row'></div>
        
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
                    	Search By : <div id="Dcol" style="float:right; margin-right: 85px;"></div>
                   
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
        
        <div id="dialog2" title="title">
        	<form id="searchForm" style="width:99%">
				<fieldset>
                    <div id="searchInContainer">
                    	Search By : <div id="Dcol2" style="float:right; margin-right: 85px;"></div>
                   
                   		<input  style="float:left; margin-left: 73px;" id="Dtext2" type="search" placeholder="Search here ..." class="form-control text-uppercase">
                   </div>
				</fieldset>
			</form>
            
			<div class='col-xs-12' align="center">
            <br>
				<table id="gridDialog2" class="table table-striped"></table>
				<div id="gridDialogPager2"></div>
			</div>
		</div>
        
        
        <!--------------------ADD FORM 
               		 <select id="Dcol2" class="form-control"></select>-------------------------------->
        
        <div id="dialogForm" title="Dialog Form" >
        	<form class='form-horizontal' style='width:99%' id='formdata'>
            
            	<div class="form-group">
				  <label class="col-md-2 control-label" for="itemcode">Item Code</label>  
				  <div class="col-md-3">
					<input id="itemcode" name="itemcode" type="text" maxlength="12" class="form-control input-sm" data-validation="required">
				  </div>
                  
                  <label class="col-md-2 control-label" for="description">Item Description</label>  
				  <div class="col-md-5">
				  <input id="description" name="description" type="text" maxlength="100" class="form-control input-sm" data-validation="required">
				  </div>
			    </div>
                
                <div class="form-group"> 
                 <label class="col-md-2 control-label" for=""></label>
				  <div class="col-md-3">
				  <input id="" name="" type="hidden">
				  </div>
                  
                  <label class="col-md-2 control-label" for="generic">Generic Name</label>  
				  <div class="col-md-5">
				  <input id="generic" name="generic" type="text" maxlength="40" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
                
                <div class="form-group">
                   <label class="col-md-2 control-label" for="groupcode">Group Code</label>  
				  <div class="col-md-3">
					<label class="radio-inline"><input type="radio" name="groupcode" value='Stock' data-validation="required">Stock</label>
					<label class="radio-inline"><input type="radio" name="groupcode" value='Asset' data-validation="">Asset</label>
                    <label class="radio-inline"><input type="radio" name="groupcode" value='Other' data-validation="">Other</label>
				  </div>
                  <label class="col-md-2 control-label" for="productcat">Category</label>  
				  <div class="col-md-3">
				  <input id="productcat" name="productcat" type="text" maxlength="12" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="subcatcode">Sub Category</label>  
				  <div class="col-md-3">
				  <input id="subcatcode" name="subcatcode" type="text" maxlength="15" class="form-control input-sm" data-validation="required">
				  </div>
                  
                  <label class="col-md-2 control-label" for="uomcode">UOM Code</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="uomcode" name="uomcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
                      
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="pouom">PO OUM</label>  
				  <div class="col-md-3">
				  <input id="pouom" name="pouom" type="text" maxlength="15" class="form-control input-sm" data-validation="required">
				  </div>
                  
               	  <label class="col-md-2 control-label" for="itemtype">Item Type</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="itemtype" value='Non-poison' data-validation="required">Non-poison</label>
					<label class="radio-inline"><input type="radio" name="itemtype" value='Poison' data-validation="">Poison</label>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="suppcode">Supplier Code</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="suppcode" name="suppcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                  
                  <label class="col-md-2 control-label" for="mstore">Main Store</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="mstore" name="mstore" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				</div>
                
            <hr> 
            
            	<div class="form-group">
				  <label class="col-md-3 control-label" for="minqty">Min Stock Qty</label>  
				  <div class="col-md-2">
				  <input id="minqty" name="minqty" type="text" maxlength="11" class="form-control input-sm" data-validation="required,number">
				  </div>
                  
                  <label class="col-md-3 control-label" for="maxqty">Max Stock Qty</label>  
				  <div class="col-md-2">
				  <input id="maxqty" name="maxqty" type="text" maxlength="11" class="form-control input-sm" data-validation="required,number">
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-3 control-label" for="reordlevel">Record Level</label>  
				  <div class="col-md-2">
				  <input id="reordlevel" name="reordlevel" type="text" maxlength="11" class="form-control input-sm" data-validation="required,number">
				  </div>
                  
                  <label class="col-md-3 control-label" for="reordqty">Reoder Qty</label>  
				  <div class="col-md-2">
				  <input id="reordqty" name="reordqty" type="text" maxlength="11" class="form-control input-sm" data-validation="required,number">
				  </div>
				</div>
                
                <hr>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="reuse">Reuse</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="reuse" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="reuse" value='No' data-validation="">No</label>
				  </div>
				  
				  <label class="col-md-2 control-label" for="rpkitem">Repack Item</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="rpkitem" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="rpkitem" value='No' data-validation="">No</label>
				  </div>
                  
                  <label class="col-md-2 control-label" for="tagging">Tagging</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="tagging" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="tagging" value='No' data-validation="">No</label>
				  </div>
				</div>
                
                 <div class="form-group">
				  <label class="col-md-2 control-label" for="expdtflg">Expiry Date</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="expdtflg" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="expdtflg" value='No' data-validation="">No</label>
				  </div>
				  
				  <label class="col-md-2 control-label" for="chgflag">Charge</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="chgflag" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="chgflag" value='No' data-validation="">No</label>
				  </div>
                  
                  <label class="col-md-2 control-label" for="active">Record Status</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="active" value='Yes' checked>Yes</label>
					<label class="radio-inline"><input type="radio" name="active" value='No'>No</label>
				  </div>
				</div>
            
            </form>
        </div>
	</div><!--/.container-->

    
</body>
</html>