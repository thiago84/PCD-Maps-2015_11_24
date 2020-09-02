
angular.module("app").factory("httpInterceptor", function($q, $rootScope) {
    $rootScope.pendingRequests = 0;
    
    return {
        request: function (config) {
            $rootScope.pendingRequests++;
            
            if ($rootScope.token) {
                config.headers = {
                    "Authorization" : "Basic ".concat($rootScope.token)
                };
            }
            
            return config || $q.when(config);
        },
        response: function (response) {
            $rootScope.pendingRequests--;
            return response || $q.when(response);
        },
        responseError: function (response) {
            $rootScope.pendingRequests--;
            
            switch(response.status) {
                case 401:
                    location.hash = "#/entrar";
                    break;
                default:
                    Materialize.toast(response.data.error.message, 4000);
                    break;
            }
            
            return $q.reject(response);
        }
    };
});

angular.module("app").config(function($httpProvider) {
    $httpProvider.interceptors.push("httpInterceptor");
});
