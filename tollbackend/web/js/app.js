/**
 * Created by admin on 5/18/2016.
 */

$(document).ready(function(){
    $(".but").click(function(){
        $(".google-map-overlay").toggleClass("moh");
        $(".grid").toggleClass("moh1");
        $(".but").toggleClass("but1");
    });
});


$(document).ready(function(){
    $(".direction-but").click(function(){
        if($('#state').css('display') == 'block') {
            $('#state').css('display', 'none');
            $('#direction').css('display', 'block');
        }
        else {
            $('#state').css('display', 'block');
            $('#direction').css('display', 'none');
        }
        $(".direction-but").toggleClass("direction-but1");
    });
});

var saveAs = null;
var FusionCharts = null;
var chart = c3.generate({
   bindto: '#chart',
        data: {
          columns: [
            ['Tollered vechicals', 4985],
            ['Tollered With Errors', 285],
            ['Wrong Entries', 123]
//           ['data1', 30, 200, 100, 400, 150, 250],
//           ['data2', 130, 100, 140, 200, 150, 50]
          ],
          type: 'bar',
          onclick: function (d, element) { console.log("onclick", d, element); },
          onmouseover: function (d) { console.log("onmouseover", d); },
          onmouseout: function (d) { console.log("onmouseout", d); }
        },
        axis: {
          x: {
            type: 'categorized'
          }
        },
        bar: {
          width: {
            ratio: 0.1,
//            max: 30
          },
        }
      });
      var vchart = c3.generate({
          bindto: '#vchart',
        data: {
          columns: [
            ['Bike', 10],
            ['Jeep/van', 32],
            ['LCV', 22],
            ['Bus/Truck', 6],
            ['Upto 3 Axle', 41],
            ['4to6 Axle', 15],
            ['HCM/EME', 25],
            ['7 or More Axle', 16]
//           ['data1', 30, 200, 100, 400, 150, 250],
//           ['data2', 130, 100, 140, 200, 150, 50]
          ],
          type: 'bar',
          onclick: function (d, element) { console.log("onclick", d, element); },
          onmouseover: function (d) { console.log("onmouseover", d); },
          onmouseout: function (d) { console.log("onmouseout", d); }
        },
        axis: {
          x: {
            type: 'categorized'
          }
        },
        bar: {
          width: {
            ratio: 0.1,
//            max: 30
          },
        }
      });