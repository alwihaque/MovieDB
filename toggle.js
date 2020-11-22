function toggle() {
    let searchDiv = document.getElementById("advancedSearch");
    if (searchDiv.style.display === "none" || searchDiv.style.display === "") {
        searchDiv.style.display = "block";
    } else {
        searchDiv.style.display = "none";
    }
}
//Please refer to report for detailed explanation of this function
$(document).ready(function () {
    $('[id^=entry]').keyup(function () {
        var query = $(this).val();
        var type;
        var inputID = $(this).attr('id');
        console.log("input id: " + inputID);
        if (inputID === 'entryMovie') {
            type = 'movie';
        } else if (inputID === 'entryActor') {
            type = 'actor';
        } else if (inputID === 'entryGenre') {
            type = 'genre';
        }
        console.log("field type: " + type);
        if (query !== '') {
            $.ajax({
                url: "autocomplete.php",
                method: "POST",
                data: {
                    query: query,
                    type: type
                },
                success: function (data) {
                    console.log(data);
                    if (inputID === 'entryMovie') {
                        $('#autocompleteListMovie').fadeIn();
                        $('#autocompleteListMovie').html(data);
                    } else if (inputID === 'entryActor') {
                        $('#autocompleteListActor').fadeIn();
                        $('#autocompleteListActor').html(data);
                    } else if (inputID === 'entryGenre') {
                        $('#autocompleteListGenre').fadeIn();
                        $('#autocompleteListGenre').html(data);
                    }
                }

            });
        } else {
            if (inputID === 'entryMovie') {
                $('#autocompleteListMovie').html('');
            } else if (inputID === 'entryActor') {
                $('#autocompleteListActor').html('');
            } else if (inputID === 'entryGenre') {
                $('#autocompleteListGenre').html('');
            }
        }
    });

    $(document).on('click', 'li', function () {
        var parentId = $(this).parent().attr('id');
        var divId = $(this).parent().parent().attr('id');
        if (parentId.substr(0,12) === 'autoComplete' && $(this).text() !== 'Not found') {
            if (divId === 'autocompleteListMovie'){
                $('#entryMovie').val($(this).text());
            } else if (divId === 'autocompleteListActor'){
                $('#entryActor').val($(this).text());
            } else if (divId === 'autocompleteListGenre'){
                $('#entryGenre').val($(this).text());
            }
            $('#'+divId).fadeOut();
        }

    })
});