'use strict';

var IncubaApp = angular.module('IncubaApp', []);

IncubaApp.controller('SearchCtrl', function($scope, $http){

    $scope.mostrar = false;

    $scope.search = function()
    {
        $http.get('emprendedores/busqueda', {
            params: {buscar: $scope.searchInput}
        }).success(function($data) {
            $scope.emprendedores = $data.data;
            $scope.mostrar = true;
        });
    }

});
