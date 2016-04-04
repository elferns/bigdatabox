var app = angular.module('adminApp', ['ngMaterial', 'ngAnimate'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
});

app.controller('pageCtrl', function($scope, $http, $location, $anchorScroll){
    CKEDITOR.replace( 'page_content' );

    $scope.showEditPage = function ($pageId){
        $http.get('/api/page_details/'+$pageId).then(function (response) {
            $scope.page = response.data;
            CKEDITOR.instances['page_content'].setData(response.data.content);
            $anchorScroll();
            //console.log('all is good', response.data);
        }, function (error) {
            //console.log('an error occurred', error.data);
        });
    }

});

app.controller('bannerCtrl', function($scope, $http, $location, $anchorScroll, $timeout){

    //hide the success message after some time
    $timeout(function() {
        $scope.hideDeleteMsg = true;
    }, 3000);

});

app.directive('validFile', function(){
    return {
        restrict: 'EA',
        require: 'ngModel',
        link: function(scope, elem, attrs, ngModel){
            var file_info = "";

            elem.on('change', function(event){
                var file_info = event.target.files;

                scope.$apply(function () {
                    ngModel.$render(file_info);
                });
            });

            if (attrs.maxsize) {
                var maxsize = parseInt(attrs.maxsize);
                ngModel.$validators.maxsize = function(modelValue, viewValue) {
                    var value = modelValue || viewValue;
                    if(value) {
                        if (value[0] && value[0].size && value[0].size > maxsize) {
                            return false;
                        }
                    }
                    return true;
                };
            }

            if (attrs.extension) {
                var validFormats = attrs.extension;
                ngModel.$validators.extension = function(modelValue, viewValue) {
                    var value = modelValue || viewValue;

                    if(value) {
                        var ext = value[0].type.substring(value[0].type.indexOf('/')+1);
                        if (value[0] && value[0].type && validFormats.indexOf(ext) === -1) {
                            return false;
                        }
                    }
                    return true;
                };
            }

            ngModel.$render = function (fileVal) {
                ngModel.$setViewValue(fileVal);
            };

        }
    };
});

app.controller('modelCtrl', function($scope, $mdDialog, $mdMedia, $http, $window, $timeout) {
        $scope.status = '  ';
        $scope.customFullscreen = $mdMedia('xs') || $mdMedia('sm');

        //hide the success message after some time
        $timeout(function() {
            $scope.hideDeleteMsg = true;
        }, 3000);
        /*$scope.showAlert = function(ev) {
            // Appending dialog to document.body to cover sidenav in docs app
            // Modal dialogs should fully cover application
            // to prevent interaction outside of dialog
            $mdDialog.show(
                $mdDialog.alert()
                    .parent(angular.element(document.querySelector('#popupContainer')))
                    .clickOutsideToClose(true)
                    .title('This is an alert title')
                    .textContent('You can specify some description text in here.')
                    .ariaLabel('Alert Dialog Demo')
                    .ok('Got it!')
                    .targetEvent(ev)
            );
        };*/

        $scope.showDeleteConfirm = function(ev, moduleName, delId) {
            // Appending dialog to document.body to cover sidenav in docs app
            var confirm = $mdDialog.confirm()
                .title('Delete confirmation')
                .textContent('Are you sure you want to delete?')
                .targetEvent(ev)
                .ok('Ok')
                .cancel('Cancel');
            $mdDialog.show(confirm).then(function() {
                if( moduleName == 'page' ){
                    $http.delete('/api/destroy/'+delId).then(function (response) {
                        $window.location.reload();
                        //console.log('all is good', response.data);
                    }, function (error) {
                        //console.log('an error occurred', error.data);
                    });
                }
            }, function() {
                   return false;
            });
        };

        /*$scope.showAdvanced = function(ev) {
            var useFullScreen = ($mdMedia('sm') || $mdMedia('xs'))  && $scope.customFullscreen;
            $mdDialog.show({
                    controller: DialogController,
                    templateUrl: 'dialog1.tmpl.html',
                    parent: angular.element(document.body),
                    targetEvent: ev,
                    clickOutsideToClose:true,
                    fullscreen: useFullScreen
                })
                .then(function(answer) {
                    $scope.status = 'You said the information was "' + answer + '".';
                }, function() {
                    $scope.status = 'You cancelled the dialog.';
                });
            $scope.$watch(function() {
                return $mdMedia('xs') || $mdMedia('sm');
            }, function(wantsFullScreen) {
                $scope.customFullscreen = (wantsFullScreen === true);
            });
        };*/

    });
/*function DialogController($scope, $mdDialog) {
    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
    $scope.answer = function(answer) {
        $mdDialog.hide(answer);
    };
}*/



app.controller('listing', function($scope, $http){
    $scope.moduleName = null;
    $scope.listData = null;
    $scope.listHead = null;

    $scope.init = function ($moduleName) {
        $scope.moduleName = $moduleName;

        $http({
            method: 'GET',
            url: '/admin/'+$scope.moduleName+'/list'
        }).then(function successCallback(response) {
            $scope.listData = response.data.table_body;
            $scope.listHead = response.data.table_head;
            $scope.sortType     = response.data.table_sort.sortType; // set the default sort type
            $scope.sortReverse  = response.data.table_sort.sortReverse;  // set the default sort order
            $scope.links  = response.data.links;
            $scope.searchFil   = '';
        }, function errorCallback(response) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
        });
    };

    $scope.order = function($sortType){

        $scope.sortType = $sortType;
        $scope.sortReverse = !$scope.sortReverse;
    };
});



