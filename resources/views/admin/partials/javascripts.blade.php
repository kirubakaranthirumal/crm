 <!-- ============================================
	============== Vendor JavaScripts ===============
	============================================= -->
	<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> -->
	<!-- <script>window.jQuery || document.write('<script src="/admin-lte/assets/js/vendor/jquery/jquery-1.11.2.min.js') }}"><\/script>')</script> -->

	<script src="{{ asset('/admin-lte/assets/js/vendor/bootstrap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/jRespond/jRespond.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/d3/d3.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/d3/d3.layout.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/rickshaw/rickshaw.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/sparkline/jquery.sparkline.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/animsition/js/jquery.animsition.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/daterangepicker/moment.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/daterangepicker/daterangepicker.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/screenfull/screenfull.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/flot/jquery.flot.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/flot-tooltip/jquery.flot.tooltip.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/flot-spline/jquery.flot.spline.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/easypiechart/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/raphael/raphael-min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/morris/morris.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/owl-carousel/owl.carousel.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"></script>
	<!-- daterangepicker -->
	<script src="{{ asset('/admin-lte/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
	<!-- datepicker -->
	<script src="{{ asset('/admin-lte/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/datatables/extensions/dataTables.bootstrap.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/chosen/chosen.jquery.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/summernote/summernote.min.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/coolclock/coolclock.js') }}"></script>
	<script src="{{ asset('/admin-lte/assets/js/vendor/coolclock/excanvas.js') }}"></script>
	<!-- iCheck -->
	<script src="{{ asset('/admin-lte/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
	<!--/ vendor javascripts -->
	<!-- ============================================
	============== Custom JavaScripts ===============
	============================================= -->
	<script src="{{ asset('/admin-lte/assets/js/main.js') }}"></script>
	
	<script src="{{ asset('/admin-lte/assets/js/formValidation.js') }}"></script>
	
	
	<!--/ custom javascripts -->


	<!-- ===============================================
	============== Page Specific Scripts ===============
	================================================ -->
        <script>
            $(window).load(function(){
                // Initialize Statistics chart
                var data = [{
                    data: [[1,15],[2,40],[3,35],[4,39],[5,42],[6,50],[7,46],[8,49],[9,59],[10,60],[11,58],[12,74]],
                    label: 'Unique Visits',
                    points: {
                        show: true,
                        radius: 4
                    },
                    splines: {
                        show: true,
                        tension: 0.45,
                        lineWidth: 4,
                        fill: 0
                    }
                }, {
                    data: [[1,50],[2,80],[3,90],[4,85],[5,99],[6,125],[7,114],[8,96],[9,130],[10,145],[11,139],[12,160]],
                    label: 'Page Views',
                    bars: {
                        show: true,
                        barWidth: 0.6,
                        lineWidth: 0,
                        fillColor: { colors: [{ opacity: 0.3 }, { opacity: 0.8}] }
                    }
                }];

                var options = {
                    colors: ['#e05d6f','#61c8b8'],
                    series: {
                        shadowSize: 0
                    },
                    legend: {
                        backgroundOpacity: 0,
                        margin: -7,
                        position: 'ne',
                        noColumns: 2
                    },
                    xaxis: {
                        tickLength: 0,
                        font: {
                            color: '#fff'
                        },
                        position: 'bottom',
                        ticks: [
                            [ 1, 'JAN' ], [ 2, 'FEB' ], [ 3, 'MAR' ], [ 4, 'APR' ], [ 5, 'MAY' ], [ 6, 'JUN' ], [ 7, 'JUL' ], [ 8, 'AUG' ], [ 9, 'SEP' ], [ 10, 'OCT' ], [ 11, 'NOV' ], [ 12, 'DEC' ]
                        ]
                    },
                    yaxis: {
                        tickLength: 0,
                        font: {
                            color: '#fff'
                        }
                    },
                    grid: {
                        borderWidth: {
                            top: 0,
                            right: 0,
                            bottom: 1,
                            left: 1
                        },
                        borderColor: 'rgba(255,255,255,.3)',
                        margin:0,
                        minBorderMargin:0,
                        labelMargin:20,
                        hoverable: true,
                        clickable: true,
                        mouseActiveRadius:6
                    },
                    tooltip: true,
                    tooltipOpts: {
                        content: '%s: %y',
                        defaultTheme: false,
                        shifts: {
                            x: 0,
                            y: 20
                        }
                    }
                };

                var plot = $.plot($("#statistics-chart"), data, options);

                $(window).resize(function() {
                    // redraw the graph in the correctly sized div
                    plot.resize();
                    plot.setupGrid();
                    plot.draw();
                });
                // * Initialize Statistics chart

                //Initialize morris chart
               /*  Morris.Donut({
                    element: 'browser-usage',
                    data: [
                        {label: 'Chrome', value: 25, color: '#00a3d8'},
                        {label: 'Safari', value: 20, color: '#2fbbe8'},
                        {label: 'Firefox', value: 15, color: '#72cae7'},
                        {label: 'Opera', value: 5, color: '#d9544f'},
                        {label: 'Internet Explorer', value: 10, color: '#ffc100'},
                        {label: 'Other', value: 25, color: '#1693A5'}
                    ],
                    resize: true
                }); */
                //*Initialize morris chart


                // Initialize owl carousels
                $('#todo-carousel, #feed-carousel, #notes-carousel').owlCarousel({
                    autoPlay: 5000,
                    stopOnHover: true,
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    singleItem : true,
                    responsive: true
                });

                $('#appointments-carousel').owlCarousel({
                    autoPlay: 5000,
                    stopOnHover: true,
                    slideSpeed : 300,
                    paginationSpeed : 400,
                    navigation: true,
                    navigationText : ['<i class=\'fa fa-chevron-left\'></i>','<i class=\'fa fa-chevron-right\'></i>'],
                    singleItem : true
                });
                //* Initialize owl carousels


                // Initialize rickshaw chart
                var graph;

                var seriesData = [ [], []];
                var random = new Rickshaw.Fixtures.RandomData(50);

                for (var i = 0; i < 50; i++) {
                    random.addData(seriesData);
                }

                graph = new Rickshaw.Graph( {
                    element: document.querySelector("#realtime-rickshaw"),
                    renderer: 'area',
                    height: 133,
                    series: [{
                        name: 'Series 1',
                        color: 'steelblue',
                        data: seriesData[0]
                    }, {
                        name: 'Series 2',
                        color: 'lightblue',
                        data: seriesData[1]
                    }]
                });

                var hoverDetail = new Rickshaw.Graph.HoverDetail( {
                    graph: graph,
                });

                graph.render();

                setInterval( function() {
                    random.removeData(seriesData);
                    random.addData(seriesData);
                    graph.update();

                },1000);
                //* Initialize rickshaw chart

                //Initialize mini calendar datepicker
                $('#mini-calendar').datetimepicker({
                    inline: true
                });
                //*Initialize mini calendar datepicker


                //todo's
                $('.widget-todo .todo-list li .checkbox').on('change', function() {
                    var todo = $(this).parents('li');

                    if (todo.hasClass('completed')) {
                        todo.removeClass('completed');
                    } else {
                        todo.addClass('completed');
                    }
                });
                //* todo's


                //initialize datatable
                $('#project-progress').DataTable({
                    "aoColumnDefs": [
                      { 'bSortable': false, 'aTargets': [ "no-sort" ] }
                    ],
                });
                //*initialize datatable
				
				//initialize datatable
                $('#project-progress2').DataTable({
                    "aoColumnDefs": [
                      { 'bSortable': false, 'aTargets': [ "no-sort" ] }
                    ],
                });
                //*initialize datatable

                //load wysiwyg editor
                $('#summernote').summernote({
                    toolbar: [
                        //['style', ['style']], // no style button
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']],
                        //['insert', ['picture', 'link']], // no insert buttons
                        //['table', ['table']], // no table button
                        //['help', ['help']] //no help button
                    ],
                    height: 143   //set editable area's height
                });
                //*load wysiwyg editor
            });
        </script>
        <!--/ Page Specific Scripts -->

