
app.Facebook = function (options) {
    var self = this;
    
    this.options = options || {};
    
    FB.init({
        appId: '644733135604047',
        cookie: true,
        version: 'v2.2'
    });
    
    this.statusChangeCallback = function (response) {
        if (response.status === 'connected') {
            this.loginSuccess();
        } else if (response.status === 'not_authorized') {
            console.log('Please log into this app.');
        } else {
            console.log('Please log into Facebook.');
        }
    };
    
    this.doLogin = function() {
        FB.login(this.statusChangeCallback.bind(this));
    };
    
    this.checkLoginState = function () {
        FB.getLoginStatus(this.statusChangeCallback.bind(this));
    };

    this.loginSuccess = function () {
        FB.api('/me', function (response) {
            self.options.successCallback.call(this, response);
        });
    };
    
    this.refresh = function() {
        $(".fb-like, .fb-share-button, .fb-comments").attr("data-href", location.href);
        FB.XFBML.parse();
    };
    
    this.setMeta = function(data) {
        $("head > meta[property='og:url']").attr("content", location.href);
        $("head > meta[property='og:title']").attr("content", data.title);
        $("head > meta[property='og:description']").attr("content", data.description);
        $("head > meta[property='og:image']").attr("content", location.origin + data.image);
        
        $("head > title").html(data.title + " - PCD Maps");
        $("head > meta[name='description']").attr("content", data.description);
    };
};
