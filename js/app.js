
window.app = {};
window.app.init = function() {
    $("[data-activates='slide-left']").sideNav();
    $(".side-nav").on("click", "li > a", function() {
        $(".button-collapse").sideNav("hide");
    });
    $('[data-activates="slide-right"]').sideNav({ edge: 'right' });
};
window.app.error = function(response) {
    if (response.status === 401) {
        location.hash = "#/entrar";
    } else {
        Materialize.toast(response.data.error.message, 4000);
        console.log(response.data.error);
    }
};
window.app.update = function() {
    setTimeout(function() {
        $(".materialboxed").materialbox();
        $("select").material_select();
        $(":input").each(function(index, el) {
            var $input = $(el);
            if ($input.val()) {
                $input.parent().find("label").addClass("active");
            }
        });
    }, 1000);
};
window.app.loading = {};
window.app.loading.show = function() {
    $(".loading").addClass("show-1");
};
window.app.loading.hide = function() {
    $(".loading").removeClass("show-1");
};
window.app.init();