<script language="javascript">
	
	var badwords = ["4r5e","5h1t","5hit","a55","anal","anus","ar5e","arrse","arse","ass","ass-fucker","asses","assfucker","assfukka","asshole","assholes","asswhole","a_s_s","b!tch","b00bs","b17ch","b1tch","ballbag","balls","ballsack","bastard","beastial","beastiality","bellend","bestial","bestiality","bi+ch","biatch","bitch","bitcher","bitchers","bitches","bitchin","bitching","bloody","blow job","blowjob","blowjobs","boiolas","bollock","bollok","boner","boob","boobs","booobs","boooobs","booooobs","booooooobs","breasts","buceta","bugger","bum","bunny fucker","butt","butthole","buttmuch","buttplug","c0ck","c0cksucker","carpet muncher","cawk","chink","cipa","cl1t","clit","clitoris","clits","cnut","cock","cock-sucker","cockface","cockhead","cockmunch","cockmuncher","cocks","cocksuck","cocksucked","cocksucker","cocksucking","cocksucks","cocksuka","cocksukka","cok","cokmuncher","coksucka","coon","cox","crap","cum","cummer","cumming","cums","cumshot","cunilingus","cunillingus","cunnilingus","cunt","cuntlick","cuntlicker","cuntlicking","cunts","cyalis","cyberfuc","cyberfuck","cyberfucked","cyberfucker","cyberfuckers","cyberfucking","d1ck","damn","dick","dickhead","dildo","dildos","dink","dinks","dirsa","dlck","dog-fucker","doggin","dogging","donkeyribber","doosh","duche","dyke","ejaculate","ejaculated","ejaculates","ejaculating","ejaculatings","ejaculation","ejakulate","f u c k","f u c k e r","f4nny","fag","fagging","faggitt","faggot","faggs","fagot","fagots","fags","fanny","fannyflaps","fannyfucker","fanyy","fatass","fcuk","fcuker","fcuking","feck","fecker","felching","fellate","fellatio","fingerfuck","fingerfucked","fingerfucker","fingerfuckers","fingerfucking","fingerfucks","fistfuck","fistfucked","fistfucker","fistfuckers","fistfucking","fistfuckings","fistfucks","flange","fook","fooker","fuck","fucka","fucked","fucker","fuckers","fuckhead","fuckheads","fuckin","fucking","fuckings","fuckingshitmotherfucker","fuckme","fucks","fuckwhit","fuckwit","fudge packer","fudgepacker","fuk","fuker","fukker","fukkin","fuks","fukwhit","fukwit","fux","fux0r","f_u_c_k","gangbang","gangbanged","gangbangs","gaylord","gaysex","goatse","God","god-dam","god-damned","goddamn","goddamned","hardcoresex","hell","heshe","hoar","hoare","hoer","homo","hore","horniest","horny","hotsex","jack-off","jackoff","jap","jerk-off","jism","jiz","jizm","jizz","kawk","knob","knobead","knobed","knobend","knobhead","knobjocky","knobjokey","kock","kondum","kondums","kunilingus","l3i+ch","l3itch","labia","lmfao","lust","lusting","m0f0","m0fo","m45terbate","ma5terb8","ma5terbate","masochist","master-bate","masterb8","masterbat*","masterbat3","masterbate","masterbation","masterbations","masturbate","mo-fo","mof0","mofo","mothafuck","mothafucka","mothafuckas","mothafuckaz","mothafucked","mothafucker","mothafuckers","mothafuckin","mothafucking","mothafuckings","mothafucks","mother fucker","motherfuck","motherfucked","motherfucker","motherfuckers","motherfuckin","motherfucking","motherfuckings","motherfuckka","motherfucks","muff","mutha","muthafecker","muthafuckker","muther","mutherfucker","n1gga","n1gger","nazi","nigg3r","nigg4h","nigga","niggah","niggas","niggaz","nigger","niggers","nob","nob jokey","nobhead","nobjocky","nobjokey","numbnuts","nutsack","orgasim","orgasims","orgasm","orgasms","p0rn","pawn","pecker","penis","penisfucker","phonesex","phuck","phuk","phuked","phuking","phukked","phukking","phuks","phuq","pigfucker","pimpis","piss","pissed","pisser","pissers","pisses","pissflaps","pissin","pissing","pissoff","poop","porn","porno","pornography","pornos","prick","pricks","pron","pube","pusse","pussi","pussies","pussy","pussys","rectum","retard","rimjaw","rimming","s hit","s.o.b.","sadist","schlong","screwing","scroat","scrote","scrotum","semen","sex","sh!+","sh!t","sh1t","shag","shagger","shaggin","shagging","shemale","shi+","shit","shitdick","shite","shited","shitey","shitfuck","shitfull","shithead","shiting","shitings","shits","shitted","shitter","shitters","shitting","shittings","shitty","skank","slut","sluts","smegma","smut","snatch","son-of-a-bitch","spac","spunk","s_h_i_t","t1tt1e5","t1tties","teets","teez","testical","testicle","tit","titfuck","tits","titt","tittie5","tittiefucker","titties","tittyfuck","tittywank","titwank","tosser","turd","tw4t","twat","twathead","twatty","twunt","twunter","v14gra","v1gra","vagina","viagra","vulva","w00se","wang","wank","wanker","wanky","whoar","whore","willies","willy","xrated","bomb","kill","murder","xxx"];
	
	function loadLog(filename){
		
		var cb_file = filename;
		var oldscrollHeight = $("#chatbox"+cb_file).attr("scrollHeight") - 20; //Scroll height before the request
		var str1 = "{{asset('chat/loghtml/log.')}}";
		var str2 = "firstchat";
		var str3 = ".html";
		var filename =  "{{asset('chat/loghtml/log.')}}"+filename+".html";
		$.ajax({
			url: filename,
			cache: false,
			success: function(html){
				$("#chatbox"+cb_file).html(html); //Insert chat log into the #chatbox div
				var newscrollHeight = $("#chatbox"+cb_file).attr("scrollHeight") - 20; //Scroll height after the request
				if(newscrollHeight > oldscrollHeight){
					$("#chatbox"+cb_file).animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
				}
			},
		});
	}
	
	function startchat(id){
		var myInterval;
		clearInterval(myInterval);
		var url_str = "chatId="+id;
		$.ajax({
			type: "GET",
			url: "{{asset('admin/custchathisupd')}}",
			data: url_str,
			success: function(data){
				var result=data.split("~");
				$("#"+id).parents("tr").remove();
				$("#entryform").hide();
				$("#chatfile").val(result[0]);
				$("#name1").val(result[1]);
				loadLog(result[0]);
				myInterval=setInterval (function() { loadLog(result[0]); }, 2500);
				$("#chatContainer").append('<div onclick = "maxchat(this.id)" id="maxchat'+result[0]+'" style="height:30px;float:right;display:none;"><span style="width:50px;background:#333;padding:5px 10px 5px 10px;margin-right:5px;cursor:pointer">+</span></div>'
						+'<div class="chat-box pull-right"><section id="chat'+result[0]+'" class="tile widget-chat" style="border: 3px solid rgb(65, 139, 202); margin-bottom:0px;">'
						+'<div class="tile-header chat dvd dvd-btm" style="background-color:#418bca; color:#fff;"><h1 class="custom-font">Chat</h1>'
							+'<ul class="controls">'
								+'<li><a onclick = "minchat(this.id)" id="minchat'+result[0]+'"><i class="fa fa-minus" aria-hidden="true"></i></a></li>'
								+'<li class="remove"><a onclick = "closechat(this.id)" id="closechat'+result[0]+'" role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>'
							+'</ul>'
						+'</div>'

							+'<div class="tile-body slim-scroll chatbox" style="max-height: 320px;overflow:auto;" id="chatbox'+result[0]+'"></div>'
							+'<div class="tile-footer"><div class="chat-form"><div class="input-group">'
								+'<input type="hidden" name="chatfile" id="chatfile" value="'+result[0]+'" />'
								+'<input class="form-control" placeholder="Type your message here..." type="text" class="chatmsg" onkeypress="onTextChange(this.id)" id="msg1'+result[0]+'" style="color: #333;width:100%">'
								+'<span class="input-group-btn"> <button type="button" onclick = "chatsubmit(this.id)" id="'+result[0]+'" value="submit" class="btn btn-default"><i class="fa fa-chevron-right"></i></button></span>'
								+'<input type="hidden" name="name1" id="name1" value="'+result[0]+'">'
								+'<p style="color:red;" id="badnotice'+result[0]+'"></p>'
							+'</div></div>'
						+'</div>'
						+'</section></div>'
						);
				$("#chat"+result[0]).show("slow");
			}
		});
	}
	
	function chatsubmit(id){
		document.getElementById("badnotice"+id).innerHTML="";
		var str4 = "{{asset('chat/post.new.php')}}";
		var streamname = "firstchat";
		var postfilename = str4.concat("?stream=",streamname);
		var clientmsg = $("#msg1"+id).val();
		var clientname = $("#name1").val();
		var filename = id;
		var rating = $("#rating").val();
		var error=0;
		var badwords = ["4r5e","5h1t","5hit","a55","anal","anus","ar5e","arrse","arse","ass","ass-fucker","asses","assfucker","assfukka","asshole","assholes","asswhole","a_s_s","b!tch","b00bs","b17ch","b1tch","ballbag","balls","ballsack","bastard","beastial","beastiality","bellend","bestial","bestiality","bi+ch","biatch","bitch","bitcher","bitchers","bitches","bitchin","bitching","bloody","blow job","blowjob","blowjobs","boiolas","bollock","bollok","boner","boob","boobs","booobs","boooobs","booooobs","booooooobs","breasts","buceta","bugger","bum","bunny fucker","butt","butthole","buttmuch","buttplug","c0ck","c0cksucker","carpet muncher","cawk","chink","cipa","cl1t","clit","clitoris","clits","cnut","cock","cock-sucker","cockface","cockhead","cockmunch","cockmuncher","cocks","cocksuck","cocksucked","cocksucker","cocksucking","cocksucks","cocksuka","cocksukka","cok","cokmuncher","coksucka","coon","cox","crap","cum","cummer","cumming","cums","cumshot","cunilingus","cunillingus","cunnilingus","cunt","cuntlick","cuntlicker","cuntlicking","cunts","cyalis","cyberfuc","cyberfuck","cyberfucked","cyberfucker","cyberfuckers","cyberfucking","d1ck","damn","dick","dickhead","dildo","dildos","dink","dinks","dirsa","dlck","dog-fucker","doggin","dogging","donkeyribber","doosh","duche","dyke","ejaculate","ejaculated","ejaculates","ejaculating","ejaculatings","ejaculation","ejakulate","f u c k","f u c k e r","f4nny","fag","fagging","faggitt","faggot","faggs","fagot","fagots","fags","fanny","fannyflaps","fannyfucker","fanyy","fatass","fcuk","fcuker","fcuking","feck","fecker","felching","fellate","fellatio","fingerfuck","fingerfucked","fingerfucker","fingerfuckers","fingerfucking","fingerfucks","fistfuck","fistfucked","fistfucker","fistfuckers","fistfucking","fistfuckings","fistfucks","flange","fook","fooker","fuck","fucka","fucked","fucker","fuckers","fuckhead","fuckheads","fuckin","fucking","fuckings","fuckingshitmotherfucker","fuckme","fucks","fuckwhit","fuckwit","fudge packer","fudgepacker","fuk","fuker","fukker","fukkin","fuks","fukwhit","fukwit","fux","fux0r","f_u_c_k","gangbang","gangbanged","gangbangs","gaylord","gaysex","goatse","God","god-dam","god-damned","goddamn","goddamned","hardcoresex","heshe","hoar","hoare","hoer","homo","hore","horniest","horny","hotsex","jack-off","jackoff","jap","jerk-off","jism","jiz","jizm","jizz","kawk","knob","knobead","knobed","knobend","knobhead","knobjocky","knobjokey","kock","kondum","kondums","kunilingus","l3i+ch","l3itch","labia","lmfao","lust","lusting","m0f0","m0fo","m45terbate","ma5terb8","ma5terbate","masochist","master-bate","masterb8","masterbat*","masterbat3","masterbate","masterbation","masterbations","masturbate","mo-fo","mof0","mofo","mothafuck","mothafucka","mothafuckas","mothafuckaz","mothafucked","mothafucker","mothafuckers","mothafuckin","mothafucking","mothafuckings","mothafucks","mother fucker","motherfuck","motherfucked","motherfucker","motherfuckers","motherfuckin","motherfucking","motherfuckings","motherfuckka","motherfucks","muff","mutha","muthafecker","muthafuckker","muther","mutherfucker","n1gga","n1gger","nazi","nigg3r","nigg4h","nigga","niggah","niggas","niggaz","nigger","niggers","nob","nob jokey","nobhead","nobjocky","nobjokey","numbnuts","nutsack","orgasim","orgasims","orgasm","orgasms","p0rn","pawn","pecker","penis","penisfucker","phonesex","phuck","phuk","phuked","phuking","phukked","phukking","phuks","phuq","pigfucker","pimpis","piss","pissed","pisser","pissers","pisses","pissflaps","pissin","pissing","pissoff","poop","porn","porno","pornography","pornos","prick","pricks","pron","pube","pusse","pussi","pussies","pussy","pussys","rectum","retard","rimjaw","rimming","s hit","s.o.b.","sadist","schlong","screwing","scroat","scrote","scrotum","semen","sex","sh!+","sh!t","sh1t","shag","shagger","shaggin","shagging","shemale","shi+","shit","shitdick","shite","shited","shitey","shitfuck","shitfull","shithead","shiting","shitings","shits","shitted","shitter","shitters","shitting","shittings","shitty","skank","slut","sluts","smegma","smut","snatch","son-of-a-bitch","spac","spunk","s_h_i_t","t1tt1e5","t1tties","teets","teez","testical","testicle","tit","titfuck","tits","titt","tittie5","tittiefucker","titties","tittyfuck","tittywank","titwank","tosser","turd","tw4t","twat","twathead","twatty","twunt","twunter","v14gra","v1gra","vagina","viagra","vulva","w00se","wang","wank","wanker","wanky","whoar","whore","willies","willy","xrated","xxx"];
		for(var i=0;i<badwords.length;i++){
			var val=badwords[i];
			if((clientmsg.toLowerCase()).indexOf(val.toString())>-1){
				error=error+1;
			}
		}
		if(error>0){
			//alert("Your Message Contains Bad Words, Please Remove Them Before Proceeding");
			document.getElementById("badnotice"+id).innerHTML="Some Bad Words In Your Text!";
		}
		else{
			document.getElementById("badnotice"+id).innerHTML="";
			if(clientmsg!=""){
				$.post(postfilename, {subject: clientmsg,usertype:'admin',name:clientname,rating:rating,type:'onhold',filename:filename},function( data ) {
					loadLog(filename);
				});
				$("#msg1"+id).attr("value", "");
				document.getElementById("msg1"+id).value = "";
				$("#msg1"+id).focus();
			}
		}
		return false;
	}

	function minchat(minid){
		var id = minid.replace("minchat", ""); 
		$("#chat"+id).hide("slow");
		$("#maxchat"+id).show();
	}

	function closechat(clsid){
		var id = clsid.replace("closechat", "");
		var res=confirm("Are you sure want to close?");
		var str = "file="+id;
		if(res){
			$.ajax({
				type: "GET",
				url: "{{asset('admin/custchathiscls')}}",
				data: str,
				success: function(data){
					var str4 = "{{asset('chat/close.new.php')}}";
					var streamname = "closechat";
					var postfilename = str4.concat("?stream=",streamname);
					$.post(postfilename, {type:'closed',filename:id},function( data ) {
						console.log(data);
					});
					$("#chat"+id).hide("slow");
					$("#maxchat"+id).hide();
				}
			});
		}
	}
	
	function maxchat(maxid){
		var id = maxid.replace("maxchat", ""); 
		$("#chat"+id).show("slow");
		$("#maxchat"+id).hide();
		$.get( "closechat.php", function( data ) {
		});
	}
	
	function onTextChange(msgid){
		
		var id = msgid.replace("msg1", ""); 
		
		$(document).keypress(function (e) {
			var error=0;
			if ( e.keyCode === 32 ){
				document.getElementById("badnotice"+id).innerHTML="";
				var clientmsg = $("#msg1"+id).val();
				var badwords = ["4r5e","5h1t","5hit","a55","anal","anus","ar5e","arrse","arse","ass","ass-fucker","asses","assfucker","assfukka","asshole","assholes","asswhole","a_s_s","b!tch","b00bs","b17ch","b1tch","ballbag","balls","ballsack","bastard","beastial","beastiality","bellend","bestial","bestiality","bi+ch","biatch","bitch","bitcher","bitchers","bitches","bitchin","bitching","bloody","blow job","blowjob","blowjobs","boiolas","bollock","bollok","boner","boob","boobs","booobs","boooobs","booooobs","booooooobs","breasts","buceta","bugger","bum","bunny fucker","butt","butthole","buttmuch","buttplug","c0ck","c0cksucker","carpet muncher","cawk","chink","cipa","cl1t","clit","clitoris","clits","cnut","cock","cock-sucker","cockface","cockhead","cockmunch","cockmuncher","cocks","cocksuck","cocksucked","cocksucker","cocksucking","cocksucks","cocksuka","cocksukka","cok","cokmuncher","coksucka","coon","cox","crap","cum","cummer","cumming","cums","cumshot","cunilingus","cunillingus","cunnilingus","cunt","cuntlick","cuntlicker","cuntlicking","cunts","cyalis","cyberfuc","cyberfuck","cyberfucked","cyberfucker","cyberfuckers","cyberfucking","d1ck","damn","dick","dickhead","dildo","dildos","dink","dinks","dirsa","dlck","dog-fucker","doggin","dogging","donkeyribber","doosh","duche","dyke","ejaculate","ejaculated","ejaculates","ejaculating","ejaculatings","ejaculation","ejakulate","f u c k","f u c k e r","f4nny","fag","fagging","faggitt","faggot","faggs","fagot","fagots","fags","fanny","fannyflaps","fannyfucker","fanyy","fatass","fcuk","fcuker","fcuking","feck","fecker","felching","fellate","fellatio","fingerfuck","fingerfucked","fingerfucker","fingerfuckers","fingerfucking","fingerfucks","fistfuck","fistfucked","fistfucker","fistfuckers","fistfucking","fistfuckings","fistfucks","flange","fook","fooker","fuck","fucka","fucked","fucker","fuckers","fuckhead","fuckheads","fuckin","fucking","fuckings","fuckingshitmotherfucker","fuckme","fucks","fuckwhit","fuckwit","fudge packer","fudgepacker","fuk","fuker","fukker","fukkin","fuks","fukwhit","fukwit","fux","fux0r","f_u_c_k","gangbang","gangbanged","gangbangs","gaylord","gaysex","goatse","God","god-dam","god-damned","goddamn","goddamned","hardcoresex","heshe","hoar","hoare","hoer","homo","hore","horniest","horny","hotsex","jack-off","jackoff","jap","jerk-off","jism","jiz","jizm","jizz","kawk","knob","knobead","knobed","knobend","knobhead","knobjocky","knobjokey","kock","kondum","kondums","kunilingus","l3i+ch","l3itch","labia","lmfao","lust","lusting","m0f0","m0fo","m45terbate","ma5terb8","ma5terbate","masochist","master-bate","masterb8","masterbat*","masterbat3","masterbate","masterbation","masterbations","masturbate","mo-fo","mof0","mofo","mothafuck","mothafucka","mothafuckas","mothafuckaz","mothafucked","mothafucker","mothafuckers","mothafuckin","mothafucking","mothafuckings","mothafucks","mother fucker","motherfuck","motherfucked","motherfucker","motherfuckers","motherfuckin","motherfucking","motherfuckings","motherfuckka","motherfucks","muff","mutha","muthafecker","muthafuckker","muther","mutherfucker","n1gga","n1gger","nazi","nigg3r","nigg4h","nigga","niggah","niggas","niggaz","nigger","niggers","nob","nob jokey","nobhead","nobjocky","nobjokey","numbnuts","nutsack","orgasim","orgasims","orgasm","orgasms","p0rn","pawn","pecker","penis","penisfucker","phonesex","phuck","phuk","phuked","phuking","phukked","phukking","phuks","phuq","pigfucker","pimpis","piss","pissed","pisser","pissers","pisses","pissflaps","pissin","pissing","pissoff","poop","porn","porno","pornography","pornos","prick","pricks","pron","pube","pusse","pussi","pussies","pussy","pussys","rectum","retard","rimjaw","rimming","s hit","s.o.b.","sadist","schlong","screwing","scroat","scrote","scrotum","semen","sex","sh!+","sh!t","sh1t","shag","shagger","shaggin","shagging","shemale","shi+","shit","shitdick","shite","shited","shitey","shitfuck","shitfull","shithead","shiting","shitings","shits","shitted","shitter","shitters","shitting","shittings","shitty","skank","slut","sluts","smegma","smut","snatch","son-of-a-bitch","spac","spunk","s_h_i_t","t1tt1e5","t1tties","teets","teez","testical","testicle","tit","titfuck","tits","titt","tittie5","tittiefucker","titties","tittyfuck","tittywank","titwank","tosser","turd","tw4t","twat","twathead","twatty","twunt","twunter","v14gra","v1gra","vagina","viagra","vulva","w00se","wang","wank","wanker","wanky","whoar","whore","willies","willy","xrated","xxx"];
				for(var i=0;i<badwords.length;i++){
					var val=badwords[i];
					if((clientmsg.toLowerCase()).indexOf(val.toString())>-1){
						error=error+1;
					}
				}
				
				if(error>0){
					document.getElementById("badnotice"+id).innerHTML="Some Bad Words In Your Text!";
					return false;
				}
				
			}
			
			if ( e.keyCode === 13 ){
				chatsubmit(id);
			}
			
			
		});
	}

	function register_popup(attender_id){
		
		var str4 = "{{asset('chat/post.new.php')}}";
		var streamname = "firstchat";
		var postfilename = str4.concat("?stream=",streamname);
		var clientmsg = "Hello";
		var d = new Date();
		var filename1 = d.getTime();
		var myInterval;
		clearInterval(myInterval);
		
		chat_from_id = $("#luserid").val();
		chat_from_name = $("#lusername").val();

		$.post(postfilename, {subject:clientmsg,userid:chat_from_id,name:chat_from_name,attenderid:attender_id,type:'new',chatfile:filename1,chattype:'3'},function( data ) {
			console.log(data);
			var result=data.split("~");
			filename = result[0];

			loadLog(filename);
			myInterval=setInterval (function() { loadLog(result[0]); }, 2500);


			if(!$('#maxchat'+filename).length) {
				$("#chatContainer").append('<div onclick = "maxchat(this.id)" id="maxchat'+filename+'" style="height:30px;float:right;display:none;"><span style="width:50px;background:#333;padding:5px 10px 5px 10px;margin-right:5px;cursor:pointer">+</span></div>'
					+'<div class="chat-box pull-right"><section id="chat'+filename+'" class="tile widget-chat" style="border: 3px solid rgb(65, 139, 202); margin-bottom:0px;">'
					+'<div class="tile-header chat dvd dvd-btm" style="background-color:#418bca; color:#fff;"><h1 class="custom-font">Chat</h1>'
						+'<ul class="controls">'
							+'<li><a onclick = "minchat(this.id)" id="minchat'+filename+'"><i class="fa fa-minus" aria-hidden="true"></i></a></li>'
							+'<li class="remove"><a onclick = "closechat(this.id)" id="closechat'+filename+'" role="button" tabindex="0" class="tile-close"><i class="fa fa-times"></i></a></li>'
						+'</ul>'
					+'</div>'
					
					+'<div class="tile-body slim-scroll chatbox" style="max-height: 320px;overflow:auto;" id="chatbox'+filename+'"></div>'
					+'<div class="tile-footer"><div class="chat-form"><div class="input-group">'
				
							+'<input type="hidden" name="chatfile" id="chatfile" value="'+filename+'" />'
							+'<input class="form-control" placeholder="Type your message here..." type="text" class="chatmsg" onkeypress="onTextChange(this.id)" id="msg1'+filename+'" style="color: #333;width:100%">'
							+'<span class="input-group-btn"> <button type="button" onclick = "chatsubmit(this.id)" id="'+filename+'" value="submit" class="btn btn-default"><i class="fa fa-chevron-right"></i></button></span>'
							+'<input type="hidden" name="name1" id="name1" value="'+filename+'">'
							+'<p style="color:red;" id="badnotice'+filename+'"></p>'
						+'</div></div>'
				+'</div>'
				+'</section></div>'
				);
			}
			else{
				$("#msg1"+filename).focus();
			}

			$("#chat"+filename).show("slow");
		});

		//return false;
	}	
