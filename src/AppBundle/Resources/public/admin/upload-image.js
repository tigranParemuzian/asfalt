
myDropzone = new Dropzone("#image-dropzone",
    {
        url: env + "/api/admins/images",
        addRemoveLinks: true,
        dictDefaultMessage:'Drop files here to upload',
        maxFilesize: 10000,
        thumbnailWidth: 300,
        thumbnailHeight: 100,
        resizeWidth: 1920,
        resizeHeight: 890,
        maxFiles:7,
        dictRemoveFile: "<i  class=\"fa fa-times fa-fw\" aria-hidden=\"true\"><i>",
        clickable: true,
        init:function(){
            $(this).on('success', function(file) {
                console.log(file);
                var mockFile = { name: "myimage.jpg", size: 12345, type: 'image/jpeg' , objectId:'id', position:'position', side:'side' };
                this.addFile.call(this, mockFile);
                this.options.thumbnail.call(this, mockFile, "http://someserver.com/myimage.jpg");
                console.log(file);
                file.objectId = response.id;
                file.position = position;
                file.isMain = response.is_main;
                file.side = response.side;

                var edit = document.createElement('button');
                edit.setAttribute('class', 'edit-btn text-info');
                edit.setAttribute('type',"button");
                edit.setAttribute('onclick', "editImage("+response.id+")");
                edit.innerHTML = '<i class="fa fa-crop fa-fw"></i>';
                ;

                var check = '';

                if(response.is_main == true){
                    check = 'checked';
                }

                var isMain = document.createElement('label');
                isMain.setAttribute('class', 'is-main-image');
                isMain.innerHTML = '<input class="is-main" type="radio" name="isMani" onclick="imageToMain('+response.id+')" ' +
                    check +
                    '> Is Main';

            })
        },
        removedfile: function(file) {
            ajaxDeleteImage(file.objectId);
            var ref;
            if (file.previewElement) {
                if ((ref = file.previewElement) != null) {
                    ref.parentNode.removeChild(file.previewElement);
                }
            }
            return this._updateMaxFilesReachedClass();
        }
    });


$("#image-dropzone").sortable({
    items:'.dz-preview',
    cursor: 'move',
    opacity: 0.8,
    containment: '#image-dropzone',
    distance: 20,
    tolerance: 'pointer'
});

myDropzone.on('sending', function(file, xhr, formData){
    position ++;
    formData.append('side', file.side);
    formData.append('position', position);
    formData.append('realty', rl);
});

myDropzone.on("success", function(file, response) {
    file.objectId = response.id;
    file.position = position;
    file.isMain = response.is_main;
    file.side = response.side;
    images.push(file);


    var edit = document.createElement('button');
    edit.setAttribute('class', 'edit-btn text-info');
    edit.setAttribute('type',"button");
    edit.setAttribute('onclick', "editImage("+response.id+")");
    edit.innerHTML = '<i class="fa fa-crop fa-fw"></i>';

    var arraySides = ['left', 'right', 'front', 'back', 'inside', 'panorama', 'other'];

    var sides = document.createElement('div');
    sides.setAttribute('class', 'form-group image-side');
    sides.innerHTML =''  ;
    var info = '<label for="sel1">Select Side:</label><select class="form-control">';
    $.each(arraySides, function (key, value) {
        var isSelectrd = '';

        if(key == response.side){
            isSelectrd ='selected';
        }

        info += '<option value="'+key+'" '+isSelectrd+'>'+value+'</option>';
        if(key == (arraySides.length -1)){
            info+='</select>';
        }

    });
    sides.innerHTML +=info;

    var check = '';

    if(response.is_main == true){
        check = 'checked';
    }

    var isMain = document.createElement('label');
    isMain.setAttribute('class', 'form-group float-left is-main-image');
    isMain.innerHTML = '<input class="is-main" type="radio" name="isMani" onclick="imageToMain('+response.id+')" ' +
        check +
        '> Is Main';

    file.previewTemplate.appendChild(edit);
    file.previewTemplate.appendChild(isMain);
    file.previewTemplate.appendChild(sides);
});

/**
 * Get Images
 */
