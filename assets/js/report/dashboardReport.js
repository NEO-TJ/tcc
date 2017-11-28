// ******************************************************************************************** Event.
// -------------------------------------------------------------------------------------------- Page Load.
$(document).ready(function() {
    initDaterange();
    initPageLoad();
    CreateDashboardReport();
});

// -------------------------------------------------------------------------------------------- Init DatetimePicker.
function initDaterange() {
    var start = moment().subtract(1, 'year').startOf('year');
    var end = moment();

    function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#daterange').daterangepicker({
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

            'Last 5 Year': [moment().subtract(5, 'year').startOf('year')
            , moment().subtract(1, 'year').endOf('year')],
            'Last 10 Year': [moment().subtract(10, 'year').startOf('year')
            , moment().subtract(1, 'year').endOf('year')]
        }
    }, cb);

    cb(start, end);
}

// -------------------------------------------------------------------------------------------- Force AJAX.
$('#genReport').on('click', function(e) { CreateDashboardReport(); });
// -------------------------------------------------------------------------------------------- Select input
$('select#provinceCode').on('change', function(e) { ChangeProvince(e); });
// ******************************************************************************************** End Event.





// ******************************************************************************************** AJAX.
function CreateDashboardReport() {
    picker = $('#daterange').data('daterangepicker');
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let rankingLimit = $("input[name='rankingLimit']:checked").val();
    let strDateStart = picker.startDate.format('YYYY-MM-DD');
    let strDateEnd = picker.endDate.format('YYYY-MM-DD');
    let provinceCode = $('select#provinceCode :selected').val();
    let iccCardId = $('select#iccCardId :selected').val();

    let data = {
        'rankingLimit'  : rankingLimit,
        'strDateStart'  : strDateStart,
        'strDateEnd'    : strDateEnd,
        'provinceCode'  : provinceCode,
        'iccCardId'     : iccCardId
    }

    // Get dashboard report by ajax.
    $.ajax({
        url: baseUrl + 'report/ajaxGetDashboardReportData',
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function(){},
        error: function(xhr, textStatus){
            swal("Error", textStatus + xhr.responseText, "error");
        },
        complete: function(){},
        success: function(result) {
            renderMarkerMapPlace(result.dsMarineDebrisEventMapPlace);
            renderChart(result);
            renderTable(result.dsMarineDebrisSinglePlace, result.dsMarineDebrisGroupingPlace);
        }
    });
}

// ____________________________________________________________________________________________ Province
function ChangeProvince(e) {
    let baseUrl = window.location.origin + "/" + window.location.pathname.split('/')[1] + "/";
    let provinceCode = $('select#provinceCode :selected').val();

    let data = { 'provinceCode': provinceCode };

    // Get project name filtered with province code by ajax.
    $.ajax({
        url: baseUrl + 'report/ajaxGetProjectFiltered',
        type: 'post',
        data: data,
        dataType: 'json',
        beforeSend: function() {},
        error: function(xhr, textStatus) {
            swal("Error", textStatus + xhr.responseText, "error");
        },
        complete: function() {},
        success: function(result) {
            setSelectElementOfProject(result, $('select#iccCardId'));
        }
    });
}
// ******************************************************************************************** End AJAX.





// ******************************************************************************************** Method.
// ____________________________________________________________________________________________ Map.
function renderMarkerMapPlace(data) {
    //Removing already Added Markers//////////
    for(let i=0; i < markers_map.length; i++){
        markers_map[i].setMap(null);
    }
    markers_map = new Array();
    //////////////////////////////////////////
    // Adding New Markers////////////////////
    $.each(data, function(index, value) {
        let lat = parseFloat(value.Lat);
        let lng = parseFloat(value.Lon);
        let myLatlng = new google.maps.LatLng(lat,lng);

        let marker = {
            map                 : map,
            position            : myLatlng, // These are the minimal Options, you can add others too
            title               : value.Project_Name,
            infowindow_open     : true,
            infowindow_content  : value.Project_Name + "<p>" + value.sumQty,
        };
        createMarker_map(marker);
    });
}
// ____________________________________________________________________________________________ End Map.


