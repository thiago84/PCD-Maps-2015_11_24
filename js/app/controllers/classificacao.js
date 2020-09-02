
angularApp.controller("ClassificacaoCreateController", function ($scope, Classificacao) {
    $scope.classificacao = new Classificacao();

    $scope.salvar = function () {
        Classificacao.save($scope.classificacao, function () {
            Materialize.toast("Classificação inserida com sucesso.", 4000);
            location.hash = "#/painel/classificacoes";
        });
    };
});

angularApp.controller("ClassificacaoUpdateController", function ($scope, $routeParams, Classificacao) {
    Classificacao.get({ id: $routeParams.id }, function (classificacao) {
        $scope.classificacao = classificacao;
        app.update();
    });

    $scope.salvar = function () {
        Classificacao.update($scope.classificacao, function () {
            Materialize.toast("Classificação atualizada com sucesso.", 4000);
            location.hash = "#/painel/classificacoes";
        });
    };
});

angularApp.controller("ClassificacoesController", function ($scope, Classificacao) {
    $scope.init = function() {
        Classificacao.query(function(classificacoes) {
            $scope.classificacoes = classificacoes;
        });
    };
    
    $scope.excluir = function() {
        if (confirm("Deseja mesmo excluir a classificação?")) {
            Classificacao.delete({ id: this.classificacao.id }, function() {
                Materialize.toast("Classificação excluída com sucesso.", 4000);
                $scope.init();
            });
        }
    };
    
    $scope.init();
});
