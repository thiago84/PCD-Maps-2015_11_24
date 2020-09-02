
angularApp.controller("UsuariosController", function ($scope, Usuario) {
    $scope.init = function() {
        Usuario.query(function(usuarios) {
            $scope.usuarios = usuarios;
        });
    };
    
    $scope.excluir = function() {
        if (confirm("Deseja mesmo excluir o usuário?")) {
            Usuario.delete({ id: this.usuario.id }, function() {
                Materialize.toast("Usuário excluído com sucesso.", 4000);
                $scope.init();
            });
        }
    };
    
    $scope.init();
});

angularApp.controller("UsuarioUpdateController", function ($scope, $routeParams, Usuario) {
    Usuario.get({ id: $routeParams.id }, function (usuario) {
        $scope.usuario = usuario;
        app.update();
    });

    $scope.salvar = function () {
        Usuario.update($scope.usuario, function () {
            Materialize.toast("Usuário atualizado com sucesso.", 4000);
            location.hash = "#/painel/usuarios";
        });
    };
});
