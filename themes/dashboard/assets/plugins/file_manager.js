    $(document).ready(function () {
        $(document).find('input:file').each(function() {
            if($(this).attr('rel') != "file_manager")
                return;
            $(this).attr('onClick','file_manager(\'' + this.name + '\')');
            file = $(this).attr('file_value');
            $("<input type='hidden' />").attr({ value: $(this).attr('file_value'), name: this.name  }).insertBefore(this);

            this.name = this.name + "_old";
            if(file != "" && typeof file !== 'undefined')
            {
                var file_name_string = file;

                var file_name_array = file_name_string.split(".");
                var file_extension = file_name_array[file_name_array.length - 1];

                $('[name="'+this.name + '"]').parent().parent().append('<div class="profile-avatar" style="width:250px !important"><img style="width:100% !important; height:auto !important" class="file_preview" src="" alt="No Image" ></div>');
                $('[name="'+this.name + '"]').parent().parent().find(".file_preview").attr('src', file);
            }
        });
    });
    function file_manager(target)
    {
        window.open(site_root + "/admin/files/show/embedded?target="+target,"myWindow","width=1000,height=420");
    }
    function file_selected(file, target){
        var file_name_string = file;

        var file_name_array = file_name_string.split(".");
        var file_extension = file_name_array[file_name_array.length - 1];
        if(file_extension == "jpg" || file_extension == "png")
        {
            $('[name="'+target + '"]').parent().parent().find(".file_preview").parent().remove();
            $('[name="'+target + '"]').parent().parent().append('<div class="profile-avatar" style="width:250px !important"><img style="width:100% !important; height:auto !important" class="file_preview" src="" alt="No Image" ></div>');
            $('[name="'+target + '"]').parent().parent().find(".file_preview").attr('src', file);

        }    
        $('[name="'+target + '"]').attr('value',file);
        $('[name="'+target + '"]').parent().find(".filename").html(file);
    }


    function initialize_file_manager(){


        //------------- Elfinder file manager  -------------//
        var elf = $('#elfinder').elfinder({
            url : site_root + '/admin/files/connector'  // connector URL (REQUIRED)
            // lang: 'ru',             // language (OPTIONAL)
            ,


            commandsOptions : {
                // configure value for "getFileCallback" used for editor integration
                getfile : {
                    // send only URL or URL+path if false
                    onlyURL  : true,

                    // allow to return multiple files info
                    multiple : false,

                    // allow to return folders info
                    folders  : false,

                    // action after callback (close/destroy)
                    oncomplete : ''
                },

                // "upload" command options.
                upload : {
                    ui : 'uploadbutton'
                },

                // "quicklook" command options. For additional extensions
                quicklook : {
                    autoplay : true,
                    jplayer  : 'extensions/jplayer'
                },

                // configure custom editor for file editing command
                edit : {
                    // list of allowed mimetypes to edit
                    // if empty - any text files can be edited
                    mimes : [],

                    // edit files in wysisyg's
                    editors : [
                        // {
                        // 	/**
                        // 	 * files mimetypes allowed to edit in current wysisyg
                        // 	 * @type  Array
                        // 	 */
                        // 	mimes : ['text/html'],
                        // 	/**
                        // 	 * Called when "edit" dialog loaded.
                        // 	 * Place to init wysisyg.
                        // 	 * Can return wysisyg instance
                        // 	 *
                        // 	 * @param  DOMElement  textarea node
                        // 	 * @return Object
                        // 	 */
                        // 	load : function(textarea) { },
                        // 	/**
                        // 	 * Called before "edit" dialog closed.
                        // 	 * Place to destroy wysisyg instance.
                        // 	 *
                        // 	 * @param  DOMElement  textarea node
                        // 	 * @param  Object      wysisyg instance (if was returned by "load" callback)
                        // 	 * @return void
                        // 	 */
                        // 	close : function(textarea, instance) { },
                        // 	/**
                        // 	 * Called before file content send to backend.
                        // 	 * Place to update textarea content if needed.
                        // 	 *
                        // 	 * @param  DOMElement  textarea node
                        // 	 * @param  Object      wysisyg instance (if was returned by "load" callback)
                        // 	 * @return void
                        // 	 */
                        // 	save : function(textarea, editor) {}
                        //
                        // }
                    ]
                },

                // help dialog tabs
                help : { view : ['about', 'shortcuts', 'help'] }
            }
        }).elfinder('instance');

        //-------------  Plupload uploader -------------//
        $("#uploader").pluploadQueue({
            // General settings
            runtimes : 'html5,html4', 
            url : '/finder/upload.php',
            max_file_size : '10mb',
            max_file_count: 15, // user can add no more then 15 files at a time
            chunk_size : '1mb',
            unique_names : true,
            multiple_queues : true,

            // Resize images on clientside if we can
            resize : {width : 320, height : 240, quality : 80},
            
            // Rename files by clicking on their titles
            rename: true,
            
            // Sort files
            sortable: true,

            // Specify what files to browse for
            filters : [
                {title : "Image files", extensions : "jpg,gif,png"}
                /*{title : "Zip files", extensions : "zip,avi"}*/
            ]
        });
    }