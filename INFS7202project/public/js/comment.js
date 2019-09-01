

	var saveComment = function(pid){
    $('#commentText,#ratingRadios').removeClass("is-invalid");
    var isValidComment = true;

    var comment = $('#commentText').val();
    if(comment == '') {
        $('#commentText').addClass("is-invalid");
        isValidComment = false;
    }

    var rating = false;
    var radios = document.getElementsByName("rating");
    for (var i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            rating = radios[i];
            break;
        }
    }
    if (!rating.value) {
        $('#ratingRadios').addClass("is-invalid");
        isValidComment = false;
    }

    if(isValidComment) {
        url = "http://localhost/INFS7202project/app/api/addComment.php?pid={0}&comment={1}&rating={2}".format(pid, comment, rating.value);
        // url = "https://infs3202-49f0fc7f.uqcloud.net/INFS7202project/app/api/addComment.php?pid={0}&comment={1}&rating={2}".format(pid, comment, rating.value);
        // Ajax request
        $.ajax({
            url: url,
            success: function(result){
                // Clear comment and rating
                $('#commentText').val("");
                rating.checked = false;
                var json = JSON.parse(result);
                if(json.success == false) {
                    // TODO: handle error
                } else {
                    commentHTML = $($.parseHTML(json.content));
                    $("#commentsArea").prepend(commentHTML.hide());
                    commentHTML.slideDown('slow');
                }
            },
            error: function() {
                console.log("Uh-oh");
            }
        });
    }
	};


	String.prototype.format = function () {
	var args = [].slice.call(arguments);
	return this.replace(/(\{\d+\})/g, function (a){
	    return args[+(a.substr(1,a.length-2))||0];
	});
	};
