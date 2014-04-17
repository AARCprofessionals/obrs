//Theme Options
var themeOptions = {
		siteWrap: '.site-wrap',
		footerWrap: '.footer-wrap',
		mainMenu: '.header-navigation',
		selectMenu: '.select-menu',
		courseRating: '.course-rating',
		themexSlider: '.themex-slider',
		parallaxSliderClass: 'parallax-slider',
		toolTip: '.tooltip',
		toolTipWrap: '.tooltip-wrap',
		tooltipSwitch: '.switch-button',
		button: '.button',
		submitButton: '.submit-button',
		printButton: '.print-button',
		facebookButton: '.facebook-button',
		toggleTitle: '.toggle-title',
		toggleContent: '.toggle-content',
		toggleContainer: '.toggle-container',
		accordionContainer: '.accordion',
		tabsContainer: '.tabs-container',
		tabsTitles: '.tabs',
		tabsPane: '.pane',
		playerContainer: '.jp-container',
		playerSource: '.jp-source a',
		player: '.jp-jplayer',
		playerFullscreen: '.jp-screen-option',
		placeholderFields: '.popup-form input',
		userImageUploader: '.user-image-uploader',
		popup: '.popup',
		popupContainer: '.popup-container',
		noPopupClass: 'no-popup',
		googleMap: '.google-map-container',
		widgetTitle: '.widget-title'
};


var ajaxForms= {
		loginForm: '.login-form',
		registerForm: '.register-form',
		passwordForm: '.password-form',
		contactForm: '.contact-form',
};

//Ajax Form
function ajaxForm(form) {
	form.submit(function() {
		var data={
			action: form.find('.action').val(),
			nonce: form.find('.nonce').val(),
			data: form.serialize()
		}

		form.find('.message').slideUp(300);
		form.find('.form-loader').show();
		form.find(themeOptions.submitButton).addClass('disabled');
		
		jQuery.post(form.attr('action'), data, function(response) {
			form.find(themeOptions.submitButton).removeClass('disabled');
			if(response.match('success') != null) {
				if(jQuery('a.redirect',response).length) {
					window.location.href=jQuery('a.redirect',response).attr('href');
				} else {
					form.find('.message').html(response).slideDown(300);
					form.find('.form-loader').hide();
				}						
			} else {
				form.find('.message').html(response).slideDown(300);
				form.find('.form-loader').hide();
			}
		});				
		return false;
	});
}

