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

(function (exports, d) {
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
        d.attachEvent && d.attachEvent("onreadystatechange", onReadyIe);
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
function MMMediaBundleFileDropzone(_id, _url, _fieldName, _multiple, _files) {

    var $this = this;

    /**
     * creates and DOM input which holds a Media-Entity ID
     * @param _file
     * @returns {Element}
     */
    this.getHiddenEntityInput = function (_file) {

        if (!_file.id)
            return;

        var reference = document.createElement('input')
        reference.type = 'hidden';
        reference.name = _fieldName;
        reference.value = _file.id;

        return reference;
    };

    /**
     * appends an DOM input to the related previewElement of the given file-element
     * @param _file
     */
    this.appendHiddenEntityInput = function (_file) {

        if (_file) {

            var $reference = $this.getHiddenEntityInput(_file)

            if ($reference)
                _file.previewElement.appendChild($reference);
        }
    }

    var $id_dropzone_preview = _id + '_previews'

    /**
     * loads the Dropzone instance
     */
    this.dropzone = new Dropzone(_id,
        { // The camelized version of the ID of the form element
            url: _url,
            // The configuration we've talked about above
            autoProcessQueue: true,
            paramName: (_multiple ? 'files' : 'files[]'),
            addRemoveLinks: true,
            previewsContainer: $id_dropzone_preview,

            uploadMultiple: _multiple,
            parallelUploads: ( (_multiple) ? 100 : 1 ),
            maxFiles: ( (_multiple) ? 100 : 1 ),

            // The setting up of the dropzone
            init: function () {

                var myDropzone = this;

                /**
                 * checks if its an mutiple field and adds the related event
                 */
                if (_multiple) {

                    /**
                     * hooks the successmultiple event to append all hidden inputs which holds all tthe entity ids
                     */
                    myDropzone.on("successmultiple", function (files, response) {


                        if (response && response.success) {

                            for (file in response.data) {

                                files[file].id = response.data[file].id;

                                $this.appendHiddenEntityInput(files[file]);

                            }

                        }

                    });
                }
                else {
                    /**
                     * hooks the sucess event to append a hidden input which holds the entity id
                     */
                    myDropzone.on("success", function (file, response) {

                        if (response && response.success) {

                            for (tFile in response.data) {

                                file.id = response.data[0].id;

                                $this.appendHiddenEntityInput(file);
                            }
                        }
                    });
                }


                /**
                 * add already stored files to the widget
                 */

                    //temporaty add this event to get the real formated dropzone-file objects
                myDropzone.on("addedfile", $this.appendHiddenEntityInput);

                //loops thought the presetted files and appends them to the dropzone_preview
                for (var i = 0; i < _files.length; i++) {
                    var mock = _files[i];
                    mock.accepted = true;

                    myDropzone.files.push(mock);
                    myDropzone.emit('addedfile', mock);
                    myDropzone.createThumbnailFromUrl(mock, mock.url);
                    myDropzone.emit('complete', mock);
                }

                //removes the temporaty added this event
                myDropzone.off("addedfile", $this.appendHiddenEntityInput);


                if (_multiple) {

                    var $dragula = dragula([document.querySelector( $id_dropzone_preview )],
                        {
                            direction: 'horizontal'
                        });
                    console.log(document.querySelector(_id), $dragula);

                }


            }
        }
    );
}

function MMMediaBundleFileDropzoneInitiateEvents() {

}


/**
 * Start loading the dom is rdy
 */
MMMediaBundleDomReady(function (event) {

    var elements = document.getElementsByClassName('mmmb-dropzone');

    for (var i = 0; i < elements.length; i++) {

        var dropzone = elements[i];

        var url = dropzone.getAttribute('data-url');
        var fieldName = dropzone.getAttribute('data-field-name');
        var id = dropzone.getAttribute('id');

        //fetches preloaded Files
        var files = dropzone.getAttribute('data-files');
        files = JSON.parse(files);

        /*
         * @TODO: better bool check
         */
        var multiple = dropzone.getAttribute('data-multiple');

        if (multiple == "false" || multiple == "" || multiple == "0")
            multiple = false;
        else
            multiple = true;

        //loads the UploadWidget-Dropzone
        new MMMediaBundleFileDropzone("#" + id, url, fieldName, multiple, files);
    }

    MMMediaBundleFileDropzoneInitiateEvents();


});