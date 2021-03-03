$(function() {

    $(".addProdukToko").click(function(){
        btn_1();
    })
    
    $(".btn-form-1").click(function(){
        btn_1();
    })

    $(".btn-form-2").click(function(){
        btn_2();
    })

    function btn_1(){
        // button form
        $(".btn-form-1").addClass("active");
        $(".btn-form-2").removeClass("active");

        // form
        $(".form-1").show();
        $(".form-2").hide();
    }

    function btn_2(){
        // button form
        $(".btn-form-1").removeClass("active");
        $(".btn-form-2").addClass("active");

        // form
        $(".form-1").hide();
        $(".form-2").show();
    }
})