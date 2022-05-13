(function($){
    $(document).ready(()=>{
        //Set results per page
        $('.results-per-page').on('change',()=>{
            let refreshBtn = $('#refresh-btn');
            if ( refreshBtn.length != 0 ) {
                refreshBtn.trigger("click");
            }else{
                set_results_per_page();
                location.reload();
            }
        });

        //Page numbers
        $('.pagin .page').click((e)=>{
            let page = $(e.target).attr('data-page-number');
            setUrlParam('page_number', page);
        });
       
        //Nav prev arrow
        $('.pagin .prev').click(()=>{
            let currentPage = $('.pagin').attr('data-selectd-page');
            currentPage = parseInt(currentPage);
            setUrlParam('page_number', currentPage-1);
        });

        //Nav next arrow
        $('.pagin .next').click(()=>{
            let currentPage = $('.pagin').attr('data-selectd-page');
            currentPage = parseInt(currentPage);
            setUrlParam('page_number', currentPage+1);
        });

    //end document ready
    });
//end IIFE
})($)