<?php 
	include_once('../../../../assets/php/sschecker.php'); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="../../../../assets/plugins/form-validator/theme-default.css" rel="stylesheet" />
<link href="../../../../assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet">
<link href="../../../../assets/plugins/font-awesome-4.4.0/css/font-awesome.min.css" rel="stylesheet">
<link href="../../../../assets/plugins/ionicons-2.0.1/css/ionicons.min.css" rel="stylesheet">
<link href="../../../../assets/plugins/AccordionMenu/dist/metisMenu.min.css" rel="stylesheet">
<link href="../../../../assets/plugins/bootstrap-3.3.5-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="../../../../assets/plugins/jasny-bootstrap/css/jasny-bootstrap.min.css" rel="stylesheet">
<link href="../../../../assets/plugins/css/trirand/ui.jqgrid-bootstrap.css" rel="stylesheet" />
<link href="../../../../assets/plugins/searchCSS/stylesSearch.css" rel="stylesheet">
<link href="../../../../assets/plugins/fullcalendar-2.6.0/fullcalendar.css" rel="stylesheet" />
<link href="../../../../assets/plugins/fullcalendar-2.6.0/fullcalendar.print.css" media="print" rel="stylesheet" />
<style>
.wrap {
	word-wrap: break-word;
}
.ui-th-column {
	word-wrap: break-word;
	white-space: normal !important;
	vertical-align: top !important;
}
.radio-inline + .radio-inline {
	margin-left: 0;
}
.radio-inline {
	margin-right: 10px;
}
::-webkit-scrollbar {
	width: 6px; /* for vertical scrollbars */;
	height: 6px; /* for horizontal scrollbars */
}
::-webkit-scrollbar-track {
	background: rgba(0, 0, 0, 0.1);
}
::-webkit-scrollbar-thumb {
	background: rgba(0, 0, 0, 0.5);
}
h2 {
	font-size: 24px;
}
.custom-combobox {
	position: relative;
	display: inline-block;
}
.custom-combobox-toggle {
	position: absolute;
	top: 0;
	bottom: 0;
	margin-left: -1px;
	padding: 0;
}
.custom-combobox-input {
	margin: 0;
	padding: 5px 5px;
}
.auto-style1 {
	text-decoration: underline;
}
.add_input {
	width: 80%;
	display: inline-block;
	vertical-align: bottom;
}
.add input {
	/*background:url(add.png);*/
    display: inline-block;
	width: 30px;
	/*border-radius: 0px 5px 5px 0px;*/
	font-weight: 700;
}
.sel_date{
	width:150px;
	display:inline-block;
}

.custSideTip
{
    position:fixed !important;
    right:0 !important;
    max-width:200px !important;
    background-color:white;
}

</style>
<meta charset="utf-8" />
<title>Appointment - Doctor</title>
</head>

<body>

<div style="width: 100%; padding: 5px">
	<div class="row" style="border:1px silver solid; padding:10px 0px 10px 0px;margin:5px 2px 20px 2px">
		<div class="col-sm-7">
			<input id="docid" name="docid" type="hidden">
			<input id="cmb_doctor" class="add_input form-control input-sm" name="qty" name="cmb_doctor" placeholder="select doctor" type="text" value="" /><a class="add">
			<input class="form-control input-sm" type="button" onclick="$('#dialog-doctor-info').dialog('open');" value="i" />
			<input class="form-control input-sm" type="button" value="..." />
			</a>
			<!--input id="cmb_doctor" class="form-control input-sm" name="cmb_doctor" placeholder="select doctor" type="text"><br-->
			
		</div>
		<div class="col-sm-5" style="text-align:right">
			<input id="create-appt" class="btn" type="button" value="New Appointment">&nbsp;
			<input id="new-transfer" class="btn" type="button" value="Transfer">&nbsp;
			<input class="btn" type="button" value="Search">
		</div>
	</div>
	<div style="float:left">
		<select id="cmb_month" class="sel_date form-control input-sm" style="width:100px">
		<option value="0">January</option>
		<option value="1">February</option>
		<option value="2">March</option>
		<option value="3">April</option>
		<option value="4">May</option>
		<option value="5">June</option>
		<option value="6">July</option>
		<option value="7">August</option>
		<option value="8">September</option>
		<option value="9">October</option>
		<option value="10">November</option>
		<option value="11">December</option>
		</select> <select id="cmb_year" class="sel_date form-control input-sm" style="width:70px">
		<option value="2015">2015</option>
		<option value="2016">2016</option>
		<option value="2017">2017</option>
		<option value="2018">2018</option>
		<option value="2019">2019</option>
		<option value="2020">2020</option>
		</select> <input class="btn sel_date" style="width:40px" onclick="FcGoToDate()" type="button" value="Go">
	</div>
	<div id="calendar">
	</div>
