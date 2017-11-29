// ******************************************************************************************** Event
// -------------------------------------------------------------------------------------------- Page Load
$(document).ready(function() {
    //window.location = $('#backToTop').prop('href');
    // DateTimePicker.

    // UI Block.
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

    initDaterange();
    initialPage();
    initialGoogleMap();
});
// -------------------------------------------------------------------------------------------- Init DatetimePicker.
function initDaterange() {
    $('#dtsEventDate').datetimepicker({
        viewMode: 'days',
        format: 'DD-MMM-YYYY',
        useCurrent: true
    });
    $('#dtsEventDate').val(moment().format('DD-MMM-YYYY'));
}

/*
    $('#eventDate').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month')
            , moment().subtract(1, 'month').endOf('month')],

            'This Year': [moment().startOf('year'), moment().endOf('year')],
            'Last Year': [moment().subtract(1, 'year').startOf('year')
            , moment().subtract(1, 'year').endOf('year')],

            '2 Year': [moment().subtract(1, 'year').startOf('year'), moment()],
            '5 Year': [moment().subtract(5, 'year').startOf('year'), moment()],
            '10 Year': [moment().subtract(10, 'year').startOf('year'), moment()]
        }
    }, cb);
*/

//    cb(start, end);

// -------------------------------------------------------------------------------------------- End Page Load.


/*
$('a#eventImage').on('click', function(e) {
    alert("event image");
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    e.preventDefault();
    $.post(baseUrl + 'eventImage/manipulate', {"iccCardId" : iccCardId}, function() { window.location.href = 'page.php' });  
});
*/
// -------------------------------------------------------------------------------------------- Submit & Reset
$('button#btnSave').on('click', function(e) {
    if (ValidateInputRequire()) {
        saveIccCard();
    } else {
        ShowDialog(dltValidate);
    }
});


// -------------------------------------------------------------------------------------------- Radio input
$('input[type=radio]#eventDistance').on('change', function() {
    $('input[type=number]#eventDistanceEtc').val('');
    $('input[type=number]#eventDistanceEtc').removeClass('input-require');
    $('input[type=number]#eventDistanceEtc').prop('disabled', true);
});
$('input[type=radio]#eventDistanceEtc').on('change', function() {
    $('input[type=number]#eventDistanceEtc').removeClass('input-require');
    $('input[type=number]#eventDistanceEtc').addClass('input-require');
    $('input[type=number]#eventDistanceEtc').prop('disabled', false);
});
// -------------------------------------------------------------------------------------------- Number input
$('input[type=number]#eventDistanceEtc').on('change', function() {
    $('input[type=radio]#eventDistanceEtc').val($('input[type=number]#eventDistanceEtc').val());
});


// -------------------------------------------------------------------------------------------- Click command.
$(document).on('click', 'button#deleteIccCard', function(e) { confirmDeleteFullIccCard(getConfirmInfo()); });

$(document).on('click', 'button#approveIccCard', function(e) { confirmApproveIccCardStatus(getConfirmInfo()); });

$(document).on('click', 'button#doneIccCard', function(e) { confirmDoneIccCardStatus(getConfirmInfo()); });
// -------------------------------------------------------------------------------------------- End Click command.





// ******************************************************************************************** Method
// -------------------------------------------------------------------------------------------- AJAX
// ____________________________________________________________________________________________ Save
function saveIccCard() {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let dataType = $('input#dataType').val();
    
    let data = {                                // JSON Create.
        "dsIccCardMasterSerializeArray":    $('form#formIccCardMaster').serializeArray(),
        "dsContactInfo":                    queryContactInfoDataForSave(),
        "dsEntangledAnimal":                queryEntangledAnimalDataForSave(),
        "dsGarbageTransaction":             queryGarbageTransactionDataForSave()
    };

    // Ajax add or edit record.
    $.ajax({
        url: baseUrl + 'iccCard/ajaxSaveInputData',
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
                    window.location.href = baseUrl + "iccCard"
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
// ____________________________________________________________________________________________ End Save


// ____________________________________________________________________________________________ Click command.
function successDeleteFullIccCard() {
    window.location.href = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/iccCard";
}
function successApproveIccCardStatus() {
    $('span#iccCardStatus').text("กำลังดำเนินการ");
    $('button#approveIccCard').hide();
}
function successDoneIccCardStatus() {
    $('span#iccCardStatus').text("โครงการแล้วเสร็จ");
    $('button#doneIccCard').hide();
}
// ____________________________________________________________________________________________ End Click command.
// -------------------------------------------------------------------------------------------- AJAX



// -------------------------------------------------------------------------------------------- Initial Page
function initialPage() {
    if($('input[type=radio]#eventDistanceEtc').prop('checked')) {
        $('input[type=number]#eventDistanceEtc').prop('disabled', false);
    } else {
        $('input[type=number]#eventDistanceEtc').prop('disabled', true);
    }
}
// -------------------------------------------------------------------------------------------- End Initial Page





// -------------------------------------------------------------------------------------------- Tool
function getConfirmInfo() {
    let rData = {
        "iccCardId"     : $('input#iccCardId').val(),
        "projectName"   : $('input#projectName').val(),
        "provinceName"  : $('select#provinceCode :selected').text(),
        "eventDate"     : $('input#dtsEventDate').text(),
        "status"        : $('span#iccCardStatus').text()
    };

    return rData;
}