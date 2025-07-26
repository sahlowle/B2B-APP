"use strict";

$('.auth-template-action-btn').on('click', function() {
    $(this).toggleClass('text-dark')
    $(this).closest('.single-auth-template').find('.settings').toggleClass('active');
})

$('.imgbgchk').on('change', function() {
    let data = '';
    if (authSettings[$(this).val()]['required'].includes('title')) {
        data += `<div class="form-group row">
            <label for="title"
                class="col-2 control-label">${jsLang('Title')}</label>
            <div class="col-6 d-flex ms-2">
                <input type="text" class="form-control inputFieldDesign" id="title" name="title" value="${authSettings[$(this).val()]['data']['title']}">
            </div>
        </div>`;
    }
    
    if (authSettings[$(this).val()]['required'].includes('description')) {
        data += `<div class="form-group row">
            <label for="description"
                class="col-2 control-label">${jsLang('Description')}</label>
            <div class="col-6 d-flex ms-2">
                <textarea rows="3" class="form-control" name="description">${authSettings[$(this).val()]['data']['description']}</textarea>
            </div>
        </div>`;
    }
    
    if (authSettings[$(this).val()]['required'].includes('file')) {                
        data += `<div class="form-group row">
            <label class="control-label col-2 ltr:ps-3 rtl:pe-3">${jsLang('Background')}</label>
            <div class="col-sm-6 ms-2">
                <div class="custom-file position-relative" data-val="single"
                    id="image-status">
                    <input class="form-control up-images attachment d-none" name="attachment"
                        id="validatedCustomFile" accept="image/*">
                    <label class="custom-file-label overflow_hidden position-relative d-flex align-items-center"
                        for="validatedCustomFile" data-before="Browse">${jsLang('Upload image')}</label>
                </div>
                <div id="img-container">
                    <div class="d-flex flex-wrap">
                        <div class="position-relative border boder-1 p-1  ltr:me-2 rtl:ms-2 rounded mt-2">
                            <img width="100px" class="upl-img object-fit-contain p-1"
                                src="${ url + '/resources/views/admin/auth/login_templates/' + $(this).val() + '/' + authSettings[$(this).val()]['data']['file']}" alt="{{ __('Image') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
    }
    
    $('#extra_content').hide();
    $('#extra_content').html(data);
    
    $('#extra_content').fadeIn(400);
    
    $('.preview-button').attr('href', url + '/auth/login?template=' + $(this).val() );
    
})
