var Appc = angular.module('Controllers', []);

Appc.controller('HomeCtrl', ['$scope', '$http', '$location',
    function($scope, $http, $location) {
        console.log("Init Controller");
    }]
);