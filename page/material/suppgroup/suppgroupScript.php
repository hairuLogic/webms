<script>
		$.jgrid.defaults.responsive = true;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		var editedRow=0;

		$(document).ready(function () {
		
			/*$("#effectdate").datepicker({
				dateFormat: 'dd-mm-yy',
			});*/
			
			$( "#dialog" ).dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
			});
			
			$.validate({
				/*modules : 'date',
				language : {
					requiredFields: ''
				},*/
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
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					emptyFormdata();
					if(oper!='view'){
					dialogHandler('costcenter','costcode',['costcode','description'], 'Cost Code');
					dialogHandler('glmasref','glaccno',['glaccount','description'], 'Gl Account No');
					dialogHandler('costcenter','advccode',['costcode','description'], 'Advance Cost Code');
					dialogHandler('glmasref','advglaccno',['glaccount','description'], 'Advance Account No');
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
			
			
			$("#jqGrid").jqGrid({
				url: 'suppgroupTbl.php',
				editurl: 'suppgroupSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'sysno', name: 'sysno', width: 30,hidden:true },
					{ label: 'Comp Code', name: 'compcode', hidden:true},
					{ label: 'Supplier Group', name: 'suppgroup', width: 50, sorttype: 'text', classes: 'wrap', canSearch: true, checked:true},
					{ label: 'Description', name: 'description', width: 100, sorttype: 'text', classes: 'wrap', canSearch: true},
					{ label: 'Cost Code', name: 'costcode', width: 60, sorttype: 'number', classes: 'wrap'},
					{ label: 'Gl Account No', name: 'glaccno', width: 60, sorttype: 'number', classes: 'wrap'},
					{ label: 'Add User', name: 'adduser', width: 30,hidden:true },
					{ label: 'Add Date', name: 'adddate', width: 90,hidden:true},
					{ label: 'Upd User', name: 'upduser', width: 80,hidden:true}, 
					{ label: 'Upd Date', name: 'upddate', width: 90,hidden:true},
					{ label: 'Del User', name: 'deluser', width: 80,hidden:true},
					{ label: 'Del Date', name: 'deldate', width: 90,hidden:true},
					{ label: 'Advance Cost Code', name: 'advccode', width: 80, sorttype: 'number', editable: true, classes: 'wrap'},
					{ label: 'Advance Account No', name: 'advglaccno', width: 80, sorttype: 'number', classes: 'wrap'},
					{ label: 'Record Status', name: 'recstatus', width: 80, hidden:true}, 
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				width: 900,
				height: 350,
				rowNum: 30,
				pager: "#jqGridPager",
				onPaging: function(pgButton){
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
					$("#suppgroup").prop("readonly",true);
					
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
				$.post( "suppgroupSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
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
			
			var selText,Dtable,Dcols;
			$("#gridDialog").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'trantype', width: 40, sorttype: 'number', classes: 'pointer', checked:true}, 
					{ label: 'Description', name: 'description', width: 70, sorttype: 'text', classes: 'pointer'},
				],
				width: 550,
				height: 180,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPager",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialog").jqGrid ('getRowData', rowid);
					$("#gridDialog").jqGrid("clearGridData", true);
					$( "#dialog" ).dialog( "close" );
					$('#'+selText).val(rowid);
					$('#'+selText).focus();
					$('#'+selText).parent().next().html(data['description']);
				},
				
			});
			
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
					search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
					//search($('#Stext').val(),$('#Scol').val());
				}, 500 );
			});
			
			$('#Scol').change(function(){
				search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
				//search($('#Stext').val(),$('#Scol').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'suppgroupTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
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
					//Dsearch($('#Dtext').val(),$('#Dcol').val());
					Dsearch($('#Dtext').val(),$('input:radio[name=dcolr2]:checked').val());
				}, 500 );
			});
			
			$('#Dcol').change(function(){
				//Dsearch($('#Dtext').val(),$('#Dcol').val());
				Dsearch($('#Dtext').val(),$('input:radio [name=dcolr2]:checked').val());
			});
			
			function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			 ///////////////////////////////////// view ///////////////////////
			  $("#editdialogForm")
			  .dialog({ 
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
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
			//////////////////////////////////////////////////////////////////
			
			//***********************menu
			$('#menu').metisMenu();
			
		});

 </script>