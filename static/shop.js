var page = 1;

function show_more_results() {
    // Work out url
    var url = "index.php?p=" + page + "&layout=none";
    
    // Check for category
    var cat = $.url().param("cat");
    if (cat) {
        url += "&cat=" + cat;
    }
    
    // Request data
    $.ajax({
        url: url,
        success: function (data) {
            // A really hackish way to check if any data was returned
            if (data.length > 10) {
                $("#product_list").append(data);
            } else {
                $("#show_more_results").html("No more results to show");
            }
        }
    });
    
    // Increase page
    page++;
}
