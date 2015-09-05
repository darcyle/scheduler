var scheduleApp = angular.module('scheduleApp', []);

var scheduleControllers = angular.module('scheduleControllers', []);

scheduleControllers.controller('ScheduleListCtrl', ['$scope', '$http', function ($scope, $http) {
   $scope.api = function(method, args) {
   		console.log('API: ', method, args);
   		if (typeof args == 'undefined') {
   			args = {};
   		}
   		responseData = {}
	 	$http({
	        url: '/api/v1/',
	        method: 'POST',
	        data: JSON.stringify({'method':method, 'args': args}),
	        headers: {'Content-Type': 'application/json'}
	        }).success(function (data, status, headers, config) {
	        	console.log('data: ',data);
	        	responseData = data;
	        }).error(function (data, status, headers, config) {
	            console.log('ERROR: ' + status)
	            return false;
	        });
	    return responseData;
	};

	var data  = $scope.api('getWeek');
	$scope.schedules = data.schedules;
	$scope.weekStartDate = data.weekStartDate;
}]);

