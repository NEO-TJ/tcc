//********************************************* Method *************************************************
//--------------------------------- Icc Card - Garbage Transacton --------------------------------------
//_______________________________________ Query data for save __________________________________________
function queryGarbageTransactionDataForSave(){
    let dsSerializeArray = $('form#formGarbageTransaction').serializeArray();
    dsSerializeArray = dsSerializeArray.filter(function(jsonObject) {
        return jsonObject.value != 0;
    });

    let dsGarbageTransaction = new Array();
    let arrSplit = new Array();
    $(dsSerializeArray).each(function(index, value) {
        arrSplit = value.name.substring(5).split(";");

        let rowGarbageTransaction = {
            'id':           arrSplit[1],
            'FK_Garbage':   arrSplit[0],
            'Garbage_Qty':  value.value,
            'Active':       1,
        }
        dsGarbageTransaction.push(rowGarbageTransaction);
    });
    dsGarbageTransaction = ( (dsGarbageTransaction.length == 0) ? null : dsGarbageTransaction);

    return dsGarbageTransaction;
}
