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
function MMMediaBundleFileDropzone(_id, _url, _fieldName, _multiple, _files,_options) {

    var $this = this;
    $this.id = _id;

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
    };

    /**
     * fires the afterInit event after the bundle finishs the custom init call
     */
    this.fireAfterInitEvent = function(_DropzoneDOM)
    {

        var $event;
        var $element = document.getElementById(this.id.replace('#',''));

        if (document.createEvent) {
            var $event = document.createEvent("HTMLEvents");

            $event.initEvent("MMMediaBundleFileDropzone.afterInit", true, true);
        } else {
            var $event = document.createEventObject();
            $event.eventType = "MMMediaBundleFileDropzone.afterInit";
        }

        if (document.createEvent) {
            $element.dispatchEvent($event);
        } else {
            $element.fireEvent("on" + $event.eventType, $event);
        }
    };


    /**
     * function which get called by Dropzone after init
     */
    this.initCallback = function () {

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

        /**
         * loads Dragular to enable drag and drop functionality
         * @TODO: check if its possible to enable drag n drop with multiple instances of Dropzone
         */
        if (_multiple) {

            var $dragula = dragula([document.querySelector($id_dropzone_preview)],
                {
                    direction: 'horizontal',
                    mirrorContainer: document.querySelector($id_dropzone_preview)

                });
        }


        $this.fireAfterInitEvent();

    };

    /**
     * dom id of preview container
     * @type {string}
     */
    var $id_dropzone_preview = _id + '_previews';

    var $options = {
        url: _url
        // The configuration we've talked about above
        , autoProcessQueue: true
        , paramName: (_multiple ? 'files' : 'files[]')
        , addRemoveLinks: true

        , previewsContainer: $id_dropzone_preview

        // multiple settings
        , uploadMultiple: _multiple
        , parallelUploads: ( (_multiple) ? 100 : 1 )
        , maxFiles: ( (_multiple) ? 100 : 1 )

        // The setting up of the dropzone
        , init: this.initCallback
    };


    /**
     * merge aditional given options
     */
    if (typeof _options == "object")
        for (var key in _options)
            $options[key] = _options[key];


    console.log($options);

    /**
     * loads the Dropzone instance
     */
    this.dropzone = new Dropzone(_id, $options);
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

        // get the allowed filetypes
        var fileTypes = dropzone.getAttribute('data-accepted-files');
        fileTypes = fileTypes ? fileTypes : false;

        /*
         * @TODO: better bool check
         */
        var multiple = dropzone.getAttribute('data-multiple');

        if (multiple == "false" || multiple == "" || multiple == "0")
            multiple = false;
        else
            multiple = true;

        var _options = {

            acceptedFiles: fileTypes,

            dictDefaultMessage: dropzone.getAttribute('data-dictDefaultMessage'), // The message that gets displayed before any files are dropped. This is normally replaced by an image but defaults to "Drop files here to upload"'
            dictFallbackMessage: dropzone.getAttribute('data-dictFallbackMessage'), // If the browser is not supported, the default message will be replaced with this text. Defaults to "Your browser does not support drag'n'drop file uploads."'
            dictFallbackText: dropzone.getAttribute('data-dictFallbackText'), // This will be added before the file input files. If you provide a fallback element yourself, or if this option is null this will be ignored. Defaults to "Please use the fallback form below to upload your files like in the olden days."'
            dictInvalidFileType: dropzone.getAttribute('data-dictInvalidFileType'), // Shown as error message if the file doesn·'t match the file type.'
            dictFileTooBig: dropzone.getAttribute('data-dictFileTooBig'), // Shown when the file is too big. {{filesize}} and {{maxFilesize}} will be replaced.'
            dictResponseError: dropzone.getAttribute('data-dictResponseError'), // Shown as error message if the server response was invalid. {{statusCode}} will be replaced with the servers status code.'
            dictCancelUpload: dropzone.getAttribute('data-dictCancelUpload'), // If addRemoveLinks is true, the text to be used for the cancel upload link.'
            dictCancelUploadConfirmation: dropzone.getAttribute('data-dictCancelUploadConfirmation'), // If addRemoveLinks is true, the text to be used for confirmation when cancelling upload.'
            dictRemoveFile: dropzone.getAttribute('data-dictRemoveFile'), // If addRemoveLinks is true, the text to be used to remove a file.'
            dictRemoveFileConfirmation: dropzone.getAttribute('data-dictRemoveFileConfirmation'), //
            dictMaxFilesExceeded: dropzone.getAttribute('data-dictMaxFilesExceeded')  // If maxFiles is set, this will be the error message when it\'s exceeded.
        };


        //loads the UploadWidget-Dropzone
        new MMMediaBundleFileDropzone("#" + id, url, fieldName, multiple, files, _options);
    }

    MMMediaBundleFileDropzoneInitiateEvents();


});