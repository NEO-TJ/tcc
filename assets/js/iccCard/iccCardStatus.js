// ******************************************************************************************** Method.
// -------------------------------------------------------------------------------------------- Click command.
function confirmDeleteFullIccCard(rData) {
    swal({
        title: "โปรดยืนยันการลบข้อมูล",
        html: '<div class="container">'
            + '<div class="text-left">ชื่อโครงการ : ' + rData.projectName + '</div>'
            + '<div class="text-left">จังหวัด : ' + rData.provinceName + '</div>'
            + '<div class="text-left">วันที่ทำกิจกรรม : ' + rData.eventDate + '</div>'
            + '<div class="text-left">สถานะปัจจุบันของกิจกรรม : ' + rData.status + '</div></div>',
        type: "warning",
        showConfirmButton: true,
        showCancelButton: true,
        focusCancel: true,
        allowEnterKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'ยืนยัน!',
        cancelButtonText: "ยกเลิก",
        confirmButtonClass: 'btn btn-danger',
        closeOnConfirm: false,
        closeOnCancel: false,
    })
    .then((result) => {
        if(result) {
            deleteFullIccCard(rData.iccCardId);
        } else if (result.dismiss === 'cancel') {
            swal(
                'ยกเลิกการลบข้อมูล'
            )
        }
    });
}
function confirmApproveIccCardStatus(rData) {
    swal({
        title: "โปรดยืนยันการอนุมัติ",
        html: '<div class="container">'
            + '<div class="text-left">ชื่อโครงการ : ' + rData.projectName + '</div>'
            + '<div class="text-left">จังหวัด : ' + rData.provinceName + '</div>'
            + '<div class="text-left">วันที่ทำกิจกรรม : ' + rData.eventDate + '</div>'
            + '<div class="text-left">สถานะปัจจุบันของกิจกรรม : ' + rData.status + '</div></div>',
        type: "question",
        showConfirmButton: true,
        showCancelButton: true,
        focusCancel: true,
        allowEnterKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false,
        confirmButtonText: 'ยืนยัน!',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: false,
    })
    .then((result) => {
        if(result) {
            approveIccCardStatus(rData.iccCardId);
        } else if (result.dismiss === 'cancel') {
            swal(
                'ยกเลิกการอนุมัติโครงการ'
            )
        }
    });
}
function confirmDoneIccCardStatus(rData) {
    swal({
        title: "โปรดยืนยันการ เสร็จสิ้น ของโครงการ",
        html: '<div class="container">'
                + '<div class="text-left">ชื่อโครงการ : ' + rData.projectName + '</div>'
                + '<div class="text-left">จังหวัด : ' + rData.provinceName + '</div>'
                + '<div class="text-left">วันที่ทำกิจกรรม : ' + rData.eventDate + '</div>'
                + '<div class="text-left">สถานะปัจจุบันของกิจกรรม : ' + rData.status + '</div>'
            + '</div>',
        type: "question",
        showConfirmButton: true,
        showCancelButton: true,
        focusCancel: true,
        allowEnterKey: false,
        allowOutsideClick: false,
        closeOnConfirm: false,
        confirmButtonText: 'ยืนยัน!',
        cancelButtonText: "ยกเลิก",
        closeOnConfirm: false,
        closeOnCancel: false,
    })
    .then((result) => {
        if(result) {
            doneIccCardStatus(rData.iccCardId);
        } else if (result.dismiss === 'cancel') {
            swal(
                "ยกเลิกการบันทึกสถานะ 'เสร็จสิ้น' ของโครงการ"
            )
        }
    });
}
// -------------------------------------------------------------------------------------------- End Click command.



// -------------------------------------------------------------------------------------------- AJAX.
function deleteFullIccCard(iccCardId) {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let data = { "iccCardId": iccCardId };              // JSON Create.
    
    // Ajax add or edit record.
    $.ajax({
        url: baseUrl + 'iccCard/ajaxDeleteFullIccCard',
        type: 'post',
        data: data,
        beforeSend: function() {
            swal({
                title: "บันทึกข้อมูล...",
                text: '<span class="text-info"><i class="fa fa-refresh fa-spin"></i> กำลังดำเนินการ กรุณารอซักครู่...</span>',
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
                    title: "ดำเนินการเรียบร้อย!",
                    text: "ข้อมูลถูกลบออกจากระบบแล้ว",
                    type: "success",
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonText: "Done",
                    confirmButtonClass: "btn btn-success",
                }).then(function() {
                    successDeleteFullIccCard();
                });
            } else {
                swal({
                    title: "ไม่สำเร็จ!",
                    text: "เกิดความผิดพลาดในการลบข้อมูลจากระบบ กรุณาลองใหม่อีกครั้ง"
                        + "\n\n\n\n\n\n\n\n\n\n" + result,
                    type: "error",
                    confirmButtonColor: "#DD6B55"
                });
            }
        }
    });
}
function approveIccCardStatus(iccCardId) {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let data = { "iccCardId": iccCardId };              // JSON Create.

    // Ajax add or edit record.
    $.ajax({
        url: baseUrl + 'iccCard/ajaxApproveIccCardStatus',
        type: 'post',
        data: data,
        beforeSend: function() {
            swal({
                title: "บันทึกข้อมูล...",
                text: '<span class="text-info"><i class="fa fa-refresh fa-spin"></i> กำลังดำเนินการ กรุณารอซักครู่...</span>',
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
                    title: "ดำเนินการเรียบร้อย!",
                    text: "ข้อมูลถูกบันทึกในระบบเรียบร้อยแล้ว",
                    type: "success",
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonText: "Done",
                    confirmButtonClass: "btn btn-success",
                }).then(function() {
                    successApproveIccCardStatus();
                });
            } else {
                swal({
                    title: "ไม่สำเร็จ!",
                    text: "เกิดความผิดพลาดในการบันทึกข้อมูลในระบบ กรุณาลองใหม่อีกครั้ง"
                        + "\n\n\n\n\n\n\n\n\n\n" + result,
                    type: "error",
                    confirmButtonColor: "#DD6B55"
                });
            }
        }
    });
}
function doneIccCardStatus(iccCardId) {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let data = { "iccCardId": iccCardId };              // JSON Create.

    // Ajax add or edit record.
    $.ajax({
        url: baseUrl + 'iccCard/ajaxDoneIccCardStatus',
        type: 'post',
        data: data,
        beforeSend: function() {
            swal({
                title: "บันทึกข้อมูล...",
                text: '<span class="text-info"><i class="fa fa-refresh fa-spin"></i> กำลังดำเนินการ กรุณารอซักครู่...</span>',
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
                    title: "ดำเนินการเรียบร้อย!",
                    text: "ข้อมูลถูกบันทึกในระบบเรียบร้อยแล้ว",
                    type: "success",
                    showCancelButton: false,
                    allowOutsideClick: false,
                    confirmButtonText: "Done",
                    confirmButtonClass: "btn btn-success",
                }).then(function() {
                    successDoneIccCardStatus();
                });
            } else {
                swal({
                    title: "ไม่สำเร็จ!",
                    text: "เกิดความผิดพลาดในการบันทึกข้อมูลในระบบ กรุณาลองใหม่อีกครั้ง"
                        + "\n\n\n\n\n\n\n\n\n\n" + result,
                    type: "error",
                    confirmButtonColor: "#DD6B55"
                });
            }
        }
    });
}
// -------------------------------------------------------------------------------------------- End AJAX.
// ******************************************************************************************** End Method.