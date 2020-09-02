
angular.module("app").controller("MainController", function ($rootScope, $scope, $location, Entrar) {
    $rootScope.token = $.cookie("token");
    
    $scope.auth = Entrar;
    $scope.logged = false;
    
    $scope.isAdmin = function () { 
        return $scope.logged && !("/inicial" === $location.path() || "/entrar" === $location.path());
    };
    
    $scope.$on("update", function() {
        $scope.menu = [];
        
        $scope.auth.get(function(response) {
            $rootScope.token = null;
            
            if (response.token) {
                $rootScope.token = response.token;
                $rootScope.username = response.username;
                
                for(var item in response.modules) {
                    var module = response.modules[item];
                    $scope.menu.push({ title: module.title, href: module.href });
                }
//                $scope.menu.push({ title: "Denúncias", href: "#/denuncias" });
//                $scope.menu.push({ title: "Classificações", href: "#/classificacoes" });
//                $scope.menu.push({ title: "Usuários", href: "#/usuarios" });
//                $scope.menu.push({ title: "Estatisticas", href: "#/estatisticas" });
            }
            
            $scope.logged = $rootScope.token ? true : false;
        });
    });
    
    $scope.sair = function() {
        $scope.auth.delete({ id: $rootScope.token }, function() {
            $rootScope.token = null;
            $scope.logged = false;
            $scope.$emit("update");
            location.href = "#/inicial";
        });
    };
    
    $scope.$emit("update");
});

angular.module("app").controller("EstatisticasController", function ($scope, Estatisticas) {
    $scope.estatisticas = [];
    
    Estatisticas.query(function(estatisticas) {
        $scope.estatisticas = estatisticas[0];
    });
});
