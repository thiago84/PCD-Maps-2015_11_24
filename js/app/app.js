
// http://www.sitepoint.com/creating-crud-app-minutes-angulars-resource/
// http://stackoverflow.com/questions/20584367/how-to-handle-resource-service-errors-in-angularjs
// http://jimhoskins.com/2012/12/17/angularjs-and-apply.html
// http://www.sitepoint.com/understanding-angulars-apply-digest/

var angularApp = angular.module("app", ["ngRoute", "ngResource"]);

angularApp.config(function ($routeProvider) {
    $routeProvider
        .when("/inicial", {
            templateUrl  : "views/inicial.html",
            controller   : "InicialController"
        })
        
        .when("/entrar", {
            templateUrl  : "views/entrar.html",
            controller   : "EntrarController"
        })
        .when("/cadastrar", {
            templateUrl  : "views/cadastrar.html",
            controller   : "CadastrarController"
        })
        
        .when("/painel", {
            templateUrl  : "views/painel.html"
        })
        
        .when("/painel/denuncias", {
            templateUrl  : "views/denuncias_album.html",
            controller   : "DenunciaController"
        })
        .when("/painel/denuncia", {
            templateUrl  : "views/denuncia.html",
            controller   : "DenunciaCreateController"
        })
        .when("/painel/denuncia/:id", {
            templateUrl  : "views/denuncia.html",
            controller   : "DenunciaUpdateController"
        })
        
        .when("/painel/classificacoes", {
            templateUrl  : "views/classificacoes.html",
            controller   : "ClassificacoesController"
        })
        .when("/painel/classificacao", {
            templateUrl  : "views/classificacao.html",
            controller   : "ClassificacaoCreateController"
        })
        .when("/painel/classificacao/:id", {
            templateUrl  : "views/classificacao.html",
            controller   : "ClassificacaoUpdateController"
        })
        
        .when("/painel/usuarios", {
            templateUrl  : "views/usuarios.html",
            controller   : "UsuariosController"
        })
        .when("/painel/usuario/:id", {
            templateUrl  : "views/usuario.html",
            controller   : "UsuarioUpdateController"
        })
        
        .when("/painel/contatos", {
            templateUrl  : "views/contatos.html",
            controller   : "ContatoController"
        })
        .when("/painel/contato", {
            templateUrl  : "views/contato.html",
            controller   : "ContatoCreateController"
        })
        .when("/painel/contato/:id", {
            templateUrl  : "views/contato.html",
            controller   : "ContatoUpdateController"
        })
        
        .when("/visualizar/:id", {
            templateUrl  : "views/visualizar.html",
            controller   : "DenunciaVisualizarController"
        })
        .when("/estatisticas", {
            templateUrl  : "views/estatisticas.html",
            controller   : "EstatisticasController"
        })
        
        .when("/contatos", {
            templateUrl  : "views/contatos_visualizar.html",
            controller   : "ContatoController"
        })
        
        .otherwise({
            redirectTo: "/inicial"
        });
});
