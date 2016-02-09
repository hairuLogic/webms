<?php include_once('../../../../header.php'); ?>

	<h3>Appointment Calendar</h3>
	<!--div class='col-md-6'>
		<div class="row">
			<div class="pull-right form-inline">
				<div class="btn-group">
					<button class="btn btn-primary" data-calendar-nav="prev"><< Prev</button>
					<button class="btn btn-default" data-calendar-nav="today">Today</button>
					<button class="btn btn-primary" data-calendar-nav="next">Next >></button>
				</div>
				<div class="btn-group">
					<button class="btn btn-warning" data-calendar-view="year">Year</button>
					<button class="btn btn-warning active" data-calendar-view="month">Month</button>
					<button class="btn btn-warning" data-calendar-view="week">Week</button>
					<button class="btn btn-warning" data-calendar-view="day">Day</button>
				</div>
			</div>
		</div>
	</div-->
	<div class='col-md-6'>
		<div class="row">
			<div id="appt_calendar"></div>
		</div>
	</div>
	<div class='col-md-6'>
		<table id="appt_grid" class="table table-striped"></table>
		<div id="appt_grid_pager"></div>
	</div>

<?php include_once('../../../../implementingjs.php'); ?>	

    <!-- JS Page Level -->    
    <script type="text/javascript" src="../../../../assets/plugins/bootstrap-calendar-master/components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="../../../../assets/plugins/bootstrap-calendar-master/components/jstimezonedetect/jstz.min.js"></script>
    <script type="text/javascript" src="../../../../assets/plugins/bootstrap-calendar-master/js/calendar.js"></script>
	<script src="doctor.js"></script>
       
<?php include_once('../../../../footer.php'); ?>