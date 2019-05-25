/*
Template Name: Admin Press Admin
Author: Themedesigner
Email: niravjoshi87@gmail.com
File: js
*/
$(function () {
    "use strict";
    // ============================================================== 
    // Product chart
    // ============================================================== 
    Morris.Area({
        element: 'morris-area-chart2',
        data: [{
            period: '2010',
            Masuk: 0,
            
        }, {
            period: '2011',
            Masuk: 130,
            
        }, {
            period: '2012',
            Masuk: 30,
            
        }, {
            period: '2013',
            Masuk: 30,
            iPhone: 200,
            
        }, {
            period: '2014',
            Masuk: 200,
            
        }, {
            period: '2015',
            Masuk: 105,
            
        },
         {
            period: '2016',
            Masuk: 250,
           
        }],
        xkey: 'period',
        ykeys: ['Masuk'],
        labels: ['Masuk'],
        pointSize: 0,
        fillOpacity: 0.4,
        pointStrokeColors:[ '#01c0c8'],
        behaveLikeLine: true,
        gridLineColor: '#e0e0e0',
        lineWidth: 0,
        smooth: true,
        hideHover: 'auto',
        lineColors: [ '#01c0c8'],
        resize: true
        
    });
   // ============================================================== 
   // Morris donut chart
   // ==============================================================       
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Diambil",
            value: 8500,

        }, {
            label: "Masuk",
            value: 3630,
        }, {
            label: "Selesai",
            value: 4870
        }],
        resize: true,
        colors:['#26c6da', '#1976d2', '#ef5350']
    });
    // ============================================================== 
    // sales difference
    // ==============================================================
    
    // ============================================================== 
    // sparkline chart
    // ==============================================================
    var sparklineLogin = function() { 
       $('#sparklinedash').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#26c6da'
        });
         $('#sparklinedash2').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#7460ee'
        });
          $('#sparklinedash3').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#03a9f3'
        });
           $('#sparklinedash4').sparkline([ 0, 5, 6, 10, 9, 12, 4, 9], {
            type: 'bar',
            height: '50',
            barWidth: '2',
            resize: true,
            barSpacing: '5',
            barColor: '#f62d51'
        });
       
   }
    var sparkResize;
 
        $(window).resize(function(e) {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineLogin, 500);
        });
        sparklineLogin();
});

