
angularApp.controller("EntrarController", function ($rootScope, $scope, Entrar, Facebook) {
    $scope.usuario = new Entrar();
    
    $scope.entrar = function () {
        Entrar.save($scope.usuario, function (response) {
            $scope.success(response);
        });
    };
    
    $scope.facebook = function() {
        var appFacebook = new app.Facebook({
            successCallback: function(facebookResponse) {
                Facebook.save(facebookResponse, function(response) {
                    $scope.success(response);
                });
            }
        });
        appFacebook.doLogin();
    };
    
    $scope.success = function(response) {
        $rootScope.token = response.token;
        $rootScope.logged = response.token ? true : false;
        $scope.$emit("update");
        Materialize.toast("Usuário autenticado com sucesso.", 4000);
        location.hash = "#/inicial";
    };
});
