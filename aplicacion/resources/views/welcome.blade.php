<!DOCTYPE html>
<html lang="es">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Gestión de Condominios</title>
    <meta name="keywords" content="condominios, condominios venezuela, condominio en linea, software administracion condominio, condominio web aplicacion" />
    <meta name="description" content="Aplicacion Web que te permite administrar tu condominios en línea." />
    <meta name="keywords" content=" content" />
		<link href="cvweb/css/bootstrap.min.css" rel="stylesheet">
		<link href="cvweb/css/prettyPhoto.css" rel="stylesheet">
		<!-- <link href="cvweb/css/font-awesome.min.css" rel="stylesheet"> -->
		{{-- <link href="v2/libs/font-awesome-4.5.0/css/font-awesome.min.css" rel="stylesheet"> --}}
		<link href="cvweb/css/animate.css" rel="stylesheet">
		<link href="cvweb/css/main.css" rel="stylesheet">
		<link href="cvweb/css/responsive.css" rel="stylesheet">
		<!--[if lt IE 9]> <script src="cvweb/js/html5shiv.js"></script>
		<script src="cvweb/js/respond.min.js"></script> <![endif]-->
		<link rel="shortcut icon" href="cvweb/images/ico/favicon.png">
</head><!--/head-->
<body>
	<div class="preloader">
		<div class="preloder-wrap">
			<div class="preloder-inner">
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
				<div class="ball"></div>
			</div>
		</div>
	</div><!--/.preloader-->
	<header id="navigation">
		<div class="navbar navbar-inverse navbar-fixed-top" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
					</button>
					<!-- <a class="navbar-brand" href="index.html"><h1><img src="cvweb/images/logo-cv-web.png" alt="logo"></h1></a> -->
					<a class="navbar-brand" href="index.php"><h1><img src="{{ asset('cvweb') }}/logo-condominios2.png" alt="" ></h1></a>
				</div>
				<div class="collapse navbar-collapse">
					<ul class="nav navbar-nav navbar-right">
						<li class="scroll active"><a href="#navigation">Inicio</a></li>
						<li class="scroll"><a href="#about-us">Quienes somos</a></li>
						{{-- <li class="scroll"><a href="#services">Servicios</a></li>
						<li class="scroll"><a href="#blog">Soporte</a></li>
						<li class="scroll"><a href="#contact">Contacto</a></li> --}}
						@if($towers != 0)
							<li class="scroll"><a href="{{ route('login') }}">Iniciar Sesión</a></li>
						@else
							<li class="scroll"><a href="{{ route('register') }}">Registrar Condominio</a></li>
						@endif
					</ul>
				</div>
			</div>
		</div><!--/navbar-->
	</header> <!--/#navigation-->

	<section id="home">
		<div class="home-pattern"></div>
		<div id="main-carousel" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#main-carousel" data-slide-to="0" class="active"></li>
				<li data-target="#main-carousel" data-slide-to="1"></li>
				<li data-target="#main-carousel" data-slide-to="2"></li>
			</ol><!--/.carousel-indicators-->
			<div class="carousel-inner">
				<div class="item active" style="background-image: url(cvweb/images/slider/slider1-CV.jpg)">
					<div class="carousel-caption">
						<div>
							<h2 class="heading animated bounceInDown">Gestión de Condominios</h2>
							<p class="animated bounceInUp"></p>
							<a class="btn btn-default slider-btn animated fadeIn" href="{{ route('login') }}">
								Iniciar Sesión
							</a>
						</div>
					</div>
				</div>
				<div class="item" style="background-image: url(cvweb/images/slider/slider2-CV.jpg)">
					<div class="carousel-caption">
						<div>
							<h2 class="heading animated bounceInDown">Ideal para administradores y juntas de condominios...</h2>
							<p class="animated bounceInUp">Es la herramienta perfecta para tu gestión administrativa, flexible y poderosa<br>te permitirá administrar tu condominios de una forma fácil y práctica.</p>
							<a class="btn btn-default slider-btn animated fadeIn" href="#about-login">Iniciar Sesión</a>
						</div>
					</div>
				</div>
			<div class="item" style="background-image: url(cvweb/images/slider/slider3-CV.jpg)">
				<div class="carousel-caption">
					<div>
						<h2 class="heading animated bounceInRight">Estamos mejorando para ti</h2>
						<p class="animated bounceInLeft">Diseño moderno y totalmente adaptable a la gran mayoria de dispositivos</p>
						<!-- <a class="btn btn-default slider-btn animated bounceInUp" href="#">Iniciar Sesión</a>  -->
					</div>
				</div>
			</div>
		</div><!--/.carousel-inner-->

		<a class="carousel-left member-carousel-control hidden-xs" href="#main-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
		<a class="carousel-right member-carousel-control hidden-xs" href="#main-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
	</div>

