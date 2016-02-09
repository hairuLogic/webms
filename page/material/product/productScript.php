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
			
			/*$(".input-group-addon").click(function(){
				var test = $(this).parent().parent().siblings("label").text();			
				//$(".input-group-addon + label").text();
				$("#dialog").dialog('option', 'title', test);
			});*/
			
			$("#dialogForm")
			  .dialog({ 
				width: 9/10 * $(window).width(),
				modal: true,
				autoOpen: false,
				open: function( event, ui ) {
					//$('button').focus();
					emptyFormdata();
					if(oper!='view'){
					dialogHandler('material.uom','uomcode',['uomcode','description'], 'UOM Code');
					dialogHandler('material.supplier','suppcode',['SuppCode','Name'] , 'Supplier Code');
					dialogHandler2('sysdb.department','mstore',['deptcode','description'], 'Main Store');
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
				url: 'productTbl.php',
				editurl: 'productSave.php',
				datatype: "json",
				 colModel: [
					{ label: 'sysno', name: 'sysno', width: 20, hidden:true },
					{ label: 'compcode', name: 'compcode', width: 20, hidden:true },
					{ label: 'Item Code', name: 'itemcode', width: 40, sorttype: 'text', classes: 'wrap', canSearch: true, checked: true},
					{ label: 'Item Description', name: 'description', width: 80, sorttype: 'text', classes: 'wrap', canSearch: true  },
					{ label: 'Uom Code', name: 'uomcode', width: 40, sorttype: 'text', classes: 'wrap'  },
					{ label: 'Group Code', name: 'groupcode', width: 40, sorttype: 'text', classes: 'wrap'  },
					{ label: 'Product Category', name: 'productcat', width: 40, sorttype: 'text', classes: 'wrap'  },
					{ label: 'Supplier Code', name: 'suppcode', width: 40, sorttype: 'text', classes: 'wrap'  },
					{ label: 'avgcost', name: 'avgcost', width: 50, hidden:true },
					{ label: 'actavgcost', name: 'actavgcost', width: 50, hidden:true },
					{ label: 'currprice', name: 'currprice', width: 50, hidden:true },
					{ label: 'qtyonhand', name: 'qtyonhand', width: 50, hidden:true },
					{ label: 'bonqty', name: 'bonqty', width: 50, hidden:true },
					{ label: 'rpkitem', name: 'rpkitem', width: 50, hidden:true },
					{ label: 'minqty', name: 'minqty', width: 50, hidden:true },
					{ label: 'maxqty', name: 'maxqty', width: 50, hidden:true },
					{ label: 'reordlevel', name: 'reordlevel', width: 50, hidden:true },
					{ label: 'reordqty', name: 'reordqty', width: 50, hidden:true },
					{ label: 'adduser', name: 'adduser', width: 50, hidden:true },
					{ label: 'adddate', name: 'adddate', width: 50, hidden:true },
					{ label: 'upduser', name: 'upduser', width: 50, hidden:true },
					{ label: 'upddate', name: 'upddate', width: 50, hidden:true },
					{ label: 'active', name: 'active', width: 60, hidden:true },
					{ label: 'chgflag', name: 'chgflag', width: 50, hidden:true },
					{ label: 'subcatcode', name: 'subcatcode', width: 50, hidden:true },
					{ label: 'expdtflg', name: 'expdtflg', width: 50, hidden:true },
					{ label: 'mstore', name: 'mstore', width: 50, hidden:true },
					{ label: 'costmargin', name: 'costmargin', width: 50, hidden:true },
					{ label: 'pouom', name: 'pouom', width: 50, hidden:true },
					{ label: 'reuse', name: 'reuse', width: 50, hidden:true },
					{ label: 'trqty', name: 'trqty', width: 50, hidden:true },
					{ label: 'deactivedate', name: 'deactivedate', width: 50, hidden:true },
					{ label: 'tagging', name: 'tagging', width: 50, hidden:true },
					{ label: 'itemtype', name: 'itemtype', width: 50, hidden:true },
					{ label: 'generic', name: 'generic', width: 50, hidden:true },
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
					$("#itemcode").prop("readonly",true);
					
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
						console.log(index +"-"+ value);
					}
				});
			}
			
			function emptyFormdata(){
				$('#formdata').trigger('reset');
				$('.help-block').html('');
			}
			
			function saveFormdata(oper){
				$.post( "productSave.php", $( "#formdata" ).serialize()+'&'+$.param({ 'oper': oper }) , function( data ) {
					
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
					{ label: 'Code', name: 'code', width: 40, sorttype: 'text', classes: 'pointer', checked:true}, 
					{ label: 'Description', name: 'description', width: 70, sorttype: 'text', classes: 'pointer'},
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
					$('#'+selText).parent().next().html(data['description']);
				},
			});
			
			///////////////////////// gridDialog2 //////////////////////////////////////////
			var selText2,Dtable2,Dcols2;
			$("#gridDialog2").jqGrid({
				datatype: "local",
				colModel: [
					{ label: 'Code', name: 'code', width: 40, sorttype: 'text', classes: 'pointer', checked: true}, 
					{ label: 'Description', name: 'description', width: 70, sorttype: 'text', classes: 'pointer'},
				],
				width: 550,
				//height: 180,
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
			
			/*function dialogHandler2(table,id,cols){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText2=id,Dtable2=table,Dcols2=cols,
					$( "#dialog2" ).dialog( "open" );
					$("#gridDialog2").jqGrid('setGridParam',{datatype:'json',url:'../getDialog2.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#Dtext').val('');$('#Dcol').html('');
					$.each(cols, function( index, value ) {
						$("#Dcol2" ).append( "<option value='"+value+"' >"+value+"</option>" );
						$("#Dcol2" ).append( "<input type='radio' name='"+cols+"' value='"+value+"'>"+value);
						//alert(value);
					});
				});
			}*/
			
			function dialogHandler2(table,id,cols,title){
				$( "#"+id+" ~ a" ).on( "click", function() {
					selText2=id,Dtable2=table,Dcols2=cols,
					$("#gridDialog2").jqGrid("clearGridData", true);
					$( "#dialog2" ).dialog( "open" );
					$( "#dialog2" ).dialog( "option", "title", title );
					$("#gridDialog2").jqGrid('setGridParam',{datatype:'json',url:'../getDialog2.php?table='+table+'&cols='+cols}).trigger('reloadGrid');
					$('#Dtext2').val('');$('#Dcol2').html('');
					$.each(cols, function( index, value ) {
						if(value['checked'])	{
							$("#Dcol2").append( "<label class='radio-inline'><input type='radio' name='dcolr3' checked value='"+value+"' checked>"+value+"</input></label>" );
						}
						else{
							$("#Dcol2").append( "<label class='radio-inline'><input type='radio' name='dcolr3' value='"+value+"' checked>"+value+"</input></label>" );
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
			
			function Dsearch2(Dtext,Dcol){
				$("#gridDialog2").jqGrid('setGridParam',{datatype:'json',url:'../getDialog2.php?table='+Dtable+'&cols='+Dcols+'&Dcol2='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			////////////////////////////////////////////////////////////////////////////////
			
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
						else{
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
				$("#jqGrid").jqGrid('setGridParam',{datatype:'json',url:'productTbl.php?Scol='+Scol+'&Stext='+Stext}).trigger('reloadGrid');
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
				Dsearch($('#Dtext').val(),$('input:radio [name=dcolr2]:checked').val());
			});
			
			function Dsearch(Dtext,Dcol){
				$("#gridDialog").jqGrid('setGridParam',{datatype:'json',url:'../getDialog.php?table='+Dtable+'&cols='+Dcols+'&Dcol='+Dcol+'&Dtext='+Dtext}).trigger('reloadGrid');
			}
			
			//***********************menu
			$('#menu').metisMenu();
			
		});

 </script>