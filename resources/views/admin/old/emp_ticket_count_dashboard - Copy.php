 <div class="col-lg-3 col-xs-6"><div class="small-box bg-green">
                <div class="inner">
                  <h3>
					<?php
						if(!empty($ticketcountdata->assignedStatus)){
							echo $ticketcountdata->assignedStatus;
						}
						else{
							echo"0";
						}
					?>
                  <p>Assigned Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <?php
					if(!empty($ticketcountdata->assignedStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=3')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
			<div class="small-box bg-yellow">
				<div class="inner">
					<h3>
						<?php
							if(!empty($ticketcountdata->inprogressStatus)){
								echo $ticketcountdata->inprogressStatus;
							}
							else{
								echo"0";
							}
						?>
					</h3>
					<p>In-Progress Tickets</p>
				</div>
				<div class="icon">
					<i class="ion ion-person-add"></i>
				</div>
				<?php
					if(!empty($ticketcountdata->inprogressStatus)){
				?>
						 <a href="{{asset('my_tickets?tab_id=4')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
			</div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>
                 	 <?php
						if(!empty($ticketcountdata->closedStatus)){
							echo $ticketcountdata->closedStatus;
						}
						else{
							echo"0";
						}
					?>
                  </h3>
                  <p>Closed Tickets</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <?php
                	if(!empty($ticketcountdata->closedStatus)){
                ?>
						 <a href="{{asset('my_tickets?tab_id=5')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
					else{
				?>
						<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				<?php
					}
				?>
              </div>