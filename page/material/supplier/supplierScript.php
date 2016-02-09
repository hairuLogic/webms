<script>
		$.jgrid.defaults.responsive = true;
		$.jgrid.defaults.styleUI = 'Bootstrap';
		var editedRow=0, editedRowItem=0, editedRowBonus=0;
		
		var suppCode, itemCode;

		$(document).ready(function () {
		
			/*$("#expirydate").datepicker({
				dateFormat: 'dd-mm-yy',
			});*/
			
			$("#dialog").dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
			});
			
			$("#dialogItem").dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
			});
			
			$("#dialogBonus").dialog({
				autoOpen: false,
				width: 7/10 * $(window).width(),
				modal: true,
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
			
			$.validate({
				/*modules : 'date',
				language : {
					requiredFields: ''
				}*/
			});
				
			var oper;
			$("#dialogForm")
			  .dialog({ 
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
					if(oper!='view'){
					emptyFormdata();
					dialogHandler('material.suppgroup','SuppGroup',['suppgroup','description'], 'Supplier Group');
					dialogHandler('finance.costcenter','CostCode',['costcode','description'], 'Cost Code');
					dialogHandler('finance.glmasref','GlAccNo',['glaccount','description'], 'Gl Account No');
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
				url: 'supplierTbl.php',
				editurl: 'supplierSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'Comp Code', name: 'compcode', sorttype: 'number', hidden:true},
					{ label: 'Supplier Code', name: 'SuppCode', width: 40 , sorttype: 'text', classes: 'wrap', canSearch: true, checked:true
						//editable: true,  editoptions: {readonly: "readonly"}
					},						
					{ label: 'Supplier Group', name: 'SuppGroup', width: 40, editable: true, classes: 'wrap' },
					{ label: 'Supplier Name', name: 'Name', width: 80, editable: true, classes: 'wrap', canSearch: true },
					{ label: 'Cont Pers', name: 'ContPers', width: 90, hidden: true},
					{ label: 'Addr1', name: 'Addr1', width: 30, hidden: true}, 
					{ label: 'Addr2', name: 'Addr2', width: 90, hidden:true},
					{ label: 'Addr3', name: 'Addr3', width: 80,hidden:true},
					{ label: 'Addr4', name: 'Addr4', width: 90,hidden:true},
					{ label: 'Tel No', name: 'TelNo', width: 80,hidden:true},
					{ label: 'Fax No', name: 'Faxno', width: 90,hidden:true},
					{ label: 'Term Others', name: 'TermOthers', width: 40, editable: true, classes: 'wrap' }, 
					{ label: 'TermNonDisp', name: 'TermNonDisp', width: 50, editable: true, classes: 'wrap' },
					{ label: 'Term Disp', name: 'TermDisp', width: 40, editable: true, classes: 'wrap' },
					{ label: 'Cost Code', name: 'CostCode', width: 40, editable: true, classes: 'wrap' },
					{ label: 'Gl Account No', name: 'GlAccNo', width: 50, editable: true, classes: 'wrap' },
					{ label: 'OutAmt', name: 'OutAmt', width: 80, hidden: true},
					{ label: 'AccNo', name: 'AccNo', width: 80, hidden: true, editable: true},
					{ label: 'AddUser', name: 'AddUser', width: 80, hidden: true},
					{ label: 'AddDate', name: 'AddDate', width: 80, hidden: true},
					{ label: 'UpdUser', name: 'UpdUser', width: 80, hidden: true},
					{ label: 'UpdDate', name: 'UpdDate', width: 80, hidden: true},
					{ label: 'DelUser', name: 'DelUser', width: 80, hidden: true},
					{ label: 'DelDate', name: 'DelDate', width: 80, hidden: true},
					{ label: 'DepAmt', name: 'DepAmt', width: 80, hidden: true},
					{ label: 'MiscAmt', name: 'MiscAmt', width: 80, hidden: true},
					{ label: 'Supply Goods', name: 'SuppFlg', width: 80, editable: true, classes: 'wrap', hidden: true},
					{ label: 'Advccode', name: 'Advccode', width: 80, hidden: true, editable: true},
					{ label: 'AdvGlaccno', name: 'AdvGlaccno', width: 80, hidden: true, editable: true},
					{ label: 'recstatus', name: 'recstatus', width: 80, hidden: true,},
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				width: '100%',
				height: 100,
				rowNum: 30,


				pager: "#jqGridPager",
				onPaging: function(pgButton){
				},
				gridComplete: function(){
					if(editedRow!=0){
						$("#jqGrid").jqGrid('setSelection',editedRow,false);
					}
				},
				onSelectRow:function(rowid, selected)
				{
					suppCode=rowid;
					if(rowid != null) {
						$("#gridSuppitems").jqGrid().setGridParam({url :'suppitemsTbl.php?suppcode='+suppCode,datatype:'json'}).trigger("reloadGrid");
						$("#pg_jqGridPager2 table").show();
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
					$("#SuppCode").prop("readonly",true);
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
					//$("#SuppCode").prop("readonly",false);
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
				$.post( "supplierSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
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
					{ label: 'Code', name: 'code', width: 50, sorttype: 'text', classes: 'pointer', checked:true}, 
					{ label: 'Description', name: 'desc', width: 200, sorttype: 'text', classes: 'pointer'},
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
					$("#gridDialog").jqGrid("clearGridData", true);
					$( "#dialog" ).dialog( "close" );
					$('#'+selText).val(rowid);
					$('#'+selText).focus();
					$('#'+selText).parent().next().html(data['desc']);
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
					//search($('#Stext').val(),$('#Scol').val());
					search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
				}, 500 );
			});
			
			$('#Scol').change(function(){
				//search($('#Stext').val(),$('#Scol').val());
				search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'supplierTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
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
					Dsearch($('#Dtext').val(),$('input:radio[name=dcolr2]:checked').val());
				}, 500 );
			});
			
			$('#Dcol').change(function(){
				Dsearch($('#Dtext').val(),$('input:radio[name=dcolr2]:checked').val());
			});
			
			function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			/**************************************************************************************************************/
			 
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////// suppitems //////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			//var suppcode, itemcode;
			
			var buttItem1=[{
				text: "Save",click: function() {
					if( $('#formdataSupplierItem').isValid({requiredFields: ''}, {}, true) ) {
						saveFormdataItem(operItem);
					}
				}
			},{
				text: "Cancel",click: function() {
					$(this).dialog('close');
				}
			}];
			
			var buttItem2=[{
				text: "Close",click: function() {
					$(this).dialog('close');
			}}]
			
			$("#gridSuppitems").jqGrid({
				editurl: 'suppitemsSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'Supplier Code', name: 'suppcode', width: 30, hidden: true},
				 	{ label: 'no', name: 'lineno_', width: 50, hidden: true, sorttype: 'number'},
					//{ label: 'Price Code', name: 'pricecode', width: 50, editable: true},
				 	{ label: 'Item Code', name: 'itemcode', width: 40, sorttype: 'text', editable: true, classes: 'wrap'},
					{ label: 'Item Description', name: 'description', width: 90, sorttype: 'text', classes: 'wrap'},
					{ label: 'Price Code', name: 'pricecode', width: 30, sorttype: 'text', editable: true, classes: 'wrap'},
					{ label: 'Uom Code', name: 'uomcode', width: 30, sorttype: 'text', editable: true, classes: 'wrap'},
					{ label: 'Unit Price', name: 'unitprice', width: 30, sorttype: 'float', editable: true, classes: 'wrap'},
					{ label: 'Purchase Quantity', name: 'purqty', width: 40, sorttype: 'float', editable: true, classes: 'wrap'},
					{ label: 'Percentage of Discount', name: 'perdiscount', width: 30,  hidden: true},
					{ label: 'Amount Discount', name: 'amtdisc', width: 30,  hidden: true},
					{ label: 'Amount Sales Tax', name: 'amtslstax', width: 30,  hidden: true},
					{ label: 'Percentage of Sales Tax', name: 'perslstax', width: 30,  hidden: true},
					{ label: 'Expiry Date', name: 'expirydate', width: 30,  hidden: true},
					{ label: "Item Code at Supplier's Site", name: 'sitemcode', width: 30,  hidden: true},
					{ label: 'adduser', name: 'adduser', width: 30,  hidden: true},
					{ label: 'adddate', name: 'adddate', width: 30,  hidden: true},
					{ label: 'upduser', name: 'upduser', width: 30,  hidden: true},
					{ label: 'upddate', name: 'upddate', width: 30,  hidden: true},
					{ label: 'recstatus', name: 'recstatus', width: 30, hidden: true},
					{ label: 'deluser', name: 'deluser', width: 30,  hidden: true},
					{ label: 'deldate', name: 'deldate', width: 30,  hidden: true},
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				rownumbers: true,
				height: 100,
				rowNum: 30,
				pager: "#jqGridPager2",
				
				onPaging: function(pgButton){ 
				},
				gridComplete: function(){
					if(editedRowItem!=0){
						$("#gridSuppitems").jqGrid('setSelection',editedRowItem,false);
					}
				},
				onSelectRow:function(rowid, selected)
				{
					var ret=$('#gridSuppitems').jqGrid('getRowData',rowid);
					
					suppcode=ret.suppcode;
					$("#suppcode").val(suppcode);
					
					pricecode=ret.pricecode;
					$("#pricecode").val(pricecode);
					
					itemcode=ret.itemcode;
					$("#itemcode").val(itemcode);
					
					uomcode=ret.uomcode;
					$("#uomcode").val(uomcode);
					
					purqty=ret.purqty;
					$("#purqty").val(purqty);
					
					//console.log(suppcode +'-'+ ret.pricecode +'-'+itemcode+'-'+ret.uomcode+'-'+ret.purqty);
					
					if(rowid != null) {
						$("#gridSuppbonus").jqGrid().setGridParam({url :'suppbonusTbl.php?suppcode='+suppcode+'&itemcode='+itemcode,datatype:'json'}).trigger("reloadGrid");
						$("#pg_jqGridPager3 table").show();
					}
				},
			});
			
			jQuery("#gridSuppitems").jqGrid('setGroupHeaders', {
			  useColSpanStyle: false, 
			  groupHeaders:[
				{startColumnName: 'itemcode', numberOfColumns: 6, titleText: 'Items Supplied By the Supplier'},
			  ]
			});
			
			//////////pagerSuppitems///////////////////////////////////////////////////////////////
			var operItem;
			
			 $("#gridSuppitems").jqGrid('navGrid','#jqGridPager2',
				{	
					view:false,edit:false,add:false,del:true,search:false,
					beforeRefresh: function(){
						$("#gridSuppitems").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
					},
				},
				// options for the Edit Dialog
				{},
				// options for the Add Dialog
				{},
				// options for the Delete Dailog
				{	afterSubmit : function( data, postdata, operItem){
						$("#gridSuppitems").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
						return [true,'',''];
					},
					errorTextFormat: function (data) {
						return 'Error: ' + data.responseText;
					},
					serializeDelData : function (data){
						selRowId = $("#gridSuppitems").jqGrid ('getGridParam', 'selrow');
						rowData = $("#gridSuppitems").jqGrid ('getRowData', selRowId);
						return {'suppcode': rowData.suppcode,'operItem': 'del', 'id':rowData.lineno_}	
					}
				}).jqGrid('navButtonAdd',"#jqGridPager2",{
					caption:"", 
					buttonicon:"glyphicon glyphicon-info-sign", 
					onClickButton: function(){
						operItem='view';
						selRowId = $("#gridSuppitems").jqGrid ('getGridParam', 'selrow');
						populateFormdataItem(selRowId,'view');
						//populateFormdataItemView(selRowId);
					}, 
					position: "first", 
					title:"View Selected Row", 
					cursor: "pointer"
				}).jqGrid('navButtonAdd',"#jqGridPager2",{
					caption:"", 
					buttonicon:"glyphicon glyphicon-edit", 
					onClickButton: function(){
						operItem='edit';
						selRowId = $("#gridSuppitems").jqGrid ('getGridParam', 'selrow');
						populateFormdataItem(selRowId,'edit');
						enableForm('#dialogFormSupplierItem');
						//populateFormdataItem(selRowId);
						$("#suppcode").prop("readonly",true);
						$("#lineno_").prop("readonly",true);
					},
					position: "first", 
					title:"Edit Selected Row", 
					cursor: "pointer"
				}).jqGrid('navButtonAdd',"#jqGridPager2",{
					caption:"", 
					buttonicon:"glyphicon glyphicon-plus", 
					onClickButton: function(){
						operItem='add';
						$("#dialogFormSupplierItem" ).dialog( "option", "buttons", buttItem1 );
						$("#dialogFormSupplierItem" ).dialog( "option", "title", "Add" );
						$("#dialogFormSupplierItem").dialog( "open" );
						enableForm('#dialogFormSupplierItem');
						$('#suppcode').val(suppCode);
						$('#suppcode').attr('readonly','readonly');
						//$("#dialogFormSupplierItem").dialog("open");
					}, 
					position: "first", 
					title:"Add New Row", 
					cursor: "pointer"
				});
			//////////////////////////////////////////////////////////////////////////////////////////////////
			
			$("#dialogFormSupplierItem")
			  .dialog({ 
				width: 5/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
					emptyFormdataSupplierItem();
					if(operItem!='view'){
					dialogHandlerSuppitems('material.pricesource','pricecode',['pricecode','description'], 'Price Code');
					dialogHandlerSuppitems('material.product','itemcode',['itemcode','description'], 'Item Code');
					dialogHandlerSuppitems('material.uom','uomcode',['uomcode','description'], 'UOM Code');
					}
				},
				close: function( event, ui ) {
					$("#formdataSupplierItem a").off();
				},
				buttons : butt1,
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			  function emptyFormdataSupplierItem(){
				$('#formdataSupplierItem').trigger('reset');
				$('.help-block').html('');
			  }
			  
			  function saveFormdataItem(operItem){
				$.post( "suppitemsSave.php", $("#formdataSupplierItem" ).serialize()+'&'+$.param({ 'operItem': operItem }) , function( data ) {
					
				}).fail(function(data) {
					errorTextItem(data.responseText);
				}).success(function(data){
					$('#dialogFormSupplierItem').dialog('close');
					editedRowItem = $("#gridSuppitems").jqGrid ('getGridParam', 'selrow');
					$("#gridSuppitems").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
				});
			}
			
			function populateFormdataItem(selRowId,state){
					if(!selRowId){
						alert('Please select row');
						return emptyFormdataSupplierItem();
					}
					switch(state) {
					case state = 'edit':
						$( "#dialogFormSupplierItem" ).dialog( "option", "title", "Edit" );
						$( "#dialogFormSupplierItem" ).dialog( "option", "buttons", buttItem1 );
						break;
					case state = 'view':
						disableForm('#dialogFormSupplierItem');
						$( "#dialogFormSupplierItem" ).dialog( "option", "title", "View" );
						$( "#dialogFormSupplierItem" ).dialog( "option", "buttons", buttItem2 );
						break;
					default:
				}
					$("#dialogFormSupplierItem").dialog( "open" );
					rowData = $("#gridSuppitems").jqGrid ('getRowData', selRowId);
					$.each(rowData, function( index, value ) {
						var input=$("[name='"+index+"']");
							if(input.is("[type=radio]")){
								$("[name='"+index+"'][value='"+value+"']").prop('checked', true);
							}else{
								input.val(value);
							}
							console.log(value+"-"+index);
					});
			}
			
			function errorTextItem(text){
				$( "#formdataSupplierItem" ).prepend("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> "+text+"</div>");
			}
			
			var selText2,Dtable2,Dcols2;
			$("#gridDialogItem").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 50, sorttype: 'text', classes: 'pointer', checked:true}, 
					{ label: 'Description', name: 'description', width: 200, sorttype: 'text', classes: 'pointer'},
				],
				width: 550,
				//height: 180,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPagerItem",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialogItem").jqGrid ('getRowData', rowid);
					$("#gridDialogItem").jqGrid("clearGridData", true);
					$( "#dialogItem" ).dialog( "close" );
					$('#'+selText2).val(rowid);
					$('#'+selText2).focus();
					$('#'+selText2).parent().next().html(data['description']);
				},
				
			});
			
			function dialogHandlerSuppitems(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText2=id,Dtable2=table,Dcols2=cols,
					$("#gridDialogItem").jqGrid("clearGridData", true);
					$( "#dialogItem" ).dialog( "open" );
					$( "#dialogItem" ).dialog( "option", "title", title );
					$("#gridDialogItem").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#DtextItem').val('');$('#DcolItem').html('');
					$.each(cols, function( index, value ) {
						if(value['checked'])	{
							$("#DcolItem").append( "<label class='radio-inline'><input type='radio' name='dcolr3' checked value='"+value+"' checked>"+value+"</input></label>" );
						}
						else{
							$("#DcolItem").append( "<label class='radio-inline'><input type='radio' name='dcolr3' value='"+value+"' checked>"+value+"</input></label>" );
						}
					});
				});
			}
			
			$('#DtextItem').keyup(function() {
				delay(function(){
					DsearchItem($('#DtextItem').val(),$('input:radio[name=dcolr3]:checked').val());
				}, 500 );
			});
			
			$('#DcolItem').change(function(){
				DsearchItem($('#DtextItem').val(),$('input:radio[name=dcolr3]:checked').val());
			});
			
			function DsearchItem(Dtext2,Dcol2){
				$("#gridDialogItem").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable2+'&cols='+Dcols2+'&Dcol='+Dcol2+'&Dtext='+Dtext2}).trigger('reloadGrid');
			}

			 /*******************************************************************************************/
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 ////////////// suppbonus //////////////////////////////////////////////////////////////////////////////////////
			 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			 
			 var buttBonus1=[{
				text: "Save",click: function() {
					if( $('#formdataSupplierBonus').isValid({requiredFields: ''}, {}, true) ) {
						saveFormdataBonus(operBonus);
					}
				}
			},{
				text: "Cancel",click: function() {
					$(this).dialog('close');
				}
			}];
			
			var buttBonus2=[{
				text: "Close",click: function() {
					$(this).dialog('close');
			}}]
			
			$("#gridSuppbonus").jqGrid({
				editurl: 'suppbonusSave.php',
				datatype: "json",
				 colModel: [
				 	{ label: 'compcode', name: 'compcode', width: 50, hidden: true},
				 	{ label: 'Supplier Code', name: 'suppcode', width: 40, hidden: true},
					{ label: 'Price Code', name: 'pricecode', width: 30, hidden: true},
					{ label: 'no', name: 'lineno_', width: 50, hidden: true, sorttype: 'number'},
					{ label: 'uomcode', name: 'uomcode', width: 50, hidden: true},
					{ label: 'purqty', name: 'purqty', width: 50, hidden: true},
					{ label: 'bonpricecode', name: 'bonpricecode', width: 50, hidden: true},
				 	{ label: 'Bonus Item Code', name: 'bonitemcode', sorttype: 'text', width: 30, classes: 'wrap'},
					{ label: 'Item Description', name: 'description', sorttype: 'text', width: 80, classes: 'wrap'},
					{ label: 'Bonus UOM Code', name: 'bonuomcode', width: 30, sorttype: 'text', classes: 'wrap'},
					{ label: 'Bonus Quantity', name: 'bonqty', width: 30, sorttype: 'number', classes: 'wrap'}, 
					{ label: 'bonsitemcode', name: 'bonsitemcode', width: 50, hidden: true},
					{ label: "Supplier's Item Code", name: 'itemcode', width: 30, sorttype: 'text', classes: 'wrap'},
					{ label: 'adduser', name: 'adduser', width: 50, hidden: true},
					{ label: 'adddate', name: 'adddate', width: 50, hidden: true},
					{ label: 'upduser', name: 'upduser', width: 50, hidden: true},
					{ label: 'upddate', name: 'upddate', width: 50, hidden: true},
					{ label: 'recstatus', name: 'recstatus', width: 80, hidden: true,},
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: true,
				rownumbers: true,
				height: 100,
				rowNum: 30,
				pager: "#jqGridPager3",
				onPaging: function(pgButton){ 
				},
				gridComplete: function(){
					if(editedRowBonus!=0){
						$("#gridSuppbonus").jqGrid('setSelection',editedRowBonus,false);
					}
				},		
			});
			
			jQuery("#gridSuppbonus").jqGrid('setGroupHeaders', {
			  useColSpanStyle: false, 
			  groupHeaders:[
				{startColumnName: 'bonitemcode', numberOfColumns: 6, titleText: 'Bonus Items Given by the Supplier for the item'},
			  ]
			});
			
			//////////pagerSuppbonus///////////////////////////////////////////////////////////////
			var operBonus;
			
			 $("#gridSuppbonus").jqGrid('navGrid','#jqGridPager3',
				{	
					view:false,edit:false,add:false,del:true,search:false,
					beforeRefresh: function(){
						$("#gridSuppbonus").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
					},
				},
				// options for the Edit Dialog
				{},
				// options for the Add Dialog
				{},
				// options for the Delete Dailog
				{	afterSubmit : function( data, postdata, operBonus){
						$("#gridSuppbonus").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
						return [true,'',''];
					},
					errorTextFormat: function (data) {
						return 'Error: ' + data.responseText;
					},
					serializeDelData : function (data){
						selRowId = $("#gridSuppbonus").jqGrid ('getGridParam', 'selrow');
						rowData = $("#gridSuppbonus").jqGrid ('getRowData', selRowId);
						return {'suppcode': rowData.suppcode,'operBonus': 'del', 'id':rowData.lineno_}	
					}
			}).jqGrid('navButtonAdd',"#jqGridPager3",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-info-sign", 
				onClickButton: function(){
					operBonus='view';
					selRowId = $("#gridSuppbonus").jqGrid ('getGridParam', 'selrow');
					populateFormdataBonus(selRowId,'view');
					//populateFormdataBonusView(selRowId);
				}, 
				position: "first", 
				title:"View Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager3",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-edit", 
				onClickButton: function(){
					operBonus='edit';
					selRowId = $("#gridSuppbonus").jqGrid ('getGridParam', 'selrow');
					//populateFormdataBonus(selRowId);
					populateFormdataBonus(selRowId,'edit');
					enableForm('#dialogFormSupplierBonus');
					$("#suppcode2").prop("readonly",true);
					$("#pricecode2").prop("readonly",true);
					$("#itemcode2").prop("readonly",true);
					$("#uomcode2").prop("readonly",true);
					$("#purqty2").prop("readonly",true);
					$("#lineno_2").prop("readonly",true);
				},
				position: "first", 
				title:"Edit Selected Row", 
				cursor: "pointer"
			}).jqGrid('navButtonAdd',"#jqGridPager3",{
				caption:"", 
				buttonicon:"glyphicon glyphicon-plus", 
				onClickButton: function(){
					operBonus='add';
					$( "#dialogFormSupplierBonus" ).dialog( "option", "buttons", buttBonus1 );
					$( "#dialogFormSupplierBonus" ).dialog( "option", "title", "Add" );
					$("#dialogFormSupplierBonus").dialog( "open" );
					enableForm('#dialogFormSupplierBonus');
					
					//$("#dialogFormSupplierBonus").dialog("open");
					$('#suppcode2').val(suppcode);
					$('#suppcode2').attr('readonly','readonly');
					
					$('#pricecode2').val(pricecode);
					$('#pricecode2').attr('readonly','readonly');
					
					$('#itemcode2').val(itemcode);
					$('#itemcode2').attr('readonly','readonly');
					
					$('#uomcode2').val(uomcode);
					$('#uomcode2').attr('readonly','readonly');
					
					$('#purqty2').val(purqty);
					$('#purqty2').attr('readonly','readonly');
					//console.log(suppcode+','+itemcode)
				}, 
				position: "first", 
				title:"Add New Row", 
				cursor: "pointer"
			});
			
			/////////////////////////dialogBonus/////////////////////////////////////////////////////////////////////
			
			$("#dialogFormSupplierBonus")
			  .dialog({ 
				width: 5/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
					emptyFormdataSupplierBonus();
					if(operBonus!='view'){
					dialogHandlerSuppBonus('material.pricesource','bonpricecode',['pricecode','description'], 'Bonus Price Code');
					dialogHandlerSuppBonus('material.product','bonitemcode',['itemcode','description'], 'Bonus Item Code');
					dialogHandlerSuppBonus('material.uom','bonuomcode',['uomcode','description'], 'Bonus UOM Code');
					}
				},
				close: function( event, ui ) {
					$("#formdataSupplierBonus a").off();
				},
				buttons : butt1,
			  })
			  .dialogExtend({
				"closable" : true,
			  });
			  
			  function emptyFormdataSupplierBonus(){
				$('#formdataSupplierBonus').trigger('reset');
				$('.help-block').html('');
			  }
			  
			  function saveFormdataBonus(operBonus){
				$.post( "suppbonusSave.php", $("#formdataSupplierBonus" ).serialize()+'&'+$.param({ 'operBonus': operBonus }) , function( data ) {
					
				}).fail(function(data) {
					errorTextBonus(data.responseText);
				}).success(function(data){
					$('#dialogFormSupplierBonus').dialog('close');
					editedRowBonus = $("#gridSuppbonus").jqGrid ('getGridParam', 'selrow');
					$("#gridSuppbonus").jqGrid('setGridParam',{datatype:'json'}).trigger('reloadGrid');
				});
			}
			
			function populateFormdataBonus(selRowId,state){
					if(!selRowId){
						alert('Please select row');
						return emptyFormdataSupplierBonus();
					}
					switch(state) {
					case state = 'edit':
						$( "#dialogFormSupplierBonus" ).dialog( "option", "title", "Edit" );
						$( "#dialogFormSupplierBonus" ).dialog( "option", "buttons", buttBonus1 );
						break;
					case state = 'view':
						disableForm('#dialogFormSupplierBonus');
						$( "#dialogFormSupplierBonus" ).dialog( "option", "title", "View" );
						$( "#dialogFormSupplierBonus" ).dialog( "option", "buttons", buttBonus2 );
						break;
					default:
				}
					$("#dialogFormSupplierBonus").dialog( "open" );
					rowData = $("#gridSuppbonus").jqGrid ('getRowData', selRowId);
					$.each(rowData, function( index, value ) {
						var input=$("[name='"+index+"']");
							if(input.is("[type=radio]")){
								$("[name='"+index+"'][value='"+value+"']").prop('checked', true);
							}else{
								input.val(value);
							}
					});
			}
			
			function errorTextBonus(text){
				$( "#formdataSupplierBonus" ).prepend("<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert'>&times;</a><strong>Error!</strong> "+text+"</div>");
			}
			
			/////////////////////////////////////gridDialogBonus////////////////////////////////
			var selText3,Dtable3,Dcols3;
			$("#gridDialogBonus").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 50, sorttype: 'text', classes: 'pointer', checked:true}, 
					{ label: 'Description', name: 'description', width: 200, sorttype: 'text', classes: 'pointer'},
				],
				width: 550,
				//height: 180,
				viewrecords: true,
				loadonce: true,
                multiSort: true,
				rowNum: 30,
				pager: "#gridDialogPagerBonus",
				ondblClickRow: function(rowid, iRow, iCol, e){
					var data=$("#gridDialogBonus").jqGrid ('getRowData', rowid);
					$("#gridDialogBonus").jqGrid("clearGridData", true);
					$( "#dialogBonus" ).dialog( "close" );
					$('#'+selText3).val(rowid);
					$('#'+selText3).focus();
					$('#'+selText3).parent().next().html(data['description']);
				},
				
			});
			
			function dialogHandlerSuppBonus(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText3=id,Dtable3=table,Dcols3=cols,
					$("#gridDialogBonus").jqGrid("clearGridData", true);
					$( "#dialogBonus" ).dialog( "open" );
					$( "#dialogBonus" ).dialog( "option", "title", title );
					$("#gridDialogBonus").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#DtextBonus').val('');$('#DcolBonus').html('');
					$.each(cols, function( index, value ) {
						if(value['checked'])	{
							$("#DcolBonus").append( "<label class='radio-inline'><input type='radio' name='dcolr4' checked value='"+value+"' checked>"+value+"</input></label>" );
						}
						else{
							$("#DcolBonus").append( "<label class='radio-inline'><input type='radio' name='dcolr4' value='"+value+"' checked>"+value+"</input></label>" );
						}
					});
				});
			}
			
			$('#DtextBonus').keyup(function() {
				delay(function(){
					DsearchBonus($('#DtextBonus').val(),$('input:radio[name=dcolr4]:checked').val());
				}, 500 );
			});
			
			$('#DcolBonus').change(function(){
				DsearchBonus($('#DtextBonus').val(),$('input:radio[name=dcolr4]:checked').val());
			});
			
			function DsearchBonus(Dtext3,Dcol3){
				$("#gridDialogBonus").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable3+'&cols='+Dcols3+'&Dcol='+Dcol3+'&Dtext='+Dtext3}).trigger('reloadGrid');
			}
			
			/**************************************************viewSuppBonus*********************************/
			
			 $("#dialogFormSupplierBonusView")
			  .dialog({ 
				width: 6/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
					emptyFormdataSuppBonusView();
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
			  
			  function populateFormdataBonusView(selRowId){
					if(!selRowId){
						alert('Please select row');
						return emptyFormdataSuppBonusView();
					}
					$("#dialogFormSupplierBonusView").dialog( "open" );
					rowData = $("#gridSuppbonus").jqGrid ('getRowData', selRowId);
					$.each(rowData, function( index, value ) {
						var input=$("[name='"+index+"']");
							input.val(value);
							//console.log(index +"-"+ value)
					});
				}
				
				function emptyFormdataSuppBonusView(){
					$('#formdataSupplierBonusView').trigger('reset');
					$('.help-block').html('');
				}
			 
			/************************************************************************************************/
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			$("#pg_jqGridPager2 table").hide();
			$("#pg_jqGridPager3 table").hide();
			
			//***********************menu
			$('#menu').metisMenu();
			
		});

 </script>