
// Custom Select Box is here

$(".selectBox").on("click", function (e) {
    $(this).toggleClass("show");
    var dropdownItem = e.target;
    var container = $(this).find(".selectBox__value");
    container.text(dropdownItem.text);
    $(dropdownItem)
        .addClass("active")
        .siblings()
        .removeClass("active");
});

$(".toggle-password").click(function () {

    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});

// ANIMATE PROGRESS BAR FILL
$(".meter > span").each(function () {
    $(this)
        .data("origWidth", $(this).width())
        .width(0)
        .animate({
            width: $(this).data("origWidth")
        }, 1200);
});

$(document).ready(function () {
    $(".dropdowns").click(function () {
        $(this).toggleClass("active");
    })
    if ($(".dropdowns")) {
        $(".dropdowns").text($(".dropdowns-toggles .active").text())
    }
})




// Remove Active class when clicked outside the Dropdown

document.body.addEventListener("click", function (evt) {
    if (!evt.target.className.includes("dropdowns")) {
        var elems = document.querySelectorAll(".dropdowns");
        [].forEach.call(elems, function (el) {
            el.classList.remove("active");
        });
    }
});
