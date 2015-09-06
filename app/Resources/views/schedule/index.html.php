<?php 
	$view->extend('::base.html.php');
	$view['slots']->set('title', 'SAG Massage Scheduler');
?>
<style>
	div.row h1 {
		text-align: center;
	}
</style>

<div ng-controller="ScheduleListCtrl">

	<div class="jumbotron">
		<div class="container">
			<h1>Welcome to the SAG Scheduler!</h1>
			<p>Here you can easily sign up for massages. All appointments are 30 minutes.</p>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-2" style="text-align: center">
				<h3 align="center">{{weekStartDate}}</h3>
				<button class="btn" type="button" style="margin-bottom: 3px" ng-class="{'btn-primary': getAvailableCount(), 'btn-danger': getAvailableCount() == 0}">
				  Availabilites <span class="badge">{{getAvailableCount()}}</span>
				</button>
				

				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-primary active" ng-click="onlyAvail = false">
						<input type="radio" name="options" id="option1" autocomplete="off" checked="checked"> All
					</label>
					<label class="btn btn-primary" ng-click="onlyAvail = true">
						<input type="radio" name="options" id="option2" autocomplete="off"> Available
					</label>
				</div>

				<nav>
					<ul class="pagination">
						<li>
							<a href="#" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
						<li>
							<a href="#" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
					</ul>
				</nav>
			</div>
			
			<div ng-repeat="schedule in schedules" ng-class="'col-md-'+ columnSize">
				<h1>{{schedule.day}}</h1>
				<div class="appointments">
					<div ng-repeat="appointment in schedule.appointments | available: onlyAvail" ng-class="{'panel-success': appointment.user === null, 'panel-danger': appointment.user !== null}" class="panel">
						<div class="panel-heading">{{appointment.time}}</div>
						<div class="panel-body">
							<div class="user">{{appointment.user}}</div>
							<a ng-if="appointment.user !== null" class="btn btn-danger btn-block" ng-click="cancel(schedule, appointment)">Cancel</a>
							<a ng-if="appointment.user === null" class="btn btn-primary btn-block" ng-click="schedule(schedule, appointment)">Schedule</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>