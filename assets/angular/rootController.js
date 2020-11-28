/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Admin.directive('fileModel', ['$parse', function ($parse) {
        return {
            restrict: 'A',
            link: function (scope, element, attrs) {
                var model = $parse(attrs.fileModel);
                var modelSetter = model.assign;

                element.bind('change', function () {
                    scope.$apply(function () {
                        console.dir(element[0].files[0])
                        modelSetter(scope, element[0].files[0]);
                    });
                });
            }
        };
    }]);


Admin.controller('rootController', function ($scope, $http, $timeout, $interval) {
   
});




