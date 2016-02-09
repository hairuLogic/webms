<script>
		$.jgrid.defaults.responsive = true;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		var editedRow=0;

		$(document).ready(function () {
			
			$( "#dialog" ).dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
			});
			
			$( "#dialog2" ).dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
			});
			
			$.validate({
				modules : 'date',
				language : {
					requiredFields: ''
				},
			});
			
			var butt1=[{
				text: "Save",click: function() {
					if( $('#formdata').isValid({requiredFields: ''}, {}, true) ) {
						saveFormdata(oper);
					}
				}
			},{
				text: "Cancel",click: function() {
					$(this).dialog('close');
				}
			}];
			
			var butt2=[{
				text: "Close",click: function() {
					$(this).dialog('close');
			}}]
			
			var oper;
			$("#dialogForm")
			  .dialog({ 
				width: 9/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					emptyFormdata();
					if(oper!='view'){
					dialogHandler('glmasref','glaccno',['glaccount','description'], 'Account');
					dialogHandler('costcenter','glccode',['costcode','description'], 'Cost Center');
					}
				},
				
				close: function( event, ui ) {
					$("#formdata a").off();
				},
				buttons : butt1,
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			   ////view///
			  
			   $("#editdialogForm")
			  .dialog({ 
				width: 900,
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					emptyFormdata2();
				},
				buttons :
					[{
						text: "Close",click: function() {
							$(this).dialog('close');
						}
					}]
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			  
			  $("#jqGrid").jqGrid({
				url: 'bankTbl.php',
				editurl: 'bankSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'compcode', name: 'compcode', width: 90,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Bankcode', name: 'bankcode', width: 90, classes: 'wrap' , canSearch: true, checked:true },
					
					{ label: 'Bankname', name: 'bankname', width: 90 , classes: 'wrap', canSearch: true },
					
					{ label: 'Address1', name: 'address1', width: 90, classes: 'wrap'  },
					
					{ label: 'address2', name: 'address2', width: 90 , classes: 'wrap' ,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'address3', name: 'address3', width: 90, classes: 'wrap' , hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'postcode:', name: 'postcode', width: 90, classes: 'wrap' , hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'State Code', name: 'statecode', width: 90, classes: 'wrap' ,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Country', name: 'country', width: 90 , classes: 'wrap' ,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Tel No', name: 'telno', width: 90 , classes: 'wrap' },
					
					{ label: 'Fax No', name: 'faxno', width: 90, classes: 'wrap' ,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Contact Person', name: 'contact', width: 90, hidden:true,},
					
					{ label: 'Bank Account No', name: 'bankaccount', classes: 'wrap' , width: 90,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Clearing Days', name: 'clearday', classes: 'wrap' , width: 90, hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Effect Date:', name: 'effectdate', classes: 'wrap' , width: 90,  hidden:true,  editable: true ,
					editrules: {edithidden: true , hidedlg: true}},
					
					{ label: 'Gl Account No', name: 'glaccno', classes: 'wrap' , width: 90, hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Glccode', name: 'glccode', classes: 'wrap' , width: 90, hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Petty Cash', name: 'pctype', width: 90,hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Last User', name: 'lastuser', width: 90, hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Last Update', name: 'lastupdate', width: 90,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{ label: 'Open Balance', name: 'openbal', width: 90,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
					{label: 'Record Status', name: 'recstatus', width: 90,  hidden:true,  editable: true ,
					editrules: { required: true, edithidden: true , hidedlg: true}},
					
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				width: 780,
				height: 350,
				rowNum: 30,
				pager: "#jqGridPager",
				onPaging: function(pgButton)
				{
				},
				gridComplete: function(){
					if(editedRow!=0){
						$("#jqGrid").jqGrid('setSelection',editedRow,false);
					}
				},
				
			});
			
			 			$("#jqGrid").jqGrid('navGrid','#jqGridPager',
				{	
					view:false,edit:false,add:false,del:true,search:false,
					beforeRefresh: function(){
						$("#jqGrid").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
					},
				},
				// options for the Edit Dialog
				{},
				// options for the Add Dialog
				{},
				// options for the Delete Dailog
				{	afterSubmit : function( data, postdata, oper){
						$("#jqGrid").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
						return [true,'',''];
					},
					errorTextFormat: function (data) {
						return 'Error: ' + data.responseText;
					}
			}).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-info-sign", 
				onClickButton: function(){
					oper='view';
					selRowId = $("#jqGrid").jqGrid ('getGridParam', 'selrow');
					populateFormdata(selRowId,'view');
				}, 
				position: "first", 
				title:"View Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-edit", 
				onClickButton: function(){
					oper='edit';
					selRowId = $("#jqGrid").jqGrid ('getGridParam', 'selrow');
					populateFormdata(selRowId,'edit');
					enableForm('#dialogForm');
					$("#bankcode").prop("readonly",true);
					
				}, 
				position: "first", 
				title:"Edit Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-plus", 
				onClickButton: function(){
					oper='add';
					$( "#dialogForm" ).dialog( "option", "buttons", butt1 );
					$( "#dialogForm" ).dialog( "option", "title", "Add" );
					$("#dialogForm").dialog( "open" );
					enableForm('#dialogForm');
					//$("#glaccount").prop("readonly",false);
				}, 
				position: "first", 
				title:"Add New Row", 
				cursor: "pointer"
			});
			
			function disableForm(formName){
				$('texarea').prop("readonly",true);
				$(formName+' input').prop("readonly",true);
				$(formName+' input[type=radio]').prop("disabled",true);
			}
			
			function enableForm(formName){
				$('textarea').prop("readonly",true);
				$(formName+' input').prop("readonly",false);
				$(formName+' input[type=radio]').prop("disabled",false);
			}
			
			function populateFormdata(selRowId,state){
				enableForm('#dialogForm');
				if(!selRowId){
					alert('Please select row');
					return emptyFormdata();
				}
				switch(state) {
					case state = 'edit':
						$( "#dialogForm" ).dialog( "option", "title", "Edit" );
						$( "#dialogForm" ).dialog( "option", "buttons", butt1 );
						break;
					case state = 'view':
						disableForm('#dialogForm');
						$( "#dialogForm" ).dialog( "option", "title", "View" );
						$( "#dialogForm" ).dialog( "option", "buttons", butt2 );
						break;
					default:
				}
				
				$("#dialogForm").dialog( "open" );
				rowData = $("#jqGrid").jqGrid ('getRowData', selRowId);
				$.each(rowData, function( index, value ) {
					var input=$("[name='"+index+"']");
					if(input.is("[type=radio]")){
						$("[name='"+index+"'][value='"+value+"']").prop('checked', true);
					}else{
						input.val(value);
					}
				});
			}
			
					
			
			
			function emptyFormdata(){
				$('#formdata').trigger('reset');
				$('.help-block').html('');
			}
			
			function saveFormdata(oper){
				$.post( "bankSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
				}).fail(function(data) {
					errorText(data.responseText);
				}).success(function(data){
					$('#dialogForm').dialog('close');
					editedRow = $("#jqGrid").jqGrid ('getGridParam', 'selrow');
					$("#jqGrid").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
				});
			}
			
			function errorText(text){
				$( "#formdata" ).prepend("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> "+text+"</div>");
			}
			
			var delay = (function(){
				var timer = 0;
				return function(callback, ms){
					clearTimeout (timer);
					timer = setTimeout(callback, ms);
				};
			})();
			
			populateSelect();
			function populateSelect(){
				$.each($("#jqGrid").jqGrid('getGridParam','colModel'), function( index, value ) {
					if(value['canSearch']){
						if(value['checked'])	{
						$("#Scol" ).append( "<label class='radio-inline'><input type='radio' name='dcolr' value='"+value['name']+"' checked>"+value['label']+"</input></label>" );
						}
						else	{
							$("#Scol" ).append( "<label class='radio-inline'><input type='radio' name='dcolr' value='"+value['name']+"'>"+value['label']+"</input></label>" );
						}
					}
				});
			}
			
			$('#Stext').keyup(function() {
				delay(function(){
					//search($('#Stext').val(),$('#Scol').val());
					search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
				}, 500 );
			});
			
			$('#Scol').change(function(){
				//search($('#Stext').val(),$('#Scol').val());
				search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'bankTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
			
			var selText,Dtable,Dcols;
			$("#gridDialog").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 50, canSearch: true, checked:true}, 
					{ label: 'Description', name: 'desc', width: 200,canSearch: true},
					
				],
				width: 6/10 * $(window).width(),
				//height: 180,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPager",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialog").jqGrid ('getRowData', rowid);
					$("#gridDialog").jqGrid("clearGridData", true);
					$( "#dialog" ).dialog( "close" );
					$('#description').val(data['description']);
					$('#'+selText).val(rowid);
					$('#'+selText).focus();
				},
				
			});
			
			function dialogHandler(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText=id,Dtable=table,Dcols=cols,
					$("#gridDialog").jqGrid("clearGridData", true);
					$( "#dialog" ).dialog( "open" );
					$( "#dialog" ).dialog( "option", "title", title );
					$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#Dtext').val('');$('#Dcol').html('');
					$.each(cols, function( index, value ) {
						if(value['checked'])	{
							$("#Dcol").append( "<label class='radio-inline'><input type='radio' name='dcolr2' checked value='"+value+"' checked>"+value+"</input></label>" );
						}
						else{
							$("#Dcol").append( "<label class='radio-inline'><input type='radio' name='dcolr2' value='"+value+"' checked>"+value+"</input></label>" );
						}
					});
				});
			}
			
			$('#Dtext').keyup(function() {
				delay(function(){
					Dsearch($('#Dtext').val(),$('input:radio[name=dcolr2]:checked').val());
				}, 500 );
			});
			
			$('#Dcol').change(function(){
				Dsearch($('#Dtext').val(),$('input:radio[name=dcolr2]:checked').val());
			});
			
			/*function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}*/
			

			
			 ///////////////////////////////////// view ///////////////////////
			  $("#editdialogForm")
			  .dialog({ 
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					$('button').focus();
					emptyFormdata2();
				},
				buttons :
					[{
						text: "Close",click: function() {
							$(this).dialog('close');
						}
					}]
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			  function populateFormdata2(selRowId){
					if(!selRowId){
						alert('Please select row');
						return emptyFormdata2();
					}
					$("#editdialogForm").dialog( "open" );
					rowData = $("#jqGrid").jqGrid ('getRowData', selRowId);
					$.each(rowData, function( index, value ) {
						var input=$("[name='"+index+"']");
						if(input.is("[type=radio]")){
							$("[name='"+index+"'][value='"+value+"']").prop('checked', true);
						}else{
							input.val(value);
						}
					});
				}
				
				function emptyFormdata2(){
					$('#formdata2').trigger('reset');
					$('.help-block').html('');
				}
				
				function errorText(text){
				$( "#formdata2" ).prepend("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> "+text+"</div>");
			}
			  
			//////////////////////////////////////////////////////////////////
			
			//***********************menu
			$('#menu').metisMenu();
			
			
		});

 </script>