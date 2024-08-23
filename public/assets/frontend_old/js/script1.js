$('.owl-carousel.gallery-carousel').owlCarousel({
  loop: true,
  margin: 24,
  nav: false,
  autoplay: true,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 3,
      margin: 12,
    },
    360: {
      items: 4,
      margin: 12,
    },
    768:{
      items: 3
    },
    1000: {
      items: 5
    }
  }
})






$(function() {
    
  $('#thumbnails img').click(function() {
    var src = $(this).attr('src');
    $('#largeImage').attr('src', src).show();
  });
  $('#largeImage').click(function() {
    $('#thumbnails img').show();

  });
});





// Load more start

$(document).ready(function(){
  $(".for-more").slice(0, 15).show();
  $("#loadMore").on("click", function(e){
    e.preventDefault();
    $(".for-more:hidden").slice(0, 5).slideDown();
    if($(".for-more:hidden").length == 0) {
      $("#loadMore").hide()
    }
  });
  
})

// Load more end






// menu color effect start

$(document).ready(function(){

  var a = "";

  if ($('.nav-items').hasClass('active')) {
      $(".nav-items").each(function(){
          $(this).addClass("pblur")
      })
  }

  $('.nav-items').hover(
    function(){
      a = $(".nav-items").index( this );
      $(".nav-items").each(function(){
          if($(".nav-items").index(this) == a){
            $( this ).removeClass("blur")
          }
          else{
            $( this ).addClass("blur")
          }
      })
    },
    function(){
      $('.nav-items').removeClass("blur")
    }


  )
})

// menu color effect end








