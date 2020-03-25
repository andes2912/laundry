/*
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3 & 4
Version: 4.0.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v4.0/frontend/e-commerce/
    ----------------------------
        APPS CONTENT TABLE
    ----------------------------
    
    <!-- ======== GLOBAL SCRIPT SETTING ======== -->
    01. Handle Fixed Header Option
    02. Handle Page Container Show
    03. Handle Pace Page Loading Plugins
    04. Handle Tooltip Activation
    05. Handle Theme Panel Expand
    06. Handle Theme Page Control
    07. Handle Payment Type Selection
    08. Handle Checkout Qty Control
    09. Handle Product Image
	
    <!-- ======== APPLICATION SETTING ======== -->
    Application Controller
*/



/* 01. Handle Fixed Header Option
------------------------------------------------ */
var handleHeaderFixedTop = function() {
    if ($('#header[data-fixed-top="true"]').length !== 0) {
        $(window).on('scroll', function() {
        	var targetScrollTop = ($(window).width() >= 1920) ? 48 : 40;
        	var targetPaddingTop = ($(window).width() >= 1920) ? '100px' : '76px';
            if ($(window).scrollTop() >= targetScrollTop) {
                $('body').css('padding-top', targetPaddingTop);
                $('#header').addClass('header-fixed');
            } else {
                $('#header').removeClass('header-fixed');
                $('body').css('padding-top', '0');
            }
        });
    }
};


/* 02. Handle Page Container Show
------------------------------------------------ */
var handlePageContainerShow = function() {
    $('#page-container').addClass('in');
};


/* 03. Handle Pace Page Loading Plugins
------------------------------------------------ */
var handlePaceLoadingPlugins = function() {
    Pace.on('hide', function(){
        setTimeout(function() {
            $('.pace').addClass('hide');
        },500);
    });
};


/* 04. Handle Tooltip Activation
------------------------------------------------ */
var handleTooltipActivation = function() {
    if ($('[data-toggle=tooltip]').length !== 0) {
        $('[data-toggle=tooltip]').tooltip();
    }
};


/* 05. Handle Theme Panel Expand
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


/* 06. Handle Theme Page Control
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


/* 07. Handle Payment Type Selection
------------------------------------------------ */
var handlePaymentTypeSelection = function() {
    $(document).on('click', '[data-click="set-payment"]', function(e) {
        e.preventDefault();
        
        var targetLi = $(this).closest('li');
        var targetValue = $(this).attr('data-value');
        $('[data-click="set-payment"]').closest('li').not(targetLi).removeClass('active');
        $('[data-id="payment-type"]').val(targetValue);
        $(targetLi).addClass('active');
    });
};


/* 08. Handle Checkout Qty Control
------------------------------------------------ */
var handleQtyControl = function() {
    $(document).on('click', '[data-click="increase-qty"]', function(e) {
        e.preventDefault();
        var targetInput = $(this).attr('data-target');
        var targetValue = parseInt($(targetInput).val()) + 1;  
        
        $(targetInput).val(targetValue);
    });
    $('[data-click="decrease-qty"]').click(function(e) {
        e.preventDefault();
        var targetInput = $(this).attr('data-target');
        var targetValue = parseInt($(targetInput).val()) - 1;  
            targetValue = (targetValue < 0) ? 0 : targetValue;
        $(targetInput).val(targetValue);
    });
};


/* 09. Handle Product Image
------------------------------------------------ */
var handleProductImage = function() {
    $(document).on('click', '[data-click="show-main-image"]', function(e) {
        e.preventDefault();
        
        var targetContainer = '[data-id="main-image"]';
        var targetImage = '<img src="'+ $(this).attr('data-url') +'" />';
        var targetLi = $(this).closest('li');
        
        $(targetContainer).html(targetImage);
        $(targetLi).addClass('active');
        $('[data-click="show-main-image"]').closest('li').not(targetLi).removeClass('active');
    });
};


/* Application Controller
------------------------------------------------ */
var App = function () {
	"use strict";
	
	return {
		//main function
		init: function () {
		    handleHeaderFixedTop();
		    handlePageContainerShow();
		    handlePaceLoadingPlugins();
            handleTooltipActivation();
            handleThemePanelExpand();
            handleThemePageControl();
            handlePaymentTypeSelection();
            handleQtyControl();
            handleProductImage();
		}
  };
}();