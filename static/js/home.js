$(document).ready(function() {
    for(var i = 1; i < $(".display-content").length; i ++) {
        var maxHeight;
        if($(".display-content").eq(i-1).height() < $(".display-content").eq(i).height()) {
            maxHeight = $(".display-content").eq(i).height();
        } else if ($(".display-content").eq(i-1).height() > $(".display-content").eq(i).height()){
            maxHeight = $(".display-content").eq(i-1).height();
        }
    }
    for(var i = 0; i < $(".display-content").length; i ++) {
        $(".display-content").eq(i).css("height", maxHeight + "px")
    }
});