function ajaxImages() {
    jQuery.ajax({
        url: env+"/api/admins/"+ rl +"/images",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: false,
        success: function (resultData) {
            $.each(resultData, function (kay, val) {
                position++;
                var mockFile = { name: 'image-'+position, size: val.id, objectId:val.id, position:position,  isMain:val.is_main, side:convertSide(val.side) };
                images.push(mockFile);

                myDropzone.options.addedfile.call(myDropzone, mockFile);

                myDropzone.emit("thumbnail", mockFile, val.download_link);

                var edit = document.createElement('button');
                edit.setAttribute('class', 'edit-btn text-info');
                edit.setAttribute('type',"button");
                edit.setAttribute('onclick', "editImage("+val.id+")");
                edit.innerHTML = '<i class="fa fa-crop fa-fw"></i>';

                var arraySides = ['left', 'right', 'front', 'back', 'inside', 'panorama', 'other'];

                var sides = document.createElement('div');
                sides.setAttribute('class', 'form-group image-side');
                sides.innerHTML =''  ;
                var info = '<label for="sel1">Select Side:</label><select class="form-control">';
                $.each(arraySides, function (key, value) {
                    var isSelectrd = '';
                    if(key == val.side){
                        isSelectrd ='selected';
                    }
                    info += '<option value="'+key+'" '+isSelectrd+'>'+value+'</option>';
                    if(key == (arraySides.length -1)){
                        info+='</select>';
                    }

                });
                sides.innerHTML +=info;

                var check = '';

                if(val.is_main == true){
                    check = 'checked';
                }

                var isMain = document.createElement('label');
                isMain.setAttribute('class', 'form-group float-left is-main-image');
                isMain.innerHTML = '<input class="is-main" type="radio" name="isMani" onclick="imageToMain('+val.id+')" ' +
                    check +
                    '> Is Main';


                $(".dz-preview")[kay].appendChild(edit);
                $(".dz-preview")[kay].appendChild(isMain);
                $(".dz-preview")[kay].appendChild(sides);
            });


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

/**
 * Delete Images
 */
function ajaxDeleteImage(img_id) {
    jQuery.ajax({
        url: env+"/api/admins/"+img_id+"/delete/images",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function editImage(imag_id) {

    jQuery.ajax({
        url: env+"/api/admins/"+ imag_id +"/image",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            $('#myModalLabel').text('Edit '+ resultData.file_original_name );
            $('#imagemodal .modal-body').html('<img id="image-'+ resultData.id +'" style="max-width: 100%" src="'+ resultData.download_link +'">');
            $('#imagemodal').modal('show');
            initEditor(resultData.id);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function imageToMain(imag_id) {

    jQuery.ajax({
        url: env+"/api/admins/"+ imag_id +"/image/main",
        type: "GET",
        contentType: 'application/json; charset=utf-8',
        async: true,
        success: function (resultData) {
            $('#image-dropzone').html('<input type="hidden" name="position">' +
                '<div class="dz-default dz-message"></div>');
            ajaxImages();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR, textStatus, errorThrown);
        }
    });
}

function initEditor(elemId) {

    var dkrm = new Darkroom('#image-'+elemId, {
        // Size options
        minWidth: 100,
        minHeight: 100,
        maxWidth: 600,
        maxHeight: 500,
        ratio: 4/3,
        backgroundColor: '#000',

        // Plugins options
        plugins: {
            //save: false,
            crop: {
                quickCropKey: 67, //key "c"
                //minHeight: 50,
                //minWidth: 50,
                ratio: 4/2
            },
            save: {
                callback: function() {
                    $("#sortable").sortable("enable");
                    this.darkroom.selfDestroy();
                    var newImage = dkrm.canvas.toDataURL();
                    fileStorageLocation = newImage;

                    jQuery.ajax({
                        url: env+'/api/admins/edits/images',
                        type: "POST",
                        contentType: 'application/json; charset=utf-8',
                        async: true,
                        dataType:"json",
                        data: JSON.stringify({
                            "imageId": elemId,
                            "image": newImage
                        }),
                        success:function(ansvwe)
                        {
                            $('#image-dropzone').html('<input type="hidden" name="position">' +
                                '<div class="dz-default dz-message"></div>');
                            ajaxImages();
                        }
                    });
                }
            },
        },

        // Post initialize script
        initialize: function() {
            var cropPlugin = this.plugins['crop'];
            cropPlugin.selectZone(10, 10, 1200, 900);
        },
    });

}

function convertSide(number) {

    var side = '';
    switch(number) {
        case 0:
            side ='Left';
            break;
        case 1:
            side='Right';
            break;
        case 2:
            side='Front';
            break;
        case 3:
            side='Back';
            break;
        case 4:
            side='Inside';
            break;
        case 5:
            side='Panorama';
            break;
        case 6:
            side='Other';
            break;
        default:
            side = number;
            break;
    }

    return side;
}

function writeImageParent(image) {

}
