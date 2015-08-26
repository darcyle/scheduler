var scheduleApp = angular.module('scheduleApp', []);

var scheduleControllers = angular.module('scheduleControllers', []);

scheduleControllers.controller('ScheduleListCtrl', function ($scope) {
  $scope.schedules = [
    {'time': '10:30AM',
     'user': 'David Grossman'},
    {'time': '11:00AM',
     'user': 'Francesca Davis'},
    {'time': '11:30AM',
     'user': null}
  ];
});