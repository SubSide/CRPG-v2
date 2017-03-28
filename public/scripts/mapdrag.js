function Map(el){
    this.el = el;
    this.mouseX = 0;
    this.mouseY = 0;
    this.isDragging = false;
}

Map.prototype.startDrag = function(x, y){
    this.mouseX = x;
    this.mouseY = y;
    this.isDragging = true;
}

Map.prototype.stopDrag = function(){
    this.isDragging = false;
}

Map.prototype.drag = function(x, y){
    if(this.isDragging) {
        var left = parseInt($(this.el).css("left")) + (x - this.mouseX);
        var top = parseInt($(this.el).css("top")) + (y - this.mouseY);

        if(left < ($(".map").parent().width() - $(".map").width())) left = ($(".map").parent().width() - $(".map").width());
        if(left > 0) left = 0;

        if(top < ($(".map").parent().height() - $(".map").height())) top = ($(".map").parent().height() - $(".map").height());
        if(top > 0) top = 0;

        $(this.el).css({left: left+"px", top: top+"px"});
        this.mouseX = x;
        this.mouseY = y;
    }
}


var map = new Map(".map");

$(document).ready(function(){
    $(".playfield").bind("mousedown touchstart", function(e){
        var pageX = e.pageX;
        var pageY = e.pageY;

        if(e.type == "touchstart"){
            var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            pageX = touch.pageX;
            pageY = touch.pageY;
        }

        e.preventDefault();
        map.startDrag(pageX, pageY);
    });
    $(document).bind("mouseup touchend touchcancel", function(e){
        map.stopDrag();
    });
    $(document).bind("mousemove touchmove", function(e){
        var pageX = e.pageX;
        var pageY = e.pageY;

        if(e.type == "touchmove"){
            var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouches[0];
            pageX = touch.pageX;
            pageY = touch.pageY;
        }

        map.drag(pageX, pageY);
    });
})