var currentImage = 0;
var shuffleMode = false;
var fadeTime = 1000;

function nextImage() {
    if(shuffleMode) {
        currentImage = Math.floor(Math.random() * imageData.length);
    } else {
        currentImage = currentImage + 1;

        if(currentImage >= imageData.length) {
            currentImage = 0;
        }
    }
    setImageData(imageData[currentImage]);
}

function setImageData(data) {
    // delete all the old slides that have already been hidden
    $("#oldSlide").remove();

    var oldSlide = $("#slide");
    var newSlide = oldSlide.clone();


    oldSlide.attr("id", "oldSlide");

    newSlide.attr("id", "slide");

    newSlide.insertAfter(oldSlide);
    newSlide.css("left", "10%").css("opacity", 0).animate({"left": "0%", "opacity": 1}, fadeTime);
    oldSlide.animate({"left": "-10%", "opacity": 0}, fadeTime);

    newSlide.find(".image img").attr("src", data.file).show();

    newSlide.find(".meta .title").text(data.title);

    if(data.description) {
        newSlide.find(".meta .description span:first-child").html(data.description + " &mdash; ");
    } else {
        newSlide.find(".meta .description span:first-child").html("");
    }

    if(data.author) {
        newSlide.find(".meta .author").text("von " + data.author);
    } else {
        newSlide.find(".meta .author").text("");
    }

    newSlide.find(".meta .date").text(data.date);
}

function slideCountdown() {
    nextImage();
    setTimeout('slideCountdown()', 10000);
}

$(document).ready(function() {
    // slideshow
    if(imageData) {
        $(".slide").show();
        $(this).click(nextImage);
        slideCountdown();
    }
});
