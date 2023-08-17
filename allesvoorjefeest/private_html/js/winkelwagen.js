$(document).ready(function() {
  $("form#addToCart").submit(function (event) {
    var formData = {
      aantal: $("#aantal").val(),
      artikelId: $("#artikelId").val()
    };

    $.ajax({
      type: "POST",
      url: "/actions/winkelwagen.php",
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
       $("div#addToCartBlock")
               .html("Artikel is toegevoegd aan winkelmandje")
               .addClass("green")
               .removeClass("orange");
    });
    event.preventDefault();
  });
});