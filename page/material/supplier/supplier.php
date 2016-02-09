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
	
    <?php include("supplierScript.php")?>
    
    <meta charset="utf-8" />
    <title>Material - Supplier</title>
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
        
        <br>
        
         <div class='row'>
			<div class="col-md-12">
				<table id="gridSuppitems" class="table table-striped"></table>
                <div id="jqGridPager2"></div>
            </div>
        </div>
        
        <br>
        
         <div class='row'>
			<div class="col-md-12">
				<table id="gridSuppbonus" class="table table-striped"></table>
                <div id="jqGridPager3"></div>
            </div>
        </div>
		
		<div id="dialog" title="title">
        	<form id="searchForm" style="width:99%">
				<fieldset>
                    <div id="searchInContainer">
                    	Search By : <div id="Dcol" style="float:right; margin-right: 78px;"></div>
                   
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
        
        
        <div id="dialogForm" title="Supplier Form" >
        	<form class='form-horizontal' style='width:99%' id='formdata'>
            
            
            	<div class="form-group">
				  <label class="col-md-2 control-label" for="SuppCode">Supplier Code</label>  
				  <div class="col-md-2">
					<input id="SuppCode" name="SuppCode" type="text" maxlength="6" class="form-control input-sm" data-validation="required">
				  </div>
				</div>

				<div class="form-group">
				  <label class="col-md-2 control-label" for="Name">Name</label>  
				  <div class="col-md-8">
				  <input id="Name" name="Name" type="text" maxlength="100" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="Addr1">Address</label>  
				  <div class="col-md-8">
				  <input id="Addr1" name="Addr1" type="text" maxlength="40" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
				
				<div class="form-group">
				  <div class="col-md-offset-2 col-md-8">
				  <input id="Addr2" name="Addr2" type="text" maxlength="40" class="form-control input-sm">
				  </div>
				</div>
				
				<div class="form-group">
				  <div class="col-md-offset-2 col-md-8">
				  <input id="Addr3" name="Addr3" type="text" maxlength="40" class="form-control input-sm">
				  </div>
				</div>
                
                <div class="form-group">
				  <div class="col-md-offset-2 col-md-8">
				  <input id="Addr4" name="Addr4" type="text" maxlength="40" class="form-control input-sm">
				  </div>
				</div>
                
                <div class="form-group">
				   <label class="col-md-2 control-label" for="TelNo">Tel No</label>  
				  <div class="col-md-3">
				  <input id="TelNo" name="TelNo" type="text" maxlength="50" class="form-control input-sm" data-validation="number">
				  </div>
				  
				  <label class="col-md-2 control-label" for="Faxno">Fax No</label>  
				  <div class="col-md-3">
				  <input id="Faxno" name="Faxno" type="text" maxlength="30" class="form-control input-sm" data-validation="number">
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="ContPers">Contact Person</label>  
				  <div class="col-md-3">
				  <input id="ContPers" name="ContPers" type="text" maxlength="40" class="form-control input-sm" data-validation="required">
				  </div>
				  
				   <label class="col-md-2 control-label" for="SuppGroup">Supplier Group</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="SuppGroup" name="SuppGroup" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="CostCode">Cost Code</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="CostCode" name="CostCode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				  
				  <label class="col-md-2 control-label" for="GlAccNo">Gl Account No</label>  
				  <div class="col-md-3">
					  <div class='input-group'>
						<input id="GlAccNo" name="GlAccNo" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="AccNo">Company Account No</label>  
				  <div class="col-md-3">
				  <input id="AccNo" name="AccNo" type="text" maxlength="15" class="form-control input-sm" data-validation="required">
				  </div>
                  
                  
				  
				   	<label class="col-md-2 control-label" for="SuppFlg">Supply Goods</label>  
				  	<div class="col-md-2">
                        <label class="radio-inline"><input type="radio" name="SuppFlg" value='Yes' checked>Yes</label>
                        <label class="radio-inline"><input type="radio" name="SuppFlg" value='No'>No</label>
					</div>
                  
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="recstatus">Record Status</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="recstatus" value='A' checked>Active</label>
					<label class="radio-inline"><input type="radio" name="recstatus" value='D'>Deactive</label>
				  </div>
				</div>
                
                <fieldset style="border:3px; border-top:1px solid black;">
                   <legend style="text-align:center; width:17% !important; border-bottom:0px !important;     font-size:16px !important; font-weight: bold;">Payment Terms</legend>
                </fieldset>
                
                <div class="form-group">
				   <label class="col-md-2 control-label" for="TermDisp">Disposable</label>  
				  <div class="col-md-2">
				  <input id="TermDisp" name="TermDisp" type="text" value="0" maxlength="9" class="form-control input-sm" data-validation="required,number">
				  </div>
				  
				  <label class="col-md-2 control-label" for="TermNonDisp">Non-Disposable</label>  
				  <div class="col-md-2">
				  <input id="TermNonDisp" name="TermNonDisp" type="text" value="0" maxlength="9" class="form-control input-sm" data-validation="required,number">
				  </div>
                
                <div class="form-group">
				   <label class="col-md-1 control-label" for="TermOthers">Other</label>  
				  <div class="col-md-2">
				  <input id="TermOthers" name="TermOthers" type="text" value="0" maxlength="9" class="form-control input-sm" data-validation="required,number">
				  </div>
               </div>
               
               
			</form>
		</div>
        
        <!--------------------------------FormSupplierItem-     pattern="[0-9]+([,\.][0-9]+)?"  step="0.01"------------------>
         <div id="dialogItem" title="title">
         	<form id="searchForm" style="width:99%">
				<fieldset>
                    <div id="searchInContainer">
                    	Search By : <div id="DcolItem" style="float:right; margin-right: 80px;"></div>
                   
                   		<input  style="float:left; margin-left: 73px;" id="DtextItem" type="search" placeholder="Search here ..." class="form-control text-uppercase">
                   </div>
				</fieldset>
			</form>
            
			<div class='col-xs-12' align="center">
            <br>
				<table id="gridDialogItem" class="table table-striped"></table>
				<div id="gridDialogPagerItem"></div>
			</div>
		</div>
        
         <div id="dialogFormSupplierItem" title="Supplier Item" >
        	<form class='form-horizontal' style='width:99%' id='formdataSupplierItem'>
            
            	<input id="lineno_" name="lineno_" type="hidden" class="form-control input-sm">
                <input id="suppcode" name="suppcode" type="hidden" class="form-control input-sm">
               
            	 <div class="form-group">
				  <label class="col-md-4 control-label" for="pricecode">Price Code</label>  
				  	<div class="col-md-3">
					  <div class='input-group'>
						<input id="pricecode" name="pricecode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                 </div>
            
            	<div class="form-group">
				  <label class="col-md-4 control-label" for="itemcode">Item Code</label>  
				  	<div class="col-md-5">
					  <div class='input-group'>
						<input id="itemcode" name="itemcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                </div>		
                 
                 <div class="form-group">
				  <label class="col-md-4 control-label" for="uomcode">UOM Code</label>  
				  	<div class="col-md-5">
					  <div class='input-group'>
						<input id="uomcode" name="uomcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                 </div>	
                 
                 <div class="form-group">
				  	<label class="col-md-4 control-label" for="purqty">Purchase Quantity</label>  
				  		<div class="col-md-4">
				  		<input id="purqty" name="purqty" type="text" required class="form-control input-sm" data-validation="required">
				  		</div>
                </div>	
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="unitprice">Unit Price</label>  
				  		<div class="col-md-4">
				  		<input id="unitprice" name="unitprice" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="perdiscount">Percentage of Discount</label>  
				  		<div class="col-md-4">
				  		<input id="perdiscount" name="perdiscount" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="amtdisc">Amount Discount</label>  
				  		<div class="col-md-4">
				  		<input id="amtdisc" name="amtdisc" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>	
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="perslstax">Percentage of Sales Tax</label>  
				  		<div class="col-md-4">
				  		<input id="perslstax" name="perslstax" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="amtslstax">Amount Sales Tax</label>  
				  		<div class="col-md-4">
				  		<input id="amtslstax" name="amtslstax" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="expirydate">Expiry Date</label>  
				  		<div class="col-md-4">
				  		<input id="expirydate" name="expirydate" type="Date" min="<?php echo date("Y-m-d"); ?>"   class="form-control input-sm" data-validation="date,required">
				  		</div>
                </div>
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="sitemcode">Item Code at Supplier's Site</label>  
				  		<div class="col-md-4">
				  		<input id="sitemcode" name="sitemcode" type="text" maxlength="12" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                <div class="form-group">
				  <label class="col-md-4 control-label" for="recstatus">Record Status</label>  
				  <div class="col-md-6">
					<label class="radio-inline"><input type="radio" name="recstatus" value='A' checked>Active</label>
					<label class="radio-inline"><input type="radio" name="recstatus" value='D'>Deactive</label>
				  </div>
				</div>
			</form>
		</div>
        
         <!--------------------------------FormSupplierBonus------------------->
         <div id="dialogBonus" title="title">
         	<form id="searchForm" style="width:99%">
				<fieldset>
                    <div id="searchInContainer">
                    	Search By : <div id="DcolBonus" style="float:right; margin-right: 80px;"></div>
                   
                   		<input  style="float:left; margin-left: 73px;" id="DtextBonus" type="search" placeholder="Search here ..." class="form-control text-uppercase">
                   </div>
				</fieldset>
			</form>
            
			<div class='col-xs-12' align="center">
            <br>
				<table id="gridDialogBonus" class="table table-striped"></table>
				<div id="gridDialogPagerBonus"></div>
			</div>
		</div>
        
        <div id="dialogFormSupplierBonus" title="Bonus Item" >
        	<form class='form-horizontal' style='width:99%' id='formdataSupplierBonus'>
            
            <input id="suppcode2" name="suppcode" type="hidden" class="form-control input-sm">
            <input id="pricecode2" name="pricecode" type="hidden" class="form-control input-sm">
            <input id="itemcode2" name="itemcode" type="hidden" class="form-control input-sm">
            <input id="uomcode2" name="uomcode" type="hidden" class="form-control input-sm">
            <input id="purqty2" name="purqty" type="hidden" class="form-control input-sm">
            <input id="lineno_2" name="lineno_" type="hidden" class="form-control input-sm">
            
            	<div class="form-group">
				  <label class="col-md-4 control-label" for="bonpricecode">Bonus Price Code</label>  
				  	<div class="col-md-3">
					  <div class='input-group'>
						<input id="bonpricecode" name="bonpricecode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                 </div>
                 
                 <div class="form-group">
				  <label class="col-md-4 control-label" for="bonitemcode">Bonus Item Code</label>  
				  	<div class="col-md-5">
					  <div class='input-group'>
						<input id="bonitemcode" name="bonitemcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                </div>	
                
                <div class="form-group">
				  <label class="col-md-4 control-label" for="bonuomcode">Bonus UOM Code</label>  
				  	<div class="col-md-5">
					  <div class='input-group'>
						<input id="bonuomcode" name="bonuomcode" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  	</div>
                 </div>
                 
                 <div class="form-group">
				  	<label class="col-md-4 control-label" for="bonqty">Bonus Quantity</label>  
				  		<div class="col-md-4">
				  		<input id="bonqty" name="bonqty" type="text" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>	
                
                <div class="form-group">
				  	<label class="col-md-4 control-label" for="bonsitemcode">Bonus Item Code at Supplier Site</label>  
				  		<div class="col-md-4">
				  		<input id="bonsitemcode" name="bonsitemcode" type="text" maxlength="12" class="form-control input-sm" data-validation="required">
				  		</div>
                </div>
                
                 <div class="form-group">
				  <label class="col-md-4 control-label" for="recstatus">Record Status</label>  
				  <div class="col-md-6">
					<label class="radio-inline"><input type="radio" name="recstatus" value='A' checked>Active</label>
					<label class="radio-inline"><input type="radio" name="recstatus" value='D'>Deactive</label>
				  </div>
				</div>
            </form>
        </div>
	</div><!--/.container-->

    
</body>
</html>