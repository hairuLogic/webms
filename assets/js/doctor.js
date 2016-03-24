/* Write here your custom javascript codes */
var Doctor = function () {

	function first_load_1(){
	        var events = {
	            url: "/_research/webms/assets/php/entry_appt.php",
	            type: 'GET',
	            data: {
	            	action: "get_all_calendar",
	            	typ: '',
	                id: ''
	            }
	        };
	        	
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'removeEventSource', events);
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'addEventSource', events);         
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'refetchEvents' );
	        
	        //$('#schDateTime').val('');
	          			
	        jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id=&start=&end=&typ=grid"}).trigger("reloadGrid")

	}
	
	function first_load(){
		$('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title',
				right: 'prev,next month,agendaWeek,today'
			},
			height: $(window).height()-300,
			editable: false,
			minTime: "08:00:00",
			maxTime: "20:00:00",
			slotDuration: "00:30:00",
			eventLimit: true, // allow "more" link when too many events
			events: "",
			eventRender: function (event, element) {
			    //element.find('span.fc-title').html(element.find('span.fc-title').text());
			    
    element.find(".fc-event-title").remove();
    element.find(".fc-event-time").remove();
    var new_description =   
        moment(event.start).format("HH:mm") + '-'
        + moment(event.end).format("HH:mm") + '<br/>'
        + 'cuctomer' + '<br/>'
        + '<strong>Address: </strong><br/>' + 'cust address' + '<br/>'
        + '<strong>Task: </strong><br/>' + 'cust 123' + '<br/>'
        + '<strong>Place: </strong>' + 'xust vbnm' + '<br/>'
    ;
    element.append(new_description);

			    
			},
			dayClick: function(date, jsEvent, view) {
		        if(view.name == 'agendaDay'){
		        	$('#schDateTime_3').val(date.format());
		        	//$("#dialog-form").dialog("open");
		        	$("#create-appt").trigger( "click" );
		        	
		        }else{
					$('#calendar').fullCalendar('changeView', 'agendaDay');
					$('#calendar').fullCalendar('gotoDate', date);
				}
	        },
		    eventClick: function(event) {
		        if (event.color == 'red') {
		            return false;
		        }
		        		        
		        if (event.id != '') {
		        	$("#create-appt").trigger( "click" );
		        	Doctor.init_appointment(event.id);
		        }
		    }
		});


		jQuery("#gridDialog").jqGrid({ 
			url:"/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id=&start=&end=&typ=grid", 
			//data: data.appointment,
			datatype: "json", 
			colNames:['ID','MRN','DateTime','Status','Doctor','Patient Name','Patient IC'], 
			colModel:[ {name:'id',index:'id'}, {name:'mrn',index:'mrn'}, {name:'start',index:'start'}, {name:'title',index:'title'}, {name:'doctor',index:'doctor'},{name:'name',index:'name'},{name:'noic',index:'noic'}, ], 
			rowNum:10, 
			rowList:[10,20,30], 
			pager: '#gridDialogPager', 
			toppager: true,
			sortname: 'id', 
			viewrecords: true, 
			sortorder: "desc",
			width: null,
			height: $(window).height()-45,
			shrinkToFit: false ,
			ondblClickRow: function(rowId) {
		        var rowData = jQuery(this).getRowData(rowId); 
		        var jobNumber = rowData['id'];
		        //console.log(jobNumber);
		        //document.location.href = "./jobflow?token=view&" + jobNumber ;
		        //populate_appt_dtl(rowData['id']);
		        Doctor.init_appointment(rowData['id']);
		        $('.nav-tabs li:eq(0) a').tab('show'); 
		    }
		});


		jQuery("#gridDialog").jqGrid('navGrid','#gridDialogPager',{edit:false,add:false,del:false});
		
		first_load_1();

	}
    
    function populate_all_calendar(cal_data)
    {

		$('#calendar').fullCalendar({
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek'
			},
			//defaultDate: '2016-01-12',
			height: $(window).height()-50,
			editable: false,
			minTime: "08:00:00",
			maxTime: "20:00:00",
			slotDuration: "00:30:00",
			eventLimit: true, // allow "more" link when too many events
			events: cal_data,
			dayClick: function(date, jsEvent, view) {
				//$( "#dialog1" ).dialog( "open" );
		        //alert('Clicked on: ' + date.format());
		        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
		        //alert('Current view: ' + view.name);
		        // change the day's background color just for fun
		        //$(this).css('background-color', 'red');
		        //if(view.name != 'month') {
		        //}else 
		        if(view.name == 'agendaDay'){
		        	$('#schDateTime').val(date.format());
		        }else{
		        	//$( "#dialog1" ).dialog( "open" );
					$('#calendar').fullCalendar('changeView', 'agendaWeek');
					$('#calendar').fullCalendar('gotoDate', date);
				}
	        },
		    eventClick: function(event) {
		        if (event.color == 'red') {
		            return false;
		        }
		        		        
		        if (event.id != '') {
		        	Doctor.init_appointment(event.id);
		        }
		    }
		});

		//grid sample
		jQuery("#gridDialog").jqGrid({ 
			url:"/_research/webms/assets/php/entry_appt.php?action=get_all_calendar", 
			datatype: "json", 
			colNames:['MRN','DateTime','Status','Doctor','Patient Name','Patient IC'], 
			colModel:[ {name:'mrn',index:'mrn'}, {name:'start',index:'start'}, {name:'title',index:'title'}, {name:'doctor',index:'doctor'},{name:'name',index:'name'},{name:'noic',index:'noic'}, ], 
			rowNum:10, 
			rowList:[10,20,30], 
			pager: '#gridDialogPager', 
			sortname: 'id', 
			viewrecords: true, 
			sortorder: "desc",
			width: null,
			height: $(window).height()-45,
			shrinkToFit: false ,
			ondblClickRow: function(rowId) {
		        var rowData = jQuery(this).getRowData(rowId); 
		        var jobNumber = rowData['id'];
		        //console.log(jobNumber);
		        //document.location.href = "./jobflow?token=view&" + jobNumber ;
		        populate_appt_dtl(rowData['id']);
		        $('.nav-tabs li:eq(0) a').tab('show'); 
		    }
		}); 

		jQuery("#gridDialog").jqGrid('navGrid','#gridDialogPager',{edit:false,add:false,del:false});

		//form window
    }
    
    function populate_all_doctor(doc_id)
    {
	        var events = {
	            url: "/_research/webms/assets/php/entry_appt.php",
	            type: 'GET',
	            data: {
	            	action: "get_all_calendar",
	            	typ: 'doctor',
	                id: doc_id
	            }
	        };
	        	
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'removeEventSource', events);
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'addEventSource', events);         
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'refetchEvents' );
	        
	        //$('#schDateTime').val('');
	          			
	        jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id="+doc_id+"&start=&end=&typ=grid"}).trigger("reloadGrid")

    }

    function populate_all_patient(pat_id)
    {
	        var events = {
	            url: "/_research/webms/assets/php/entry_appt.php",
	            type: 'GET',
	            data: {
	            	action: "get_all_calendar",
	            	typ: 'patient',
	                id: pat_id
	            }
	        };
	        	
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'removeEventSource', events);
	        	console.log('remove cal');
	        $('#calendar').fullCalendar( 'addEventSource', events);         
	        $('#calendar').fullCalendar( 'refetchEvents' );
	        	console.log('remove cal');
	        
	        //$('#schDateTime').val('');
	          			
	        jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id="+pat_id+"&start=&end=&typ=gridpatient"}).trigger("reloadGrid")

    }


    function populate_patient_dtl(pat_id)
    {
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=get_patient_dtl&patid="+pat_id, function(data)
        {
            //console.log(data);

            $.each(data.patient, function (index, value) 
            {
                $("#cmb_mrn").val(value.MRN);
                $("#patIc").val(value.Newic);
                $("#patName").val(value.Name);
                //$("#patAddr").val(value.Address1);
                $("#patContact").val(value.telh);
                $("#patHp").val(value.telhp);
                $("#patFax").val(value.telo);


                $("#cmb_mrn-3").val(value.MRN);
                $("#patIc-3").val(value.Newic);
                $("#patName-3").val(value.Name);
                //$("#patAddr").val(value.Address1);
                $("#patContact-3").val(value.telh);
                $("#patHp-3").val(value.telhp);
                $("#patFax-3").val(value.telo);
            });
            
	    	jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&typ=patient&id="+$("#patIc").val()}).trigger("reloadGrid")
        });
        
    }

    function populate_appt_dtl(appt_id)
    {
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=get_appt_dtl&apptid="+appt_id, function(data)
        {
            $.each(data.appt, function (index, value) 
            {
                //$('.selPat option[value="N106228"]');
                //$('#cmb_patient option[value="'+value.mrn+'"]').attr("selected", "selected");
                $("#schDateTime_3").val(value.apptdate+'T'+value.appttime);
                $("#patStatus").val(value.apptstatus);
                $("#patIc").val(value.icnum);
                $("#patIc-3").val(value.icnum);
                $("#patName-3").val(value.Name);
                $("#cmb_mrn-3").val(value.MRN);
                $("#patContact-3").val(value.telh);
                $("#patHp-3").val(value.telhp);
                $("#patFax-3").val(value.telo);
                $("#docid").val(value.prov_id);
                $("#cmb_doctor").val(value.description);
                $("#cmb_doctor-2").val(value.description);
               
                $("#txt_doc").html(value.description);
                $("#txt_appt").html(value.apptdate+'T'+value.appttime);
                $("#txt_name").html(value.Name);
                $("#txt_ic").html(value.icnum);
                $("#txt_mrn").html(value.MRN);
                $("#txt_tel").html(value.telh);
                $("#txt_hp").html(value.telhp);

                $("#create-new").html('Update');
                //$("#btn-cancel").show();
            });
            
            //$('.nav-tabs li:eq(1) a').tab('show');
            
            //populate_all_doctor($("#docid").val());
            
	    	//jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&typ=patient&id="+$("#patIc").val()}).trigger("reloadGrid")
        });

    }

    function get_all_calendar(doc_id)
    {
    	if(doc_id == '')
    		return;
    		
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&docid="+doc_id, function(data)
        {
            //console.log(data.appointment);
            populate_all_calendar(data.appointment);

/*            $.each(data.appointment, function (index, value) 
            {
                $("#cmb_doctor").append('<option value="'+value.compcode+'">'+value.name+'</option>');
            });
*/            
        });
    }
    
   
    function save_appt_dtl(){
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=save_appt_dtl",
        { icnum:$("#patIc").val(),apptdate:$("#schDateTime").val().split("T")[0],appttime:$("#schDateTime").val().split("T")[1],mrn:$("#cmb_mrn").val(),pat_name:$("#patName").val(),remarks:$("#cmb_mrn").val() }, 
        function(data)
        {
            populate_all_calendar(data.appointment);
            
        });
	}
	
    function appt_cleanup(){
    	console.log('adf');
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=appt_cleanup",
        function(data)
        {
            console.log('done cleanup');
            populate_all_calendar('');
        });
	}
	
	
    return {

        init_calendar: function (doc_id) {
        	//_cleanup();
        	populate_all_calendar('');
        },
        
        init_doctor: function (doc_id) {
            populate_all_doctor(doc_id);
        //    populate_all_patient();
        },
        
        init_patient: function (pat_id) {
        	populate_all_patient(pat_id);
        	//populate_patient_dtl(pat_id);
        },
        
        init_patient_dtl: function (pat_id){
        
        	populate_patient_dtl(pat_id);
        },
        
        init_appointment: function (appt_id) {
        	populate_appt_dtl(appt_id);
        },

        init_save: function () {
        	save_appt_dtl();
        },
        
        init_load: function () {        
        	first_load();
        }
    };

}();

function FcGoToDate(){
	cmbdt = new Date($('#cmb_day').val()+' '+$('#cmb_month').val()+' '+$('#cmb_year').val());
	$('#calendar').fullCalendar( 'gotoDate', cmbdt );
}