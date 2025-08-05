<input type="text" id="search" placeholder="Search product..." autocomplete="off">
<div id="search-results"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('#search').on('keyup', function () {
        let query = $(this).val();

        if (query.length > 0) {
            $.ajax({
                url: "{{ route('search.auto') }}",
                method: "GET",
                data: { query: query },
                success: function (data) {
                    let results = '';
                    if (data.length > 0) {
                        data.forEach(item => {
                            results += `<p>${item.email}</p>`;
                        });
                    } else {
                        results = '<p>No results found</p>';
                    }
                    $('#search-results').html(results);
                }
            });
        } else {
            $('#search-results').html('');
        }
    });
});
</script>
