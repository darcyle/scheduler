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
				<h3 align="center">{{weekStartDate}}
				<button class="btn btn-primary" type="button">
				  Availabilites <span class="badge">5</span>
				</button>
				</h3>

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
			
			<div ng-repeat="schedule in schedules" class="col-md-2">
				<h1>{{schedule.day}}</h1>
				<div class="appointments">
					<div ng-repeat="appointment in schedule.appointments" ng-class="{'panel-success': appointment.user === null, 'panel-danger': appointment.user !== null}" class="panel">
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