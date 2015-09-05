var scheduleApp = angular.module('scheduleApp', []);

var scheduleControllers = angular.module('scheduleControllers', []);


scheduleControllers.controller('ScheduleListCtrl', ['$scope', '$http', 'api', function ($scope, $http, api) {
	$scope.schedules = [];
	$scope.weekStartDate = 'fuck';

	api('getWeek').then(
		function(data){
			console.log(data);
			$scope.schedules = data.schedules;
			$scope.weekStartDate = data.weekStartDate;
		},
		function(error) {

		}
	);

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
					resolve(data);
				}).error(function (data, status, headers, config) {
					reject(Error(data));
				});
		});
		return promise;
	};
}]);


