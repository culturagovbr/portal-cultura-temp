(function ($) {
    $(document).ready(function () {
        app.init();
    });

    var app = {
        init: function () {
            this.addAttachment();
            this.deleteRow();
        },

        openMediaModal: function (rowToInsert = 0) {
            var button = $(this);
	        var defaultIcon = $('.document-url-meta').data('default-icon');
	        var rowModel = '<div class="t-row">' +
		        '<button type="button" class="remove-document-url" title="Excluir documento">' +
		        '<span class="dashicons dashicons-dismiss"></span>' +
		        '</button>' +
		        '<input type="text" class="document-url-input" name="document-url[]" value=""/>' +
		        '<div class="thumbnail default-image" >' +
		        '<a href="#" target="_blank">' +
		        '<img src="' + defaultIcon + '">' +
		        '</a>' +
		        '</div>' +
		        '<div class="data">' +
		        '<span class="doc-name"><b></b></span>' +
		        '<small class="doc-date"></small>' +
		        '<small class="doc-size"></small>' +
		        '</div>' +
		        '</div>';

            wp.media.editor.send.attachment = function (props, attachment) {

	            $('.document-url-meta').append(rowModel);
                $('#easy-docs-metabox .document-url-wrapper').removeClass('no-doc');
	            $('#easy-docs-metabox .t-row').last().find('.document-url-input').attr('value', attachment.url);
	            $('#easy-docs-metabox .t-row').last().find('.thumbnail > a').attr('href', attachment.url);
	            $('#easy-docs-metabox .t-row').last().find('.thumbnail img').attr('src', (typeof(attachment.sizes) !== 'undefined') ? attachment.sizes.thumbnail.url : defaultIcon);
	            $('#easy-docs-metabox .t-row').last().find('.doc-name b').text(attachment.title ? attachment.title : attachment.name);
	            $('#easy-docs-metabox .t-row').last().find('.doc-date').text(attachment.dateFormatted);
	            $('#easy-docs-metabox .t-row').last().find('.doc-size').text(attachment.filesizeHumanReadable);

            };
            wp.media.editor.open(button);
        },

        addAttachment: function () {
            $('#upload-doc-button, #easy-docs-metabox .add-new-doc').click(function (e) {
                e.preventDefault();
                app.openMediaModal();
            });
        },

        deleteRow: function () {
            $('.remove-document-url').click(function (e) {
                e.preventDefault();
                var rows = $('#easy-docs-metabox .t-row').length;
                console.log(rows);
                if( rows > 1 ){
                    $(this).parent().remove();
                } else {
                    $('#easy-docs-metabox .document-url-wrapper').addClass('no-doc');
                    $('#easy-docs-metabox .t-row').find('.document-url-input').attr('value', '');
                }
            })
        }
    };
})(jQuery);