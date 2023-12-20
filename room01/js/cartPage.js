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

});