// button ripple effect start
(function (window, $) {

  $(function () {

    $('.fill-btn , .border-btn , .text-btn').on('click', function (event) {
      // event.preventDefault();
      var $btn = $(this),
        $div = $('<div/>'),
        btnOffset = $btn.offset(),
        xPos = event.pageX - btnOffset.left,
        yPos = event.pageY - btnOffset.top;

      $div.addClass('ripple-effect');
      $div
        .css({
          height: $btn.height(),
          width: $btn.height(),
          top: yPos - ($div.height() / 2),
          left: xPos - ($div.width() / 2),
          background: $btn.data("ripple-color") || "#fff"
        });
      $btn.append($div);

      window.setTimeout(function () {
        $div.remove();
      }, 2000);
    });

  });

})(window, jQuery);
// button ripple effect end



// Removeable Scripts Start

function includeHTML() {
  var z, i, elmnt, file, xhttp;
  z = document.getElementsByTagName("*");
  for (i = 0; i < z.length; i++) {
    elmnt = z[i];
    file = elmnt.getAttribute("include-html");
    if (file) {
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.status == 200) {elmnt.innerHTML = this.responseText;}
          if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
          elmnt.removeAttribute("include-html");
          includeHTML();
        }
      }      
      xhttp.open("GET", file, true);
      xhttp.send();
      return;
    }
  }
};

includeHTML();


// Removeable Scripts End

$(window).on('scroll', function(){
  if (window.pageYOffset >= 1) {
    $("header").addClass("scrollShadow")
  } else {
    $("header").removeClass("scrollShadow")
  }
})

$(document).on('click','.footer-block p',function(){
  $(this).toggleClass("show")
})

// $(document).ready(function () {
//   $(".menu-icon").on("click", function () {
//     $(".sideMenu").addClass("active");
//     $("body").addClass("scroll-stop");
//     $(".backBg").addClass("show");
//   });
//   $(".closeIcons").on("click", function () {
//     $(".sideMenu").removeClass("active");
//     $("body").removeClass("scroll-stop");
//     $(".backBg").removeClass("show");
//   });
//   $(".backBg").on("click", function () {
//     $(".sideMenu").removeClass("active");
//     $("body").removeClass("scroll-stop");
//     $(".backBg").removeClass("show");
//   });
// });

$(document).on("click",".menu-icon", function () {
  $(".sideMenu").addClass("active");
  $("body").addClass("scroll-stop");
  $(".backBg").addClass("show");
});
$(document).on("click", ".closeIcons", function () {
  $(".sideMenu").removeClass("active");
  $("body").removeClass("scroll-stop");
  $(".backBg").removeClass("show");
});
$(document).on("click", ".backBg", function () {
  $(".sideMenu").removeClass("active");
  $("body").removeClass("scroll-stop");
  $(".backBg").removeClass("show");
});


$(document).on('click','.side-menu-dropdown .tm',function(){
  $(this).closest('.side-menu-dropdown').find('.menu-collapse-wrapper').toggleClass("show", 300);
  $(this).toggleClass('arrow-toggle')
})


$(document).on('click', '.search-open' , function(){
  $(".mobile-search-bar").addClass("active")
})
$(document).on('click', '.this-close-btn' , function(){
  $(".mobile-search-bar").removeClass("active")
})


$(document).ready(function () {
  $(".web-filter").on("click", function () {
    $(".filter-section-wrapper").toggleClass("active" ,300);
  });
  $(".mobile-filter").on("click", function () {
    $(".filter-section-wrapper").addClass("active");
    $("body").addClass("scroll-stop");
    $(".backBg").addClass("show");
  });
  $(".close-filter").on("click", function () {
    $(".filter-section-wrapper").removeClass("active");
    $("body").removeClass("scroll-stop");
    $(".backBg").removeClass("show");
  });
  $(".backBg").on("click", function () {
    $(".filter-section-wrapper").removeClass("active");
    $("body").removeClass("scroll-stop");
    $(".backBg").removeClass("show");
  });
});

jQuery(document).ready(function(){

  var $this = $('.ck-collapse');
  
  // If more than 2 Education items, hide the remaining
  $('.ck-collapse').each(function() {
    $(this).find('.ck').slice(0,5).addClass('shown')
    $(this).find('.ck').not('.shown').hide();
    if ($(this).find('.ck').length > 5) {
      $(this).append('<div><a href="javascript:;" class="show-more"></a></div>');
  }
  });
	// $('.ck-collapse .ck').slice(0,4).addClass('shown');
	// $('.ck-collapse .ck').not('.shown').hide();
	$('.ck-collapse .show-more').on('click',function(){
    $(this).closest('.ck-collapse').find('.ck').not('.shown').toggle(300);
		$(this).toggleClass('show-less');
	});

});

