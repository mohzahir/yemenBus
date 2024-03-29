//used in front page to add minus tickets
$(document).on('click', '.btn-number', function(e){
    e.preventDefault();
    var currentVal = parseInt($('.ticketNo').val());
    if (!isNaN(currentVal)) {
        let currentBtn = $(this).data('type');

        if (currentBtn == 'plus' && currentVal < 8)
        {
            $('.ticketNo').val(currentVal+1);
        }else if(currentBtn == 'minus' && currentVal > 1){
            $('.ticketNo').val(currentVal-1);
        }
    }

});

////////////// to handel payment form

$(document).on( 'click' , 'input[name = "payment_type"]', function(){
    let radioValue = $(this).attr("value")
    if ( radioValue == "total_payment" || radioValue == 'deposit_payment') {
        $(".pay-div").show('slow');
        $(".on_delivery-div").hide('slow');
        $(".url-div").hide('slow');
    }
    if (radioValue == "later_payment") {
        $(".pay-div").hide('slow');
        $(".url-div").hide('slow');
        $(".on_delivery-div").hide('slow');
        $(".bank-trans").hide('slow');
    }
  //  $('input[name = "payment_type"]').trigger('click');  
})

$(document).on( 'click' , '#friend', function(){
    $(".pay-div").hide('slow');
    $(".bank-trans").hide('slow');
    $(".on_delivery-div").hide('slow');
    $(".url-div").show('slow');
});
$(document).on( 'click' , '#nopay', function(){
    $(".pay-div").hide('slow');
    $(".bank-trans").hide('slow');
    $(".url-div").hide('slow');
    $(".on_delivery-div").show('slow');
});



$(document).on( 'click' , 'input[name = "paymentType"]', function(){
    let radioValue = $(this).attr("value")
    if ( radioValue == "bank") {
        $(".bank-trans").show('slow');
    }
    if (radioValue == "telr") {
        $(".bank-trans").hide('slow');
    }
    //$('input[name = "paymentType"]').trigger('click');  
})

///////////// to add passengers tickets in form 

var i=1; 

$(document).on( 'click' , '.add-ticket',function(e){  
    e.preventDefault()
     i++;  
    $('.remove-ticket').show();
    $('.remove-ticket').attr('id',i);
     $('.add-passenger-container').append(`<div class="form-group d-flex passenger-row passenger-`+i+`" id="passenger-row">
                    <input class="form-control valid" name="name[]" id="name" type="text" 
                    placeholder=" اسم الراكب">
                    
                    <div style="margin-right: 3px"></div>
                    <select class="form-control" name="age[]" id="age-`+i+`">
                        <option value="">الفئة العمرية للراكب</option>
                        <option value="adult">بالغ</option>
                        <option value="child">طفل (من سنتين الى 12)</option>
                        <option value="baby">رضيع (تحت السنتين)</option>
                    </select>
                    <div style="margin-right: 3px"></div>
                    
                    <select class="form-control" name="gender[]" id="gender-`+i+`">
                    <option value="">جنس الراكب</option>
                        <option value="femal">انثى</option>
                        <option value="male">ذكر</option>
                    </select>
                    <div style="margin-right: 3px"></div>
                    
                    <input class="form-control" name="dateofbirth[]" type="text" style="margin-right: 3px" placeholder="تاريخ الميلاد(dd-mm-yyyy)" required>

                    <input class="form-control" name="nid[]" id="nid" type="text" style="margin-right: 3px"
                    placeholder="رقم هوية الراكب">
                </div>`);  
                $('#gender-'+i).niceSelect(); 
                $('#age-'+i).niceSelect(); 

});  

$(document).on('click', '.remove-ticket', function(e){  
    e.preventDefault()
    var button_id = $(this).attr("id");   
    i--;
    $(this).attr("id", i);  
    $('.passenger-'+button_id).remove();  

});  


