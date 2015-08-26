<?php 
	$view->extend('::base.html.php');
	$view['slots']->set('title', 'SAG Massage Scheduler');

?>

<div class="jumbotron">
	<div class="container">
		<h1>Welcome to the SAG Scheduler!</h1>
		<p>Here you can easily sign up for massages. All appointments are 30 minutes.</p>
	</div>
</div>

<style>
	div.appointments ul {
		margin-left: 0px;
		padding-left: 0px;
		list-style: none;
	}
	div.appointments li {
		border: 1px solid black;
		margin-bottom: 5px;
	}
	div.appointments h1 {
		padding: 2px;
		text-align: center;
		color: white;
		background-color: gray;
		margin-top: 0px;
		font-size: 14pt;
	}
	div.appointments p {
		margin-left: 10px;
	}
	div.row h1 {
		text-align: center;
	}

</style>

<div class="container" ng-controller="ScheduleListCtrl">
<h1>Week of 8/24</h1>
<p>10 availabilities</p>
	<div class="row">
		<div class="col-md-2">
			<h1>Mon</h1>
			<div class="appointments">
				<div class="panel panel-danger">
					<div class="panel-heading">10:30AM</div>
					<div class="panel-body">
						David Grossman <a href="#" class="btn btn-danger btn-block">Cancel</a>
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