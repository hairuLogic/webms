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
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					emptyFormdata();
					if(oper!='view'){
					dialogHandler2('costcenter','depccode',['costcode','description'], 'Deposit Cost');
					dialogHandler2('glmasref','depglacc',['glaccount','description'], 'Deposit GL Account');
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
				url: 'depositTypeTbl.php',
				editurl: 'depositTypeSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'No', name: 'sysno', width: 20, sorttype: 'number', hidden:true  },
					{ label: 'Compcode', name: 'compcode', width: 40, hidden:true },
					{ label: 'Source', name: 'source', width: 50, hidden:true },
					{ label: 'Transaction Type', name: 'trantype', width:50, classes: 'wrap', canSearch: true, checked:true},
					{ label: 'Description', name: 'description', width: 70, classes: 'wrap', canSearch: true },
					{ label: 'Deposit Cost Code', name: 'depccode', width: 50,  classes: 'wrap' },
					{ label: 'Deposit GL Account', name: 'depglacc', width: 50, classes: 'wrap' },
					{ label: 'Update Payer Name', name: 'updpayername', width: 50,  classes: 'wrap' },
					{ label: 'Update Episode', name: 'updepisode', width: 50, classes: 'wrap' },
					{ label: 'Manual Alloc', name: 'manualalloc', width: 40, hidden:true},
					{  label: 'adduser', name: 'adduser', width: 40, hidden:true  },
					{ label: 'adddate', name: 'adddate', width: 40, hidden:true },
					{ label: 'upduser', name: 'upduser', width: 40, hidden:true },
					{ label: 'upddate', name: 'upddate', width: 40, hidden:true },
					{ label: 'recstatus', name: 'recstatus', width: 40, hidden:true }
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce:false,
				//loadonce: true,
				width: 900,
				height: 350,
				rowNum: 30,
				//rownumbers: true,
				
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
					$("#trantype").prop("readonly",true);
					
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
					//$("#trantype").prop("readonly",false);
				}, 
				position: "first", 
				title:"Add New Row", 
				cursor: "pointer"
			});
			
			function disableForm(formName){
				$('texarea').prop("readonly",true);
				$(formName+' input').prop("readonly",true);
				$(formName+' input[type=radio]').prop("disabled",true);
				//$(".ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable").hide();
				//$('.ui-dialog ui-widget ui-widget-content ui-corner-all ui-front ui-draggable ui-resizable').attr("disabled", true);				
				//$(formName+' a.input-group-addon btn btn-primary').hide("disabled",true);
				//$('.input-group-addon btn btn-primary.a').parent().find('.ion-more').hide();
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
						//$('.input-group-addon btn btn-primary').attr("disabled", true);	
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
						console.log(index +'-'+value);
					}
				});
			}
			
			function emptyFormdata(){
				$('#formdata').trigger('reset');
				$('.help-block').html('');
			}
			
			function saveFormdata(oper){
				$.post( "depositTypeSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
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
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'depositTypeTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
			////******************gridDialog2   
			var selText2,Dtable2,Dcols2;
			$("#gridDialog2").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 40, sorttype: 'number', checked:true}, 
					{ label: 'Description', name: 'description', width: 70},
				],
				width: 550,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPager2",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialog2").jqGrid ('getRowData', rowid);
					$("#gridDialog2").jqGrid("clearGridData", true);
					$( "#dialog2" ).dialog( "close" );
					$('#'+selText2).val(rowid);
					$('#'+selText2).focus();
					$('#'+selText2).parent().next().html(data['description']);
				},
				
			});
			
			function dialogHandler2(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText2=id,Dtable2=table,Dcols2=cols,
					$("#gridDialog2").jqGrid("clearGridData", true);
					$( "#dialog2" ).dialog( "open" );
					$( "#dialog2" ).dialog( "option", "title", title );
					$("#gridDialog2").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#Dtext2').val('');$('#Dcol2').html('');
					$.each(cols, function( index, value ) {
						if(value['checked'])	{
							$("#Dcol2").append( "<label class='radio-inline'><input type='radio' name='dcolr3' checked value='"+value+"' checked>"+value+"</input></label>" );
							//$("#Dcol2" ).append( "<label class='radio-inline'><input type='radio' name='dcolr3' value='"+value+"' >"+value+"</input></label>" );
						}
						else{
							$("#Dcol2").append( "<label class='radio-inline'><input type='radio' name='dcolr3' value='"+value+"' checked>"+value+"</input></label>" );
							//$("#Dcol2" ).append( "<label class='radio-inline'><input type='radio' name='dcolr3' checked value='"+value+"' >"+value+"</input></label>" );
						}
					});
				});
			}
			
			$('#Dtext2').keyup(function() {
				delay(function(){
					Dsearch2($('#Dtext2').val(),$('input:radio[name=dcolr3]:checked').val());
				}, 500 );
			});
			
			$('#Dcol2').change(function(){
				Dsearch2($('#Dtext2').val(),$('input:radio[name=dcolr3]:checked').val());
			});
			
			function Dsearch2(Dtext2,Dcol2){
				$("#gridDialog2").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable2+'&cols='+Dcols2+'&Dcol='+Dcol2+'&Dtext='+Dtext2}).trigger('reloadGrid');
			}
			 
			//////////////////////////////////////////////////////////////////
			
			//***********************menu
			$('#menu').metisMenu();
			
			
		});

 </script>