<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習</title>
</head>
<body>
<table>
<form method="POST" action="post.php">
<td>
    <ul class="recommendColor">
        <li class="icon num1" data-colorcode="111">アイコン1</li>
        <li class="icon num2" data-colorcode="222">アイコン2</li>
        <li class="icon num3" data-colorcode="333">アイコン3</li>
        <li class="icon num4" data-colorcode="444">アイコン4</li>
        <li class="icon num5" data-colorcode="555">アイコン5</li>
        <li class="icon num6" data-colorcode="666">アイコン6</li>
        <li class="icon num7" data-colorcode="777">アイコン7</li>
        <li class="icon num8" data-colorcode="888">アイコン8</li>
        <input type="hidden" name="recommendColor" value="">
    </ul>
    <br>
    <ul class="deprecatedColor">
        <li class="icon num21" data-colorcode="111">アイコン1</li>
        <li class="icon num22" data-colorcode="222">アイコン2</li>
        <li class="icon num23" data-colorcode="333">アイコン3</li>
        <li class="icon num24" data-colorcode="444">アイコン4</li>
        <li class="icon num25" data-colorcode="555">アイコン5</li>
        <li class="icon num26" data-colorcode="666">アイコン6</li>
        <li class="icon num27" data-colorcode="777">アイコン7</li>
        <li class="icon num28" data-colorcode="888">アイコン8</li>
        <input type="hidden" name="deprecatedColor" value="">
    </ul>
</td>
<input type="submit" name="colors" value="送信">
</form>

<td>
    <ul class="recommendColor">
        <li class="icon num1" data-colorcode="111">アイコン1</li>
        <li class="icon num2" data-colorcode="222">アイコン2</li>
        <li class="icon num3" data-colorcode="333">アイコン3</li>
        <li class="icon num4" data-colorcode="444">アイコン4</li>
        <li class="icon num5" data-colorcode="555">アイコン5</li>
        <li class="icon num6" data-colorcode="666">アイコン6</li>
        <li class="icon num7" data-colorcode="777">アイコン7</li>
        <li class="icon num8" data-colorcode="888">アイコン8</li>
        <input type="hidden" name="recommendColor" value="">
    </ul>
<br>
    <ul class="deprecatedColor">
        <li class="icon num21" data-colorcode="111">アイコン1</li>
        <li class="icon num22" data-colorcode="222">アイコン2</li>
        <li class="icon num23" data-colorcode="333">アイコン3</li>
        <li class="icon num24" data-colorcode="444">アイコン4</li>
        <li class="icon num25" data-colorcode="555">アイコン5</li>
        <li class="icon num26" data-colorcode="666">アイコン6</li>
        <li class="icon num27" data-colorcode="777">アイコン7</li>
        <li class="icon num28" data-colorcode="888">アイコン8</li>
        <input type="hidden" name="deprecatedColor" value="">
    </ul>
</td>

</table>
</body>
<style type="text/css">
    .icon.selected{
        color: red;
    }

    .selectedColor{
        opacity: 0.2;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script>
    $(function(){

        function recommendColor(icon){

            var colorcode = icon.attr("data-colorcode");

            if(icon.hasClass("selected")){
                icon.removeClass("selected");
                icon.closest("td").find(".icon[data-colorcode="+ colorcode +"]").removeClass("selectedColor");
                console.log(1);

            } else if (icon.hasClass("selectedColor")){
                console.log("none");
            } else {
                if(icon.closest("ul").find(".icon.selected").length === 3){
                    console.log(2);
                } else{
                    icon.addClass("selected");

                    icon.closest("td").find(".icon[data-colorcode="+ colorcode +"]").addClass("selectedColor");
                    icon.removeClass("selectedColor");
                }
            }

        }

        function deprecatedColor(icon){

            var colorcode = icon.attr("data-colorcode");

            if(icon.hasClass("selected")){
                icon.removeClass("selected");
                icon.closest("td").find(".icon[data-colorcode="+ colorcode +"]").removeClass("selectedColor");
            } else if (icon.hasClass("selectedColor")){
                //
            } else {
                icon.addClass("selected");

                icon.closest("td").find(".icon[data-colorcode="+ colorcode +"]").addClass("selectedColor");
                icon.removeClass("selectedColor");
            }
        }

        $(".recommendColor .icon").on("click", function(){

            var icon = $(this)
            var colorcode = $(this).attr("data-colorcode");

            recommendColor(icon);

            var colors = [];
            $(this).closest("ul").find($("input[name='recommendColor']")).val("");

            $(this).closest("ul").find(".icon.selected").each(function(){

                var colorcode = $(this).attr("data-colorcode");
                colors.push(colorcode);

                codes = colors.join(",");
                console.log(codes);

                $(this).closest(".recommendColor").find($("input[name='recommendColor']")).val(codes);

            });

        });

        $(".deprecatedColor .icon").on("click", function(){

            var icon = $(this);
            var colorcode = $(this).attr("data-colorcode");

            deprecatedColor(icon);

            var colors = [];
            $(this).closest("ul").find($("input[name='deprecatedColor']")).val("");

            $(this).closest("ul").find(".icon.selected").each(function(){

                var colorcode = $(this).attr("data-colorcode");
                colors.push(colorcode);

                codes = colors.join(",");
                console.log(codes);

                $(this).closest(".deprecatedColor").find($("input[name='deprecatedColor']")).val(codes);

            });
        });

    });
</script>
</html>


<!-- $(function(){

$(".js-recommendColor .colorIcon").on("click", function(){

     var colorcode = $(this).attr("data-colorcode");

        if($(this).hasClass("selected")){

            $(this).removeClass("selected");

            $(".colorIcon[data-colorcode=" + colorcode + "]").removeClass("recommendSelected");
            // console.log("remove");
        } else {

            if($(".js-recommendColor .colorIcon.selected").length === 3){
                // 何もしない
                // console.log("3");
        } else {
            $(this).addClass("selected");
            $(".colorIcon[data-colorcode=" + colorcode + "]").addClass("recommendSelected");
            $(this).removeClass("recommendSelected");
            // console.log("add");
        }
    }

        var codes = "";

        $(this).closest("td").find(".colorIcon").each( function(){

            if( $(this).hasClass("selected") ){

            var colorCode = $(this).attr("data-colorcode");

            codes += colorcode;

            console.log(codes);

            }
        });
    });



    $(".js-deprecatedColor .colorIcon").on("click", function(){

        if($(this).hasClass("recommendSelected")){
            // 何もしない
        } else if($(this).hasClass("selected")){
            $(this).removeClass("selected");
            // console.log("remove");
        } else {

            $(this).addClass("selected");
            // console.log("add");
        }
    });
}); -->