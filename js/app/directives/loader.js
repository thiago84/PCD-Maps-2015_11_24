
angular.module("app").directive("loader", function () {
    return {
        controller: function($rootScope, $scope) {
            $rootScope.$watch("pendingRequests", function(value) {
                $scope.loading = value ? true : false;
            });
        },
        scope: {},
        restrict: "E",
        templateUrl: "/js/app/directives/loader.html"
    };
});
