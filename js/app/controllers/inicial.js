
angularApp.controller("InicialController", function ($scope, Denuncia) {
    $scope.mapa = new app.Mapa("#mapa");
    $scope.mapa.init();
    
    Denuncia.query(function(denuncias) {
        $scope.denuncias = denuncias;
        $scope.mapa.carregarPontos(denuncias);
    });
});
