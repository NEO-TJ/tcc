//********************************************** Event *************************************************
//------------------------------------ Icc Card - Contact Info -----------------------------------------
$('table#tbContactInfo.table-components .add-elements').on('click', addNewRowContactInfoTable);
$('table#tbContactInfo.table-components').on("click", ".delete-elements", deleteRowContactInfoTable);


//********************************************* Method *************************************************
//------------------------------------- Icc Card - Contact Info ----------------------------------------
//______________________________________ Add new row of table __________________________________________
function addNewRowContactInfoTable() {
    cloneRowContactInfoTable();
    resetLastRowContactInfoTable();
}
// Clone row table with auto increment no
function cloneRowContactInfoTable() {
    var $clone = $("table#tbContactInfo.table-components tbody tr:first-child");

    $clone.find('.btn').removeClass('add-elements btn-default').addClass('delete-elements btn-danger')
        .html('<i class="fa fa-minus"></i>');
    $clone.find('td:first-child').html($('table#tbContactInfo.table-components tbody tr').length + 1);

    $clone.clone().appendTo('table#tbContactInfo.table-components tbody');

    $clone.find('td:first-child').html(1);
    $clone.find('.btn').removeClass('delete-elements btn-danger').addClass('add-elements btn-default')
        .html('<i class="fa fa-plus"></i>');
}


//________________________________________ Delete row of table _________________________________________
function deleteRowContactInfoTable() {
    $(this).closest("tr").remove();

    var n = 0;
    $('table#tbContactInfo.table-components tbody tr').each(function() {
        n++;
        $(this).find('td:first-child').html(n);
    });
}



//__________________________________ Reset Icc Card - Contact Info fill ________________________________
//------------------------------ Reset Icc Card - Contact Info input fill ------------------------------
function resetLastRowContactInfoTable(dsFullBom, i) {
    var currentTr = $('table#tbContactInfo.table-components tbody tr:last-child');

    currentTr.find('td input').val('');
}



//__________________________________________ Query data for save _______________________________________
function queryContactInfoDataForSave(){
	let dsSave = new Array();
	$('table#tbContactInfo tbody tr').each(function(i, row) {
		let rowContactInfo = {
            'id': 		$(this).find('td:nth-child(6) button#contactInfoId').val(),
            'Name': 	$(this).find('td:nth-child(3) input#contactName').val(),
            'Email': 	$(this).find('td:nth-child(5) input#email').val(),
        };
        dsSave.push(rowContactInfo);
    });
    dsSave = ( ( (dsSave.length == 1) && IsEmpty(dsSave[0]['Name']) ) ? null : dsSave);
    
	return dsSave;
}
