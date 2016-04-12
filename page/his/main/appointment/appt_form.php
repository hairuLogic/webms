<div id="dialog-form" style="display: none" title="Appointment Detail" class="ui-front">
<form id="frmAppt" onsubmit="return checkform(this)">
	<input type="hidden" id="formstatus" name="formstatus" value="open">
	<div id="apptnew" class="tab-pane fade in">
			<label class="col-md-2 control-label" for="name">Doctor: </label>
			<div class="col-md-10 selPat" style="margin-bottom:20px">
				<input id="cmb_doctor_3" disabled class="add_input form-control input-sm" name="cmb_doctor_3" placeholder="select doctor" type="text" value="" required /><a class="add">
				<input class="form-control input-sm" type="button" value="i" />
				</a>
			</div>
			<label class="col-md-2 control-label" for="name">Date/Time:
			</label>
			<div class="col-md-10 selPat">
				<input id="schDateTime" class="form-control input-sm" name="schDateTime" readonly type="text" placeholder="Please select datetime from calendar" onclick="selCalendar()" required><br>
			</div>
			<label class="col-md-2 control-label" for="status">Status</label>
			<div class="col-md-10">
				<select id="patStatus" class="form-control" name="patStatus">
				<option value="Open">Open</option>
				<option value="Attend">Attend</option>
				<option value="Cancelled">Cancelled</option>
				</select><br></div>
			<label class="col-md-2 control-label" for="name">MRN</label>
			<div class="col-md-10 selPat">
				<input id="cmb_mrn" class="form-control" name="cmb_mrn" type="text"><br>
			</div>
			<label class="col-md-2 control-label" for="name">IC No.</label>
			<div class="col-md-10">
				<input id="patIc" class="form-control input-sm" name="patIc" type="text"><br>
			</div>
			<label class="col-md-2 control-label" for="name">Name</label>
			<div class="col-md-10">
				<input id="patName" class="form-control input-sm" name="patName" type="text" required><br>
			</div>
			<label class="col-md-2 control-label" for=""></label>
			<div class="col-md-10">
				<table>
					<tr>
						<td><label class="col-md-4 control-label" for="name">Telephone</label>
						<div class="col-md-8">
							<input id="patContact3" class="form-control input-sm" name="patContact3" type="text" required><br>
						</div>
						</td>
						<td><label class="col-md-4 control-label" for="name">Handphone</label>
						<div class="col-md-8">
							<input id="patHp3" class="form-control input-sm" name="patHp3" type="text"><br>
						</div>
						</td>
					</tr>
					<tr>
						<td><label class="col-md-4 control-label" for="name">Tel. 
						Office</label>
						<div class="col-md-8">
							<input id="patFax-3" class="form-control input-sm" name="patFax-3" type="text"><br>
						</div>
						</td>
						<td></td>
					</tr>
				</table>
			</div>
			<label class="col-md-2 control-label" for="name">Case:</label>
			<div class="col-md-10" style="margin-bottom:20px">
				<input id="patCase" class="add_input form-control input-sm" name="patCase" type="text"><a class="add">
			<input class="form-control input-sm" type="button" value="..." />
			</a><br>
			</div>
			<label class="col-md-2 control-label" for="name">Remarks:</label>
			<div class="col-md-10">
				<textarea id="patNote" class="form-control input-sm" name="patNote" type="text"></textarea><br>
			</div>
			<label class="col-md-2 control-label" for="name">Last Update:</label>
			<div class="col-md-10">
				<input id="patLastUpdate" class="form-control input-sm" name="patLastUpdate" type="text" required><br>
			</div>
			<label class="col-md-2 control-label" for="name">Update By:</label>
			<div class="col-md-10">
				<input id="patUpdateBy" class="form-control input-sm" name="patUpdateBy" type="text" required><br>
			</div>
		</div>
</form>	
</div>

<script type="text/javascript">
function checkform(form) {
    // get all the inputs within the submitted form
    var inputs = form.getElementsByTagName('input');
    for (var i = 0; i < inputs.length; i++) {
        // only validate the inputs that have the required attribute
        if(inputs[i].hasAttribute("required")){
            if(inputs[i].value == ""){
                // found an empty field that is required
                alert("Please fill all required fields");
                return false;
            }
        }
    }
    return true;
}
</script>