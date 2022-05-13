(function($){
    $(document).ready(()=>{

        flatpickr('input.date', {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d H:i:ss",
        });

    //end document ready
    });
//end IIFE
})($)