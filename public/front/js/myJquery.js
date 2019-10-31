$(function(){



    // show-hide  user list
  $(".navbar .nav-right-list  ul .profile").click(function(e){
      e.preventDefault();
      $(".navbar  .user-profile-list").fadeToggle();
  });

  // header hight
  var win_H=$(window).height();
  var nav_H=$(".navbar").innerHeight();
  $("header").height(win_H - nav_H);

  $('.dropdown').click(function(){
    $('.dropdown-menu').fadeToggle();
  });

  // stars
  $(".stars-rate li").click(function(){
  
    $(this).toggleClass("active-star");
    $(this).nextAll().removeClass("active-star");
    $(this).prevAll().addClass("active-star")
  });


  

  // user / admin orders

  $(".choose-bar a.new").click(function(e){
    e.preventDefault();
    $(".current-order").fadeOut();
    $(".prev-order").fadeOut();
    $(".new-order").fadeIn();
    $(".new-span").addClass("active-span");
    $(".prev-span").removeClass("active-span");
    $(".current-span").removeClass("active-span");
 });

  $(".choose-bar a.current").click(function(e){
     e.preventDefault();
     $(".current-order").fadeIn();
     $(".prev-order").fadeOut();
     $(".new-order").fadeOut();
     $(".current-span").addClass("active-span");
     $(".prev-span").removeClass("active-span");
  });

  $(".choose-bar a.prev").click(function(e){
    e.preventDefault();
    $(".current-order").fadeOut();
    $(".prev-order").fadeIn();
    $(".new-order").fadeOut();
    $(".prev-span").addClass("active-span");
    $(".current-span").removeClass("active-span");
    $(".new-span").removeClass("active-span");
 });

 // pop up 
  $(".register2 .pop-btn").click(function(){
    $(".meal-pop-up").fadeIn();
  });
 
  $(".close-pop-up").click(function(){
    $(".meal-pop-up").fadeOut();
  });

  


  // meal slider

  //
  // $('.meal-slider').slick({
  //   dots: true,
  //   infinite: true,
  //   speed: 300,
  //   slidesToShow: 4,
  //   slidesToScroll: 4,
  //   autoplay: true,
  //   autoplaySpeed: 2500,
  //   responsive: [
  //     {
  //       breakpoint: 1024,
  //       settings: {
  //         slidesToShow: 3,
  //         slidesToScroll: 3,
  //         infinite: true,
  //         dots: true
  //       }
  //     },
  //     {
  //       breakpoint: 600,
  //       settings: {
  //         slidesToShow: 2,
  //         slidesToScroll: 2
  //       }
  //     },
  //     {
  //       breakpoint: 480,
  //       settings: {
  //         slidesToShow: 1,
  //         slidesToScroll: 1
  //       }
  //     }
  //     // You can unslick at a given breakpoint now by adding:
  //     // settings: "unslick"
  //     // instead of a settings object
  //   ]
  // });

   $(".slick-slide > div > div").hover(function(){
     $(this).find(".overlay").fadeToggle();
   });

  
});