
angularApp.directive('ngFile', function() {
    return {
        controller: function($element, $attrs, $scope, $parse) {
            var model = $parse($attrs.ngFile);
            var modelSetter = model.assign;
            
            $element.on('change', function() {
                this.fileObject = this.files[0];
                this.fileData = {};
                
                this.fileData.url = URL.createObjectURL(this.fileObject);
                this.fileData.nome = this.fileObject.name;
                
                var fileReader = new FileReader();
                fileReader.onload = (function (e) {
                    this.fileData.data = e.target.result;
                }).bind(this);
                fileReader.readAsDataURL(this.fileObject);
                
                modelSetter($scope, this.fileData);
                $scope.$apply();
            });
        }
    };
});
