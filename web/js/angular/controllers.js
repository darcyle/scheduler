var scheduleApp = angular.module('scheduleApp', []);

var scheduleControllers = angular.module('scheduleControllers', []);

scheduleControllers.controller('ScheduleListCtrl', ['$scope', '$http', 'api', function ($scope, $http, api) {
	$scope.schedules = [
		{
			"day":"Mon",
			"appointments": []
		},
		{
			"day":"Tue",
			"appointments": []
		},
		{
			"day":"Wed",
			"appointments": []
		},
		{
			"day":"Thu",
			"appointments": []
		},
		{
			"day":"Fri",
			"appointments": []
		}
	];
	$scope.weekStartDate = '';

	api('getWeek').then(
		function(data){
			$scope.$apply(
				function(){
					$scope.schedules = data.schedules;
					console.log(data.schedules);
					$scope.weekStartDate = data.weekStartDate;
				}
			);
		},
		function(error) {

		}
	);

	$scope.getScheduleDay = function (date) {
		schedule = null;
		angular.forEach($scope.schedules, function(value, key){
			if (value.date == date) {
				schedule = value;
				return;
			}
		});	
		
		return schedule;	
	}

	$scope.getScheduleAppointment = function(schedule, time) {
		appointment = null;
		angular.forEach(schedule.appointments, function(value, key) {
			if (value.time == time) {
				appointment = value;
				return;
			}
		});
	}

	$scope.cancel = function(schedule, appointment) {
		api('deleteAppointment', {"date":schedule.date,"time":appointment.time}).then(
			function(data){
				$scope.$apply(function(){
					appointment.user = null;
				});
			},
			function(error) {

			}
		);
		
/*

*/
	}
}]).factory('api', ['$http', function($http) {
	return function(method, args) {
		var promise = new Promise(function(resolve, reject){
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
					if (typeof data.error !== undefined) {
						resolve(data);	
					} else {
						reject(Error(data));
					}
				}).error(function (data, status, headers, config) {
					reject(Error(data));
				});
		});
		return promise;
	};
}]);
