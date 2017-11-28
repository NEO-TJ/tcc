//************************************************ Helper **********************************************
// ********************************************** Variable *********************************************
const dltOK = 0; // Success
const dltValidate = 1; // Validate error


// *********************************************** Event ***********************************************
// --------------------------------------------- Page Load ---------------------------------------------
$(document).ready(function() {
    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(".startFocus").focus();
});

// Input numeric number element
$('input[type="number"]').on('keydown', function(e) {
    let allowDecimal = false;
    let allowNegative = false;

    if ( $(this).hasClass("allow-decimal-negative") ) {
        allowDecimal = true;
        allowNegative = true;
    } else if ( $(this).hasClass("allow-decimal") ) {
        allowDecimal = true;
    } else if ( $(this).hasClass("allow-negative") ) {
        allowNegative = true;
    }

    NumericFilter(e, this, allowDecimal, allowNegative);
});




// *********************************************** Method **********************************************
// Dialog Show
function ShowDialog($type) {
    if ($type == dltOK) {

    } else if ($type == dltValidate) {
        swal("Warning", "Please check your input key.", "warning");
    }
}


// Normal numeric input
function NumericFilter(e, obj, allowDecimal, allowNegative) {
    if ((([e.keyCode || e.which] >= 48) && ([e.keyCode || e.which] <= 57)) // Allow: 0-9
        ||
        (([e.keyCode || e.which] >= 96) && ([e.keyCode || e.which] <= 105)) // Allow: 0-9 Of Numpad
        ||
        ($.inArray(e.keyCode, [9, 13, 27, 116]) !== -1) // Allow: tab, enter(carriageReturn), escape, F5
        ||
        (e.keyCode >= 33 && e.keyCode <= 40) // Allow: 4arrow, home, end, Pg Up, Pg Dn
        ||
        ($.inArray(e.which, [8, 46]) !== -1) // Allow: backspace, delete
        ||
        ($.inArray(e.keyCode, [8, 46]) !== -1)) {
        return;
    } else if ( ([e.keyCode || e.which] == 190)
            || ([e.keyCode || e.which] == 110) ) { //Allow: '.' decimal point (at Numpad and Normal Keyboard)
        if (allowDecimal == true) {
            let val = obj.value;

            if (val.indexOf(".") > -1) {
                e.preventDefault();
            }
            return;
        }
        e.preventDefault();
    } else if ( ([e.keyCode || e.which] == 109)
            || ([e.keyCode || e.which] == 173) ) { // Allow: '-' (at Numpad and Normal keyboard)
        if (allowNegative == true) {
            let val = obj.value;

            if (val.indexOf("-") > -1) {
                e.preventDefault();
            }
            return;
        }
        e.preventDefault();
    } else {
        e.preventDefault();
        return;
    }
}


//----------------------------------------------- Validation -------------------------------------------
// Validate Empty variable of class require input
function ValidateInputRequire() {
    let result = false;
    let resultKeyInput = true;
    let resultSelectInput = true;

    $('input.input-require').each(function(i, obj) {
        // Check input data require has key?
        if (IsEmpty($(this).val())) {
            $(this).addClass('bg-error');
            resultKeyInput = false;
        } else {
            $(this).removeClass('bg-error');
        }
    });
    $('select.input-require').each(function(i, obj) {
        // Check input data require has selected?
        if ($(this).val() == 0) {
            $(this).addClass('bg-error');
            resultSelectInput = false;
        } else {
            $(this).removeClass('bg-error');
        }
    });

    result = (resultKeyInput && resultSelectInput) && ValidateInputRequireTableAllowEmpty();
    return result;
}
function ValidateInputRequireTableAllowEmpty() {
    let result = false;
    let resultInput = true;
    $('.input-require-parent').each(function() {
        let parentId = $(this).prop('id');
        let objChild = $('table#' + parentId + ' > tbody > tr > td > .input-require-child');

        if ( (objChild.length == 1) && ( (IsEmpty(objChild.val())) || (objChild.val() == 0)) ) {
            let objSibling = $('table#' + parentId + ' > tbody > tr > td > .input-require-sibling');

            objSibling.each(function() {
                if ($(this).is('input')) {
                    if(!IsEmpty($(this).val())) {
                        objChild.addClass('bg-error');
                        resultInput = false;
                        return false;
                    } else {
                        objChild.removeClass('bg-error');
                    }
                } else if ($(this).is('select')) {
                    if($(this).val() > 0) {
                        objChild.addClass('bg-error');
                        resultInput = false;
                        return false;
                    } else {
                        objChild.removeClass('bg-error');
                    }
                }
            });
        }
    });
    result = resultInput;

    return result;
}



// Check Empty variable of element
function IsEmpty(str) {
    return typeof str == 'string' && !str.trim() || typeof str == 'undefined' || str === null;
}
// Validate Empty variable of select element
function ValidateFillSelectElement(obj) {
    let result = false;
    let val = obj.find(':selected').val();

    if (val == 0) {
        obj.addClass('bg-error');
    } else {
        obj.removeClass('bg-error');
        result = true;
    }

    return result;
}
// Validate Empty variable of input element
function ValidateFillInputElement(obj, allowZero) {
    let result = false;
    let val = obj.val();

    if (IsEmpty(val)) {
        obj.addClass('bg-error');
    } else {
        obj.removeClass('bg-error');
        result = true;
    }

    return result;
}