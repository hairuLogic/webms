<script>
	$.jgrid.defaults.responsive = true;
	$.jgrid.defaults.styleUI = 'Bootstrap';


	$(document).ready(function () {
		
		$( "#dialog" ).dialog({
				autoOpen: false,
				//width: 600,
				width: 7/10 * $(window).width(),
				modal: true,
		});
		
		var oper;
			$("#dialogForm")
			  .dialog({ 
				width: 6/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					$('button').focus();
					emptyFormdata();
				},
				buttons :
					[{
						text: "Save",click: function() {
							if( $('#formdata').isValid({requiredFields: ''}, {}, true) ) {
								saveFormdata(oper);
							}
						}
					},{
						text: "Cancel",click: function() {
							$(this).dialog('close');
						}
					}]
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			  $("#jqGrid").jqGrid({
				url: 'costcenterTbl.php',
				editurl: 'costcenterSave.php',///////////////////////////
				datatype: "json",
				 colModel: [
					{ label: 'No', name: 'sysno', width: 5, sorttype: 'number', hidden:true},
					{ label: 'compcode', name: 'compcode', width: 40, hidden:true},						
					{ label: 'Cost Code', name: 'costcode', width: 20, classes: 'wrap', canSearch: true},
					{ label: 'Description', name: 'description', width: 80, classes: 'wrap', canSearch: true},
					{ label: 'adduser', name: 'adduser', width: 80, hidden:true},
					{ label: 'adddate', name: 'adddate', width: 90, hidden:true},
					{ label: 'upduser', name: 'upduser', width: 30, hidden:true},
					{ label: 'upddate', name: 'upddate', width: 10, hidden:true},
					{ label: 'deluser', name: 'deluser', width: 80,hidden:true},
					{ label: 'deldate', name: 'deldate', width: 90,hidden:true},
					{ label: 'recstatus', name: 'recstatus', width: 80,hidden:true},
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				//rownumbers: true,
				width: 900,
				height: 350,
				rowNum: 30,
				pager: "#jqGridPager",
				onPaging: function(pgButton){
				},
				gridComplete: function(){
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
					populateFormdata2(selRowId);
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
					populateFormdata(selRowId);
					$("#costcode").prop("readonly",true);
					
				}, 
				position: "first", 
				title:"Edit Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-plus", 
				onClickButton: function(){
					oper='add';
					$("#dialogForm").dialog( "open" );
					$("#costcode").prop("readonly",false);
				}, 
				position: "first", 
				title:"Add New Row", 
				cursor: "pointer"
			});
			
			function populateFormdata(selRowId){
				if(!selRowId){
					alert('Please select row');
					return emptyFormdata();
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
				$.post( "costcenterSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
				}).fail(function(data) {
					errorText(data.responseText);
				}).success(function(data){
					$('#dialogForm').dialog('close');
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
						$("#Scol" ).append( "<label class='radio-inline'><input type='radio' name='dcolr' value='"+value['name']+"' >"+value['label']+"</input></label>" );
					}
				});
			}
			
			$('#Stext').keyup(function() {
				delay(function(){
					search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
				}, 500 );
			});
			
			$('#Scol').change(function(){
				search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'costcenterTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
			var selText,Dtable,Dcols;
			$("#gridDialog").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 50}, 
					{ label: 'Description', name: 'description', width: 200},
				],
				width: 550,
				//height: 180,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPager",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialog").jqGrid ('getRowData', rowid);
					$( "#dialog" ).dialog( "close" );
					$('#'+selText).val(rowid);
					$('#'+selText).focus();
					$('#'+selText).parent().next().html(data['description']);
				},
				
			});
			
			///////////////////////////////////// view ///////////////////////
			  $("#editdialogForm")
			  .dialog({ 
				width: 6/10 * $(window).width(),
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
			  
			//////////////////////////////////////////////////////////////////
			
			function dialogHandler(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText=id,Dtable=table,Dcols=cols,
					$( "#dialog" ).dialog( "open" );
					$( "#dialog" ).dialog( "option", "title", title );
					
					$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#Dtext').val('');$('#Dcol').html('');
					$.each(cols, function( index, value ) {
						$("#Dcol" ).append( "<label class='radio-inline'><input type='radio' name='dcolr' value='"+value+"' >"+value+"</input></label>" );
					});
				});
			}
			
			$('#Dtext').keyup(function() {
				delay(function(){
					Dsearch($('#Dtext').val(),$('input:radio[name=dcolr]:checked').val());
				}, 500 );
			});
			
			$('#Dcol').change(function(){
				Dsearch($('#Dtext').val(),$('input:radio [name=dcolr]:checked').val());
			});
			
			function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			
			$('#menu').metisMenu();
	});
</script>