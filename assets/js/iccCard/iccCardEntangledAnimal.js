//********************************************** Event *************************************************
//------------------------------------ Icc Card - Entangled Animal -------------------------------------
$('table#tbEntangledAnimal.table-components .add-elements').on('click', addNewRowEntangledAnimalTable);
$('table#tbEntangledAnimal.table-components').on("click", ".delete-elements", deleteRowEntangledAnimalTable);


//********************************************* Method *************************************************
//------------------------------------- Icc Card - Entangled Animal ------------------------------------
//______________________________________ Add new row of table __________________________________________
function addNewRowEntangledAnimalTable() {
    cloneRowEntangledAnimalTable();
    resetLastRowEntangledAnimalTable();
}
// Clone row table with auto increment no
function cloneRowEntangledAnimalTable() {
    var $clone = $("table#tbEntangledAnimal.table-components tbody tr:first-child");

    $clone.find('.btn').removeClass('add-elements btn-default').addClass('delete-elements btn-danger')
        .html('<i class="fa fa-minus"></i>');
    $clone.find('td:first-child').html($('table#tbEntangledAnimal.table-components tbody tr').length + 1);

    $clone.clone().appendTo('table#tbEntangledAnimal.table-components tbody');

    $clone.find('td:first-child').html(1);
    $clone.find('.btn').removeClass('delete-elements btn-danger').addClass('add-elements btn-default')
        .html('<i class="fa fa-plus"></i>');
}


//________________________________________ Delete row of table _________________________________________
function deleteRowEntangledAnimalTable() {
    $(this).closest("tr").remove();

    var n = 0;
    $('table#tbEntangledAnimal.table-components tbody tr').each(function() {
        n++;
        $(this).find('td:first-child').html(n);
    });
}



//__________________________________ Reset Icc Card - Entangled Animal fill ____________________________
//------------------------------ Reset Icc Card - Entangled Animal input fill --------------------------
function resetLastRowEntangledAnimalTable(dsFullBom, i) {
    var currentTr = $('table#tbEntangledAnimal.table-components tbody tr:last-child');

    currentTr.find('td select').val(0);
    currentTr.find('td input').val('');
    currentTr.find('td input[type="checkbox"]').prop('checked', false);
}



//__________________________________________ Query data for save _______________________________________
function queryEntangledAnimalDataForSave(){
	var dsSave = new Array();
	$('table#tbEntangledAnimal tbody tr').each(function(i, row) {
		var rowEntangledAnimal = {
            'id': 		            $(this).find('td:nth-child(8) button#entangledAnimalId').val(),
            'Name': 	            $(this).find('td:nth-child(2) input#animalName').val(),
            'FK_Animal_status': 	$(this).find('td:nth-child(3) select#animalStatus :selected').val(),
            'Entangled_Flag' :      (($(this).find('td:nth-child(4) input#entangledFlag').prop('checked'))? 1: 0),
            'Entangled_Debris':     $(this).find('td:nth-child(7) input#entangledDebris').val(),
        };
        dsSave.push(rowEntangledAnimal);
    });
    dsSave = ( ((dsSave.length == 1) && IsEmpty(dsSave[0]['Name']) ) ? null : dsSave);
    
	return dsSave;
}
