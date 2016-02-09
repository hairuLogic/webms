<?php 
	include_once('../../../../header2.php'); 
?>
<body>
	 
	 <input id="source2" name="source" type="hidden" value="<?php echo $_GET['source'];?>">  
	 
	<form id="searchForm" style='width:99%'>
		<fieldset>
			<div id="searchInContainer">
					<div id="Scol">Search By : </div>
			</div>
		
			<div style="padding-left: 65px;margin-top: 25px;padding-right: 60%;">
				<input id="Stext" name="Stext" type="search" placeholder="Search here ..." class="form-control text-uppercase">
			</div>
		 </fieldset>  
	</form>
		
	<div class='col-md-12' style="padding-left:0">
		<table id="jqGrid" class="table table-striped"></table>
		<div id="jqGridPager"></div>
	</div>
        
       <div id="dialog" title="title">
        	<form id="checkForm" style="width:99%">
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
		
		<div id="dialogForm" title="Add Form" >
			<form class='form-horizontal' style='width:99%' id='formdata'>
			
			<input id="source2" name="source" type="hidden" value="<?php echo $_GET['source'];?>">
			
				<div class="form-group">
				  <label class="col-md-2 control-label" for="paymode">Pay Mode</label>  
				  <div class="col-md-4">
				  <input id="paymode" name="paymode" type="text" maxlength="12" class="form-control input-sm text-uppercase" data-validation="required" frozeOnEdit>
				  </div>
				</div>
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="paytype">Paytype</label>  
				  <div class="col-md-10">
				    <table>
                             	<tr>
                             
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Bank Draft'>Bank Draft</label></td>
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Cash'>Cash</label></td>
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Cheque'>Cheque</label></td>
								</tr>
							
				 			<tr>
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Tele Transfer'>Tele Transfer</label></td>
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Bank'>Bank</label></td>
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Card'>Card</label></td>
							</tr>
                            
                            <tr>
				 			
                                <td><label class="radio-inline"><input type="radio" name="paytype" value='Credit Note'>Credit Note</label></td>
                               <td> <label class="radio-inline"><input type="radio" name="paytype" value='Debit Note'>Debit Note</label></td>
                               <td> <label class="radio-inline"><input type="radio" name="paytype" value='Forex'>Forex</label></td>
                               </tr>
                               </table>				
                </div>
				</div>
                
				<div class="form-group">
				  			<label class="col-md-2 control-label" for="description">Description</label>  
				  				<div class="col-md-4">
									<input id="description" name="description" type="text" class="form-control input-sm" >
								</div>
                  		
				
				 			<label class="col-md-2 control-label" for="ccode">Cost Code</label>  
				 			 	<div class="col-md-4">
					  				<div class='input-group'>
										<input id="ccode" name="ccode" type="text" class="form-control input-sm" data-validation="required">
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
				</div>
               
				 
				<div class="form-group">
                   		<label class="col-md-2 control-label" for="drpayment">Dr. Payment</label>  
				  			<div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="drpayment" value='1'>Yes</label>
                            <label class="radio-inline"><input type="radio" name="drpayment" value='0'>No</label>
				  			</div>
				
                  
                <label class="col-md-2 control-label" for="recstatus">Record Status</label>  
                          <div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="recstatus" value='A' checked>Active</label>
                            <label class="radio-inline"><input type="radio" name="recstatus" value='D'>Deactive</label>
                          </div>
				</div>
               
                  
                <div class="form-group">
                        <label class="col-md-2 control-label" for="cardflag">Card Flag</label>  
                          <div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="cardflag" value='1'>Yes</label>
                            <label class="radio-inline"><input type="radio" name="cardflag" value='0'>No</label>
                          </div>
                          
                        <label class="col-md-2 control-label" for="valexpdate">ValExpDate</label>                          
                          <div class="col-md-4">
                            <label class="radio-inline"><input type="radio" name="valexpdate" value='1'>Yes</label>
                            <label class="radio-inline"><input type="radio" name="valexpdate" value='0'>No</label>
                          </div>
				</div>	
                
                <div class="form-group">
                 		<label class="col-md-2 control-label" for="lastuser">Entered By</label>  
				  			<div class="col-md-4">
				  			<input id="lastuser" name="lastuser" type="text" class="form-control input-sm" >
				  			</div>
                </div>
					 
				
                </form>
			</div>
			
	<?php 
		include_once('../../../../footer2.php'); 
	?>
	
	<!-- JS Implementing Plugins -->

	<!-- JS Customization -->

	<!-- JS Page Level -->
	<script src="paymentMode.js"></script>

<script>
		
</script>
</body>
</html>