</script>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular.min.js"></script>
<script language="javascript">
	angular.module("myapp", [], function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
		$interpolateProvider.endSymbol('%>');
	})
	.controller("OnLineUserController", function($scope,$http,$interval,$timeout){
		$http.get("{{asset('admin/getonlineuser')}}",{
			headers:{
				'Content-type': 'application/json'
			}
		}).then(function(response){
			console.log(response.data);
			$scope.onuser=response.data;
			$interval(callAtTimeout, 5000);
		});

		function callAtTimeout(){
			$http.get("{{asset('admin/getonlineuser')}}",{
				headers:{
					'Content-type': 'application/json'
				}
			}).then(function(response){
				console.log(response.data);
				$scope.onuser=response.data;
			});
		}
	})
	.controller("ChatController", function($scope,$http,$interval,$timeout){
		$http.get("{{asset('admin/fetchchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
		}).then(function(response){
			console.log(response.data);
			$scope.chats=response.data.chats;
			$scope.chatcount=response.data.chatcount;
			$interval(callAtTimeout, 5000);
		});

		function callAtTimeout(){
			$http.get("{{asset('admin/fetchchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
			}).then(function(response){
				console.log(response.data);
				$scope.chats=response.data.chats;
				$scope.chatcount=response.data.chatcount;
			});
		}
	})
	.controller("EmpChatController", function($scope,$http,$interval,$timeout){
		$http.get("{{asset('admin/fetchempchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
		}).then(function(response){
			console.log(response.data);
			$scope.empchats=response.data.empchats;
			$interval(callAtTimeout, 5000);
		});

		function callAtTimeout(){
			$http.get("{{asset('admin/fetchempchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
			}).then(function(response){
				console.log(response.data);
				$scope.empchats=response.data.empchats;
			});
		}
	})
	.controller("ChattingController", function($scope,$http,$interval,$timeout){
		$http.get("{{asset('admin/fetchonchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
		}).then(function(response){
			console.log(response.data);
			$scope.onchats=response.data.onchats;
			$interval(callAtTimeout, 5000);
		});

		function callAtTimeout(){
			$http.get("{{asset('admin/fetchonchats')}}",{
			headers:{
				'Content-type': 'application/json'
			}
			}).then(function(response){
				console.log(response.data);
				$scope.onchats=response.data.onchats;
			});
		}
	})
	.controller("EmpTicketController", function($scope,$http,$interval,$timeout){
		$http.get("{{asset('empTickets')}}",{
			headers:{
				'Content-type': 'application/json'
			}
		}).then(function(response){
			console.log(response.data);
			$scope.emptickets=response.data;
			$interval(callEmpTicket, 5000);
		});

		function callEmpTicket(){
			$http.get("{{asset('empTickets')}}",{
				headers:{
					'Content-type': 'application/json'
				}
			}).then(function(response){
				console.log(response.data);
				$scope.emptickets=response.data;
			});
		}
	});
	
</script>

<style>
	.loginform{
		background:#3c8dbc;
		width:70%;
		z-index: 1000;
		position:fixed;
		right:0px;
		bottom:0px;
		color:white;
		height: auto;
		overflow: hidden;
	}
	.chat-box{
		width:30%;
		margin-right: 10px;
		bottom:0px;
	}
	.chatbox{
		text-align:left;
		margin:0 auto;
		margin-bottom:8px;
		padding:2px;
		height:200px;
		color:black;
		overflow:auto;
	}
</style>
