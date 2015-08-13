(function () {

    var IncubaApp = angular.module('IncubaApp', []);

    IncubaApp.controller('SearchCtrl', function($scope, $http){

        $scope.mostrar = false;

        $scope.search = function()
        {
            if($scope.searchInput == ""){
                $scope.mostrar = false;
            }else{
                $http.get('emprendedores/busqueda', {
                    params: {buscar: $scope.searchInput}
                }).success(function($data) {
                    $scope.emprendedores = $data.data;
                    $scope.mostrar = true;
                });
            }
        }

    });

})();