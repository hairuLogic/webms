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
			
			$.validate({
			});
			
			var oper;
			$("#dialogForm")
			  .dialog({ 
				width: 8/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					emptyFormdata();
					//dialogHandler('costcenter','ccode',['costcode','description'], 'Cost Code');
					//dialogHandler('glmasref','glaccno',['glaccount','description'],'GL Account');
					
					dialogHandler('glmasref','stockacct',['glaccount','description'], 'Stock Account');
					dialogHandler('glmasref','cosacct',['glaccount','description'], 'COS Account');
					dialogHandler('glmasref','adjacct',['glaccount','description'], 'Adjusment Account');
					dialogHandler('glmasref','woffacct',['glaccount','description'], 'Write Off Account');
					dialogHandler('glmasref','expacct',['glaccount','description'], 'Expenses Account');
					dialogHandler('glmasref','loanacct',['glaccount','description'], 'Loan Account');
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
				/*"maximizable" : true,
				"minimizable" : true,
				"collapsable" : true,
				"dblclick" : "maximize",*/
			  });

			$("#jqGrid").jqGrid({
				url: 'CategoryTbl.php?source='+$('#source2').val(),
				editurl: 'CategorySave.php',
				datatype: "json",
				 colModel: [
					
					{label: 'Compcode', name: 'compcode', width: 90 , hidden: true},
					
					{label: 'Category Code', name: 'catcode', width: 90 , editable: true, classes: 'wrap',
					canSearch: true, checked:true, editrules:{ required: true}}, 
					
					{label: 'Description', name: 'description', width: 90, editable: true, classes: 'wrap',
					canSearch: true, editrules:{ required: true}}, 
					
					{label: 'Category Type', name: 'cattype', width: 90 , hidden: true},
					
					{label: 'Source', name: 'source', width: 90 , hidden: true},
					
					{label: 'Stock Account', name: 'stockacct', width: 90 ,  hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'COS Account', name: 'cosacct', width: 90, hidden: true, editable: true, 
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'Adjustment Account', name: 'adjacct', width: 90, hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'Write Off Account', name: 'woffacct', width: 90, hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'Expenses Account', name: 'expacct', width: 90, hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'Loan Account', name: 'loanacct', width: 90, hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'PO Validate', name: 'povalidate', width: 90, hidden: true, editable: true,
					classes: 'wrap', editrules:{ required: true, edithidden: true, hidedlg: true}},
					
					{label: 'accrualacc', name: 'accrualacc', width: 90, hidden: true, editable: true},
					
					{label: 'stktakeadjacct', name: 'stktakeadjacct', width: 90, hidden: true, editable: true},
					
					{label: 'adduser', name: 'adduser', width: 90 , hidden: true, editable: true},
					
					{label: 'adddate', name: 'adddate', width: 90 , hidden: true, editable: true},
					
					{label: 'upduser', name: 'upduser', width: 90 , hidden: true, editable: true},
					
					{label: 'upddate', name: 'upddate', width: 90 , hidden: true, editable: true},
					
					{label: 'deluser', name: 'deluser', width: 90 , hidden: true, editable: true},
					
					{label: 'deldate', name: 'deldate', width: 90 , hidden: true, editable: true},
					
					{label: 'recstatus', name: 'recstatus', width: 90, classes: 'wrap', hidden: true, 
					editable: true},
                            
						
				],
				autowidth:true,
				viewrecords: true,
                multiSort: true,
				loadonce: false,
				width: 780,
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
					$("#catcode").prop("readonly",true);
					
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
					$("#catcode").prop("readonly",false);
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
					}
				});
			}
			
			
			function emptyFormdata(){
				$('#formdata').trigger('reset');
				$('.help-block').html('');
			}
			
			function saveFormdata(oper){
				$.post( "CategorySave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
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
					{ label: 'Code', name: 'code', width: 50, checked2:true}, 
					{ label: 'Description', name: 'description', width: 80},
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
				}, 500 );
			});
			
			$('#Scol').change(function(){
				search($('#Stext').val(),$('input:radio[name=dcolr]:checked').val());
			});
			
			function search(Stext,Scol){
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'CategoryTbl.php?source='+$('#source2').val()+'&Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
			}
			
			function dialogHandler(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText=id,Dtable=table,Dcols=cols,
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
						};
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
				//console.log($('input:radio[name=dcolr]:checked').val());
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