<?php 
	$view->extend('::base.html.php');
	$view['slots']->set('title', 'SAG Massage Scheduler');
?>
<style>
	div.row h1 {
		text-align: center;
	}
</style>

<div class="jumbotron">
	<div class="container">
		<h1>Welcome to the SAG Scheduler!</h1>
		<p>Here you can easily sign up for massages. All appointments are 30 minutes.</p>
	</div>
</div>

<div class="container" ng-controller="ScheduleListCtrl">
<h1>Week of {{weekStartDate}}</h1>
<p>10 availabilities</p>
	<div class="row">
		<div class="col-md-2">
			<h1>Mon</h1>
			<div class="appointments">
				<div class="panel panel-danger">
					<div class="panel-heading">10:30AM</div>
					<div class="panel-body">
						David Grossman <a href="#" class="btn btn-danger btn-block" ng-click="wtf()">Cancel</a>
					</div>
				</div>
				<div class="panel panel-success">
					<div class="panel-heading">11:00AM</div>
					<div class="panel-body">
						<a href="#" class="btn btn-primary btn-block">Schedule</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2">
			<h1>Tue</h1>
			<div class="appointments">
				<div ng-repeat="schedule in schedules" class="panel panel-default">
					<div class="panel-heading">{{schedule.time}}</div>
					<div class="panel-body">{{schedule.user}}</div>
				</div>
			</div>			
		</div>
		<div class="col-md-2">
			<h1>Wed</h1>
			<div class="appointments">

			</div>
		</div>
		<div class="col-md-2">
			<h1>Thu</h1>
			<div class="appointments">

			</div>
		</div>
		<div class="col-md-2">
			<h1>Fri</h1>
			<div class="appointments">

			</div>
		</div>
	</div>
</div>