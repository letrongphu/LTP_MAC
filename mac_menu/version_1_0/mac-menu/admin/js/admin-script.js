var MAC = MAC || {};
(function($){
    // USE STRICT
    "use strict";
    var $window = $(window);
    var $document = $(document);
    MAC.MAC_Media = {
        init: function() {
            MAC.MAC_Media.mediaMultipleUpload();
            MAC.MAC_Media.mediaUpload();
        },

        /*  ==================
            ***** mediaUploader
            ================== 
        */
        mediaMultipleUpload: function(button = '') {

            var btnUploadGallery =  $('.upload-gallery-button');
            btnUploadGallery.each(function () {
                
                var file_frame;
                var selected_images = [];
                var gallery = $(this).parents('.mac-gallery-wrap').find('.gallery');
                var imgAttachmentIds = $(this).parents('.mac-gallery-wrap').find('.image-attachment-ids');

                if(imgAttachmentIds.val() != '' ){
                    selected_images.push(imgAttachmentIds.val());
                }
                
                $(this).off('click').click(function () {
                    event.preventDefault();
                    // If the media frame already exists, reopen it.
                    if (file_frame) {
                        file_frame.open();
                        return;
                    }
                    file_frame = wp.media.frames.file_frame = wp.media({
                        title: 'Select or Upload Images',
                        button: {
                            text: 'Use these images'
                        },
                        multiple: 'add'  // Set to true to allow multiple files to be selected
                    });
                    // Chọn các ảnh đã có sẵn ban đầu
                    file_frame.on('open', function() {
                        var selection = file_frame.state().get('selection');
                        var filArray = imgAttachmentIds.val().split('|');
                        var array = [];
                        filArray.filter(function(item) {
                            array.push(item);
                        });
                        array.forEach(function(id) {
                            var attachment = wp.media.attachment(id);
                            attachment.fetch();
                            selection.add(attachment ? [attachment] : []);
                        });
                    });
            
                    // When images are selected, run a callback.
                    file_frame.on('select', function() {
                        var attachments = file_frame.state().get('selection').toArray();
                        selected_images = [];
                        gallery.html('');
                        imgAttachmentIds.val('');
                        updateHiddenInput();
                        attachments.forEach(function(attachment) {
                            attachment = attachment.toJSON();
                            selected_images.push(attachment);
                            displayImage(attachment);
                        });
                        updateHiddenInput();
                    });
            
                    // Finally, open the modal
                    file_frame.open();
                });
            
                function displayImage(attachment) {
                    if(attachment.url !='' && attachment.url != null){
                        var imageHtml = '<div class="image-preview" data-id="' + attachment.id + '">';
                        imageHtml += '<img src="' + attachment.url + '">';
                        imageHtml += '<span class="remove-img-button" data-id="' + attachment.id + '">x</span>';
                        imageHtml += '</div>';
                        gallery.append(imageHtml);
                    }
                }
            
                function updateHiddenInput( id = null) {
                    if(imgAttachmentIds.val() != '' ){
                        var filteredArray = imgAttachmentIds.val().split('|');
                        var ids = selected_images.map(function(img) { return img.id; });
                        
                        if(id) {
                            var newArray = [];
                            filteredArray.filter(function(item) {
                                if (item != id){
                                    newArray.push(item);
                                }
                            });
                            var idsvalue = [];
                            newArray.forEach(element => {
                                if(element != '' && element != null ){
                                    idsvalue.push(element);
                                }
                            });
                            idsvalue = idsvalue.join('|');
                            imgAttachmentIds.val(idsvalue);
                        }else{
                            var value = imgAttachmentIds.val() + ids.join('|');
                            imgAttachmentIds.val(value);
                        }
                        
                    }else{
                        var ids = selected_images.map(function(img) { return img.id; });
                        imgAttachmentIds.val(ids.join('|'));
                    }
                    
                }
            
                gallery.on('click', '.remove-img-button', function(event) {
                    event.preventDefault();
                    var id = $(this).data('id');
                    selected_images = selected_images.filter(function(img) {
                        return img.id !== id;
                    });
                    $(this).parent().remove();
                    updateHiddenInput(id);
                });
            });
        
            
        },

        mediaUpload: function(button = '') {

            if(button) {
                var addMedia =  button;
            }else {
                var addMedia  = ('.add_media_button');
            }
            $(addMedia).each(function(){
                $(this).on('click', function(e) {
                    var mediaUploader;
                    var partentElement = $(this).parent('.mac-add-media');
                    e.preventDefault();
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    mediaUploader = wp.media.frames.file_frame = wp.media({
                        title: 'Choose Media',
                        button: {
                            text: 'Choose Media'
                        },
                        multiple: false
                    });
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        if (attachment.type === 'image') {
                            partentElement.find('.custom_media_url').val(attachment.url);
                            partentElement.find('.media_preview').attr('src', attachment.url).show();
                            partentElement.find('.remove_media_button').show()
                        } else {
                            partentElement.find('.media_preview').hide();
                        }
                    });
                    mediaUploader.open();
                });
                $('.remove_media_button').on('click', function(e) {
                    var partentElement = $(this).closest('.mac-add-media');
                    e.preventDefault();
                    partentElement.find('.custom_media_url').val('');
                    partentElement.find('.media_preview').attr('src', '').hide();
                    $(this).hide();
                });

            });
        },
    }
    MAC.documentOnReady = {
        init: function(){
            MAC.documentOnReady.sortableDefault();
            MAC.documentOnReady.sortableRepeater();
            MAC.documentOnReady.sortableRepeaterChildCat();
            MAC.documentOnReady.formRepeater();
            MAC.MAC_Media.init();
            MAC.documentOnReady.isTable();
            MAC.documentOnReady.collapsible();
            MAC.documentOnReady.confirmDialog();
            MAC.documentOnReady.confirmDialogFormSubmit();
            MAC.documentOnReady.onOffSelect();
            MAC.documentOnReady.switcherBTN();
        },
        switcherBTN: function() {
            var switcher = $('.mac-switcher-btn');
            $(switcher).each(function(){
                $(this).off('click').click(function () {

                    if( $(this).hasClass('active')){
                        $(this).removeClass('active');
                        $(this).find('input').attr('value','0');
                    }else{
                        $(this).addClass('active');
                        $(this).find('input').attr('value','1');
                    }
                });
            });
        },
        onOffSelect: function(){
            var childCat = $('.is-child-category');
            $(childCat).each(function () {
                if($(this).find('.list-item').length > 0) {
                    var isCatPrimary = $(this).parents('#post-body-content').find('.is-primary-category');
                    isCatPrimary.find('.mac-is-table').attr('disabled', 'disabled');
                }
            });
            // var listChildCat = $('.mac-list-cat-child');
            // $(listChildCat).each(function () {
            //     if($(this).find('.list-child-item').length > 0) {
            //         var isListCat = $(this).parents('.list-item').find('.form-table');
            //         isListCat.find('.mac-is-table').attr('disabled', 'disabled');
            //     }
            // });
            
        },

        confirmDialogFormSubmit: function() {
            
            $('.btn-delete-menu').on('click', function(event) {
                event.preventDefault();
                var tableDataName = $(this).parents('.form-add-cat-menu').find('#input-delete-data').attr('data-table');
                console.log(tableDataName);
                $(this).parents('.form-add-cat-menu').find('#input-delete-data').attr('value',tableDataName);
                $('#overlay, #confirmDialog').show();
            });
            $('.btn-delete-cat-menu').on('click', function(event) {
                event.preventDefault(); // Ngăn chặn submit form ngay lập tức
                var idDelete = $(this).parents('.list-item').find('.id-cat-menu').val();
                // Hiển thị hộp thoại xác nhận và lớp phủ
                $('#confirmDialog').find('input').attr('value',idDelete);
                $('#overlay, #confirmDialog').show();
            });

            $('#export-table-data').on('click', function(event) {
                event.preventDefault(); // Ngăn chặn submit form ngay lập tức
                // Hiển thị hộp thoại xác nhận và lớp phủ
                $('#posts-filter').off('submit').submit();
            });
        },

        confirmDialog: function() {
    
            $('#confirmOk').on('click', function() {
                // Tiếp tục hành động submit form
                $('#posts-filter').off('submit').submit(); // Submit form
            });
    
            $('#confirmCancel').on('click', function() {
                // Hủy bỏ hành động submit form
                $('#overlay, #confirmDialog').hide();
            });
    
            $('#overlay').on('click', function() {
                // Ẩn hộp thoại khi nhấn vào lớp phủ
                $('#overlay, #confirmDialog').hide();
            });
        },

        /*  ==================
            ***** button collapsible 
            ================== 
        */
        collapsible: function() {
            var collapsible = $('.mac-collapsible-btn');
            $(collapsible).each(function(){
                $(this).off('click').click(function () {
                    if( $(this).hasClass('collapsible-show') ){
                        $(this).removeClass('collapsible-show');
                    }else{
                        $(this).addClass('collapsible-show');
                    }
                });

            });
        },
        /*  ==================
            ***** Sortable
            ================== 
        */
        sortableDefault: function() {
            var sortable = $('.sortable > tbody');
            $(sortable).each(function(){
                $(this).sortable({
                    update: function( event, ui ) {
                        // Lấy danh sách vị trí mới
                        $(this).find('tr').each(function(index) {
                            //$(this).find('td.position').text(index);
                            $(this).find('td.position').attr('order',index);
                        });
                    }
                });
                $(this).disableSelection();
            });
        },
        sortableRepeater: function() {
            var sortable = $('.repeater-list-item.sortable');
            $(sortable).each(function(){
                $(this).sortable({
                    update: function( event, ui ) {
                        // Lấy danh sách vị trí mới
                    }
                });
                $(this).disableSelection();
            });
        },
        sortableRepeaterChildCat: function() {
            var sortable = $('.mac-list-cat-child.sortable');
            $(sortable).each(function(){
                $(this).sortable({
                    update: function( event, ui ) {
                        // Lấy danh sách vị trí mới
                        $(this).find('.list-item.ui-sortable-handle').each(function(index) {
                            $(this).find('td input.position').val(index);
                        });
                    }
                });
                $(this).disableSelection();
            });
        },
        /*  ==================
            ***** Repeater
            ================== 
        */
        formRepeater: function() {
            var repeater = $('.form-repeater');
            if(repeater){
                clearInterval(repeater);
            }
            $(repeater).each(function(){
                $(this).repeater({
                    initEmpty: false,
                    show: function() {
                        $(this).slideDown();
                        var btn_load = $(this).find('.add_media_button');
                        MAC.MAC_Media.mediaUpload(btn_load);
                        MAC.documentOnReady.collapsible();

                        
                            var totalCol = $(this).parents('.form-table').find('.mac-table-total-col');
                            let totalColNumber = parseInt($(totalCol).find('.mac-is-selection').val());
                            // xử lý item Menu
                            let formRepeater = $(this).parents('.form-table').find('.form-repeater');
                            let listItem = formRepeater.children('.repeater-list-item').children('div');
                            let priceList = $(this).find('.form-repeater-child .repeater-list-item');
                            let totalPriceList = priceList.children('div');
                            let idCatMenu = $(this).parents('.form-table').find('.id-cat-menu').val();
                                for( var j = 0 ; j < listItem.length; j++ ){
                                   
                                    if(totalColNumber > totalPriceList.length) {
                                        
                                        for(var y = 0; y < totalColNumber  ; y++  ) {
                                            // form_1_group-repeater[2][price-list][0][price]

                                            let htmlItem = '<div data-repeater-item class="ui-sortable-handle"><label>Price: </label><input type="text" name="form_'+idCatMenu+'_group-repeater['+ (listItem.length - 1) +'][price-list]['+(y)+'][price]" value=""></div>';
                                            
                                            if(y >= totalPriceList.length) {
                                                priceList.eq(j).append(htmlItem);
                                            }
                                        }
                                    }
                                }
                            
                                        
                                //
                        


                    },
                    hide: function(deleteElement) {
                        $(this).slideUp(deleteElement);
                    },
                    ready: function(setIndexes) {
                        /* Do something when the repeater is ready */
                    },
                    isFirstItemUndeletable: true,
                    repeaters: [{
                        selector: '.form-repeater-child',
                        initEmpty: false,
                        defaultValues: {
                            'price': ''
                        },
                        show: function() {
                            $(this).slideDown();
                        },
                        hide: function(deleteElement) {
                            $(this).slideUp(deleteElement);
                        }
                    }],
                    
                });
                
            });

        },

        /** */
        isTable: function () {
            var totalCol = $('.mac-table-total-col');
            $(totalCol).each(function() {
                $(this).change(
                    function(){
                        let idCatMenu = $(this).parents('.form-table').find('.id-cat-menu').val();
                        let totalColNumber = parseInt($(this).find('.mac-is-selection').val());
                        // xử lý Cat
                        let tableHeading = $(this).next('.mac-table-col-heading').find('.data_table');
                        let totalTD = tableHeading.find('td');
                        var html = '<td><lable>Heading Name </lable><input name="form_'+idCatMenu+'_table_col[]" class="large-text" value=""></input></td>';
                        if(totalColNumber > totalTD.length) {
                            for(var i = 0; i < totalColNumber  ; i++  ) {
                                if(i >= totalTD.length) {
                                    tableHeading.find('tr').append(html);
                                }
                            }
                        }else{
                            for(var i = 0; i < totalTD.length  ; i++  ) {
                                if( (i >= totalColNumber) || (0 == totalColNumber) ) {
                                    tableHeading.find('td:nth-child('+(i+1)+')').hide();
                                    //tableHeading.find('td:nth-child('+(i+1)+')').remove();
                                }
                            }
                            tableHeading.find('td[style="display: none;"]').remove();
                            
                        }
                        // xử lý item Menu

                        let formRepeater = $(this).parents('.form-table').find('.form-repeater');
                        let listItem = formRepeater.children('.repeater-list-item').children('div');
                        let priceList = formRepeater.find('.form-repeater-child .repeater-list-item');
                        let totalPriceList = priceList.children('div');
                        //let idCatMenu = $(this).parents('.form-table').find('.id-cat-menu').val();
                        if( listItem && listItem.length > 0 ) {
                            for( var j = 0 ; j < listItem.length; j++ ){
                                if(totalColNumber > totalPriceList.length/listItem.length ) {
                                    for(var y = 0; y < totalColNumber  ; y++  ) {
                                        let htmlItem = '<div data-repeater-item class="ui-sortable-handle"><label>Price: </label><input type="text" name="form_'+idCatMenu+'_group-repeater['+ (listItem.length - 1) +'][price-list]['+(y)+'][price]" value=""></div>';
                                        if(y >= totalPriceList.length/listItem.length) {
                                            priceList.eq(j).append(htmlItem);
                                        }
                                    }
                                }else{
                                    for(var z = 0; z < totalPriceList.length/listItem.length  ; z++  ) {
                                        if( (z >= totalColNumber) || (0 == totalColNumber) ) {
                                            priceList.children('div:nth-child('+(z+1)+')').remove();
                                        }
                                        
                                    }
                                    
                                }
                            }
                        }
                    }
                    
                );
            });
        },
    };
    MAC.documentOnLoad = {
        init: function() {
        }
    };

    $document.ready( MAC.documentOnReady.init );
    $window.on('load', MAC.documentOnLoad.init );
})(jQuery);
