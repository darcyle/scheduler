<?php 
	$view->extend('::base.html.php');
	$view['slots']->set('title', 'SAG Massage Scheduler');
?>
<style>
	div.row h1 {
		text-align: center;
	}
/*
A custom Bootstrap 3.2 'Google Plus style' theme
from http://bootply.com

This CSS code should follow the 'bootstrap.css'
in your HTML file.

license: MIT
author: bootply.com
*/

@import url(http://fonts.googleapis.com/css?family=Roboto:400);
body {
  background-color:#e0e0e0;
  -webkit-font-smoothing: antialiased;
  font: normal 14px Roboto,arial,sans-serif;
}
.navbar-default {background-color:#f4f4f4;margin-top:178px;border-width:0;z-index:5;}
.navbar-default .navbar-nav > .active > a,.navbar-default .navbar-nav > li:hover > a {border:0 solid #4285f4;border-bottom-width:2px;font-weight:800;background-color:transparent;}
.navbar-default .dropdown-menu {background-color:#ffffff;}
.navbar-default .dropdown-menu li > a {padding-left:30px;}

.header {background-color:#ffffff;border-width:0;}
.header .navbar-collapse {background-color:#ffffff;}
.btn,.form-control,.panel,.list-group,.well {border-radius:1px;box-shadow:0 0 0;}
.form-control {border-color:#d7d7d7;}
.btn-primary {border-color:transparent;}
.btn-primary,.label-primary,.list-group-item.active, .list-group-item.active:hover, .list-group-item.active:focus {background-color:#4285f4;}
.btn-plus {background-color:#ffffff;border-width:1px;border-color:#dddddd;box-shadow:1px 1px 0 #999999;border-radius:3px;color:#666666;text-shadow:0 0 1px #bbbbbb;}
.well,.panel {border-color:#d2d2d2;box-shadow:0 1px 0 #cfcfcf;border-radius:3px;}
.btn-success,.label-success,.progress-bar-success{background-color:#65b045;}
.btn-info,.label-info,.progress-bar-info{background-color:#a0c3ff;border-color:#a0c3ff;}
.btn-danger,.label-danger,.progress-bar-danger{background-color:#dd4b39;}
.btn-warning,.label-warning,.progress-bar-warning{background-color:#f4b400;color:#444444;}

hr {border-color:#ececec;}
button {
 outline: 0;
}
textarea {
 resize: none;
 outline: 0; 
}
.panel .btn i,.btn span{
 color:#666666;
}
.panel .panel-heading {
 background-color:#ffffff;
 font-weight:700;
 font-size:16px;
 color:#262626;
 border-color:#ffffff;
}
.panel .panel-heading a {
 font-weight:400;
 font-size:11px;
}
.panel .panel-default {
 border-color:#cccccc;
}
.panel .panel-thumbnail {
 padding:0;
}
.panel .img-circle {
 width:50px;
 height:50px;
}
.list-group-item:first-child,.list-group-item:last-child {
 border-radius:0;
}
h3,h4,h5 { 
 border:0 solid #efefef; 
 border-bottom-width:1px;
 padding-bottom:10px;
}
.modal-dialog {
 width: 450px;
}
.modal-footer {
 border-width:0;
}
.dropdown-menu {
 background-color:#f4f4f4;
 border-color:#f0f0f0;
 border-radius:0;
 margin-top:-1px;
}
/* end theme */
/* template layout*/
#subnav {
 position:fixed;
 width:100%;
}

@media (max-width: 768px) {
 #subnav {
  padding-top: 6px;
 }
}

#main {
 padding-top:120px;
}

div.fullInput {
	display: block;
}

div.weekSelector .btn {
	padding: px 15px;
}
</style>

<script>
$(document).ready(function(){
	$( window ).resize(function() {
		updatePadding();
	});
	updatePadding();
});

function updatePadding() {
	$('#main').css("padding-top", $('#topheader').height());
}
</script>

<div ng-controller="ScheduleListCtrl">

<nav class="navbar navbar-fixed-top header" id="topheader">
	<div class="col-md-12">
		<div class="page-header">
			<h1>SAG Massage Scheduler</h1>
		</div>
	</div>

	<div class="col-md-12 weekSelector btn-group-lg">
		<button class="btn btn-danger" type="button" style="margin-bottom: 3px" ng-class="{'btn-primary': getAvailableCount(), 'btn-danger': getAvailableCount() == 0}">
		  {{weekStartDate.toString('MMM d')}} <span class="badge" ng-bind="getAvailableCount()">0</span>
		</button>
		<button class="btn btn-danger" type="button" style="margin-bottom: 3px" ng-class="{'btn-primary': getAvailableCount(), 'btn-danger': getAvailableCount() == 0}">
		  {{weekStartDate.toString('MMM d')}} <span class="badge" ng-bind="getAvailableCount()">0</span>
		</button>		
		<button class="btn btn-danger" type="button" style="margin-bottom: 3px" ng-class="{'btn-primary': getAvailableCount(), 'btn-danger': getAvailableCount() == 0}">
		  {{weekStartDate.toString('MMM d')}} <span class="badge" ng-bind="getAvailableCount()">0</span>
		</button>
		<button class="btn btn-danger" type="button" style="margin-bottom: 3px" ng-class="{'btn-primary': getAvailableCount(), 'btn-danger': getAvailableCount() == 0}">
		  {{weekStartDate.toString('MMM d')}} <span class="badge" ng-bind="getAvailableCount()">0</span>
		</button>		
	</div>
	<div class="col-md-12" style="margin-bottom: 3px; display: none">
		<label class="btn btn-default" ng-class="{'active': onlyAvail}">
			<input type="checkbox" name="options" id="option1" autocomplete="off" checked="checked" ng-model="onlyAvail"> Only Show Available
		</label>	
	</div> 
</nav>


	<div class="container" id="main">
		<div class="row">			
			<div ng-repeat="schedule in schedules" ng-class="'col-md-'+ columnSize">
				<h1>{{schedule.day}}</h1>
				<div class="appointments">
					<div ng-repeat="appointment in schedule.appointments | available: onlyAvail" ng-class="{'panel-success': appointment.user === null, 'panel-danger': appointment.user !== null}" class="panel">
						<div class="panel-body">
							<h3>{{appointment.time}}</h3>

							
							<div ng-if="appointment.user === null" class="input-group text-center" ng-class="{'fullInput': addUser.length == 0}">
								<input  type="text" class="form-control input-lg" placeholder="Enter your first.last" ng-model="addUser">
								<span   class="input-group-btn" ng-class="{'hidden': addUser.length == 0}">
									<button class="btn btn-lg btn-primary glyphicon glyphicon-plus" type="button"></button>
								</span>
							</div>
							
							<div ng-if="appointment.user !== null" class="input-group text-center">
								<input  type="text" class="form-control input-lg" value="{{appointment.user}}" disabled="disabled" />
								<span   class="input-group-btn">
									<button class="btn btn-lg btn-danger glyphicon glyphicon-remove" type="button"></button>
								</span>
							</div>							

							
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>