</div>
<table style="font-size:10px;margin:10px"><tr style="text-align:center;"><td rowspan="2" style="vertical-align:top;font-weight:bold">Legend:</td><td style="width:50px"><img alt="Open" src="../../../../assets/img/icon/i-open.jpg" width="20px" /></td><td style="width:50px"><img alt="Open" src="../../../../assets/img/icon/i-attend.jpg" width="15" /></td><td style="width:50px"> <img alt="Open" src="../../../../assets/img/icon/i-xattend.jpg" width="15" /></td><td style="width:50px"> <img alt="Open" src="../../../../assets/img/icon/i-cancel.jpg" width="15" /></td></tr>
<tr style="text-align:center"><td>Open</td><td>Attend</td><td>Not Attend</td><td>Cancel</td></tr></table>
									
<div id="divGrid" style="float: right; width: 100%; padding: 5px; text-align: right">
	<ul class="nav nav-tabs" style="display: none">
		<li class="active"><a data-toggle="tab" href="#search">Appoinment List</a></li>
		<li><a data-toggle="tab" href="#appt">Appointment Detail</a></li>
		<li><a data-toggle="tab" href="#apptnew">New Appointment</a></li>
	</ul>
	<div class="tab-content">
		<div id="search" class="tab-pane fade in active" style="text-align: left">
			<!--h4>Search Criteria</h4-->
			<div id="gridDialogPager">
			</div>
			<table id="gridDialog" class="table table-striped" style="width: 100%">
			</table>
		</div>
	</div>
</div>
<?php 
	include_once('appt_form.php'); 
	include_once('appt_transfer.php');
	include_once('doc_info.php');
