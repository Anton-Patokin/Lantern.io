<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lantern.io</title>
    <!-- Styles -->
    <link rel="stylesheet" href="/css/dropzone.css">
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
    <div id="root">
        @yield('content')
        <main-footer></main-footer>
    </div>
    <script src="/js/app.js" charset="utf-8"></script>
    @yield('javascript')
    <script type="text/javascript">
    var photo_counter = 0;
    Dropzone.options.realDropzone = {
        uploadMultiple: false, // ceep this false -> outher way conflict on server side 'Paraplu'
        parallelUploads: 10,
        maxFilesize: 25,
        previewsContainer: '#dropzonePreview',
        // previewTemplate: document.querySelector('#preview-template').innerHTML,
        addRemoveLinks: true,
        dictRemoveFile: 'Remove',
        dictFileTooBig: 'Image is bigger than 2MB',

        // Dropzone setup
        init: function () {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for( var i=0; i < 5; i++ ) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }

            this.on("removedfile", function (file) {
                $.ajax({
                    type: 'POST',
                    url: '/file/delete',
                    data: {title: file.filename, id: file.id, _token: document.getElementById("csrf-token").value},
                    dataType: 'html',
                    success: function (data) {
                        var rep = JSON.parse(data);
                        if (rep.code == 200) {
                            photo_counter--;
                            $("#photoCounter").text("(" + photo_counter + ")");
                            console.log('foro deleted counter ', photo_counter);
                        }else{
                            $("#error").text(rep.message);
                            console.log("something went wrong ")
                        }
                    }
                });

            });
        },
        renameFilename: function (file) {
            return file.filename;
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
        accept: function (file, done) {
            var re = /(?:\.([^.]+))?$/;
            var ext = re.exec(file.name)[1];
            ext = ext.toUpperCase();
            if (ext == "JPG" || ext == "JPEG" || ext == "PNG" || ext == "GIF" || ext == "BMP" || ext == "PDF") {
                done();
            } else {
                done("Please select only supported files.");
            }
        },
        success: function (file, done) {
            photo_counter++;
            file.filename = done.file_name;
            file.id = done.file_id;
            console.log(file.filename);
            $("#photoCounter").text("(" + photo_counter + ")");
        }
    }
    </script>
</body>
</html>
