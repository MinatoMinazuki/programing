$(function(){
    $("input[type='submit']").click(function(e){
        var orderProducts;
        $("table").find("tr").each(function(){
            orderProducts = $(this).find("select").val();
            console.log(orderProducts);
            if(orderProducts === "0"){
                $(this).find("option").val("");
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

});