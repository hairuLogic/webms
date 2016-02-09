/* Write here your custom javascript codes */
var Menu = function () {

    
    function create_menu()
    {
        $.getJSON( "assets/php/entry.php?action=create_menu", function(data)
        {
            console.log(data);            

            $.each(data.menu, function (index, value) 
            {
                $("#menu").append(value);
            });
			
        }).done(function() {
			$('#menu').metisMenu();var dialogArray=[];
			
			function deleteDialog(programid){
				$.each(dialogArray, function( index, obj ) {
					if(obj.id==programid){
						 dialogArray.splice(index, 1);
					}
				});
			}
			
			function searchDialog(programid){
				var object={got:false};
				$.each(dialogArray, function( index, obj ) {
					if(obj.id==programid){
						object=obj;
						return false;//bila return false, skip .each terus pegi return
					}
				});
				return object;
			}
			
			function makeNewDialog(obj){
				var dialogObj = {id:obj.attr('programid'),dialog:{}};
				
				dialogObj.dialog=$("<iframe src='"+obj.attr('targetURL')+"' programid='"+obj.attr('programid')+"' ></iframe>")
				  .dialog({ 
					title : obj.attr('title'),
					position: { my: "left bottom", at: "left+300px bottom"},
					width: 8/10 * $(window).width(),
					height: $(window).height() - 50,
					close: function( event, ui ) {
						deleteDialog(obj.attr('programid'));
					},
				  })
				  .dialogExtend({
						"closable" : true,
						"maximizable" : true,
						"minimizable" : true,
						"collapsable" : true,
						"dblclick" : "maximize",
				  });
				  dialogArray.push(dialogObj);
			}
			
			$(".clickable").click(function(){
				var programid=$(this).attr('programid');
				if(dialogArray.length>0){
					var obj = searchDialog(programid);
					if(obj.got==false){
						makeNewDialog($(this));
					}else{
						obj.dialog.dialog( "moveToTop" );
						obj.dialog.dialogExtend("restore");
					}
				}else{
					makeNewDialog($(this));
				}
				
			});
		});
    }

    return {

        init_menu: function () {
            create_menu();
        },

    };

}();