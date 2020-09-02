
angularApp.factory("resourceMethods", [
    function() {
        return {
            update: {
                method: "PUT",
            }
        };
    }
]);

angularApp.factory("Entrar", function ($resource, resourceMethods) {
    return $resource("/api/Entrar/:id", { id: "@id" }, resourceMethods);
});

angularApp.factory("Facebook", function ($resource, resourceMethods) {
    return $resource("/api/Facebook", {}, resourceMethods);
});

angularApp.factory("Usuario", function ($resource, resourceMethods) {
    return $resource("/api/Usuario/:id", { id: "@id" }, resourceMethods);
});

angularApp.factory("Classificacao", function ($resource, resourceMethods) {
    return $resource("/api/Classificacao/:id", { id: "@id" }, resourceMethods);
});

angularApp.factory("Denuncia", function ($resource, resourceMethods) {
    return $resource("/api/Denuncia/:id", { id: "@id" }, resourceMethods);
});

angularApp.factory("Estatisticas", function ($resource, resourceMethods) {
    return $resource("/api/Estatisticas", {}, resourceMethods);
});

angularApp.factory("MinhaDenuncia", function ($resource, resourceMethods) {
    return $resource("/api/MinhaDenuncia/:id", { id: "@id" }, resourceMethods);
});

angularApp.factory("Contato", function ($resource, resourceMethods) {
    return $resource("/api/Contato/:id", { id: "@id" }, resourceMethods);
});
