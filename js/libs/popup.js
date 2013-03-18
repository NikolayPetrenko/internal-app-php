$(function() {
    $('.btn').click(function(){
        if(!$(this).is('.remove-answer') && !$(this).is('.dropdown-toggle')){
            $('.fixed').css({display:"block"});
            $('body').css({overflow:"hidden"}); 
        }
    });

    $('.close-modal').click(function() {
        $('body').css({overflow:"auto"});
        $('.fixed').fadeOut(); 
    });
    
    $('.modal-footer .btn').click(function(e) {
        e.preventDefault();
        $('body').css({overflow:"auto"});
        $('.fixed').fadeOut(); 
        $('.modal-backdrop').hide();
    });

    $('body').click(function() {
        $('body').css({overflow:"auto"});
        $('.fixed').fadeOut(); 
        $('.modal-backdrop').hide();
    });
    
    $('#questionModal, .btn').click(function(event){
        if(!$(this).is('.dropdown-toggle')){
            event.stopPropagation();
        }
    }); 
});