// ____________________________________________________________________________________________ Render Charts.
function renderChart(rDsData) {
    let rDataChart = PrepareDataToChart(rDsData.dsMarineDebrisGroupingPlace
                                    , rDsData.placeCount, rDsData.rankingLimit);

    FusionCharts.ready(function () {
        var marineDebrisSinglePlaceChart = new FusionCharts({
            "type": "pie3d",
            "renderAt": "marineDebrisSinglePlaceChart",
            "width": "100%",
            "height": "450",
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
                    "formatNumber": "1",
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
                "data": rDsData.dsMarineDebrisSinglePlace
            }
        }).render();

        var marineDebrisGroupingPlaceChart = new FusionCharts({
            "type": "scrollstackedcolumn2d", //"stackedcolumn3d",
            "renderAt": "marineDebrisPlaceGroupChart",
            "width": "100%",
            "height": "650",
            "dataFormat": "json",
            "dataSource": {
                "chart": {
                    "caption": "รายงานปริมาณขยะทะเล 10 อันดับในแต่ละสถานที่",
                    "subCaption": "",
                    "xAxisName": "สถานที่",
                    "yAxisName": "จำนวน",
                    "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                    "bgColor": "#ffffff",
                    "showBorder": "0",
                    "use3DLighting": "0",
                    "showShadow": "0",
                    "enableSmartLabels": "1",
                    "startingAngle": "0",
                    "showsum": "1",
                    "showValue" : "1", 
                    "showPercentValues": "0",
                    "showPercentInTooltip": "1",
                    "formatNumber": "1",
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
                "categories": [{"category" : rDataChart.category}],
                "dataset" : rDataChart.dataset
            }
        }).render();
    });
}
function PrepareDataToChart(dsMarineDebrisGroupingPlace, placeCount, rankingLimit) {
    let dataset = new Array();
    let rCategory = new Array();
    let rDataRanking = new Array();
    for(let i=0; i<rankingLimit; i++) { rDataRanking[i] = {"value" : 0}; }

    let iRanking = 0;
    let placeOrder = -1;
    let placeName = "This is null.";

    $.each(dsMarineDebrisGroupingPlace, function(index, value) {
        if(value.PlaceName == placeName) {
            if(iRanking < rankingLimit) {
                rDataRanking[iRanking][placeOrder] = {"value" : value.sumQty};
            }
        } else {
            if( (iRanking > 0) && (iRanking < rankingLimit) && (placeOrder >= 0) ) {
                for( ; iRanking < rankingLimit; iRanking++) { rDataRanking[iRanking][placeOrder] = {"value" : 0}; }
            }
            iRanking = 0;
            placeOrder++;
            placeName = value.PlaceName;

            rCategory.push({"label" : value.PlaceName});
            rDataRanking[iRanking][placeOrder] = {"value" : value.sumQty};
        }
        iRanking++;
    });
    for(let i = 0; i < rDataRanking.length; i++) {
        dataset.push({"seriesname" : "อันดับที่ " + (i+1), "data" : rDataRanking[i]});
    }
    result = {
        "category" : rCategory, 
        "dataset" : dataset, 
    };

    return result;
}
// ____________________________________________________________________________________________ End Render Charts.


// ____________________________________________________________________________________________ Table.
function renderTable(dsMarineDebrisSinglePlace, dsMarineDebrisGroupingPlace) {
    $('table#marineDebrisSinglePlaceTable > tbody').html(genTableSinglePlace(dsMarineDebrisSinglePlace));
    $('table#marineDebrisGroupingPlaceTable > tbody').html(genTableGroupPlace(dsMarineDebrisGroupingPlace));
}

// ----------- Generate Table SinglePlace Place.
function genTableSinglePlace(data) {
	let htmlTable = "";
    
    let rankingLimit = $("input[name='rankingLimit']:checked").val();
    let placeName = ( ($('select#provinceCode :selected').val() == 0) 
        ? "ประเทศไทย" : $('select#provinceCode :selected').text());
    let summaryMarineDebrisQty = 0;
    let row;

    for(let i=0; i<data.length; i++) {
        row = data[i];

        htmlTable += genData(placeName, row["label"], row["value"], "", i+1);
        summaryMarineDebrisQty = parseInt(summaryMarineDebrisQty) + parseInt(row["value"]);

        placeName = "";
    }

    htmlTable += ( (rankingLimit == 10) 
        ? genSummary(summaryMarineDebrisQty, false)
        : genSummary(false, summaryMarineDebrisQty) );
    
    return htmlTable;
}
// ----------- End Generate Table Summary Place.
// ----------- Generate Table By Place.
function genTableGroupPlace(data) {
	let htmlTable = "";
    
    let rankingLimit = $("input[name='rankingLimit']:checked").val();
    let totalTopTenMarineDebrisQty = 0;
    let totalMarineDebrisQty = 0;
    let placeName = "";
    let placeOrder = 1;
    let iRanking = 0;
	let row;
	for(let i=0; i<data.length; i++) {
        row = data[i];

        if(row["PlaceName"] == placeName) {
            if(iRanking < rankingLimit) {
                row["PlaceName"] = "";
                htmlTable += genData(row["PlaceName"], row["Name"], row["sumQty"], "", iRanking+1);
                totalTopTenMarineDebrisQty = parseInt(totalTopTenMarineDebrisQty) + parseInt(row["sumQty"]);
            }
        } else {
            if(iRanking > 0) {
                htmlTable += genSummary( ((rankingLimit == 10) ? totalTopTenMarineDebrisQty : false)
                    , totalMarineDebrisQty);
                totalMarineDebrisQty = 0;
                totalTopTenMarineDebrisQty = 0;
            }

            iRanking = 0;
            placeName = row["PlaceName"];
            htmlTable += genData(row["PlaceName"], row["Name"], row["sumQty"], placeOrder++, iRanking+1);
            totalTopTenMarineDebrisQty = parseInt(totalTopTenMarineDebrisQty) + parseInt(row["sumQty"]);
        }
    
        totalMarineDebrisQty = parseInt(totalMarineDebrisQty) + parseInt(row["sumQty"]);
        iRanking++;
    }
    if(iRanking > 0) {
        htmlTable += genSummary( ((rankingLimit == 10) ? totalTopTenMarineDebrisQty : false), totalMarineDebrisQty);
    }

    return htmlTable;
}
// ----------- End Generate Table By Place.

