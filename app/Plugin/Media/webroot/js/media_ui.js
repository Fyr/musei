$(function () {
    'use strict';
	$.get(mediaURL.list, null, function(response){
	    if (checkJson(response)) {
    	    var config = {
    	        container: '.media-grid',
    	        data: response.data,
    	        actions: mediaURL
    	    }
            mediaGrid = new MediaGrid(config);
	    }
	});
    $('#fileupload').fileupload({
        url: mediaURL.upload,
        dataType: 'json',
        done: function (e, data) {
            $.each(data.result.files, function (index, file) {
                file.object_type = $(data.fileInput).data('object_type');
                file.object_id = $(data.fileInput).data('object_id');
                $.post(mediaURL.move, file, function(response){
                    mediaGrid.setData(response.data);
                    mediaGrid.update();
                }, 'json');
            });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                'width',
                progress + '%'
            );
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');
});