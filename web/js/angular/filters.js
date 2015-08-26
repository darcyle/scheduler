angular.module('scheduleFilters', []).filter('available', function() {
  return function(input) {
    return input.name === null;
  };
});