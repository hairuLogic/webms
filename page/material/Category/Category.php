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
    
    <?php include("CategoryScript.php")?>
    
    
    <meta charset="utf-8" />
    <title>Material - Category</title>
</head>
<body>

	 <input id="source2" name="source" type="hidden" value="<?php echo $_GET['source'];?>">  
     
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
        
        <div id="dialogForm" title="Dialog Form" >
        	<form class='form-horizontal' style='width:99%' id='formdata'>
            <input id="source2" name="source" type="hidden" value="<?php echo $_GET['source'];?>">
            
            <div class="form-group">
		    <label class="col-md-2 control-label" for="catcode">Category Code</label>  
            <div class="col-md-4">
            <input id="catcode" name="catcode" type="text" maxlength="12" class="form-control input-sm" data-validation="required">
            </div>
            
            <label class="col-md-2 control-label" for="description">Description</label>  
				  <div class="col-md-4">
				  <input id="description" name="description" type="text" maxlength="100" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
                
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="stockacct">Stock Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="stockacct" name="stockacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                                  
                  <label class="col-md-2 control-label" for="woffacct">Write Off Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="woffacct" name="woffacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="cosacct">COS Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="cosacct" name="cosacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                       
                  <label class="col-md-2 control-label" for="expacct">Expenses Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="expacct" name="expacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="adjacct">Adjustment Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="adjacct" name="adjacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                       
                  <label class="col-md-2 control-label" for="loanacct">Loan Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="loanacct" name="loanacct" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
                  <label class="col-md-2 control-label" for="povalidate">Record Status</label>  
				  <div class="col-md-4">
				    <label class="radio-inline"><input type="radio" name="povalidate" value='1' checked>ACTIVE</label>
					<label class="radio-inline"><input type="radio" name="povalidate" value='0'>DEACTIVE</label>				
                </div>
				</div>
                  
		</form>
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
        
        
        <!-------------------------- view ------------------------------------->
        
         <div id="editdialogForm" title="View" >
        	<form class='form-horizontal' style='width:99%' id='formdata2'>
            
            <div class="form-group">
            <label class="col-md-2 control-label" for="catcode">Category Code</label>  
				  <div class="col-md-4">
				  <input id="catcode" name="catcode" value="<?php echo "catcode";?>" readonly  class="form-control input-sm">
				  </div>
                  
                  <label class="col-md-2 control-label" for="description">Description</label>  
				  <div class="col-md-4">
				  <input id="description" name="description" value="<?php echo "description";?>" readonly  class="form-control input-sm">
				  </div>
				</div>
                  
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="stockacct">Stock Account</label>  
				  <div class="col-md-4">
				  <input id="stockacct" name="stockacct" value="<?php echo "stockacct";?>" readonly  class="form-control input-sm">  
				  </div>
                                  
                  <label class="col-md-2 control-label" for="woffacct">Write Off Account</label>  
				  <div class="col-md-4">
					  <input id="woffacct" name="woffacct" value="<?php echo "woffacct";?>" readonly  class="form-control input-sm"> 
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="cosacct">COS Account</label>  
				  <div class="col-md-4">
				  <input id="cosacct" name="cosacct" value="<?php echo "cosacct";?>" readonly  class="form-control input-sm"> 
				  </div>
                       
                  <label class="col-md-2 control-label" for="expacct">Expenses Account</label>  
				  <div class="col-md-4">
				  <input id="expacct" name="expacct" value="<?php echo "expacct";?>" readonly  class="form-control input-sm"> 
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
				  <label class="col-md-2 control-label" for="adjacct">Adjustment Account</label>  
				  <div class="col-md-4">
				  <input id="adjacct" name="adjacct" value="<?php echo "adjacct";?>" readonly  class="form-control input-sm"> 
				  </div>
                       
                  <label class="col-md-2 control-label" for="loanacct">Loan Account</label>  
				  <div class="col-md-4">
				  <input id="loanacct" name="loanacct" value="<?php echo "loanacct";?>" readonly  class="form-control input-sm">
				  </div>
                  </div>
                  
                  
                  <div class="form-group">
                  <label class="col-md-2 control-label" for="povalidate">Record Status</label>  
				  <div class="col-md-4">
				    <label class="radio-inline"><input type="radio" name="povalidate" value='1' disabled>ACTIVE</label>
					<label class="radio-inline"><input type="radio" name="povalidate" value='0' disabled>DEACTIVE</label>
                </div>
				</div>
                  
		 </form>
        </div>
        
		</div>
	</div><!--/.container-->

    
</body>
</html>