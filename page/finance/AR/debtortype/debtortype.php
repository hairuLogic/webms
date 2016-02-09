<?php 
	include_once('../../../../header2.php'); 
?>
<body>
	 
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
        	<form id="checkForm" class="form-horizontal col-xs-12" style="background-color:gainsboro;margin-top:5px;border-radius:5px"><br>
            	<div id="Dcol" class='col-xs-6 form-group'>
				</div>
                
				<div class='col-xs-7 form-group'>
					<input id="Dtext" type="search" placeholder="Search here ..." class="form-control text-uppercase">
				</div>
			</form>
            
			<div class='col-xs-12' align="center">
            <br>
				<table id="gridDialog" class="table table-striped"></table>
				<div id="gridDialogPager"></div>
			</div>
		</div>
		
		<div id="dialogForm" title="Add Form" >
			<form class='form-horizontal' style='width:99%' id='formdata'>
				<div class="form-group">
				  <label class="col-md-2 control-label" for="debtortycode">Financial Class</label>  
				  <div class="col-md-4">
				  <input id="debtortycode" name="debtortycode" type="text" maxlength="30" class="form-control input-sm text-uppercase" data-validation="required" frozeOnEdit>
				  </div>
                </div>
				
				
				<div class="form-group">
				  <label class="col-md-2 control-label" for="description">Description</label>  
				  <div class="col-md-10">
				  <input id="description" name="description" type="text" maxlength="40" class="form-control input-sm text-uppercase" data-validation="required">
				  </div>
                </div>
                
				<div class="form-group">
					<label class="col-md-2 control-label" for="actdebccode">Actual Cost</label>  
					<div class="col-md-4">
					  <div class='input-group'>
						<input id="actdebccode" name="actdebccode" type="text" class="form-control input-sm text-uppercase" data-validation="required"/>
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
					</div>
					
					<label class="col-md-2 control-label" for="actdebglacc">Actual Account</label>  
					<div class="col-md-4">
					  <div class='input-group'>
						<input id="actdebglacc" name="actdebglacc" type="text" class="form-control input-sm text-uppercase" data-validation="required"/>
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
					</div>
				</div>
                
				<div class="form-group">
					<label class="col-md-2 control-label" for="depccode">Deposit Cost</label>  
					<div class="col-md-4">
					  <div class='input-group'>
						<input id="depccode" name="depccode" type="text" class="form-control input-sm text-uppercase" data-validation="required"/>
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
					</div>
					
					<label class="col-md-2 control-label" for="depglacc">Deposit Account</label>  
					<div class="col-md-4">
					  <div class='input-group'>
						<input id="depglacc" name="depglacc" type="text" class="form-control input-sm text-uppercase" data-validation="required"/>
						<a class='input-group-addon btn btn-primary'><span class='ion-more'></span></a>
					  </div>
					  <span class="help-block"></span>
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
	<script src="debtorType.js"></script>

<script></script>
</body>
</html>