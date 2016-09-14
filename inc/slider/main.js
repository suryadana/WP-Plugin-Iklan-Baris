<script>
			// 
			jQuery(document).ready(function ($) {
				// creating a container variable to hold the 'UL' element. It uses method chaining.
				var container=$('div.slider')
											.css('overflow','hidden')
											.children('ul');
				
				// creating pagination variable which holds the 'UL' element.
				var pagicontainer=$('div.pagi-container').children('ul');
				
				/* 
				On the event of mouse-hover, 
					i) Change the visibility of Button Controls.
					ii) SET/RESET the "intv" variable to switch between AutoSlider and Stop mode.
				*/
				$('.gallery').hover(function( e ){
					$('.slider-nav').toggle();
					return e.type=='mouseenter'?clearInterval(intv):autoSlider();
				});
				
				// Creating the 'slider' instance which will set initial parameters for the Slider.
				var sliderobj= new slider(container,pagicontainer,$('.slider-nav'));
				/*
				This will trigger the 'setCurrentPos' and 'transition' methods on click of any button
				 "data-dir" attribute associated with the button will determine the direction of sliding.
				*/
				sliderobj.nav.find('button').on('click', function(){
					sliderobj.setCurrentPos($(this).data('dir'));
					sliderobj.transition();
				});
				
				/*
				This will trigger the 'setCurrentPos' and 'transition' methods on click of any Pagination icons.
				 "data-pgno" attribute associated with the Pagination icons will determine the value of current variable.
				*/
				sliderobj.pagicontainer.find('li a').on('click', function(){
					sliderobj.setCurrentPos($(this).data('pgno'));
					sliderobj.transition();					
				});
				
				autoSlider(); // Calling autoSlider() method on Page Load.
				
				/* 
				This function will initialize the interval variable which will cause execution of the inner function after every 3 seconds automatically.
				*/
				function autoSlider()
				{
					return intv = setInterval(function(){
						sliderobj.setCurrentPos('next');
						sliderobj.transition();
					}, 3000);
				}
				
			});
		</script>