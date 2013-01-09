var currentImage = 0;
var shuffleMode = false;
var fadeTime = 1000;
var currentMode = "top-3";

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
    setMetadata(newSlide.find(".meta"), data);
}

function setMetadata(metabox, data) {
    metabox.find(".title").text(data.title);

    if(data.description) {
        metabox.find(".description span:first-child").html(data.description + " &mdash; ");
    } else {
        metabox.find(".description span:first-child").html("");
    }

    if(data.author) {
        metabox.find(".author").text("von " + data.author);
    } else {
        metabox.find(".author").text("");
    }

    metabox.find(".date").text(data.date);
}

function updateTop3() {
    $("#top-3-1 img").attr("src", imageData[0].file);
    setMetadata($("#top-3-1 .meta"), imageData[0]);

    $("#top-3-2 img").attr("src", imageData[1].file);
    setMetadata($("#top-3-2 .meta"), imageData[1]);

    $("#top-3-3 img").attr("src", imageData[2].file);
    setMetadata($("#top-3-3 .meta"), imageData[2]);
}

function setStreamMode(mode) {
    if(mode == "slide") {
        $("#stream > div:not(.menu)").hide();
        $(".slide").show();
    } else if(mode == "top-3") {
        $(".slide").hide();
        $("#top-3").show();
        updateTop3();
    }
    currentMode = mode;
}

function slideCountdown() {
    nextImage();
    setTimeout('slideCountdown()', 10000);
}

function updateImageData() {
    $.ajax({
        url: "ajax.php",
        data: "node=recent-images&wall=" + currentWall,
        dataType: "json",
        cache: false,
        success: function(data) {
            imageData = data;
            setStreamMode(currentMode);
        }
    });
}

$(document).ready(function() {
    // slideshow
    if(imageData) {
        $(this).click(nextImage);

        setStreamMode(currentMode);
        slideCountdown();

        setInterval("updateImageData()", 5000);
    }

    $("#mode-select").change(function() {
        setStreamMode($(this).val());
    });
});