$(document).on('click','.filter-section .filter-column .tm',function(){
  $(this).closest('.filter-column').find('.ck-collapse-wrapper').toggleClass("show", 300);
  $(this).toggleClass('arrow-toggle')
})


$(document).ready(function() {
  $('.minus').click(function () {
    var $input = $(this).parent().find('input');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
  });
  $('.plus').click(function () {
    var $input = $(this).parent().find('input');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
  });
});



// multi select dropdown

function checkboxDropdown(el) {
  var $el = $(el)

  function updateStatus(label, result) {
    if(!result.length) {
      label.html('');
    }
  };
  
  $el.each(function(i, element) {
    var $list = $(this).find('.multi-dropdown-list'),
      $label = $(this).find('.multi-dropdown-label'),
      $checkAll = $(this).find('.check-all'),
      $inputs = $(this).find('.check'),
      defaultChecked = $(this).find('input[type=checkbox]:checked'),
      result = [];
    
    updateStatus($label, result);
    if(defaultChecked.length) {
      defaultChecked.each(function () {
        result.push($(this).next().attr('values'));
        $label.html(result.join(", "));
      });
    }
    
    $label.on('click', ()=> {
      $(this).toggleClass('open');
    });

    $checkAll.on('change', function() {
      var checked = $(this).is(':checked');
      var checkedText = $(this).next().attr('values');
      result = [];
      if(checked) {
        result.push(checkedText);
        $label.html(result);
        $inputs.prop('checked', false);
      }else{
        $label.html(result);
      }
        updateStatus($label, result);
    });

    $inputs.on('change', function() {
      var checked = $(this).is(':checked');
      var checkedText = $(this).next().attr('values');
      console.log(checkedText)
      if($checkAll.is(':checked')) {
        result = [];
      }
      if(checked) {
        result.push(checkedText);
        $label.html(result.join(", "));
        $checkAll.prop('checked', false);
      }else{
        let index = result.indexOf(checkedText);
        if (index >= 0) {
          result.splice(index, 1);
        }
        $label.html(result.join(", "));
      }
      updateStatus($label, result);
    });

    $(document).on('click touchstart', e => {
      if(!$(e.target).closest($(this)).length) {
        $(this).removeClass('open');
      }
    });
  });
};

checkboxDropdown('.multi-select-dropdown');






if($('.tab-section').length){
  const mouseWheel = document.querySelector('.tab-section');
  mouseWheel.addEventListener('wheel', function(e) {
      const race = 30; // How many pixels to scroll

      if (e.deltaY > 0) // Scroll right
          mouseWheel.scrollLeft += race;
      else // Scroll left
          mouseWheel.scrollLeft -= race;
      e.preventDefault();
  });
}

const slider = document.querySelector('.tab-section');
let isDown = false;
let startX;
let scrollLeft;

if(slider){
  slider.addEventListener('mousedown', (e) => {
    isDown = true;
    slider.classList.add('active');
    startX = e.pageX - slider.offsetLeft;
    scrollLeft = slider.scrollLeft;
  });
  slider.addEventListener('mouseleave', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mouseup', () => {
    isDown = false;
    slider.classList.remove('active');
  });
  slider.addEventListener('mousemove', (e) => {
    if(!isDown) return;
    e.preventDefault();
    const x = e.pageX - slider.offsetLeft;
    const walk = (x - startX) * 3; //scroll-fast
    slider.scrollLeft = scrollLeft - walk;
    console.log(walk);
  });
}




// $(".status_change .dropdown-item").click(function(){
//     var getStatusText = $(this).text();
//     $(this).closest(".status_dropdown").find(".status__btn").text(getStatusText);
//     var generateStatusClass = $(this).attr('data-class');
//     $(this).closest(".status_dropdown").attr("data-color", `${generateStatusClass}`);
// })


$(document).on('click','.password-icon',function(){

  if($(this).closest('.password-field-wrapper').hasClass('open-eye')){
    $(this).closest('.password-field-wrapper').removeClass('open-eye');
    $(this).closest('.password-field-wrapper').find('input').attr('type','password')
  }
  else{
    $(this).closest('.password-field-wrapper').addClass('open-eye');
    $(this).closest('.password-field-wrapper').find('input').attr('type','text')
  }
  // $(this).addClass('open-eye');
  // $(this).find('input').
})



$(document).ready(function () {
  $('.CR-wrapper2 .owl-carousel').owlCarousel({
    items: 1,
    nav: false,
    dots: true,
    dotsData: true,
    loop:true,
    autoplay:true,
    autoplayTimeout:5000,
    autoplayHoverPause:true
  })
})