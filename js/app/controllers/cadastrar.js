
angularApp.controller("CadastrarController", function ($scope, Usuario) {
    $scope.usuario = new Usuario();
    
    $scope.cadastrar = function () {
        Usuario.save($scope.usuario, function () {
            Materialize.toast("Cadastro efetuado com sucesso.", 4000);
            location.hash = "#/entrar";
        });
    };
});
