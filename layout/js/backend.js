$(function () {


    var sliderToTimeForEarh = document.getElementById("myRangeToAmount");
    var outputToAmount = document.getElementById("Amount");

    if (outputToAmount != null) {
    outputToAmount.innerHTML = sliderToTimeForEarh.value + " شهور ";



        sliderToTimeForEarh.oninput = function () {

        if (this.value == 1) {

            outputToAmount.innerHTML = " شهر ";

        } else if (this.value == 2) {

            outputToAmount.innerHTML = " شهرين ";
        } else if (this.value > 2 && this.value <= 10) {

            outputToAmount.innerHTML = this.value + " شهور ";

        }else if (this.value == 12) {

            outputToAmount.innerHTML = " سنة واحدة ";

        } else {
            outputToAmount.innerHTML = this.value + " شهر ";
        }
    }
    }
    


 	$('.City').change(function () {


		if($(this).val() == 0) {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})

 	$('.Category').change(function () {
 		

		if($(this).val() == 0) {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})

 	$('.BookName').blur(function () {

		if($(this).val().length < 4) {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})


	$('.FullName').blur(function () {

		if($(this).val().length < 4) {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})


	$('.email').blur(function () {

		if($(this).val() == "") {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})


	$('.Password').blur(function () {

		if($(this).val() == "") {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})

	$('.PhoneNumber').blur(function () {

		if($(this).val().length < 10 || $(this).val().length > 10 ) {
			$(this).css("border","1px solid #f00");
			$(this).siblings("span").css("border","1px solid #f00");
		}else {
			$(this).css("border","1px solid #080");
			$(this).siblings("span").css("border","1px solid #080");
		}
	})








	


	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})


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