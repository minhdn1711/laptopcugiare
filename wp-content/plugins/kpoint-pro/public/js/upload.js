(function( $ ) {
	'use strict';

	$(document).ready(function(){

		
		init_upload_zone();

		function init_upload_zone(){

			
			var options = {				  
			  maxFilesize: 10, // MB
			  acceptedFiles: "image/*",
			  dictRemoveFileConfirmation: "Bạn có muốn xoá file này ?",
			  addRemoveLinks: true,		  
			  timeout: 180000,
			  maxFiles: 2,
			  params: {'action':'kp_upload_bill','order_id' : jQuery('#order_id_up_bill').val() },
			  url: kp_upload_bill.admin_ajax,
			  dictDefaultMessage: 'Bấm hoặc kéo thả hình ảnh vào đây',
			  clickable: ".fileinput-button",
			  init: function() {
			  	var thisDropzone = this;

			  	$.each(kp_upload_bill.uploaded_list, function(key,value){
                 
	                var mockFile = { name: value.name, size: value.size, status: Dropzone.SUCCESS };
	                 
	                thisDropzone.options.addedfile.call(thisDropzone, mockFile);
	                thisDropzone.emit('complete', mockFile);
	 
	                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, kp_upload_bill.uploaded_url_folder + "/"+value.name);
	                 
	            });

			  	this.on("success", function(file) {
			  		
			  	});

			  	this.on("removedfile", function(file) {
				  	var server_file = $(file.previewTemplate).find('.dz-filename').text();
					    
					    // Do a post request and pass this path and use server-side language to delete the file
					$.post(kp_upload_bill.admin_ajax, { action: "kp_delete_bill_name", order_id: jQuery('#order_id_up_bill').val(), name: server_file } );
					
			  	});

			  	this.on("error", function(file, response) {
			  		$(file.previewElement).find('.dz-error-message').text(response);
			  	});

			  }
			}

			
			var myDropzone = new Dropzone("#myUploadZone", options);
		}
	});

})( jQuery );