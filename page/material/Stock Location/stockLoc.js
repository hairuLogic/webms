
		$.jgrid.defaults.responsive = true;
		$.jgrid.defaults.styleUI = 'Bootstrap';

		$(document).ready(function () {
			
			$( "#dialog" ).dialog({
				autoOpen: false,
				width: 600,
				height: 410
			});
			
			$.validate({
				modules : 'date',
				language : {
					requiredFields: ''
				},
			});
			
			dialogHandler('material.product','itemcode',['itemcode','description'],'Item');
			
			var oper;
			$("#dialogForm")
			  .dialog({ 
				width: 900,
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					$('button').focus();
					emptyFormdata();
					dialogHandler('sysdb.department','deptcode',['deptcode','description'],'Department');
					dialogHandler('material.uom','uomcode',['uomcode','description'],'UOM');
					
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
				"maximizable" : true,
				"minimizable" : true,
				"collapsable" : true,
				"dblclick" : "maximize",
			  });
			
			
			$("#jqGrid").jqGrid({
				url: 'stockLocTbl.php',
				editurl: 'stockLocSave.php',
				datatype: "json",
				 colModel: [
				 
					{label: 'compcode', name: 'compcode', width: 10 , hidden: true},
					
					{label: 'Department Code', name: 'deptcode', width: 100, classes: 'wrap', editable: true,
					editrules:{ required: true}}, 
					
					{label: 'Item Code', name: 'itemcode', width: 90 , classes: 'wrap', hidden: true, editable: true},
					
					{label: 'UOM Code', name: 'uomcode', width: 90 , classes: 'wrap', editable: true,
					editrules:{ required: true}}, 
					
					{label: 'Bin Code', name: 'bincode', width: 50 , classes: 'wrap', hidden: true, editable: true ,
					editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'Rack No', name: 'rackno', width: 50 , classes: 'wrap', hidden: true, editable: true ,
					editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'year', name: 'year', width: 90 , hidden: true, editable: true},
					
					{label: 'openbalqty', name: 'openbalqty', width: 90 , hidden: true, editable: true},
					
					{label: 'openbalval', name: 'openbalval', width: 90 , hidden: true, editable: true},
					
					{label: 'netmvqty1', name: 'netmvqty1', width: 90 , hidden: true, editable: true},
					
					{label: 'netmvval1', name: 'netmvval1', width: 90 , hidden: true, editable: true},
					
					{label: 'Tran Type', name: 'stocktxntype', width: 50 , classes: 'wrap', editable: true ,
					editrules:{ required: true}},
						
					{label: 'Disp Type', name: 'disptype', width: 50 , classes: 'wrap', editable: true ,
					editrules:{ required: true}}, 
					
					{label: 'qtyonhand', name: 'qtyonhand', width: 90 , hidden: true, editable: true},
					
					{label: 'Min Stock Qty', name: 'minqty', width: 60 , classes: 'wrap', editable: true ,
					editrules:{ required: true}},
									
					{label: 'Max Stock Qty', name: 'maxqty', width: 60 , classes: 'wrap', editable: true ,
					editrules:{ required: true}},
					
					{label: 'Reorder Level', name: 'reordlevel', width: 60 , classes: 'wrap', editable: true ,
					editrules:{ required: true}},
					
					{label: 'Reorder Quantity', name: 'reordqty', width: 60 , classes: 'wrap', editable: true ,
					editrules:{ required: true}},     
					
					{label: 'lastissdate', name: 'lastissdate', width: 90 , hidden: true, editable: true},
					
					{label: 'frozen', name: 'frozen', width: 90 , hidden: true, editable: true},
					
					{label: 'adduser', name: 'adduser', width: 90 , hidden: true, editable: true},
					
					{label: 'adddate', name: 'adddate', width: 90 , hidden: true, editable: true},
					
					{label: 'upduser', name: 'upduser', width: 90 , hidden: true, editable: true},
					
					{label: 'upddate', name: 'upddate', width: 90 , hidden: true, editable: true},
					
					{label: 'cntdocno', name: 'cntdocno', width: 90 , hidden: true, editable: true},
					
					{label: 'fix_uom', name: 'fix_uom', width: 90 , hidden: true, editable: true},
					
					{label: 'locavgcs', name: 'locavgcs', width: 90 , hidden: true, editable: true},
					
					{label: 'lstfrzdt', name: 'lstfrzdt', width: 90 , hidden: true, editable: true},
					
					{label: 'lstfrztm', name: 'lstfrztm', width: 90 , hidden: true, editable: true},
					
					{label: 'frzqty', name: 'frzqty', width: 90 , hidden: true, editable: true},
					
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
				
			});
			
			$("#jqGrid").jqGrid('navGrid','#jqGridPager',
				{	
					edit:false,view:true,add:false,del:true,search:false,
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
				}
			).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-edit", 
				onClickButton: function(){
					oper='edit';
					selRowId = $("#jqGrid").jqGrid ('getGridParam', 'selrow');
					populateFormdata(selRowId);
				}, 
				position: "first", 
				title:"Edit Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-plus", 
				onClickButton: function(){
					oper='add';
					if( $('#itemcode').val() != '') {
						$("#dialogForm").dialog( "open" );
					}
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
				var itemcode = $("#itemcode").val();
				$.post( "stockLocSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper, 'itemcode': itemcode }) , function( data ) {
					
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
			
			var selText,Dtable,Dcols;
			$("#gridDialog").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 50, classes: 'pointer'}, 
					{ label: 'Description', name: 'description', width: 200, classes: 'pointer'},
					//{ label: '', name: '', width: 200, classes: 'pointer', hidden:true},
		
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
					$( "#dialog" ).dialog( "close" );
					if(Dtable=='material.product'){
						$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'stockLocTbl.php?itemcode='+rowid}).trigger('reloadGrid');			
					}
					//$('#description').val(data['description']);
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
					if(!value['hidden']){
						$("#Scol" ).append( "<option value='"+value['name']+"' >"+value['label']+"</option>" );
					}
				});
			}
			
			$('#Stext').keyup(function() {
				delay(function(){
					search($('#Stext').val(),$('#Scol').val());
				}, 500 );
			});
			
			$('#Scol').change(function(){
				search($('#Stext').val(),$('#Scol').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'stockLocTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
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
				Dsearch($('#Dtext').val(),$('input:radio[name=dcolr]:checked').val());
			});
			
			function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			$( "input:radio" ).click(function() {
				if($(this).attr('value')=='Transfer'){
					$("input:radio[value='TR Item']").prop('checked', true);
				}
			    if($(this).attr('value')=='Issue'){
					$("input:radio[value='IS Item']").prop('checked', true);
				}
			});
			
		});
	