//DOM Loaded
jQuery(document).ready(function($) {
	
	// Quiz ID
	var mtqid = $("input:hidden[name=mtq_id_value]").val();
	
	//Dropdown Menu
	$(themeOptions.mainMenu).find('li').hoverIntent(
		function() {
			var menuItem=$(this);
			menuItem.parent('ul').css('overflow','visible');			
			menuItem.children('ul').slideToggle(200, function() {
				menuItem.addClass('hover');
			});
		},
		function() {
			var menuItem=$(this);
			menuItem.children('ul').slideToggle(200, function() {
				menuItem.removeClass('hover');
			});
		}
	);
	
	//Select Menu
	$(themeOptions.selectMenu).find('select').fadeTo(0, 0);
	$(themeOptions.selectMenu).find('span').text($(themeOptions.selectMenu).find('option:eq(0)').text());
	$(themeOptions.selectMenu).find('option').each(function() {
		if(window.location.href==$(this).val()) {
			$(themeOptions.selectMenu).find('span').text($(this).text());
			$(this).attr('selected','selected');
		}
	});
	
	$(themeOptions.selectMenu).find('select').change(function() {
		window.location.href=$(this).find('option:selected').val();
		$(themeOptions.selectMenu).find('span').text($(this).find('option:selected').text());
	});

	//Course Rating
	$(themeOptions.courseRating).each(function() {
		var rating=$(this);		
		$(this).raty({
			score: rating.data('score'),
			readOnly: rating.data('readonly'),
			hints   : ['', '', '', '', ''],
			noRatedMsg : '',
			click: function(score, evt) {
				var data= {
					action: rating.data('action'),					
					rating: score,
					id: rating.data('id')
				};
				$.post(rating.data('url'), data, function(response) {
				});
			}
		});
	});
	
	//Audio and Video
	if($(themeOptions.playerContainer).length) {
		$(themeOptions.playerContainer).each(function() {
			var mediaPlayer=$(this);
			var suppliedExtensions='';
			var suppliedMedia=new Object;
			
			mediaPlayer.find(themeOptions.playerSource).each(function() {
				var mediaLink=$(this).attr('href');
				var mediaExtension=$(this).attr('href').split('.').pop();
				
				if(mediaExtension=='webm') {
					mediaExtension='webmv';
				}
				
				if(mediaExtension=='mp4') {
					mediaExtension='m4v';
				}
				
				suppliedMedia[mediaExtension]=mediaLink;				
				suppliedExtensions+=mediaExtension;
				
				if(!$(this).is(':last-child')) {
					suppliedExtensions+=',';
				}
			});
		
			mediaPlayer.find(themeOptions.player).jPlayer({
				ready: function () {
					$(this).jPlayer('setMedia', suppliedMedia);
					if($("div.lesson-options").hasClass('lesson-complete')) {
						$(this).jPlayer('stop');
					} else {
						var playerID = $(this).attr('id');
						var prefix = 'jp_jplayer_';
						var locationSlice = playerID.replace(prefix,'');
						var location = parseInt(locationSlice,10);
						if(location > 0) {
							$(this).jPlayer('stop');
						} else {
							$(this).jPlayer('play');
						}
					}
				},
				swfPath: templateDirectory+'js/jplayer/Jplayer.swf',
				supplied: suppliedExtensions,
				cssSelectorAncestor: '#'+mediaPlayer.attr('id'),
				solution: 'html, flash',
				wmode: 'window'
			});				
			
			//media player bind to fire when audio ends
			mediaPlayer.bind($.jPlayer.event.ended, function (event) {
				//when audio ends, show the next lesson arrow
				//console.log("event ended correctly.");
				if (!$('div').hasClass('mtq_quiztitle')) {
					//console.log('no quiz present.');
					$('a.submit-button').show();
					$('a.submit-button').click();
				} else {
					//console.log('quiz present');					
					$('div.mtq_start_button').removeClass('waiting');
					$(document).on('click', '.mtq_submit_button', function() {
						var currentScore = $('#total_questions_answered').val(); // Value of %%SCORE%%
						var maxScore = $('#mtq_total_questions-'+mtqid).val(); // Value of %%TOTAL%%
						if(currentScore == maxScore) {
							$('a.submit-button').show();
							$('a.submit-button').click();
							//window.scrollTo(x-coord, y-coord);
						}
					});
				}
			});
			
			mediaPlayer.show();
			
		});		
			
		$(themeOptions.playerFullscreen).click(function() {
			$('body').toggleClass('fullscreen-video');
		});

	} else {

		//console.log('No player present.');

		if(!$('div').hasClass('.mtq_quiztitle')){
			// console.log('No quiz present.');
			$('div.finish-lesson a.submit-button').show(function(){
			 console.log('button is visible');
				$(this).click();
			});
		}

	}
		
	//Sliders
	$(themeOptions.themexSlider).each(function() {
		var sliderOptions= {
			speed: parseInt($(this).find('.slider-speed').val()),
			pause: parseInt($(this).find('.slider-pause').val()),
			effect: $(this).find('.slider-effect').val()
		};
		
		$(this).themexSlider(sliderOptions);
	});
	
	//Tooltips
	$(themeOptions.toolTip).click(function(e) {
		//console.log($(this).attr('class') + ' was clicked.'); // what button was clicked?
		var tooltipButton=$(this).children(themeOptions.button);
		if(!tooltipButton.hasClass('active')) {
			var tipCloud=$(this).find(themeOptions.toolTipWrap).eq(0);
			if(!tipCloud.is(':visible')) {
				tooltipButton.addClass('active');
				$(themeOptions.toolTipWrap).hide();
				tipCloud.fadeIn(200);
			}
		}
		
		return false;
	});
	
	$(themeOptions.tooltipSwitch).click(function() {
		var tipCloud=$(this).parent();
		while(!tipCloud.is(themeOptions.toolTipWrap)) {
			tipCloud=tipCloud.parent();
		}
		
		tipCloud.fadeOut(200, function() {
			$(this).next(themeOptions.toolTipWrap).fadeIn(200);
		});
		
		return false;
	});
	
	$('body').click(function() {
		$(themeOptions.toolTipWrap).fadeOut(200);
		$(themeOptions.toolTipWrap).parent().children(themeOptions.button).removeClass('active');
	});
	
	//Placeholders
	$('input, textarea').each(function(){
		if($(this).attr('placeholder')) {
			$(this).placeholder();
		}		
	});
	
	$(themeOptions.placeholderFields).each(function(index, item){
		item = $(item);
		var defaultStr = item.val();
	
		item.focus(function () {
			var me = $(this);
			if(me.val() == defaultStr){
				me.val('');
			}
		});
		item.blur(function () {
			var me = $(this);			
			if(!me.val()){
				me.val(defaultStr);
			}
		});
	});
	
	//Popup
	if($(themeOptions.popupContainer).length) {
		$(themeOptions.popupContainer).find('a').click(function() {
			if(!$(this).hasClass(themeOptions.noPopupClass)) {
				$(themeOptions.popup).stop().hide().fadeIn(300, function() {
					var popup=$(this);
					window.setTimeout(function() {
						popup.stop().show().fadeOut(300);
					}, 2000);
				});
				return false;
			}			
		});
	}
	
	//Toggles
	$(themeOptions.accordionContainer).each(function() {
		if(!$(this).find(themeOptions.toggleContainer+'.expanded').length) {
			$(this).find(themeOptions.toggleContainer).eq(0).addClass('expanded').find(themeOptions.toggleContent).show();
		}
	});
	
	$(themeOptions.toggleTitle).live('click', function() {
		if($(this).parent().parent().hasClass('accordion') && $(this).parent().parent().find('.expanded').length) {
			if($(this).parent().hasClass('expanded')) {
				return false;
			}
			$(this).parent().parent().find('.expanded').find(themeOptions.toggleContent).slideUp(200, function() {
				$(this).parent().removeClass('expanded');			
			});
		}
		
		$(this).parent().find(themeOptions.toggleContent).slideToggle(200, function(){
			$(this).parent().toggleClass('expanded');		
		});
	});
	
	if(window.location.hash && $(window.location.hash).length) {
		$(window.location.hash).each(function() {
			var item=$(this);
			
			if(item.parent().hasClass('children')) {
				item=$(this).parent().parent();
			}
			
			item.addClass('expanded');
		});
	}
	
	//Tabs
	if($(themeOptions.tabsContainer).length) {
		$(themeOptions.tabsContainer).each(function() {
			
			var tabs=$(this);
		
			//show first pane
			tabs.find(themeOptions.tabsTitles).find('li:first-child').addClass('current');
			
			tabs.find('.tabs li').click(function() {
				//set active state to tab
				tabs.find('.tabs li').removeClass('current');
				$(this).addClass('current');
				
				//show current tab
				tabs.find('.pane').hide();
				tabs.find('.pane:eq('+$(this).index()+')').show();			
			});
		});	
	}
	
	//Submit Button
	$(themeOptions.submitButton).not('.disabled').click(function() {
		var form=$($(this).attr('href'));
		
		if(!form.length || !form.is('form')) {
			form=$(this).parent();
			while(!form.is('form')) {
				form=form.parent();
			}
		}
			
		form.submit();		
		return false;
	});
	
	$('input').keypress(function (e) {
		var form=$(this).parent();
	
		if (e.which==13) {
			e.preventDefault();
			
			while(!form.is('form')) {
				form=form.parent();
			}
			
			
			form.submit();
		}
	});
	
	//Print Button
	$(themeOptions.printButton).click(function() {
		window.print();
		return false;
	});
	
	//Facebook Button
	$(themeOptions.facebookButton).click(function() {
		if(typeof(FB)!='undefined') {
			FB.login(function(response) {
				if (response.authResponse) {
					window.location.reload();
				}
			}, {
				scope: 'email'
			});
		}		
	});
	
	//Image Uploader
	$(themeOptions.userImageUploader).find(themeOptions.button).click(function() {
		$(this).parent().find('input').trigger('click');
		return false;
	});
	$(themeOptions.userImageUploader).find('input').change(function() {
		var form=$(this).parent();
		while(!form.is('form')) {
			form=form.parent();
		}
		form.submit();
	});
	
	//Google Map
	$(themeOptions.googleMap).each(function() {
		var container=$(this);		
		var position = new google.maps.LatLng(container.find('.map-latitude').val(), container.find('.map-longitude').val());
		var myOptions = {
		  zoom: parseInt(container.find('.map-zoom').val()),
		  center: position,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		var map = new google.maps.Map(
			document.getElementById('google-map'),
			myOptions);
	 
		var marker = new google.maps.Marker({
			position: position,
			map: map,
			title:container.find('.map-description').val()
		});  
	 
		var infowindow = new google.maps.InfoWindow({
			content: container.find('.map-description').val()
		});
	 
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
		});
	});
	
	//AJAX forms
	for (var form in ajaxForms) {
		var currentForm = ajaxForms[form];
		$(currentForm).each(function() {
			ajaxForm($(this));
		});
	}
	
	//Window Loaded
	$(window).bind('load resize', function() {

	});
	
	//IE Detector
	if ( $.browser.msie ) {
		$('body').addClass('ie');
	 }
	
	//DOM Elements
	$('p:empty').remove();
	$('h1,h2,h3,h4,h5,h6,blockquote').prev('br').remove();
	
	$(themeOptions.widgetTitle).each(function() {
		if($(this).text()=='') {
			$(this).remove();
		}
	});
	
	$('ul, ol').each(function() {
		if($(this).css('list-style-type')!='none') {
			$(this).css('padding-left', '1em');
			$(this).css('text-indent', '-1em');
		}
	});
				
	if($(".lesson-options").hasClass('lesson-complete')) {
		$("a.next-lesson").show();
	};
	
	//Lesson Restriction
	
	$('ul.lesson-list li:not(.completed):not(.current) a').attr('href','#');
	
	$('ul.lesson-list li:not(.completed):not(.current) a').click(function(e){
		e.preventDefault();
	});

	$('div.lesson-item:not(.completed):not(:first) div h4 a').attr('href','#');
		
	$('div.lesson-item:not(.completed):not(:first) div h4 a').click(function(e){
		e.preventDefault();
	});
	
	$('div.mtq_start_button').each(function(){
    	$(this).data('onclick', this.onclick);
		this.onclick = function(event) {
    		if($(this).hasClass('waiting')) {
				return false;
			};

      		$(this).data('onclick').call(this, event || window.event);
    	};
  	});

	// Module Restriction
	
/*	$('.user-courses-listing .course-item a').click(function(e){
		if((!$(this).parents('started')) || (!$(this).parents('complete'))){
			e.preventDefault();
		}
	});	*/
	
		//User Page
	$('div.user-courses-listing div.course-item:not(.complete):not("div.incomplete:first") a').attr('href','#');
		
	$('div.user-courses-listing div.course-item:not(.complete):not("div.incomplete:first") a').click(function(e){
		//console.log(e + 'course image link');
		e.preventDefault();
	});
		
	$('div.user-courses-listing div.course-item:not(.complete):not("div.incomplete:first") a.button').hide();
		
		//Modules Page	
	$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-image a').attr('href','#');
	
	$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-image a').click(function(e){
		//console.log(e + 'course image link');
		e.preventDefault();
		$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-image').addClass('locked');
	});
	
	$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-meta header a').attr('href','#');
	
	$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-meta header a').click(function(e){
		//console.log(e + 'course meta link');
		e.preventDefault();
		$('div.courses-listing div div:not(.complete):not("div.incomplete:first") div.course-meta').addClass('locked');
	});
	
	//better onclick handling.
	$('[onclick]').each(function() {
    	var handler = $(this).prop('onclick');
   	 	$(this).removeProp('onclick');
    	$(this).click(handler);
	});
	
	// is the lesson complete?
	if($(".lesson-options").hasClass('lesson-complete')) {
		$('div.mtq_start_button').removeClass('waiting');
	}
	
	
	// Quiz Restrictions
	function quiz_show_next(mtqid,aid){
		var sum = 0;
		var total_answered = $('input[id^="mtq_is_answered"]').each(function() {
		        sum += Number($(this).val());
						return sum;
		    });
		$('#total_questions_answered').val(sum);
		var total_questions = $('#mtq_total_questions-'+mtqid).val();
		var aid_remove_prefix = aid.replace('mtq_row-','');
		var q = aid_remove_prefix.substring(0,1);
		var is_answered = parseInt($("#mtq_is_answered-"+q+"-"+mtqid).val());
		if(parseInt($('#mtq_autoadvance-' + mtqid).val()) != 1){
			if(is_answered != 0){ //show the list row
				$("#mtq_listrow-"+mtqid).attr('style','display: block;');
			}
		}
		
	}
	
	$('.mtq_start_button').each(function(){
		var handler = $(this).prop('onclick');
		$(this).removeProp('onclick');
		$(this).click(function(){
			handler;
			hide_quiz_nav();
		});
	});	
	
	$('.mtq_clickable').each(function(){ // run quiz_show_next when answer is clicked
		var handler = $(this).prop('onclick');
		var aid = $(this).attr('id');
		$(this).removeProp('onclick');
		$(this).click(function(id){
			handler;
			quiz_show_next(mtqid,aid);
		});
	});
	
	function hide_quiz_nav() { // Hide quiz navbar
		if ($("#mtq_listrow-"+mtqid).attr('style','display: block;')) {
			$("#mtq_listrow-"+mtqid).attr('style','display: none;');
		}
	}
	
	$('.mtq_css_next_button').each(function(){ // Hide quiz navbar on click
		var handler = $(this).prop('onclick');
		$(this).removeProp('onclick');
		$(this).click(function(){
			handler;
			hide_quiz_nav();
		});
	});
	
	$('#mtq_show_list-' + mtqid).hide(); // Hide quiz list button
	
	// Insert quiz submit button
	var submitButton = '<span id="mtq_submit_button-' + mtqid + '" class="mtq_action_button mtq_css_button mtq_results_button mtq_submit_button"> <span class="mtq_results_text">Finish Section</span></span>';
	var bubbleSubmitButton = '<span id="mtq_bubble_submit_button-' + mtqid + '" class="mtq_action_button mtq_css_button mtq_results_button mtq_submit_button"> <span class="mtq_results_text">Finish Section</span></span>';
		
	$('.mtq_results_request').append(submitButton);
	$('#mtq_results_button-' + mtqid).each(function(){
		var handler = $(this).prop('onclick');
		$(this).removeProp('onclick');
		$(this).click(function(){
			handler;
			$('#mtq_quiz_results-' + mtqid).append(bubbleSubmitButton);
		});
	});	
				
	// Insert answered questions value
	$('#mtq_variables').append('<input type="hidden" id="total_questions_answered" value="0">');
	
	
	// COURSES
  var userCourseCount = $('.course-item').length;
  //console.log(userCourseCount);

});