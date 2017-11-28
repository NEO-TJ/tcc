// ************************************************ Event **********************************************
// ---------------------------------------------- Page Load --------------------------------------------
$(document).ready(function() {
    CreateDetailRptData();
});




// -------------------------------------------------- AJAX ---------------------------------------------
// ________________________________________________ Daterange __________________________________________
function CreateDetailRptData() {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1];
    let strDateStart = $('input#strDateStart').val();
    let strDateEnd = $('input#strDateEnd').val();
    let provinceCode = $('input#provinceCode').val();

    let data = {
        'strDateStart'  : strDateStart,
        'strDateEnd'    : strDateEnd,
        'provinceCode'  : provinceCode,
    }

    // Get detail report by ajax.
    $.ajax({
        url: baseUrl + '/report/ajaxGetDetailReportData',
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function(){},
        error: function(xhr, textStatus){
            swal("Error", textStatus + xhr.responseText, "error");
        },
        complete: function(){},
        success: function(result) {
            renderTableMarineDebrisDetail(result.detailTableRpt);
            renderAllChart(result);
            //renderEventChart(result.detailEventChartRpt);
            //renderTopTenDetailChart(result.eventTopTenChartRpt);
        }
    });
}



// ________________________________________________ Charts _____________________________________________
function renderAllChart(data) {
    let detailEventChartRptData = CreateEventChartData(data["detailEventChartRpt"]);
    renderEventChart(detailEventChartRptData);
}
function CreateEventChartData(data) {
    let rCategory = Array();
    let rDataVolunteerQty = Array();
    let rDataMarineDebrisQty = Array();
    $.each(data, function(index, value) {
        rCategory.push({"label" : value.Project_Name});
        rDataVolunteerQty.push({"value" : value.Volunteer_Qty});
        rDataMarineDebrisQty.push({"value" : value.totalMarineDebris});
    });

    result = {
        "category" : rCategory, 
        "dataVolunteerQty" : rDataVolunteerQty, 
        "dataMarineDebrisQty" : rDataMarineDebrisQty
    };

    return result;
}
function renderEventChart(data) {
    FusionCharts.ready(function () {
        var marineDebrisColumnChart = new FusionCharts({
            "type": "mscolumn3d",
            "renderAt": "marineDebrisDetailColumnChart",
            "width": "100%",
            "height": "400",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                    "caption": "กราฟแท่งชนิดของข้อมูลขยะทะเล 10 อันดับแรกในประเทศไทย",
                    "subCaption": "",
                    "xAxisName": "กิจกรรมจำแนกตามโครงการ",
                    "yAxisName": "จำนวน",
                    "paletteColors": "#0075c2,#1aaf5d,#f2c500",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "use3DLighting": "0",
                    "showShadow": "0",
                    "enableSmartLabels": "1",
                    "startingAngle": "0",
                    "showValue" : "1", 
                    "showPercentValues": "0",
                    "showPercentInTooltip": "1",
                    "decimals": "1",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "0",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "showHoverEffect": "1",
                    "showLegend": "1",
                    "legendBgColor": "#ffffff",
                    "legendBorderAlpha": "0",
                    "legendShadow": "0",
                    "legendItemFontSize": "10",
                    "legendItemFontColor": "#666666",
                    "useDataPlotColorForLabels": "1"
                },
                "categories": [{"category" : data["category"]}],
                "dataset" : [
                    {
                        "seriesname" : "จำนวนอาสาสมัคร",
                        "data" : data["dataVolunteerQty"]
                    },
                    {
                        "seriesname" : "จำนวนขยะทะเล",
                        "data" : data["dataMarineDebrisQty"]
                    }
                ]
            }
        }).render();
    });
}

function renderTopTenDetailChart(data) {
    FusionCharts.ready(function () {
        var marineDebrisPieChart = new FusionCharts({
            "type": "pie3d",
            "renderAt": "marineDebrisDetailPieChart",
            "width": "100%",
            "height": "400",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                    "caption": "แผนภาพวงกลมชนิดของข้อมูลขยะทะเล 10 อันดับแรกในประเทศไทย",
                    "subCaption": "",
                    "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "use3DLighting": "0",
                    "showShadow": "0",
                    "enableSmartLabels": "1",
                    "startingAngle": "0",
                    "showValue" : "1", 
                    "showPercentValues": "0",
                    "showPercentInTooltip": "1",
                    "decimals": "1",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0",
                    "toolTipColor": "#ffffff",
                    "toolTipBorderThickness": "0",
                    "toolTipBgColor": "#000000",
                    "toolTipBgAlpha": "80",
                    "toolTipBorderRadius": "2",
                    "toolTipPadding": "5",
                    "showHoverEffect": "1",
                    "showLegend": "1",
                    "legendBgColor": "#ffffff",
                    "legendBorderAlpha": "0",
                    "legendShadow": "0",
                    "legendItemFontSize": "10",
                    "legendItemFontColor": "#666666",
                    "useDataPlotColorForLabels": "1"
                },
                "data": data
            }
        }).render();
    });
}

// ________________________________________________ Table ______________________________________________
function renderTableMarineDebrisDetail(data) {
    $('table#marineDebrisDetailTable > tbody').html(getTable(data));
}
function getTable(data) {
	let htmlTable = "";
    
    let projectName = "";
    let projectOrder = 1;
    let limit = 0;
	let row;
	for(let i=0; i<data.length; i++)
	{
        row = data[i];
        if(row["Project_Name"] == projectName) {
            row["Project_Name"] = "";
            row["Volunteer_Qty"] = "";
            htmlTable += genData(row, "", limit+1);
        } else {
            limit = 0;
            projectName = row["Project_Name"];
            htmlTable += genData(row, projectOrder++, limit+1);
        }
    
        limit++;
	}

    return htmlTable;
}
function genData(row, projectOrder, marineDebrisOrder) {
	let htmlTable;
	
    htmlTable +='<tr>';
    htmlTable +='<td class="text-right">' + projectOrder + '</td>';
    htmlTable +='<td class="text-left">' + row['Project_Name'] + '</td>';
    htmlTable +='<td class="text-right">' + row['Volunteer_Qty'] + '</td>';
    htmlTable +='<td class="text-right">' + marineDebrisOrder + '.</td>';
    htmlTable +='<td class="text-left">' + row['Name'] + '</td>';
	htmlTable +='<td class="text-right">' + row['sumQty'].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</td>';
	htmlTable +='</tr>';
	
	return htmlTable;
}