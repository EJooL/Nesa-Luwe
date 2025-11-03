// to get current year
function getYear() {
  var currentDate = new Date();
  var currentYear = currentDate.getFullYear();
  document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// isotope js
$(window).on("load", function () {
  $(".filters_menu li").click(function () {
    $(".filters_menu li").removeClass("active");
    $(this).addClass("active");

    var data = $(this).attr("data-filter");
    $grid.isotope({
      filter: data,
    });
  });

  var $grid = $(".grid").isotope({
    itemSelector: ".all",
    percentPosition: false,
    masonry: {
      columnWidth: ".all",
    },
  });
});

// nice select
$(document).ready(function () {
  $("select").niceSelect();
});

// client section owl carousel
$(".client_owl-carousel").owlCarousel({
  loop: true,
  margin: 0,
  dots: false,
  nav: true,
  navText: [],
  autoplay: true,
  autoplayHoverPause: true,
  navText: [
    '<i class="fa fa-angle-left" aria-hidden="true"></i>',
    '<i class="fa fa-angle-right" aria-hidden="true"></i>',
  ],
  responsive: {
    0: {
      items: 1,
    },
    768: {
      items: 2,
    },
    1000: {
      items: 2,
    },
  },
});

// rating
const stars = document.querySelectorAll(".rating-input .fa-star");
stars.forEach((star, index) => {
  star.addEventListener("click", () => {
    stars.forEach((s, sIndex) => {
      if (sIndex >= index) {
        s.classList.add("checked");
      } else {
        s.classList.remove("checked");
      }
    });
  });
});

// popup
document.getElementById("ulasanform").addEventListener("submit", function (e) {
  e.preventDefault();

  if (
    document.querySelectorAll(".rating-input .fa-star.checked").length === 0
  ) {
    alert("Harap berikan rating bintang terlebih dahulu!");
    return;
  }

  alert("Terima kasih! Ulasan Anda telah berhasil dikirim.");

  this.reset();
  document.querySelectorAll(".rating-input .fa-star").forEach((star) => {
    star.classList.remove("checked");
  });
});
