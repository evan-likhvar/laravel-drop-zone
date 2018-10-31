var total_photos_counter = 0;
Dropzone.options.intro1Dropzone = {
    //uploadMultiple: true,
    parallelUploads: 1,
    maxFilesize: 16,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'Remove file',
    dictFileTooBig: 'Image is larger than 16MB',
    timeout: 10000,
    thumbnailWidth: 235,
    thumbnailHeight: 175,
    dictDefaultMessage: "Поместите файл в эту область.",
    init: function () {

        let id = $('#intro1-dropzone [name="id"]').val();

        console.log(id);

        let myDropzone = this;

        $.get('/resizable/'+id+'/intro1/get-preview', function (data) {
            let file = {name: data.name, size: data.size};
            myDropzone.options.addedfile.call(myDropzone, file);
            myDropzone.options.thumbnail.call(myDropzone, file, data.link);
            myDropzone.emit("complete", file);
            myDropzone.removeEventListeners();
            $(".dropzone .dz-preview .dz-image").width(data.test).height(175);
        });

        this.on("removedfile", function (file) {
            $.post({
                url: '/resizable/delete',
                data: {id: id, type: 'intro1', _token: $('[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                    $("#response-message").text(data.message);
                    console.log(data.message);
                    myDropzone.setupEventListeners();

                },
                error: function (request, status, error) {
                    console.log('remove');
                    console.log(message);
                    alert(request.responseText);

                }
            });
            myDropzone.setupEventListeners();

        });
    },
    success: function (file, done) {
        console.log(done.message);
        console.log(file);
        $("#response-message").text(done.message);
        $(".dropzone .dz-preview .dz-image").width(235).height(175);
        this.removeEventListeners();

    },
    error: function (file, done) {
        console.log('common');
        console.log(done);
        $("#response-message").text(done.message).addClass("dz-error");
        $(".dropzone .dz-preview .dz-image").width(235).height(175);
    }
};
