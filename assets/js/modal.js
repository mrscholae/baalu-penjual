$(function() {  
    $(".btn-form-1").click(function(){
        btn_1();
    })

    $(".btn-form-2").click(function(){
        btn_2();
    })
    
    $(".btn-form-3").click(function(){
        btn_3();
    })

    function btn_1(){
        // button form
        $(".btn-form-1").addClass("active");
        $(".btn-form-2").removeClass("active");
        $(".btn-form-3").removeClass("active");

        // form
        $(".form-1").show();
        $(".form-2").hide();
        $(".form-3").hide();

        // footer
        $(".footer-1").show();
        $(".footer-2").hide();
        $(".footer-3").hide();
    }

    function btn_2(){
        // button form
        $(".btn-form-1").removeClass("active");
        $(".btn-form-2").addClass("active");
        $(".btn-form-3").removeClass("active");

        // form
        $(".form-1").hide();
        $(".form-2").show();
        $(".form-3").hide();
        
        // footer
        $(".footer-1").hide();
        $(".footer-2").show();
        $(".footer-3").hide();
    }
    
    function btn_3(){
        // button form
        $(".btn-form-1").removeClass("active");
        $(".btn-form-2").removeClass("active");
        $(".btn-form-3").addClass("active");

        // form
        $(".form-1").hide();
        $(".form-2").hide();
        $(".form-3").show();
        
        // footer
        $(".footer-1").hide();
        $(".footer-2").hide();
        $(".footer-3").show();
    }
    
})