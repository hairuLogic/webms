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
				  <label class="col-md-2 control-label" for="trantype">Transaction Type</label>  
				  <div class="col-md-2">
						<input id="trantype" name="trantype" type="text" maxlength="2" class="form-control input-sm" data-validation="required">
				  </div>
				  
				  <label class="col-md-2 control-label" for="description">Description</label>  
				  <div class="col-md-6">
				  <input id="description" name="description" type="text" maxlength="100" class="form-control input-sm" data-validation="required">
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="depccode">Deposit Cost</label>  
				  <div class="col-md-2">
					  <div class='input-group'>
						<input id="depccode" name="depccode" type="text" maxlength="3" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				  
				  <label class="col-md-2 control-label" for="depglacc">Deposit GL Account</label>  
				  <div class="col-md-4">
					  <div class='input-group'>
						<input id="depglacc" name="depglacc" type="text" class="form-control input-sm" data-validation="required">
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="updpayername">Update Payer Name</label>  
				  <div class="col-md-2">
					<label class="radio-inline"><input type="radio" name="updpayername" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="updpayername" value='No' data-validation="">No</label>
				  </div>
				  
				  <label class="col-md-2 control-label" for="updepisode">Update Episode</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="updepisode" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="updepisode" value='No' data-validation="">No</label>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="manualalloc">Manual Alloc</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="manualalloc" value='Yes' data-validation="required">Yes</label>
					<label class="radio-inline"><input type="radio" name="manualalloc" value='No' data-validation="">No</label>
				  </div>
				</div>
                
                <div class="form-group">
				  <label class="col-md-2 control-label" for="recstatus">Record Status</label>  
				  <div class="col-md-4">
					<label class="radio-inline"><input type="radio" name="recstatus" value='A' checked>Active</label>
					<label class="radio-inline"><input type="radio" name="recstatus" value='D'>Deactive</label>
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
	<script src="depositType.js"></script>

<script>
		
</script>
</body>
</html>