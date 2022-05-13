(function($){
    $(document).ready(()=>{

        $('tr.clickable').click((e)=>{
            let userId = '';
            userId = $(e.target).attr('data-user-id');
            if (userId === undefined) {
                userId = $(e.target).parent().attr('data-user-id');
            }
            if (userId != undefined && userId != '' && userId != null) {
                setUrlParam('user', userId);
            }
        });

    //end document ready
    });
//end IIFE
})($)