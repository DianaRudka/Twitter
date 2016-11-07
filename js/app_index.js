$(document).ready(function() {
    console.log('DOM załadowany');
    
    $('textarea#tweet_text').on('keyup', function() {
        var tweetLength = this.value.length;
        
        console.log(tweetLength);
    })
    
    function commentFunction() {
        
    }

});

