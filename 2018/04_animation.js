$(window).on("load", function(){
    keydown();
});

var keydown = function(){
    var btn_cnt    = 0;                                 // 左右キーを押した回数
    var img_no     = 0;                                 // 画像の番号
    var dist       = 30;                                // 移動距離
    var left_most  = $("div").offset().left;            // 移動可能な左端位置
    var right_most = left_most + $("div").width() - 80; // 移動可能な右端位置（画像の横幅分左にずらす）
    var crnt_pos   = $("img").offset().left;            // 現在位置

    $("html").keydown(function(e){
        // 右キーが押された場合
        if(e.keyCode == 39){
            img_no = (++btn_cnt % 3) + 1;
            $("img").attr("src", "04_images/mario_" + img_no + ".png");

            if(crnt_pos + dist <= right_most){
                $("img").animate({left: "+=" + dist + "px"}, 25);
                crnt_pos += dist;
            }
            else if(crnt_pos < right_most){
                $("img").animate({left: "+=" + (right_most - crnt_pos) + "px"}, 25);
                crnt_pos = right_most;
            }
        }
        // 左キーが押された場合
        else if(e.keyCode == 37){
            img_no = (++btn_cnt % 3) + 4;
            $("img").attr("src", "04_images/mario_" + img_no + ".png");

            if(crnt_pos - dist >= left_most){
                $("img").animate({left: "-=" + dist + "px"}, 25);
                crnt_pos -= dist;
            }
            else if(crnt_pos > left_most){
                $("img").animate({left: "-=" + (crnt_pos - left_most) + "px"}, 25);
                crnt_pos = left_most;
            }
        }
    });
}