$(function(){
    // $(".intoCartBtn").on("click", function(){
    //     $(".cartIconOuter").attr("data-show", "1");
    // });

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
            var editText = $(this).text();
            if($(this).hasClass("int")){
                $(this).html("<input type='number' value='"+editText+"''/>");
  
            } else {
                $(this).html("<input type='text' value='"+editText+"''/>");
            };
            $(".edit").find("input").focus().blur(function(){
                var inputVal = $(this).val();
                if(inputVal === ""){
                    inputVal = this.defaultValue;
                };
            $(this).parent().removeClass('on').text(inputVal);
            });
        };
    });

});