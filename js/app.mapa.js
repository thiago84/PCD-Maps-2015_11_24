
app.Mapa = function(container) {
    var self = this;

    this.map = null;
    this.container = container;

    this.position = {
        latitude: -30.0956985,
        longitude: -51.1392012
    };

    this.changeMarker = null;
    this.positionSelected = this.position;
    this.pontos = [];

    this.init = function () {
        this.iniciarMapa();
    };

    this.getCurrentPosition = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(self.getCurrentPositionCallback);
        }
    };

    this.setChangeMarkerCallback = function(changeMarker) {
        self.changeMarker = changeMarker;
    };
    
    this.getCurrentPositionCallback = function (position) {
        self.definirPosicao(position.coords);
    };

    this.definirPosicao = function (position) {
        self.position = new google.maps.LatLng(position.latitude, position.longitude);
        self.limparPontos();
        self.criarPonto(position, "Minha localização", true);
        self.centralizar(self.position);
        self.alterarEndereco({latLng: self.position});
    };

    this.iniciarMapa = function () {
        self.map = new google.maps.Map($(self.container).get(0), {
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
            mapTypeControl: false,
            scaleControl: false,
            zoomControl: true,
        });
        self.map.setZoom(10);
        self.map.setCenter(new google.maps.LatLng(self.position.latitude, self.position.longitude));
    };

    this.limparPontos = function () {
        for (var key in self.pontos) {
            self.pontos[key].setMap(null);
        }
        self.pontos = [];
    };

    this.criarPonto = function (position, title, draggable, color) {
        if (position.lat) {
            position.latitude = position.lat();
            position.longitude = position.lng();
        }
        
        if (!color) {
            color = "#FFFFFF";
        }
        
        var icon = "images/pointer.png";
        var icon = new google.maps.MarkerImage("http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + color.replace("#", ""),
            new google.maps.Size(21, 34),
            new google.maps.Point(0,0),
            new google.maps.Point(10, 34));
        
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(position.latitude, position.longitude),
            title: title,
            map: self.map,
            icon: icon,
            draggable: draggable
        });

        google.maps.event.addListener(marker, 'dragend', self.alterarEndereco);

        self.pontos.push(marker);

        return marker;
    };

    this.carregarPontos = function (pontos) {
        var markers = [];

        $.each(pontos, function (index, ponto) {
            var marker = self.criarPonto(ponto, ponto.localizacao, false, ponto.classificacao.cor);

            google.maps.event.addListener(marker, 'click', function () {
                for (var i in markers) {
                    if (markers[i].infoWindow) {
                        markers[i].infoWindow.close();
                    }
                }

                if (!marker.infoWindow) {
                    marker.infoWindow = new google.maps.InfoWindow({
                        maxWidth: 300,
                        content: ""
                                .concat('<div class="card card-map">')
                                    .concat('<div class="card-image">')
                                        .concat('<img src="' + (ponto.imagem ? ponto.imagem.url : "") + '" />')
                                    .concat('</div>')
                                    .concat('<div class="card-content">')
                                        .concat('<a href="#/visualizar/' + ponto.id + '">' + ponto.titulo + '</a>')
                                        .concat('<p>[' + ponto.classificacao.nome + ']</p>')
                                        .concat('<p>' + ponto.localizacao + '</p>')
                                        .concat('<p>' + self.substr(ponto.descricao) + '</p>')
                                    .concat('</div>')
                                .concat('</div>')
                        /*
                                .concat('<div style="min-height: 100px; max-height: 300px">')
                                .concat('<h5><a href="#/visualizar/' + ponto.id + '">' + ponto.titulo + '</a></h5>')
                                .concat('<p>').concat(ponto.localizacao).concat('</p>')
                                .concat('<p>[ ').concat(ponto.classificacao.nome).concat(' ]</p>')
                                .concat('<p>').concat(ponto.descricao).concat('</p>')
                                .concat(self.carregarThumb(ponto.imagem))
                                .concat('</div>')
                         */
                    });
                }

                marker.infoWindow.open(self.map, marker);
            });

            markers.push(marker);
        });
    };

    this.substr = function(texto) {
        return texto.substr(0, 128) + (texto.length > 128 ? "..." : "");
    };
    
    this.carregarThumb = function (imagem) {
        if (imagem) {
            return ""
                    .concat('<a href="' + imagem.url + '" target="_blank" class="thumbnail">')
                    .concat('<img src="' + imagem.url + '" />')
                    .concat('</a>')
        }
        return "";
    };

    this.enableAutocomplete = function () {
        // https://developers.google.com/maps/documentation/javascript/examples/places-searchbox?hl=pt-br
        var markers = [];

        var input = $("<input>").attr("id", "searchbox").appendTo(self.container).get(0);
        self.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        var autocomplete = new google.maps.places.Autocomplete(input);

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            for (var i = 0, marker; marker = markers[i]; i++) {
                marker.setMap(null);
            }

            markers = [];

            var place = this.getPlace();
            var position = place.geometry.location;

            self.limparPontos();
            self.criarPonto(position, place.name, true);
            
            var bairro = place.address_components[2].long_name;
            
            self.changeMarker.apply(this, [
                place.geometry.location.lat(),
                place.geometry.location.lng(),
                place.formatted_address,
                bairro
            ]);

            self.positionSelected = position;

            var bounds = new google.maps.LatLngBounds();
            bounds.extend(position);

            self.map.fitBounds(bounds);
            self.map.setZoom(16);

            markers.push(marker);
        });
    };

    this.centralizar = function (position) {
        self.map.setCenter(position);
        self.map.setZoom(16);
    };

    this.alterarEndereco = function (event) {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({
            latLng: event.latLng
        }, function (responses) {
            if (responses && responses.length > 0) {
                if (self.changeMarker) {
                    var endereco = responses[0];
                    var bairro = endereco.address_components[2].long_name;
                    
                    self.changeMarker.apply(this, [
                        endereco.geometry.location.lat(),
                        endereco.geometry.location.lng(),
                        endereco.formatted_address,
                        bairro
                    ]);
                }
            }
        });
    };
}
