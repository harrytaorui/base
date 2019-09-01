
$('#search-bar').on('keyup', function(event) {
    var query = this.value;

    url = "http://localhost/INFS7202project/app/api/liveSearch.php?queryString=" + query;
    // url = "https://infs3202-49f0fc7f.uqcloud.net/infs3202project/app/api/liveSearch.php?queryString=" + query;
    
    // Ajax request
    $.ajax({
        url: url,
        success: function(result){
            // Clear suggestions list
            suggestionHTML = $('#hint');
            suggestionHTML.empty();

            var json = JSON.parse(result);
            var suggestionList = json.topSuggestions;
        
            // ERROR: i will go out of bounds
            for (var i in suggestionList) {
                var element = '<a class="btn" style="text-decoration: underline;color: blue;" onclick="fillSearchInput(\'' + 
                    suggestionList[i] + '\')">' + suggestionList[i] + '</a>';
                suggestionHTML.append(element);
            }
            
        }
    });
});


function fillSearchInput($text) {
    console.log($text);
    var inputField = $('#search-bar');
    inputField.val($text);
    inputField.next().children().click();
}