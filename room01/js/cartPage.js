$(function(){
    $("input[type='submit']").click(function(e){
        var orderProducts;
        $("table").find("tr").each(function(){
            orderProducts = $(this).find("select").val();
            console.log(orderProducts);
            if(orderProducts === "0"){
                $(this).find("option").val("");
                $(this).find("input").val("");
            }
        });
    });

    $(".edit").on("click", function(){
        if(!$(this).hasClass("on")){
            $(this).addClass("on");

            var parentElement = $(this).closest(".edit");
            var editText = $(this).text();
            $(this).find("input").attr("data-show", "1");
            $(this).find("span").attr("data-show", "0");

            $(this).find("input").focus().blur(function(){
                var inputVal = $(this).val();
                if(inputVal === ""){
                    inputVal = this.defaultValue;
                };

                $(this).attr("data-show", "0");
                $(this).attr("value", inputVal);
                parentElement.removeClass('on').find("span").text(inputVal);
                parentElement.find("span").attr("data-show", "1");
            });
        };
    });

    $(".tdOrder select").change(function(){
        var self = $(this);
        var orderNum = 0;

        $(".tdOrder").each(function(){

            var slectOrder = $(this).find("select").val();

            orderNum = Number(orderNum) + Number(slectOrder);

        });

        if( orderNum === 0 ){
            $(".insideCartOrder").text("0");
            $("body").attr("data-cart-show", "0");
        } else {
            $(".insideCartOrder").text(orderNum);
            $("body").attr("data-cart-show", "1");
        }

    });

    $(".shoppingCart").click(function(){
        $(".submitBtn").click();
    })

    $(".userInfoTitleWrapper").click(function(){

        var isUserInfoSow = $(this).closest(".userInfoWrapper").attr("data-userinfo-show");

        if(isUserInfoSow === "1"){
            $(this).closest(".userInfoWrapper").attr("data-userinfo-show", "0");
        } else {
            $(this).closest(".userInfoWrapper").attr("data-userinfo-show", "1");
        }

    })

});