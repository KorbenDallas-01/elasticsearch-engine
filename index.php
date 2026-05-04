<!DOCTYPE html>
<html lang="pl"><head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="db.ico">
    <link rel="stylesheet" href="style.css">
    <title>Wyszukiwarka zarządzeń</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery for simplicity -->
</head>

<body>
    <form id="search-form" action="javascript:void(0);" method="get" autocomplete="off">
    <div class="box">
                <img src="logo-ibe.png" height="170" width="500">
    </div>
      <div class="container">
        
		<div class="search-container">
            
            <select name="pi_input" id="pi_input">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="10">10</option>
            </select>
            <input type="text" name="q" id="search-input" placeholder="wpisz czego szukasz" style="width: 350px;" required="">
            <input type="submit" class="button" value="szukaj">
        </div>
		<div id="results-container"></div>
		</div>
    </form>

     <!-- Container for search results -->

    <script>
        // Set the selected value of the dropdown and the search input on page load
        document.getElementById('pi_input').value = "1";
        document.getElementById('search-input').value = "";

        // jQuery to handle form submission via AJAX
        $('#search-form').on('submit', function() {
            var query = $('#search-input').val();
            var pi_input = $('#pi_input').val();

            $.ajax({
                url: 'search.php',
                type: 'GET',
                data: { q: query, pi_input: pi_input },
                success: function(response) {
                    var resultsContainer = $('#results-container');
                    resultsContainer.empty(); // Clear previous results

                    if (response.length === 0) {
                        resultsContainer.append('<p>Nie znaleziono żądanych wyników. Spróbuj inaczej.</p>');
                    } else {
                        var resultsLimit = parseInt(pi_input);
                        $.each(response.slice(0, resultsLimit), function(index, result) {
                            var link = result._source.filename;
                            var filename = result._source.filename;
                            var firstWords = filename.split(/\s+/).slice(0, 50).join(" ");
							if (filename.toLowerCase().endsWith(".pdf")){
                            resultsContainer.append('<div class="results-container"><img src="pdf.png">  ' + firstWords + ' <a href="/elasticsearch-php/pdfs/' + link + 'target="_blank">[_link_]</a></div><br>');
							}
						});
                    }
                },
                error: function() {
                    $('#results-container').html('<p>Wystąpił błąd. Spróbuj ponownie.</p>');
                }
            });
        });
    </script>
</body>
</html>