$(document).ready(function(){
  $(".menuIcons").on("click", function(){
    $(".sideMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop");
  });
  $(".closeIcons").on("click", function(){
    $(".sideMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
  $(".closeBG").on("click", function(){
    $(".sideMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
});


// sort bar js

$(document).ready(function(){
  $(".sortIcons").on("click", function(){
    $(".sortMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
  $(".closeIcons2").on("click", function(){
    $(".sortMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
});



// filter bar js

$(document).ready(function(){
  $(".filterIcons").on("click", function(){
    $(".filterMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
  $(".closeIcons3").on("click", function(){
    $(".filterMenu").toggleClass("active");
    $("body").toggleClass("scroll-stop")
  });
});




$(window).scroll(function(){
	$('nav').toggleClass('scrolled', $(this).scrollTop() > 50);
});


$(document).ready(function(){
	$(".dropdowns").click(function(){
		$(this).toggleClass("active");
	})
})


$(document).ready(function(){
	if($(".dropdowns")){
		$(".dropdowns").text($(".dropdowns-toggles .active").text())
	}

})



/*Review Ratings JS @hj*/

$(document).ready(function(){
  
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); 
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); 
    $("#star_value").val(onStar);
    var stars = $(this).parent().children('li.star');
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
  });
  
});


// Blog Listing TopLinks Menu

$(document).ready(function(){
  $(".dropdowns-toplinks").click(function(){
    $(this).toggleClass("active");
  })
})

$(document).ready(function(){
  if($(".dropdowns-toplinks")){
    $(".dropdowns-toplinks").text($(".dropdwn-togle-toplinks .active").text())
  }

})







$(document).ready(function(){
    if ($(".footer-logo").offset()) {
      var x = $(".footer-logo").offset();
      var y = x.left;

      if ($(".left-container")) {

        $(".left-container").css("width","calc(100% - " + y +"px)")
      }
    }
});







$("document").ready(function(){
  $(".bookmark-img").click(function(){
    $(this).toggleClass("active");
  })
})


function playVideo(event) { 

  var all_video = document.getElementsByTagName('video');

  for (var i = 0; i < all_video.length; i++) {
    all_video[i].pause();
  }

  var a = event.target.parentElement;
  a.children[0].play();

  event.target.classList.toggle("hide-icon")  
}









// Home part carousel start

  $(document).ready(function() {
    $('.owl-carousel.home-part-carousel ').owlCarousel({
      loop: true,
      margin: 10,
      responsiveClass: true,
      nav: false,
      responsive: {
        0: {
          items: 2.2,
          margin: 16
        },
        360: {
          items: 2.5,
          margin: 16
        },
        575: {
          items: 3.33,
          margin: 20
        }
      }
    })
  })

// Home part carousel end






$(document).ready(function(){
  if($(".show-star")){
    $(".show-star").each(function(){
      var a = $(this).children(".fill-star").length;

      console.log(a)

      if (a == 1) {
        $(this).addClass("red")
      }
      else if(a <= 3){
        $(this).addClass("green")
      }
      else{
        $(this).addClass("yellow")
      }
    })
  }
})























// attach invoice code start

document.addEventListener("DOMContentLoaded", init, false);

var AttachmentArray = [];

var arrCounter = 0;

var filesCounterAlertStatus = false;

var ul = document.createElement("ul");
ul.className = "thumb-Images-uploaded";
ul.id = "imgList";

function init() {
  document
    .querySelector("#files")
    .addEventListener("change", handleFileSelect, false);
}

function handleFileSelect(e) {
  if (!e.target.files) return;
  var files = e.target.files;
  for (var i = 0, f; (f = files[i]); i++) {
    var fileReader = new FileReader();

    fileReader.onload = (function(readerEvt) {
      return function(e) {
        ApplyFileValidationRules(readerEvt);
        RenderThumbnail(e, readerEvt);
        FillAttachmentArray(e, readerEvt);
      };
    })(f);

    fileReader.readAsDataURL(f);
  }
  document
    .getElementById("files")
    .addEventListener("change", handleFileSelect, false);
}

jQuery(function($) {
  $("div").on("click", ".img-wrap .close", function() {
    var id = $(this)
      .closest(".img-wrap")
      .find("img")
      .data("id");

    var elementPos = AttachmentArray.map(function(x) {
      return x.FileName;
    }).indexOf(id);
    if (elementPos !== -1) {
      AttachmentArray.splice(elementPos, 1);
    }

    $(this)
      .parent()
      .find("img")
      .not()
      .remove();

    $(this)
      .parent()
      .find("div")
      .not()
      .remove();

    $(this)
      .parent()
      .parent()
      .find("div")
      .not()
      .remove();

    var lis = document.querySelectorAll("#imgList li");
    for (var i = 0; (li = lis[i]); i++) {
      if (li.innerHTML == "") {
        li.parentNode.removeChild(li);
      }
    }
  });
});

function ApplyFileValidationRules(readerEvt) {
  if (CheckFileType(readerEvt.type) == false) {
    alert(
      "The file (" +
        readerEvt.name +
        ") does not match the upload conditions, You can only upload jpg/png/gif files"
    );
    e.preventDefault();
    return;
  }

  if (CheckFileSize(readerEvt.size) == false) {
    alert(
      "The file (" +
        readerEvt.name +
        ") does not match the upload conditions, The maximum file size for uploads should not exceed 300 KB"
    );
    e.preventDefault();
    return;
  }

  if (CheckFilesCount(AttachmentArray) == false) {
    if (!filesCounterAlertStatus) {
      filesCounterAlertStatus = true;
      alert(
        "You have added more than 10 files. According to upload conditions you can upload 10 files maximum"
      );
    }
    e.preventDefault();
    return;
  }
}

function CheckFileType(fileType) {
  if (fileType == "image/jpeg") {
    return true;
  } else if (fileType == "image/png") {
    return true;
  } else if (fileType == "image/gif") {
    return true;
  } else {
    return false;
  }
  return true;
}

function CheckFileSize(fileSize) {
  if (fileSize < 300000) {
    return true;
  } else {
    return false;
  }
  return true;
}

function CheckFilesCount(AttachmentArray) {
  var len = 0;
  for (var i = 0; i < AttachmentArray.length; i++) {
    if (AttachmentArray[i] !== undefined) {
      len++;
    }
  }
  if (len > 9) {
    return false;
  } else {
    return true;
  }
}
function RenderThumbnail(e, readerEvt) {
  var li = document.createElement("li");
  ul.appendChild(li);
  li.innerHTML = [
    '<div class="img-wrap"> <span class="close"></span>' +
      '<img class="thumb" src="',
    e.target.result,
    '" title="',
    escape(readerEvt.name),
    '" data-id="',
    readerEvt.name,
    '"/>' + "</div>"
  ].join("");

  var div = document.createElement("div");
  div.className = "FileNameCaptionStyle";
  li.appendChild(div);
  div.innerHTML = [readerEvt.name].join("");
  document.getElementById("Filelist").insertBefore(ul, null);
}
function FillAttachmentArray(e, readerEvt) {
  AttachmentArray[arrCounter] = {
    AttachmentType: 1,
    ObjectType: 1,
    FileName: readerEvt.name,
    FileDescription: "Attachment",
    NoteText: "",
    MimeType: readerEvt.type,
    Content: e.target.result.split("base64,")[1],
    FileSizeInBytes: readerEvt.size
  };
  arrCounter = arrCounter + 1;
}







function openFilter(evt, filterName) {
  var i, filterContent, filterLinks;

  filterContent = document.getElementsByClassName("filter-content");
  for (i = 0; i < filterContent.length; i++) {
    filterContent[i].style.display = "none";
  }

  filterLinks = document.getElementsByClassName("filter-links");
  for (i = 0; i < filterLinks.length; i++) {
    filterLinks[i].className = filterLinks[i].className.replace(" active", "");
  }

  document.getElementById(filterName).style.display = "block";
  evt.currentTarget.className += " active";
}








$(function(){  
  $('.drop-down-items').on('click',function(){   
    if ($(this).hasClass("sort-by-items")) {
      if ($(this).hasClass("selected")) {
        $(".sort-by-items").removeClass('selected');
      }
      else{
        $(".filter-by-items").removeClass('selected');
        $(".sort-by-items").addClass('selected');
      }  
    }
    else{
      if ($(this).hasClass("selected")) {
        $(".filter-by-items").removeClass('selected');
      }
      else{
        $(".filter-by-items").addClass('selected');
        $(".sort-by-items").removeClass('selected');
      }
    }
  }); 
});


$(function(){ 
    $(window).click(function(event) {
        if (!$(event.target).parents().hasClass('filter-header') && !$(event.target).parents().hasClass('by-toggle')) {
          $(".drop-down-items").find(function(){
            if ($(".drop-down-items").hasClass('selected')) {
              $(".drop-down-items").removeClass('selected')
            }
          })
        }
    });
})










$(document).ready(function(){
  
  $('#stars2 li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); 
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  $('#stars2 li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); 
    var stars = $(this).parent().children('li.star');
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
  });
  
});