</section><!--/#home-->

<section id="about-us">
	<div class="container">
		<div class="text-center">
			<div class="col-sm-8 col-sm-offset-2">
				<h2 class="title-one">¿Quienes Somos?</h2>
				<p>Es una aplicación 100% en línea diseñada para la administración de condominios y/o edificios. Es la herramienta ideal para juntas de condominios autoadministradas o empresas de servicios administrativos.</p>
			</div>
		</div>
		<div class="about-us">
			<div class="row">
				<div class="col-sm-6">
					<h3>¿Nuestro Sistema?</h3>
					<ul class="nav nav-tabs">
						<li class="active"><a href="#about" data-toggle="tab"><i class="fa fa-chain-broken"></i> Acerca de</a></li>
						<li><a href="#mission" data-toggle="tab"><i class="fa fa-th-large"></i> Misión</a></li>
						<!-- <li><a href="#community" data-toggle="tab"><i class="fa fa-users"></i> Community</a></li> -->
					</ul>
					<div class="tab-content">
						<div class="tab-pane fade in active" id="about">
							<div class="media">
								<img class="pull-left media-object" src="cvweb/images/about-us/about-CV.jpg" alt="Acerca de">
								<div class="media-body">
									<p>Nuestro sistema le(s) permitirá administrar su(s) condominio(s) en una forma fácil y práctica, además de brindar a los propietarios o residentes de cada condominio las facilidades para consultar su estatus de solvencia en cuanto a los pagos y la manera en como los recursos del condominio son administrados, esto proporciona transparencia y confianza en la gestión de la junta administradora.</p>
								</div>
							</div>
						</div>
						<div class="tab-pane fade" id="mission">
							<div class="media">
								<img class="pull-left media-object" src="cvweb/images/about-us/mission-CV.jpg" alt="Misión">
								<div class="media-body">
									<p>Ofrecer un sistema adaptable tanto a juntas de condominios residenciales, administradoras de condominios, edificios. Garantizando en lo posible la disponibilidad de la aplicación en Internet, la integridad, confiabilidad y confidencialidad de los datos, así como el soporte continuo y oportuno para la solución de problemas y también para la incorporación de nuevos requerimientos con respuestas en el menor tiempo posible. </p>
								</div>
							</div>
						</div>
						<!-- <div class="tab-pane fade" id="community">
							<div class="media">
								<img class="pull-left media-object" src="cvweb/images/about-us/community.jpg" alt="Community">
								<div class="media-body">
									<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. </p>
								</div>
							</div>
						</div> -->
					</div>
				</div>
				<div id="about-login" class="col-sm-6">
					<h3 id="titLogin">Acceder al sistema</h3>
					<div class="skill-bar" id='loginDialogId'>
						<br><br><br><br><br><br><br>
						<a href="{{ route('login') }}">
							<button class="btn btn-success btn-lg btn-block">Iniciar Sesión</button>
						</a>
						{{-- <iframe src="v2/login.php" frameborder="0" style="height: 318px; overflow: hidden; border: 1px solid #ddd;" id="logFrame"></iframe> --}}
						<!-- <iframe src="v2/login_nw.php" width="318px" height="150px" frameborder="0" style="overflow: hidden;" id="logFrame"></iframe> -->
					</div>
					</div>
				</div>
			</div>
		</div>
	</section><!--/#about-us-->

	{{-- <section id="services" class="parallax-section">
		<div class="container">
			<div class="row text-center">
				<div class="col-sm-8 col-sm-offset-2">
					<h2 class="title-one">Servicios</h2>
					<p>Nuestro principal servicio es ofrecerles un completo sistema en linea para la administración de condominios que facilita la gestión administrativa, la interacción y el feedback entre administradores y propietarios lo que se traduce en una mayor eficiencia y transparencia de su gestión.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div class="our-service">
						<div class="services row">
							<div class="col-sm-4">
								<div class="single-service">
									<i class="fa fa-gears"></i>
									<h2>Software Adaptable</h2>
									<p>Ofrecemos una aplicación adaptable, ya que ademas de acceder a la misma desde nuestra web (http://www.condominiosvenezuela.com), tambien ofrecemos el servicio de "Marca Blanca", es decir que en caso de que ya posea una pagina web nuestro sistema puede ser integrado a la misma y así mantendría la identidad corporativa de su empresa administradora o condominio, en caso de aun no poseer pagina web propia y desee el servicio de "Marca Blanca" también podemos ofrecerles el servicio de creación de pagina web e identidad gráfica corporativa (Diseño de Logotipo, Banner, etc...)</p>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="single-service">
									<i class="fa fa-commenting"></i>
									<h2>Notificaciones SMS</h2>
									<p>Ademas de nuestro habitual servicio de notificaciones via e-mail, adicionalmente ofrecemos un nuevo servicio de notificaciones vía SMS(mensaje de texto) que les permitirá ampliar la forma de comunicación con los propietarios mediante el envío de mensajes personalizados de forma automatizada ahorrando exponencialmente su valioso tiempo.<br>
									Podrá enviar distintos tipos de notificaciones tales como:
										<ul style="text-align: left;">
											<li>Notificación de Facturación.</li>
											<li>Aprobación/Anulación Pagos.</li>
											<li>Morosidad/Estado de deuda.</li>
											<li>Comunicados.</li>
										</ul>
									</p>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="single-service">
									<i class="fa fa-support"></i>
									<h2>Centro de Soporte</h2>
									<p>Nuestro centro de soporte en-linea es una herramienta que permite atender las solicitudes y requerimientos de nuestros clientes de forma mas organizada. Es un sistema basado en tickets de servicios lo que permite llevar el registro de cada solicitud y sus interacciones con nuestros analistas, de tal forma que pueda hacer un seguimiento oportuno de cada caso. Este es un servicio disponible 24/7 los 365 dias del año.<br>
									Además de ser un excelente medio para compartir tips, manuales y tutoriales, asi como información de interes con nuestros clientes.</p>
								</div>
							</div></div>
						</div>
					</div>
				</div>
			</div>
		</section><!--/#service--> --}}
       {{--  <section id="contact">
            <div class="container">
                <div class="row text-center clearfix">
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="contact-heading">
                            <h2 class="title-one">Contáctanos</h2>
                            <p>No dudes en contactarnos si deseas mas información o quieres una cotización de nuestros servicios</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="contact-details">
                    <div class="pattern"></div>
                    <div class="row text-center clearfix">
                        <div class="col-sm-6">
                            <div class="contact-address">
                                <p>Gestión de Condominios</p>
                                Es una aplicación <br>
                                    <br>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="contact-address">
                                    <address><p>Atención 24/7 a través de nuestros correos y centro de soporte</p><br>
                                    Generar Ticket y/o Solicitar Cotización
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section> <!--/#contact--> --}}

	<footer id="footer">
		<div class="container">
			<div class="text-center">
				<p>Copyright &copy; 2018 - Todos los derechos reservados.</p>
			</div>
		</div>
	</footer> <!--/#footer-->

	<!-- jQuery 2.2.0 -->
	<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
	<!-- <script type="text/javascript" src="cvweb/js/jquery.js"></script>  -->
	<script type="text/javascript" src="cvweb/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="cvweb/js/smoothscroll.min.js"></script>
	<script type="text/javascript" src="cvweb/js/jquery.isotope.min.js"></script>
	<script type="text/javascript" src="cvweb/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="cvweb/js/jquery.parallax.min.js"></script>
	<script type="text/javascript" src="cvweb/js/main.min.js"></script>
</body>
</html>