?>
<script src="../../../../assets/plugins/jquery.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/trirand/i18n/grid.locale-en.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/trirand/jquery.jqGrid.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/bootstrap-3.3.5-dist/js/bootstrap.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/jasny-bootstrap/js/jasny-bootstrap.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/AccordionMenu/dist/metisMenu.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/form-validator/jquery.form-validator.min.js" type="text/ecmascript"></script>
<script src="../../../../assets/plugins/jquery.dialogextend.js" type="text/ecmascript"></script>
<!-- JS Implementing Plugins -->
<script src="../../../../assets/plugins/fullcalendar-2.6.0/lib/moment.min.js"></script>
<script src="../../../../assets/plugins/fullcalendar-2.6.0/fullcalendar.min.js"></script>
<!-- JS Customization -->
<script src="../../../../assets/js/doctor.js"></script>
<script src="../../../../assets/js/cmbautoselect.js"></script>
<script src="http://cdn.jsdelivr.net/qtip2/2.2.1/jquery.qtip.min.js"></script>
<!-- JS Page Level --><span class="auto-style1">
<script>
    jQuery(document).ready(function() 
    {
        Doctor.init_load();
        //Doctor.init_calendar();
        //Doctor.init_doctor();
        
			$( "#create-new" ).button().on( "click", function() {
                $("#txt_doc").html($("#cmb_doctor").val());
                $("#txt_appt").html($("#schDateTime").val());
                $("#txt_name").html($("#patName").val());
                $("#txt_ic").html($("#patIc").val());
                $("#txt_mrn").html($("#cmb_mrn").val());
                $("#txt_tel").html($("#patContact").val());
                $("#txt_hp").html($("#patHp").val());

				//$( "#dialog1" ).dialog( "open" );
			});
	
			$( "#create-transfer" ).button().on( "click", function() {
				Doctor.init_save();
			});

			$( "#btn-cancel" ).button().on( "click", function() {
/*	            $("#patIc").val('');
	            $("#patName").val('');
	            //$("#patAddr").val('');
	            $("#patContact").val('');
	            $('#cmb_patient option[eq=0]').attr("selected", "selected");
				$("#btn-cancel").hide();
				$("#create-transfer").html('Save');
*/				
				$('.nav-tabs li:eq(0) a').tab('show'); 
			});

/*		$("#dialog1").dialog(
		{
		    autoOpen: false, 
		    modal: true,
		    width: 400,
		    height: 400,
		    open: function() {
		        $('.ui-widget-overlay').addClass('custom-overlay');
		    },
		    close: function() {
		        $('.ui-widget-overlay').removeClass('custom-overlay');
		    }            
		});
*/        
        
		$('#cmb_patient').change( function(){
            $("#patIc").val('');
            $("#patName").val('');
            //$("#patAddr").val('');
            $("#patContact").val('');
	        Doctor.init_patient($('#cmb_patient').val());	        	
	    });        


		$("#cmb_mrn").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_patient", {
		            term: request.term,
		            typ: 'mrn'
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.patient, function(m) {
		                return {
		                    label: m.MRN +' | '+ m.Name,
		                    value: m.MRN
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	$("#cmb_mrn").val(ui.item.value);
		    	//$("#patName").val(ui.item.label);
		    	Doctor.init_patient(ui.item.value);
		    	return false;
		    }
		});
	
		$("#patName").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_patient", {
		            term: request.term,
		            typ: 'Name'
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.patient, function(m) {
		                return {
		                    label: m.Newic+' | '+m.Name,
		                    value: m.Newic
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	$("#cmb_mrn").val(ui.item.value);
		    	$("#patName3").val(ui.item.label);
		    	Doctor.init_patient(ui.item.value);
		    	return false;
		    }
		});

		$("#patIc").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_patient", {
		            term: request.term,
		            typ: 'Newic'
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.patient, function(m) {
		                return {
		                    label: m.Newic+' | '+m.Name,
		                    value: m.Newic
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	//$("#cmb_mrn").val(ui.item.value);
		    	$("#patIc").val(ui.item.label);
		    	Doctor.init_patient(ui.item.value);
		    	return false;
		    }
		});

		$("#cmb_doctor").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_doctor", {
		            term: request.term
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.doctor, function(m) {
		                return {
		                    label: m.description,
		                    value: m.resourcecode
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	$("#cmb_doctor").val(ui.item.label);
		    	$("#docid").val(ui.item.value);
		    	Doctor.init_doctor(ui.item.value);
		    	$('#calendar').fullCalendar('changeView', 'month');
		    	
		    	return false;
		    }
		});

		$("#cmb_doctor-3").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_doctor", {
		            term: request.term
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.doctor, function(m) {
		                return {
		                    label: m.description,
		                    value: m.resourcecode
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	$("#cmb_doctor").val(ui.item.label);
		    	$("#docid").val(ui.item.value);
		    	$("#schDateTime-3").val('');
		    	Doctor.init_doctor(ui.item.value);
		    	return false;
		    }
		});

		$("#cmbdoctorTo").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_all_doctor", {
		            term: request.term
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.doctor, function(m) {
		                return {
		                    label: m.description,
		                    value: m.resourcecode
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	$("#cmbdoctorTo").val(ui.item.label);
		    	$("#docidTo").val(ui.item.value);
		    	Doctor.init_appt_lst('sbTwo',ui.item.value);
		    	return false;
		    }
		});

		$("#patCase").autocomplete({
			source: function(request, response) {
		        $.getJSON("/_research/webms/assets/php/entry_appt.php?action=get_casetype", {
		            id: request.term
		        }, function(data) {
		            var array = data.error ? [] : $.map(data.casetype, function(m) {
		                return {
		                    label: m.description,
		                    value: m.case_code
		                };
		            });
		            response(array);
		        });
		    },
		    select: function (event, ui) {
		    	console.log(ui.item);
		    	return false;
		    }
		});

	});


