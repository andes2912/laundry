/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3 & 4
Version: 4.0.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v4.0/frontend/forum/
    ----------------------------
        APPS CONTENT TABLE
    ----------------------------
    
    <!-- ======== GLOBAL SCRIPT SETTING ======== -->
    01. Handle Header Navigation State
    02. Handle Pace Page Loading Plugins
    03. Handle Tooltip Activation
    04. Handle Theme Panel Expand
	
    <!-- ======== APPLICATION SETTING ======== -->
    Application Controller
*/


/* 01. Handle Header Navigation State
------------------------------------------------ */
var handleHeaderNavigationState = function() {
    $(window).on('scroll load', function() {
        if ($(window).scrollTop() > 20) {
            $('#header').addClass('navbar-sm');
        } else {
            $('#header').removeClass('navbar-sm');
        }
    });
};


/* 02. Handle Pace Page Loading Plugins
------------------------------------------------ */
var handlePaceLoadingPlugins = function() {
    Pace.on('hide', function(){
        setTimeout(function() {
            $('.pace').addClass('hide');
        }, 1000);
    });
};


/* 03. Handle Tooltip Activation
------------------------------------------------ */
var handleTooltipActivation = function() {
    if ($('[data-toggle=tooltip]').length !== 0) {
        $('[data-toggle=tooltip]').tooltip();
    }
};


/* 04. Handle Theme Panel Expand
------------------------------------------------ */
var handleThemePanelExpand = function() {
	$(document).on('click', '[data-click="theme-panel-expand"]', function() {
        var targetContainer = '.theme-panel';
        var targetClass = 'active';
        if ($(targetContainer).hasClass(targetClass)) {
            $(targetContainer).removeClass(targetClass);
        } else {
            $(targetContainer).addClass(targetClass);
        }
    });
};


/* 05. Handle Theme Page Control
------------------------------------------------ */
var handleThemePageControl = function() {
    if (Cookies && Cookies.get('theme')) {
        if ($('.theme-list').length !== 0) {
            $('.theme-list [data-theme]').closest('li').removeClass('active');
            $('.theme-list [data-theme="'+ Cookies.get('theme') +'"]').closest('li').addClass('active');
        }
        var cssFileSrc = $('[data-theme="'+ Cookies.get('theme') +'"]').attr('data-theme-file');
        $('#theme').attr('href', cssFileSrc, { expires: 365 });
    }
    
    $(document).on('click', '.theme-list [data-theme]', function() {
        var cssFileSrc = $(this).attr('data-theme-file');
        $('#theme').attr('href', cssFileSrc);
        $('.theme-list [data-theme]').not(this).closest('li').removeClass('active');
        $(this).closest('li').addClass('active');
        Cookies.set('theme', $(this).attr('data-theme'));
    });
};


/* Application Controller
------------------------------------------------ */
var App = function () {
	"use strict";
	
	return {
		//main function
		init: function () {
		    handleHeaderNavigationState();
		    handlePaceLoadingPlugins();
		    handleTooltipActivation();
		    handleThemePanelExpand();
		    handleThemePageControl();
		}
  };
}();