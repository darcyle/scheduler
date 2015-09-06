angular.module('scheduleFilters', []).filter('available', function() {
	return function(items, onlyAvailable) {
		if (onlyAvailable == false) return items;
		available = [];
		angular.forEach(items, function(value,key) {
			if (value.user === null) available.push(value);
		});
		return available;
	};
});