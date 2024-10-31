/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function($) {
        $('.rk_upload_file').click(function(e) {
            e.preventDefault();

            var custom_uploader = wp.media({
                title: 'Csv Upload',
                button: {
                    text: 'Upload'
                },
              
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                
                var attachment = custom_uploader.state().get('selection').first().toJSON();
         console.log(attachment);   
               
                //$('.header_logo').attr('src', attachment.url);
             
               
               
               var documents_file_type = attachment.filename;
			var get_ext = documents_file_type.split('.');
			//console.log(get_ext);
var exts = new Array('csv');
			//console.log(get_ext);
			if($.inArray(get_ext[1].toLowerCase(),exts)>-1){
                                    $('.header_logo_url').attr("readonly","readonly"); 
				   $('.header_logo_url').val(attachment.url);
                                   var html_elements = "<input type='hidden' name='file_id' value='"+attachment.id+"'>";
                                   
                                   $('#import_frm').append( html_elements  );
               //$('.file_info').html(attachment.toSource()); 
			}else{
                                 $('.header_logo_url').val('');
				//alert('not allow');
				alert('please select the csv file');
                                return false

			}
               
               
               
               
              //alert("jjjj");
              //alert(ajaxurl);  
      //var selection = custom_uploader.state().get('selection');
    
      /*selection.map( function( attachment ) {
        //attachment = attachment.toJSON();
        $.post(ajaxurl, {
           action: 'ajax_action',
           data: attachment
        }, function(data) {
           console.log(data);  
        });
        
      });*/
      
              
                
                
                
                
            })
            .open();
        });
    });
    
    