$(document).ready(function () {
	$(function() {
		$("#dialog-form").dialog({
			autoOpen: false,
			maxWidth:600,
			maxHeight: 500,
			width: 600,
			height: 500,
			modal: true,
			buttons: {
				"Create": function() {
					//$(this).dialog("close");
					console.log('save data');
					$('form#frmAppt').submit();
				},
				Cancel: function() {
					$(this).dialog("close");
				}
		    },
			close: function() {}
		});
		
		$("#dialog-transfer").dialog({
			autoOpen: false,
			maxWidth:$(window).width(),
			maxHeight: $(window).height(),
			width: $(window).width(),
			height: $(window).height(),
			modal: true,
			buttons: {
				"Update": function() {
					GetAllId();},
				Close: function() {
					$(this).dialog("close");
				}
		    },
			close: function() {}
		});
		
		$("#dialog-doctor-info").dialog({
			autoOpen: false,
			maxWidth:600,
			maxHeight: 500,
			width: 600,
			height: 500,
			modal: true,
			buttons: {
				Close: function() {
					$(this).dialog("close");
				}
		    },
			close: function() {}
		});
	});

    $("#create-appt")
	    .button()
	    .click(function() {
	        if($('#docid').val() == ''){
	        	alert('please select doctor!');
	        	return;
	        }
        
	        document.getElementById("frmAppt").reset();
	        $("#formstatus").val('new');
	        $("#dialog-form").dialog("open");
 	        $('#cmb_doctor_3').val($('#cmb_doctor').val());
   	});

    $("#new-transfer")
	    .button()
	    .click(function() {
	    	console.log($('#docid').val());
	    
	        if($('#docid').val() == ''){
	        	alert('please select doctor!');
	        	return;
	        }
        
	        $("#dialog-transfer").dialog("open");                
	        $('#cmbdoctorFrom').val($('#cmb_doctor').val());
	        console.log('goto appt llst');
	        Doctor.init_appt_lst('sbOne',$('#docid').val());
	    });


        $(function () {
            function moveItems(origin, dest) {
                $(origin).find(':selected').appendTo(dest);
            }

            function moveAllItems(origin, dest) {
                $(origin).children().appendTo(dest);
            }

            $('#left').click(function () {
                moveItems('#sbTwo', '#sbOne');
            });

            $('#right').on('click', function () {
                moveItems('#sbOne', '#sbTwo');
            });

            $('#leftall').on('click', function () {
                moveAllItems('#sbTwo', '#sbOne');
            });

            $('#rightall').on('click', function () {
                moveAllItems('#sbOne', '#sbTwo');
            });
        });

});


var spacesToAdd = 5;
var biggestLength = 0;
$("#sbOne option").each(function(){
var len = $(this).text().length;
    if(len > biggestLength){
        biggestLength = len;
    }
});
var padLength = biggestLength + spacesToAdd;
$("#sbOne option").each(function(){
    var parts = $(this).text().split('+');
    var strLength = parts[0].length;
    for(var x=0; x<(padLength-strLength); x++){
        parts[0] = parts[0]+' '; 
    }
    $(this).text(parts[0].replace(/ /g, '\u00a0')+'+'+parts[1]).text;
});

</script>
</span>

</body>

</html>
