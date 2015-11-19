/**
 * Created by tonigurski on 19.11.15.
 */


/**
 * preveneds Dropzone from autoloading
 * @type {boolean}
 */
Dropzone.autoDiscover = false;

/**
 * Helper to boot up the media bundle dropzone at the right moment
 */

(function(exports, d) {
    function MMMediaBundleDomReady(fn, context) {

        function onReady(event) {
            d.removeEventListener("DOMContentLoaded", onReady);
            fn.call(context || exports, event);
        }

        function onReadyIe(event) {
            if (d.readyState === "complete") {
                d.detachEvent("onreadystatechange", onReadyIe);
                fn.call(context || exports, event);
            }
        }

        d.addEventListener && d.addEventListener("DOMContentLoaded", onReady) ||
        d.attachEvent      && d.attachEvent("onreadystatechange", onReadyIe);
    }

    exports.MMMediaBundleDomReady = MMMediaBundleDomReady;
})(window, document);

/**
 * Set ups a given dropzone to be compatible with the MMMediaBundleWidget
 *
 * @param _id
 * @param _url
 * @returns DropZone
 *
 * @constructor
 */
function MMMediaBundleFileDropzone(_id,_url)
{
    var myDropzone = new Dropzone(_id,
        { // The camelized version of the ID of the form element
            url: _url,
            // The configuration we've talked about above
            autoProcessQueue: true,
            uploadMultiple: true,
            parallelUploads: 100,
            maxFiles: 100,
            paramName: 'files',

            // The setting up of the dropzone
            init: function () {
                var myDropzone = this;

                // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
                // of the sending event because uploadMultiple is set to true.
                this.on("sendingmultiple", function () {
                    // Gets triggered when the form is actually being sent.
                    // Hide the success button or the complete form.
                });
                this.on("successmultiple", function (files, response) {

                    console.log("DropZone::successmultiple", files, response);

                    if (response
                        && response.success
                    ) {
                        for (file in response.data) {

                            var reference = document.createElement('input')
                            reference.type = 'hidden';
                            reference.name = 'appbundle_article[medias][]';
                            reference.value = response.data[file].id;

                            files[file].previewElement.appendChild(reference);

                        }

                    }

                });
                this.on("errormultiple", function (files, response) {

                    console.log("DropZone::errormultiple", files, response);
                    // Gets triggered when there was an error sending the files.
                    // Maybe show form again, and notify user of error
                });


                this.on("addedfile", function(file) {

                    // Create the remove button
                    var removeButton = Dropzone.createElement("<button>Remove file</button>");


                    // Capture the Dropzone instance as closure.
                    var _this = this;

                    // Listen to the click event
                    removeButton.addEventListener("click", function(e) {
                        // Make sure the button click doesn't submit the form:
                        e.preventDefault();
                        e.stopPropagation();

                        // Remove the file preview.
                        _this.removeFile(file);
                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
            }
        }
    );

    return myDropzone;
}


/**
 * Start loading the dom is rdy
 */
MMMediaBundleDomReady(function(event) {
    console.log('MMMediaBundleDomReady');

    var elements = document.getElementsByClassName('mmmb-dropzone');

    console.log(elements);

    for (var i = 0; i < elements.length; i++){

        console.log(i);
        var dropzone = elements[i];

        var url = dropzone.getAttribute('data-url');
        var id = dropzone.getAttribute('id');

        console.log(id,url);

        MMMediaBundleFileDropzone("#"+id,url);
    }
});