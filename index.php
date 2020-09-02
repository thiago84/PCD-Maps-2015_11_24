<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta name="description" content="Sistema web colaborativo para indicação de falhas de acessibilidade para PCD" />
        <meta name="keywords" content="pcd, acessibilidade, maps" />
        
        <meta property="og:url" content="http://pcd.esy.es" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="PCD Maps" />
        <meta property="og:description" content="Sistema web colaborativo para indicação de falhas de acessibilidade para PCD" />
        <meta property="og:image" />
        
        <title>PCD Maps</title>

        <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="css/style.css" />
    </head>
    <body ng-app="app" ng-controller="MainController" ng-class="{ admin: isAdmin(), logged: logged }">
        <header>
            <nav>
                <div class="container" id="#menu">
                    <a ng-href="#/inicial" class="brand-logo" title="Ir para página inicial">PCD Maps</a>
                    
                    <aside>
                        <ul id="slide-left" class="side-nav fixed">
                            <li ng-repeat="item in menu">
                                <a ng-href="{{item.href}}">{{item.title}}</a>
                            </li>
                            <li><a href="#/sair" ng-click="sair()">Sair</a></li>
                        </ul>
                        <a href="javascript: void(0)" data-activates="slide-left" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
                    </aside>
                    
                    <ul class="right hide-on-med-and-down">
                        <li ng-show="logged"><a ng-href="#/painel/denuncia">Denunciar</a></li>
                        <li><a href="#/estatisticas">Estatísticas</a></li>
                        <li><a href="#/contatos">Contatos</a></li>
                        <li ng-hide="logged"><a ng-href="#/entrar">Entrar</a></li>
                        <li ng-show="logged"><a ng-href="#/painel">Painel</a></li>
                    </ul>
                    
                    <ul id="slide-right" class="side-nav">
                        <li ng-show="logged"><a ng-href="#/painel/denuncia">Denunciar</a></li>
                        <li><a href="#/estatisticas">Estatísticas</a></li>
                        <li><a href="#/contatos">Contatos</a></li>
                        <li ng-hide="logged"><a ng-href="#/entrar">Entrar</a></li>
                        <li ng-show="logged"><a ng-href="#/painel">Painel</a></li>
                    </ul>
                    <a href="javascript: void(0)" data-activates="slide-right" class="button-collapse hide-on-large-only right"><i class="mdi-navigation-menu"></i></a>

                </div>
            </nav>
        </header>
        
        <main>
            <div class="container">
                <div class="row">
                    <div class="col-md-12" id="content" ng-view></div>
                </div>
            </div>
        </main>
        
        <loader></loader>
        
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery.cookie.js"></script>
        <script type="text/javascript" src="js/materialize.min.js"></script>
        <script type="text/javascript" src="js/angular.min.js"></script>
        <script type="text/javascript" src="js/angular-route.min.js"></script>
        <script type="text/javascript" src="js/angular-resource.min.js"></script>
        
        <script type="text/javascript" src="js/app.js"></script>
        <script type="text/javascript" src="js/app.mapa.js"></script>
        <script type="text/javascript" src="js/app.facebook.js"></script>
        
        <script type="text/javascript" src="js/app/app.js"></script>
        <script type="text/javascript" src="js/app/resources.js"></script>
        <script type="text/javascript" src="js/app/services/http.js"></script>
        <script type="text/javascript" src="js/app/directives/loader.js"></script>
        <script type="text/javascript" src="js/app/directives/file.js"></script>
        <script type="text/javascript" src="js/app/controllers/cadastrar.js"></script>
        <script type="text/javascript" src="js/app/controllers/classificacao.js"></script>
        <script type="text/javascript" src="js/app/controllers/denuncia.js"></script>
        <script type="text/javascript" src="js/app/controllers/entrar.js"></script>
        <script type="text/javascript" src="js/app/controllers/inicial.js"></script>
        <script type="text/javascript" src="js/app/controllers/main.js"></script>
        <script type="text/javascript" src="js/app/controllers/usuario.js"></script>
        <script type="text/javascript" src="js/app/controllers/contato.js"></script>
        
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3.9&sensor=true&language=pt-BR&libraries=places"></script>
        <script type="text/javascript" src="http://connect.facebook.net/pt_BR/sdk.js"></script>
    </body>
</html>