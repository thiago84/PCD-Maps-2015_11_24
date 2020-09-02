
angularApp.controller("DenunciaController", function ($scope, MinhaDenuncia) {
    $scope.init = function() {
        MinhaDenuncia.query(function(denuncias) {
            $scope.denuncias = denuncias;
        });
    };
    
    $scope.excluir = function() {
        if (confirm("Deseja mesmo excluir a denúncia?")) {
            MinhaDenuncia.delete({ id: this.denuncia.id }, function() {
                Materialize.toast("Denúncia excluída com sucesso.", 4000);
                $scope.init();
            });
        }
    };
    
    $scope.init();
});

angularApp.controller("DenunciaCreateController", function ($scope, MinhaDenuncia, Classificacao) {
    Classificacao.query(function(classificacoes) {
        $scope.classificacoes = classificacoes;
    });
    
    $scope.denuncia = new MinhaDenuncia();
    
    $scope.mapa = new app.Mapa("#mapa");
    $scope.mapa.init();
    $scope.mapa.setChangeMarkerCallback(function(latitude, longitude, formattedAddress, bairro) {
        $scope.$apply(function() {
            $scope.denuncia.latitude = latitude;
            $scope.denuncia.longitude = longitude;
            $scope.denuncia.localizacao = formattedAddress;
            $scope.denuncia.bairro = bairro;
            app.update();
        });
    });
    $scope.mapa.getCurrentPosition();
    $scope.mapa.enableAutocomplete();
    
    $scope.salvar = function () {
        MinhaDenuncia.save($scope.denuncia, function () {
            Materialize.toast("Denúncia efetuada com sucesso.", 4000);
            location.hash = "#/painel/denuncias";
        });
    };
});

angularApp.controller("DenunciaUpdateController", function ($scope, $routeParams, MinhaDenuncia, Classificacao) {
    Classificacao.query(function(classificacoes) {
        $scope.classificacoes = classificacoes;
    });
    
    $scope.mapa = new app.Mapa("#mapa");
    $scope.mapa.init();
    $scope.mapa.setChangeMarkerCallback(function(latitude, longitude, formattedAddress, bairro) {
        $scope.$apply(function() {
            $scope.denuncia.latitude = latitude;
            $scope.denuncia.longitude = longitude;
            $scope.denuncia.localizacao = formattedAddress;
            $scope.denuncia.bairro = bairro;
            app.update();
        });
    });
    
    MinhaDenuncia.get({ id: $routeParams.id }, function (denuncia) {
        $scope.denuncia = denuncia;
        
        $scope.mapa.definirPosicao({
            latitude  : $scope.denuncia.latitude,
            longitude : $scope.denuncia.longitude
        });
        
        app.update();
    });
    
    $scope.salvar = function () {
        MinhaDenuncia.update($scope.denuncia, function () {
            Materialize.toast("Denúncia atualizada com sucesso.", 4000);
            location.hash = "#/painel/denuncias";
        });
    };
});

angularApp.controller("DenunciaVisualizarController", function ($scope, $routeParams, Denuncia) {
    $scope.mapa = new app.Mapa("#mapa");
    $scope.mapa.init();
    
    Denuncia.get({ id: $routeParams.id }, function (denuncia) {
        $scope.denuncia = denuncia;
        
        $scope.mapa.definirPosicao({
            latitude  : $scope.denuncia.latitude,
            longitude : $scope.denuncia.longitude
        });
        
        var facebook = new app.Facebook();
        facebook.setMeta({
            title: denuncia.titulo,
            description: denuncia.descricao,
            image: denuncia.imagem ? denuncia.imagem.url : null
        });
        facebook.refresh();
        
        app.update();
    });
});
