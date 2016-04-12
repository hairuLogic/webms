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
	        	
	        	//console.log('remove cal');
	        //$('#calendar').fullCalendar( 'removeEventSource', events);
	        	//console.log('remove cal');
	        $('#calendar').fullCalendar( 'addEventSource', events);         
	        	//console.log('remove cal');
	        //$('#calendar').fullCalendar( 'refetchEvents' );
	        
	        //$('#schDateTime').val('');
	          			
	        //jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id=&start=&end=&typ=grid"}).trigger("reloadGrid")

	}
	
	function first_load(){
	
		var today=new Date();		
		
		$('#cmb_month').val(today.getMonth());
		$('#cmb_year').val(today.getFullYear());
	
		$('#cmb_doctor-2').val('');
		$('#cmb_doctor').val('');
		$('#docid').val('');
		
		var tempVar = "";
		var EventtempVar = "";
		var lastdateclick = '';
		
		$('#calendar').fullCalendar({
			header: {
				left: '',
				center: 'title',
				right: 'prev,next month,agendaWeek,today'
			},
			height: $(window).height()-200,
			editable: false,
			minTime: "07:00:00",
			maxTime: "20:00:00",
			slotDuration: "00:30:00",
			fixedWeekCount: false,
			eventLimit: true, // allow "more" link when too many events
			events: "",
			
			eventRender: function (event, element, view) {				
				if(tempVar!='')
					$(tempVar).css('background-color', 'white');
				
				if(view.name == 'month'){
					$("#divGrid").show();
					$('#calendar').fullCalendar('option', 'height', $(window).height()-300);
				}else{
				    element.qtip({
				        content: '<ul><li>'+event.mrn+'</li><li>'+event.title+'</li><li>'+ event.icnum +'</li><li>'+event.telhp+'</li><li>'+event.telno+'</li></ul>',
				        position:{
				            target: 'mouse'
				        },
				        /*show: { event: 'click' },*/
				        hide: { event: 'click mouseleave' },
				        style: { 
				            width: 200,
				            padding: 5,
				            color: 'black',
				            textAlign: 'left',
				            border: {
				                width: 1,
				                radius: 3
				            },
				            classes: 'custSideTip'
				        } 
				    });     

					$("#divGrid").hide();
					$('#calendar').fullCalendar('option', 'height', $(window).height());
				}
				
				element.css('font-size','15px');
			
				if(view.name == 'month' && event.color != 'red' && event.color != 'orange'){
					element.find('span.fc-title').html(element.find('span.fc-title').text());
				    element.find(".fc-title").remove();
				    element.find(".fc-time").remove();

				    var new_description =   
				        '<br/><div style="margin-top:-15px">'+ event.test + '</div><br/>';
				    element.append(new_description);
					//element.css('background-color', '#0073ea');
					element.css('background-color', '#ffffff');
					element.css('border-color', '#ffffff');
					element.css('color', '#000000');
				}			
        
			},
			dayRender: function(date, cell){
				$('.qtip').remove();
								
				if (moment().diff(date,'days') < 0){
		            //cell.css("background-color","#FAFAFA");
		        }
		    },
		    dayClick: function(date, jsEvent, view) {
				
               lastdateclick = date.format();
                
		        var today=new Date();
		        
		        if(today.getHours() != 0 && today.getMinutes() != 0 && 
		           today.getSeconds() != 0 && today.getMilliseconds() != 0){
		            today.setHours(0,0,0,0);
		        }
		        
        		str_today = (today.getFullYear())+'-'+('0'+(today.getMonth() + 1)).slice(-2)+'-'+('0'+today.getDate()).slice(-2);

		        if(view.name != 'agendaDay'){
			      	jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id="+$('#docid').val()+"&start="+date.format()+"&end="+date.format()+"&typ=grid"}).trigger("reloadGrid")
			      	
			        if (tempVar == "")
			        {
						if(str_today == date.format()){
							$(this).css('background-color', '#fcf8e3');
			            	tempVar = '';
						}else{
				            $(this).css('background-color', '#B1C4BD');
			            	tempVar = this;
			            }		            
			        }
			        else
			        {
						if(str_today == date.format()){
							$(this).css('background-color', '#fcf8e3');
			            	$(tempVar).css('background-color', 'white');
			            	tempVar = '';
						}else{				
			            	$(this).css('background-color', '#B1C4BD');						
			            	$(tempVar).css('background-color', 'white');
			           		tempVar = this;
			            }
			        }
		        }
		        

				//code for dblclick
				prevTime = typeof currentTime === 'undefined' || currentTime === null
                    ? new Date().getTime() - 1000000
                    : currentTime;
                currentTime = new Date().getTime();

               if (currentTime - prevTime < 500 && (date.format() == lastdateclick))
                {
                    //double click call back
                    console.log("this is double click 1");
		            $('#calendar').fullCalendar('changeView', 'agendaDay');
		            $('#calendar').fullCalendar('gotoDate', date);
		            
					if(view.name == 'agendaDay'){
						console.log($('#formstatus').val());
						if($('#formstatus').val() != 'new'){
					    	$('#schDateTime').val(date.format());
					    	$("#create-appt").trigger( "click" );
					    }else{
					    	if(str_today > date.format()){
					    		alert('Appointment cannot be back dated!');
					    		return;
					    	}
					    	
					    	if(date.format().split('T').length < 2){
					    		alert('Error date format. Please try again!');
					    		return;
					    	}
					    		
					    	$('#schDateTime').val(date.format());
							$("#dialog-form").dialog("open");
					    }        	
					}
               }
                //end of code dblclick
                
	        },
		    eventClick: function(event, jsEvent, view) {
		    
				//code for dblclick
				prevTime = typeof currentTime === 'undefined' || currentTime === null
                    ? new Date().getTime() - 1000000
                    : currentTime;
                currentTime = new Date().getTime();

				if (currentTime - prevTime < 500)
				{
				    //double click call back
				    console.log("this is double click 2");
					if (event.color != 'red' && event.color != 'orange') {
					    if(view.name == 'month' && event.id != ''){
					        $('#calendar').fullCalendar('changeView', 'agendaDay');
					        $('#calendar').fullCalendar('gotoDate', event.start);
					    }else{
					    	if($('#formstatus').val() != 'new'){
					    		Doctor.init_appointment(event.id);
					    	}
					    	$('#schDateTime').val(event.start);
					        $("#dialog-form").dialog("open");
					    }
					}
				}
				
				if(EventtempVar == '' && view.name == 'month'){
					$(this).css('background-color', '#B1C4BD');
	            	$(EventtempVar).css('background-color', 'white');
	            	EventtempVar = this;
		      		
		      		jQuery("#gridDialog").jqGrid().setGridParam({url : "/_research/webms/assets/php/entry_appt.php?action=get_all_calendar&id=&start=&end=&typ=grid"}).trigger("reloadGrid")
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
	                $("#dialog-form").dialog("open");
	                //$('#cmb_doctor_3').val($('#cmb_doctor').val());
		        	//Doctor.init_appointment(event.id);
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
	        	
	        $('#calendar').fullCalendar( 'removeEventSource', events);
	        $('#calendar').fullCalendar( 'addEventSource', events);         
	        $('#calendar').fullCalendar( 'refetchEvents' );
	        
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
                $("#schDateTime").val(value.apptdate+'T'+value.appttime);
                $("#patStatus").val(value.apptstatus);
                $("#patIc").val(value.icnum);
                $("#patIc3").val(value.icnum);
                $("#patName3").val(value.Name);
                $("#cmb_mrn3").val(value.MRN);
                $("#patContact3").val(value.telh);
                $("#patHp3").val(value.telhp);
                $("#patFax3").val(value.telo);
                $("#docid").val(value.prov_id);
                $("#cmb_doctor").val(value.description);
                $("#cmb_doctor-2").val(value.description);
                $("#cmb_doctor").val(value.description);
               
                $("#patLastUpdate").val(value.lastupdate);
                $("#patUpdateBy").val(value.lastuser);

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

    function get_appt_lst(frm,docid)
    {
    	if(docid == '')
    		return;
    		
        $.getJSON( "/_research/webms/assets/php/entry_appt.php?action=get_appt_lst&docid="+docid, function(data)
        {
            //console.log(data.appt_lst);

            $.each(data.appt_lst, function (index, value) 
            {
            	if(frm == 'sbTwo'){
	                $("#"+frm).append('<option value="'+value.sysno+'" disabled="disabled">'+value.sysno+'|'+value.icnum+'</option>');
	            }else{
                	$("#"+frm).append('<option value="'+value.sysno+'">'+value.sysno+'|'+value.icnum+'</option>');
                }
            });
            
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
        { 
        	icnum:$("#patIc").val(),
        	apptdate:$("#schDateTime").val().split("T")[0],
        	appttime:$("#schDateTime").val().split("T")[1],
        	mrn:$("#cmb_mrn").val(),
        	pat_name:$("#patName").val(),
        	remarks:$("#cmb_mrn").val() 
        }, 
        function(data)
        {
            populate_all_calendar(data.appointment);
            
        });
	}
	
    function appt_cleanup(){
    	console.log('data cleanup');
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
        
        init_appt_lst: function (frm,docid) {
        	get_appt_lst(frm,docid);
        },

        init_load: function () {        
        	first_load();
        }
    };

}();

function FcGoToDate(){
	var monthNames = ["January", "February", "March", "April", "May", "June",
	  "July", "August", "September", "October", "November", "December"
	];
	
	cmbdt = new Date('01 '+monthNames[$('#cmb_month').val()]+' '+$('#cmb_year').val());

	$('#calendar').fullCalendar( 'gotoDate', cmbdt );
	$('#calendar').fullCalendar('changeView', 'month');

}

function selCalendar(){
	$("#dialog-form").dialog("close");
	
}