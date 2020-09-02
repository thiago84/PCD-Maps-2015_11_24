
angularApp.controller("ContatoCreateController", function ($scope, Contato) {
    $scope.contato = new Contato();

    $scope.salvar = function () {
        Contato.save($scope.contato, function () {
            Materialize.toast("Contato inserido com sucesso.", 4000);
            location.hash = "#/painel/contatos";
        });
    };
});

angularApp.controller("ContatoUpdateController", function ($scope, $routeParams, Contato) {
    Contato.get({ id: $routeParams.id }, function (contato) {
        $scope.contato = contato;
        app.update();
    });

    $scope.salvar = function () {
        Contato.update($scope.contato, function () {
            Materialize.toast("Contato atualizado com sucesso.", 4000);
            location.hash = "#/painel/contatos";
        });
    };
});

angularApp.controller("ContatoController", function ($scope, Contato) {
    $scope.init = function() {
        Contato.query(function(contatos) {
            $scope.contatos = contatos;
        });
    };
    
    $scope.excluir = function() {
        if (confirm("Deseja mesmo excluir o contato?")) {
            Contato.delete({ id: this.contato.id }, function() {
                Materialize.toast("Contato excluído com sucesso.", 4000);
                $scope.init();
            });
        }
    };
    
    $scope.init();
});
