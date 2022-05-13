function setUrlParam(paramName, paramValue, currentPage, refresh) {
    if (currentPage === undefined || currentPage === null) currentPage = '';
    if (refresh === undefined || refresh === null) refresh = true;

    if ('URLSearchParams' in window) {
        var searchParams = new URLSearchParams(window.location.search)
        if (paramValue != undefined && paramValue != '' && paramValue != null) {
            searchParams.set(paramName, paramValue);
        }else{
            searchParams.delete(paramName);
        }

        if (currentPage != '')
            searchParams.set('return-page', currentPage);
        var newRelativePathQuery = window.location.pathname + '?' + searchParams.toString();
        history.pushState(null, '', newRelativePathQuery);
    }
    
    if (refresh == true) {
        let refreshBtn = $('#refresh-btn');
        if ( refreshBtn.length != 0 ) {
            refreshBtn.trigger("click");
        }else{
            set_results_per_page();
            location.reload();
        }
    }

}


function set_results_per_page() {
    //set results count per page
    let resultsPerPageValue = '';
    resultsPerPageOption = $('.results-per-page').find(':selected');
    resultsPerPageValue = resultsPerPageOption.val();
    if ( resultsPerPageValue != '' && resultsPerPageValue != undefined ) {
        if ( resultsPerPageOption.attr('data-default') == 'false' ) {
            setUrlParam('results', resultsPerPageValue, '', false);
        }else{
            setUrlParam('results', '', '', false);
        }
    }
}


function promptForDownload (response) {

    if (typeof response != 'object') {
        if ( response === 'nothing_to_export' ) {
            alert( "Δυστυχώς δεν υπάρχουν δεδομένα για εξαγωγή 😥" );
        }else{
            alert( "Κάτι πηγε στραβά" );
        }
        return;
    }

    let baseUrl = '';
    let url ='';
    let fileName = response.filename;
    let friendlyFilename = response.friendly_filename;
    if ( friendlyFilename === undefined || friendlyFilename == null ) friendlyFilename = response.filename;

    baseUrl = window.location.origin + window.location.pathname;
    url = baseUrl + `?page=download&file=${fileName}&friendly-name=${friendlyFilename}`;
    
    window.open(url, '_blank');
}