// ----------- End Generate Table Row.
function genData(placeName, marineDebrisName, marineDebrisQty, placeOrder, marineDebrisOrder) {
	let htmlTable;

    htmlTable +='<tr>';
    htmlTable +='<td class="text-right">' + placeOrder + '</td>';
    htmlTable +='<td class="text-left">' + placeName + '</td>';
    htmlTable +='<td class="text-right">' + marineDebrisOrder + '.</td>';
    htmlTable +='<td class="text-left">' + marineDebrisName + '</td>';
	htmlTable +='<td class="text-right">' + marineDebrisQty.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,") + '</td>';
	htmlTable +='</tr>';

	return htmlTable;
}
function genSummary(summaryTopTenMarineDebrisQty, summaryMarineDebrisQty) {
	let htmlTable;
    // Top 10 marine debris.
    if(summaryTopTenMarineDebrisQty != false) {
        htmlTable +='<tr class="bg-warning color-table-sum">';
        htmlTable +='<td class="text-right"></td>';
        htmlTable +='<td class="text-left"></td>';
        htmlTable +='<td class="text-right"></td>';
        htmlTable +='<td class="text-left">';
        htmlTable +='<h5><u><mark><strong><em>';
        htmlTable +='<abbr>';
        htmlTable +='ผลรวมปริมาณขยะ 10 อันดับแรก';
        htmlTable +='</abbr>';
        htmlTable +='</em></strong></mark></u><h5>';
        htmlTable +='</td>';
        htmlTable +='<td class="text-right">' 
        htmlTable +='<h5><u><mark><strong><em>';
        htmlTable +='<abbr title="Total Top 10 marine debris">';
        htmlTable +=summaryTopTenMarineDebrisQty.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
        htmlTable +='</abbr>';
        htmlTable +='</em></strong></mark></u><h5>';
        htmlTable +='</td>';
        htmlTable +='</tr>';
    }
    // Top 10 marine debris.
    if(summaryMarineDebrisQty != false) {
        htmlTable +='<tr class="bg-warning color-table-sum">';
        htmlTable +='<td class="text-right"></td>';
        htmlTable +='<td class="text-left"></td>';
        htmlTable +='<td class="text-right"></td>';
        htmlTable +='<td class="text-left">';
        htmlTable +='<h5><u><mark><strong><em>';
        htmlTable +='<abbr>';
        htmlTable +='ผลรวมปริมาณขยะทั้งหมด';
        htmlTable +='</abbr>';
        htmlTable +='</em></strong></mark></u><h5>';
        htmlTable +='</td>';
        htmlTable +='<td class="text-right">' 
        htmlTable +='<h5><u><mark><strong><em>';
        htmlTable +='<abbr title="Total marine debris">';
        htmlTable +=summaryMarineDebrisQty.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
        htmlTable +='</abbr>';
        htmlTable +='</em></strong></mark></u><h5>';
        htmlTable +='</td>';
        htmlTable +='</tr>';
    }
	
	return htmlTable;
}
// ----------- End Generate Table Row.
// ____________________________________________________________________________________________ End Table.
// ******************************************************************************************** End Method.





// -------------------------------------------------------------------------------------------- Tool.
// ____________________________________________________________________________________________ Set Select Elecment 
function setSelectElementOfProject(dataSet, $selector) {
    $selector.empty();
    $selector.append('<option value="0">ทุกโครงการ...</option>');
    for (var i = 0; i < dataSet.length; i++) {
        $selector.append('<option value="' + dataSet[i].id + '">' + dataSet[i].Project_Name + '</option>');
    }
}



// ____________________________________________________________________________________________ Initial Page load.
function initPageLoad() {
    $('select#provinceCode').trigger('change');
}
// ____________________________________________________________________________________________ End Initial Page load.
// -------------------------------------------------------------------------------------------- End Tool.