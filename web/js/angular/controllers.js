var scheduleApp = angular.module('scheduleApp', []);

var scheduleControllers = angular.module('scheduleControllers', []);

scheduleControllers.controller('ScheduleListCtrl', ['$scope', '$http', 'api', function ($scope, $http, api) {
	$scope.getNextDate = function() {
		// Advance the date. Request the new week.
	}

	$scope.getPreviousWeek = function() {
		// Previous date. Request new week.

		// SUbtract a week.

		// Update flag that previous is enabled if diff of earliest monday and previous week in 
		// milliseconds is not positive.


	}

	$scope.requestWeek = function() {
		// Request the week!
		var args = {}
		if ($scope.weekStartDate != "Date") {
			args.date = $scope.weekStartDate.toFormat('yyyy-MM-dd');
		}
		api('getWeek').then(
			function(data){
				$scope.$apply(
					function(){
						$scope.schedules = data.schedules;
						console.log(data.schedules);
						$scope.weekStartDate = new XDate(data.weekStartDate);
						console.log($scope.weekStartDate);
						$scope.columnSize = Math.floor(12 / data.schedules.length);
					}
				);
			},
			function(error) {

			}
		);		
	}

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

	$scope.getAvailableCount = function() {
		var count = 0;
		angular.forEach($scope.schedules, function(schedule, key) {
			angular.forEach(schedule.appointments, function(appointment, key){
				if (appointment.user == null) count++;
			});
		});

		return count;
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
		api(
			'deleteAppointment', 
			{"date":schedule.date,"time":appointment.time}
		).then(
			function(data){
				$scope.$apply(function(){
					appointment.user = null;
				});
			},
			function(error) {

			}
		);
	}
	
	// RUN ON START
	$scope.columnSize = 4;
	$scope.onlyAvail = false;
	$scope.schedulecount = 0;
	$scope.previousWeekEnabled = false;
	$scope.weekStartDate = 'Date';
	$scope.schedules = [
		{
			"day":"Tue",
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

	$scope.requestWeek();

}]).factory('api', ['$http', function($http) {
	return function(method, args) {
		var promise = new Promise(function(resolve, reject){
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
