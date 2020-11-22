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
    var notify_url = rootBaseUrl + "localApi/ganarateNotificationForAdmin";
    $scope.rootData = {'notifications': [],
        "classDataNotify": [],
        "classDataNotifyShort": [],
        "classDataNotifyCount": 0,
        "messageDataNotify": [],
        "messageDataNotifyShort": [],
        "messageDataNotifyCount": 0,
        "shownotify": "no"
    };




    $scope.checkUnseenData = function () {
        var notificationlist = [];
        var status_url = rootBaseUrl + "localApi/ganarateNotificationForAdmin";
        $http.get(status_url).then(function (rdata) {
            var resdata = rdata.data;
            $scope.rootData.classDataNotify = resdata.unssenclassdata;
            $scope.rootData.classDataNotifyShort = resdata.unssenclassdata.splice(0, 5);
            $scope.rootData.classDataNotifyCount = resdata.totalclassdata;
            $scope.rootData.messageDataNotify = resdata.unseenmessagedata;
            $scope.rootData.messageDataNotifyShort = resdata.unseenmessagedata.splice(0, 5);
            $scope.rootData.messageDataNotifyCount = resdata.totalmessagedata;
            var messgage = resdata.message;
            var totalnotify = resdata.totalunseen;

            messgage = messgage + "\n Click here to view details.";

            var text = messgage;
            if ($scope.rootData.shownotify == 'yes') {
                var notification = new Notification('You have ' + totalnotify + ' unseen notification(s).', {body: text, image: "http://edifyschoolnagpur.com/wp-content/uploads/2018/01/DSC0065.jpg", icon: globleicon});
                notification.onclick = function (event) {
                    event.preventDefault(); // prevent the browser from focusing the Notification's tab

                    window.location = rootBaseUrl + "Messages/notifications"
                }
            }


        })



    }


//    $interval(function(){
//        $scope.checkUnseenData();
//    })

    $scope.checkUnseenData();


})


window.addEventListener('load', function () {
    // At first, let's check if we have permission for notification
    // If not, let's ask for it
    if (window.Notification && Notification.permission !== "granted") {
        Notification.requestPermission(function (status) {
            if (Notification.permission !== status) {
                Notification.permission = status;
            }
        });
    }
    if (Notification.permission == 'denied') {
        Notification.requestPermission(function (status) {

        });
    }


    var button = document.getElementsByTagName('button')[0];

    button.addEventListener('click', function () {
        // If the user agreed to get notified
        // Let's try to send ten notifications
        if (window.Notification && Notification.permission === "granted") {
            var i = 0;
            // Using an interval cause some browsers (including Firefox) are blocking notifications if there are too much in a certain time.
            var interval = window.setInterval(function () {
                // Thanks to the tag, we should only see the "Hi! 9" notification 
                var n = new Notification("Hi! " + i, {tag: 'soManyNotification'});
                if (i++ == 9) {
                    window.clearInterval(interval);
                }
            }, 200);
        }

        // If the user hasn't told if he wants to be notified or not
        // Note: because of Chrome, we are not sure the permission property
        // is set, therefore it's unsafe to check for the "default" value.
        else if (window.Notification && Notification.permission !== "denied") {
            Notification.requestPermission(function (status) {
                // If the user said okay
                if (status === "granted") {
                    var i = 0;
                    // Using an interval cause some browsers (including Firefox) are blocking notifications if there are too much in a certain time.
                    var interval = window.setInterval(function () {
                        // Thanks to the tag, we should only see the "Hi! 9" notification 
                        var n = new Notification("Hi! " + i, {tag: 'soManyNotification'});
                        if (i++ == 9) {
                            window.clearInterval(interval);
                        }
                    }, 200);
                }

                // Otherwise, we can fallback to a regular modal alert
                else {
                    alert("Hi!");
                }
            });
        }

        // If the user refuses to get notified
        else {
            // We can fallback to a regular modal alert
            alert("Hi!");
        }
    });
});




