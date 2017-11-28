//------------------------------------------------- Search ---------------------------------------------
$('form#formSearch').on('submit', function(e) {
    let iccCardId = $('select#iccCardId :selected').val();
    let dynamicFormAction = window.location.href.substr(0, window.location.href.lastIndexOf('/')) + "/" + iccCardId;
    $(this).attr('action', dynamicFormAction)
});