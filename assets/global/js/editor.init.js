

$(document).ready(function () {
    $('.summernote').summernote({
        dialogsInBody: true,
        height: 300,
        placeholder: 'Start typing...',
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['picture', 'link', 'video']],
            ['view', ['codeview']],
        ],
        callbacks: {
            onInit: function () {
                
            },
           
        }
    });
});