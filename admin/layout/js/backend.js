$(function () {


	 $("select").selectBoxIt({
	 	autoWidth : false
	 });

$("input").on('focus',function () {
    $place = $(this).attr("placeholder");
   $(this).attr("placeholder","");
  }).on("blur",function () {
    $(this).attr("placeholder",$place);
  });﻿

	// Convert Password Field To Text Field On Hover

	var passField = $('.password');

	$('.show-pass').hover(function () {

		passField.attr('type', 'text');

	}, function () {

		passField.attr('type', 'password');

	});

	$('.confirm').click(function () {

		return confirm('Are You Sure?');

	});


	$(".cat h3").click(function () {

		$(this).next(".daliteOfCatogery").fadeToggle(500);
	});


	$('.toggle-info').click(function () {

		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {

			$(this).html('<i class="fa fa-minus fa-lg"></i>');

		} else {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');

		}

	});


});