window.onload = function () {
  var loader = document.querySelector(".loader-container");
  var content = document.querySelector(".full-content");
  if (loader && content) {
    loader.style.display = "none";
    content.style.display = "block";
  }
};
(function () {
  const urlParams = new URLSearchParams(window.location.search);
  const page = urlParams.get("page");

  const contentDivs = document.querySelectorAll("section[id$='-page']");
  contentDivs.forEach((div) => {
    div.style.display = "none";
  });

  if (page) {
    const targetDiv = document.getElementById(page + "-page");
    if (targetDiv) {
      targetDiv.style.display = "block";
    }
  }
})();

var myCarousel = document.querySelector("#carousel");
var carousel = new bootstrap.Carousel(myCarousel, {
  interval: 2000,
  ride: "carousel",
  autoPlay: true,
});

$(document).ready(function () {
  $(".owl-carousel").owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoWidth: false,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 3,
      },
      1000: {
        items: 3,
      },
      1280: {
        items: 3,
      },
    },
  });
});
new WOW().init();
// google translate

function googleTranslateElementInit() {
  new google.translate.TranslateElement(
    {
      pageLanguage: "en",
      includedLanguages: "en,de,ko,zh-CN",
    },
    "google_translate_element"
  );
}
