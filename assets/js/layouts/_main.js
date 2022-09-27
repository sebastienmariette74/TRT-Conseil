const { css } = require("jquery");
const $ = require("jquery");

$arrowToggle = false;
$(".mainArrow").on("click", function () {
  if (!$arrowToggle) {
    $arrowToggle = true;
    $(".sidebar").css({
      width: "300px",
      height: "100vh",
    });
    $('.arrow').css('transform', 'rotate(180deg)');
  } else {
    $arrowToggle = false;
    $(".sidebar").css({
        width: "30px",
        height: "30px"
    });
    $('.arrow').css('transform', 'rotate(360deg)');
  }
});