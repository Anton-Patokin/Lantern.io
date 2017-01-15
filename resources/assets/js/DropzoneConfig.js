Dropzone.options.realDropzone = {
    paramName: "file",
    uploadMultiple: false, // keep this false -> other way conflict on server side 'Paraplu'
    parallelUploads: 10,
    maxFilesize: 25,
    dictFileTooBig: 'Image is bigger than 25MB',
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    headers: {
        'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode('content').value,
    },
    createImageThumbnails : true,
    // Dropzone setup
    init: function () {
        var roomTitle = window.location.pathname.split('/');
        roomTitle = roomTitle[1];
        this.on("removedfile", function (file) {
            $.ajax({
                type: 'POST',
                url: '/file/delete',
                data: {room_title: roomTitle, title: file.filename, id: file.id},
                dataType: 'html',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    var rep = JSON.parse(data);
                    if (rep.code == 200) {
                        var successEvent = new CustomEvent('successfull-delete', {
                            'detail': {
                                'isDeleted': true,
                                'file': file
                            }
                        });

                        dispatchEvent(successEvent);
                    }else{
                        console.log("something went wrong ")
                    }
                }
            });

        });
        
    },
    renameFilename: function (filename) {
        var randomString = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for( var i=0; i < 10; i++ ) {
            randomString += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return randomString + '_' + filename;
    },
    error: function (file, response) {
        if ($.type(response) === "string")
        var message = response; //dropzone sends it's own error messages in string
        else
        var message = response.message;
        file.previewElement.classList.add("dz-error");
        _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
        _results = [];
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i];
            _results.push(node.textContent = message);
        }
        return _results;
    },
    success: function (file, done) {
        file.filename = done.file_name;
        file.id = done.file_id;
        var successEvent = new CustomEvent('successfull-upload', {
            'detail': file
        });
        dispatchEvent(successEvent);
    }
}
