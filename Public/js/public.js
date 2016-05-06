//导航停留顶部效果
$(window).scroll(function () {
  if ($(window).scrollTop() > 120) {
    $('.Menu').addClass('cur');
  } else {
    $('.Menu').removeClass('cur');
  }
});