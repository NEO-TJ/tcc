// ************************************************ Event **********************************************
// --------------------------------------------- Page Load ---------------------------------------------
$(document).ready(function() {
    tinymce.init({
        // General options
        selector : "textarea#content",
        auto_focus: 'content',
        theme : "modern",
        plugins: 'advlist autolink link image lists charmap print preview',
    });
    
    tinymce.init({
        // General options
        selector : "textarea#thumbnailUrl",
        plugins: "image",
        menubar: "false",
        toolbar: "image",
    });
    
    // DateTimePicker.
    $('#dtsPublishDate').datetimepicker({
        viewMode: 'days',
        format: 'DD-MMM-YYYY',
        useCurrent: true
    });
    $('#dtsPublishDate').val(moment().format('DD-MMM-YYYY'));
        
    // UI Block.
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    //initialPage();
});


/*
http://www.dmcr.go.th/dmcr/fckupload/upload/16/image/TSNBg3wSBdng7ijM58n2hsPwVri4VaLV6ksFhUf1JBR.jpg
*/
//------------------------------------------------ Button ----------------------------------------------
// Submit & Reset
$('form#formContentEditor').on('submit', function(e) {
    e.preventDefault();

    if (ValidateInputRequire()) {
        SaveInputData();
    } else {
        ShowDialog(dltValidate);
    }
});






//************************************************ Method **********************************************
//------------------------------------------------- Save -----------------------------------------------
function SaveInputData() {
    let baseUrl = $('input#baseUrl').val();
    let data = $('form#formContentEditor').serializeArray();
    data.push({name: 'Content', value: tinyMCE.get('content').getContent()});
    data.push({name: 'Thumbnail_Url', value: tinyMCE.get('thumbnailUrl').getContent()});

    // Ajax add or edit record.
    $.ajax({
        url: baseUrl + 'cms/ajaxSaveInputData',
        type: 'post',
        data: data,
        beforeSend: function() {
            swal({
                title: "Saving...",
                text: '<span class="text-info"><i class="fa fa-refresh fa-spin"></i> Saving please wait...</span>',
                showConfirmButton: false,
            });
        },
        error: function(xhr, textStatus) {
            swal("Error", textStatus + xhr.responseText, "error");
        },
        complete: function() {},
        success: function(result) {
            if (result == 0) {
                swal({
                    title: "Success",
                    text: "Save data to database has success",
                    type: "success",
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonText: "Done",
                    confirmButtonClass: "btn btn-success",
                }).then(function() {
                    window.location.href = baseUrl + "cms"
                });
            } else {
                swal({
                    title: "Unsuccess!",
                    text: "Can't save<span class='text-info'> data </span>to database" + result,
                    type: "error",
                    confirmButtonColor: "#DD6B55"
                });
            }
        }
    });
}