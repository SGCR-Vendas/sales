<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Sistema de Gestão de Códigos de Recarga - @if(View::hasSection('title')) @yield('title') @else Dashboard
		@endif</title>
	<!-- plugins:css -->
	<link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
	<!-- endinject -->
	<!-- Plugin css for this page -->
	<!-- End plugin css for this page -->
	<!-- inject:css -->
	<!-- endinject -->
	<!-- Layout styles -->
	<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	<!-- End layout styles -->
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />

	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.css" />
	<link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet" />


</head>

<body>
	<div class="container-scroller">

		<!-- partial:partials/_navbar.html -->
		<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
			<div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
				<a class="navbar-brand brand-logo" href="{{ env('APP_URL') }}"><img src="{{ asset('assets/images/logo-sgcr-mini.jpg') }}" alt="{{ env('APP_NAME') }}" /></a>
				<a class="navbar-brand brand-logo-mini" href="{{ env('APP_URL') }}"><img src="{{ asset('assets/images/logo-sgcr-mini.jpg') }}" alt="{{ env('APP_NAME') }}" /></a>
			</div>
			<div class="navbar-menu-wrapper d-flex align-items-stretch">
				<button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
					<span class="mdi mdi-menu"></span>
				</button>

				@if(Auth::user()->user_level==1 && Auth::user()->id_empresa==0)
				<div class="search-field d-none d-md-block">
					<form class="d-flex align-items-center h-100" action="#">
						<div class="input-group">

							<select class="form-control select2 select-2-width-400" id="selecionar_empresa" name="selecionar_empresa">
								<option value="0">Todas as Empresas</option>
								@foreach($empresas_lista as $empresa)

								<?php
								$selected = null;
								if (Session::has('empresa')) {
									if (Session::get('empresa')['id'] == $empresa->id) {
										$selected = "selected";
									}
								}
								?>

								<option value="{{ $empresa->id }}" {{ $selected }}>{{ $empresa->nome . ' - ' . $empresa->cpf }}</option>
								@endforeach
							</select>

						</div>
					</form>
				</div>
				@endif


				<ul class="navbar-nav navbar-nav-right">
					<li class="nav-item nav-profile dropdown">
						<a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<div class="nav-profile-img">
								<img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="image">
								<span class="availability-status online"></span>
							</div>
							<div class="nav-profile-text">
								<p class="mb-1 text-black">{{ Auth::user()->name }}</p>
							</div>
						</a>
						<div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
							<a class="dropdown-item" href="#">
								<i class="mdi mdi-cached me-2 text-success"></i> Activity Log </a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="{{ route('signout') }}">
								<i class="mdi mdi-logout me-2 text-primary"></i> Sair do Sistema </a>
						</div>
					</li>
					<li class="nav-item d-none d-lg-block full-screen-link">
						<a class="nav-link">
							<i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
						</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="mdi mdi-email-outline"></i>
							<span class="count-symbol bg-warning"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
							<h6 class="p-3 mb-0">Messages</h6>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<img src="{{ asset('assets/images/faces/face4.jpg') }}" alt="image" class="profile-pic">
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message
									</h6>
									<p class="text-gray mb-0"> 1 Minutes ago </p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<img src="{{ asset('assets/images/faces/face2.jpg') }}" alt="image" class="profile-pic">
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a
										message</h6>
									<p class="text-gray mb-0"> 15 Minutes ago </p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<img src="{{ asset('assets/images/faces/face3.jpg') }}" alt="image" class="profile-pic">
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated
									</h6>
									<p class="text-gray mb-0"> 18 Minutes ago </p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<h6 class="p-3 mb-0 text-center">4 new messages</h6>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
							<i class="mdi mdi-bell-outline"></i>
							<span class="count-symbol bg-danger"></span>
						</a>
						<div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
							<h6 class="p-3 mb-0">Notificações</h6>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-success">
										<i class="mdi mdi-calendar"></i>
									</div>
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
									<p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today
									</p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-warning">
										<i class="mdi mdi-settings"></i>
									</div>
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
									<p class="text-gray ellipsis mb-0"> Update dashboard </p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item preview-item">
								<div class="preview-thumbnail">
									<div class="preview-icon bg-info">
										<i class="mdi mdi-link-variant"></i>
									</div>
								</div>
								<div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
									<h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
									<p class="text-gray ellipsis mb-0"> New admin wow! </p>
								</div>
							</a>
							<div class="dropdown-divider"></div>
							<h6 class="p-3 mb-0 text-center">See all notifications</h6>
						</div>
					</li>
					<li class="nav-item nav-logout d-none d-lg-block">
						<a class="nav-link" href="#">
							<i class="mdi mdi-power"></i>
						</a>
					</li>
					<li class="nav-item nav-settings d-none d-lg-block">
						<a class="nav-link" href="#">
							<i class="mdi mdi-format-line-spacing"></i>
						</a>
					</li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
					<span class="mdi mdi-menu"></span>
				</button>
			</div>
		</nav>
		<!-- partial -->
		<div class="container-fluid page-body-wrapper">
			<!-- partial:partials/_sidebar.html -->
			<nav class="sidebar sidebar-offcanvas" id="sidebar">
				<ul class="nav">
					<li class="nav-item nav-profile">
						<a href="#" class="nav-link">
							<div class="nav-profile-image">
								<img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile">
								<span class="login-status online"></span>
								<!--change to offline or busy as needed-->
							</div>
							<div class="nav-profile-text d-flex flex-column">
								<span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
								<span class="text-secondary text-small">{{ Auth::user()->email }}</span>
							</div>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ route('dashboard') }}">
							<span class="menu-title">Dashboard</span>
							<i class="mdi mdi-home menu-icon"></i>
						</a>
					</li>

					@foreach($modulos_permitidos as $module)

					<li class="nav-item">

						@if(count($module['submodulo']) >0)
						<a class="nav-link" data-bs-toggle="collapse" href="#{{ $module['url_amigavel'] }}" aria-expanded="false" aria-controls="{{ $module['url_amigavel'] }}">
							<span class="menu-title">{{ $module['titulo'] }}</span>
							<i class="menu-arrow"></i>
							<i class="{{ $module['icone'] }} menu-icon"></i>
						</a>
						@else
						<a class="nav-link" href="{{ env('URL_APP_ADMIN') }}{{ $module['url_amigavel'] }}">
							<span class="menu-title">{{ $module['titulo'] }}</span>
							<i class="{{ $module['icone'] }} menu-icon"></i>
						</a>
						@endif

						@if(count($module['submodulo']) >0)
						<div class="collapse" id="{{ $module['url_amigavel'] }}">
							<ul class="nav flex-column sub-menu">
								@foreach($module['submodulo'] as $sub)
								<?php
								$item = env('URL_APP_ADMIN') .
									Request::segment(2) . "/" .
									Request::segment(3);

								?>
								<li class="nav-item"> <a class="nav-link {{ $item === $sub['url_amigavel']? 'active-submodulo' : '' }}" href="{{ url($sub['url_amigavel']) }}">{{ $sub['titulo'] }}</a></li>
								@endforeach
							</ul>
						</div>
						@endif
					</li>
					@endforeach

					<li class="nav-item">
						<a class="nav-link" href="{{ route('signout') }}">
							<span class="menu-title">Sair do Sistema</span>
							<i class="mdi mdi-power menu-icon"></i>
						</a>
					</li>

				</ul>
			</nav>
			<!-- partial -->
			<div class="main-panel">


				<div class="content-wrapper">
					@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
					@include('sweetalert::alert')
					@yield('content')
				</div>
				<!-- content-wrapper ends -->
				<!-- partial:partials/_footer.html -->


				<footer class="footer">
					<div class="container-fluid d-flex justify-content-between">
						<span class="text-muted d-block text-center text-sm-start d-sm-inline-block">{{ env('APP_COPY') }}</span>
						<span class="float-none float-sm-end mt-1 mt-sm-0 text-end">{{ env('APP_COPY_DEVELOPMENT') }}</span>
					</div>
				</footer>
				<!-- partial -->
			</div>
			<!-- main-panel ends -->
		</div>
		<!-- page-body-wrapper ends -->
	</div>
	<!-- container-scroller -->



	<!-- plugins:js -->
	<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
	<!-- endinject -->

	<!-- Plugin js for this page -->
	<script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
	<!-- End plugin js for this page -->

	<!-- inject:js -->
	<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
	<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
	<script src="{{ asset('assets/js/misc.js') }}"></script>
	<!-- endinject -->

	<!-- Custom js for this page -->
	<script src="{{ asset('assets/js/dashboard.js') }}"></script>
	<script src="{{ asset('assets/js/todolist.js') }}"></script>
	<!-- End custom js for this page -->

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/datatables.min.js">
	</script>

	<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

	<!-- Input-Mask -->
	<script type="text/javascript" src="{{ asset('vendor/inputmask/js/jquery.inputmask.bundle.min.js') }}"></script>

	<!-- summernote css/js -->
	<link href="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

	<script>
		dados1 = {};

		function limite_textarea(qtde, valor, campo) {
			quant = qtde;
			total = valor.length;
			if (total <= quant) {
				resto = quant - total;
				document.getElementById('cont').innerHTML = resto;
			} else {
				document.getElementById(campo).value = valor.substr(0, quant);
			}
		}
		$(document).ready(function() {

			BASE_URL = '<?php echo route('admin'); ?>';
			var route = window.location.pathname;



			$(".select2").select2();

			// $(".adicionar-linha-venda").click(function() {

			// 	//alert('clicou')


			// 	template = $("#linha-venda").clone();

			// 	console.log(template);
			// 	template.appendTo(".linha-venda");

			// })


			// /* Clone de Registro de Código */
			// $('.clonador').click(function() {

			// 	$clone = $('.box_venda.hide').clone(true);
			// 	$clone.removeClass('hide');
			// 	aplicaSelect2();
			// 	$('#lista_vendas').append($clone);

			// });

			// function aplicaSelect2() {
			// 	$('.select2').select2({
			// 		allowClear: true,
			// 		width: '100%',
			// 	});
			// }

			// $(document).ready(function() {
			// 	aplicaSelect2();
			// });

			// $('.btn_remove').click(function() {
			// 	$(this).parents('.box_venda').remove();
			// });
			//nao é

			$(".consultar-produto-associado").on('click', function() {
				let id_produto = $(this).attr('data-id_produto');
				$.ajax({
						url: "{{ route('produto.associar.pesquisar_empresa_por_produto') }}",
						type: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							id_produto: id_produto
						},
						beforeSend: function() {
							$(".money").prop("disabled", true);
							$("#id_produto").prop("disabled", false);
							$("#id_produto").html("<option value=''>Pesquisando...</option>");
						}
					})
					.done(function(msg) {
						$("#id_produto").html(msg);
					})
					.fail(function(jqXHR, textStatus, msg) {
						alert(msg);
					});
			})


			$("#selecionar_empresa").on('change', function() {
				let id_empresa = $(this).val();

				$.ajax({
						url: "{{ route('api.selecionar_empresa') }}",
						type: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							id_empresa: id_empresa,
							route: route
						}
					})
					.done(function(msg) {
						window.location.href = route;
					})
					.fail(function(jqXHR, textStatus, msg) {
						alert(msg);
					});
			})

			$("#valor_venda").on('keyup', function() {
				let valor_compra = ($("#valor_compra").val()) ?? 0;
				let valor_venda = ($("#valor_venda").val()) ?? 0;
				let lucro_obtido = (valor_venda - valor_compra);

				if (lucro_obtido > 0) {
					$("#lucro_obtido").val(lucro_obtido);
				} else {
					$("#lucro_obtido").val('0.00');
				}
			})

			$('.summernote').summernote({
				height: 400
			});

			$('.select2-multiple').select2({
				minimumResultsForSearch: -1,
				placeholder: function() {
					$(this).data('placeholder');
				}
			});

			$(".money").inputmask('currency', {
				"autoUnmask": true,
				radixPoint: ",",
				groupSeparator: ".",
				allowMinus: false,
				prefix: 'R$ ',
				digits: 2,
				digitsOptional: false,
				rightAlign: true,
				unmaskAsNumber: true
			});

			$('[data-toggle="tooltip"]').tooltip();

			$('.celular').inputmask('(99) 99999-9999');
			$('.cpf').inputmask('999.999.999-99');
			$('.cep').inputmask('99999-999');


			/* Exclusão Padrão */
			$('.excluir-padrao').on('click', function() {
				let tabela = $(this).data('table');
				let modulo = $(this).data('module');
				let redirecionar = $(this).data('redirect');
				let id = $(this).data('id');

				console.log(tabela, modulo, redirecionar, id)

			})  

			/* Vínculo de Empresa ao Produto */
			$("#id_empresa").on('change', function() {
				let id_empresa = $(this).val();

				$.ajax({
						url: "{{ route('produto.associar.pesquisar_produto_por_empresa') }}",
						type: 'post',
						data: {
							"_token": "{{ csrf_token() }}",
							id_empresa: id_empresa,
							route: route
						},
						dataType: 'json',
						beforeSend: function() {
							$(".money").prop("disabled", true);
							$("#id_produto").prop("disabled", false);
							$("#id_produto").html("<option value=''>Pesquisando...</option>");
						}
					})
					.done(function(msg) {
						$(".lista-produtos").html('<option>Selecione</option>');
						$.each(msg.produtos, function(k, v) {
							$(".lista-produtos").append('<option value="' + v.id + '">' + v.titulo + '</option>');
							/// do stuff
						});

						$(".lista-clientes").html('<option>Selecione</option>');
						$.each(msg.clientes, function(k, v) {
							$(".lista-clientes").append('<option value="' + v.id + '">' + v.nome + '</option>');
							/// do stuff
						});

						$(".listagem").show();

						$('#formulario .lista-produtos').select2();
						$('#formulario .lista-clientes').select2();

						dados1 = msg;

						//$("#id_produto").html(msg);
					})
					.fail(function(jqXHR, textStatus, msg) {
						alert(msg);
					});
			})







			$(document).on('click', '.remove', function() {
				$(this).closest('.item-lista').remove();
			})




			//tudo cert??















			$(document).on('click', '.clonador', function() {
				$('.listagem').append($('#listagem-template').html());

				$(".lista-produtos:last").html('<option>Selecione</option>');
				$.each(dados1.produtos, function(k, v) {
					$(".lista-produtos:last").append('<option value="' + v.id + '">' + v.titulo + '</option>');
					/// do stuff
				});

				$(".lista-clientes:last").html('<option>Selecione</option>');
				$.each(dados1.clientes, function(k, v) {
					$(".lista-clientes:last").append('<option value="' + v.id + '">' + v.nome + '</option>');
					/// do stuff
				});

				$('#formulario .lista-produtos:last').select2().val(null).trigger('change');;
				$('#formulario .lista-clientes:last').select2().val(null).trigger('change');;
			})


			$('#lista-simples').DataTable({
				"language": {
					"sProcessing": "Processando...",
					"sLengthMenu": "Mostrar _MENU_ registros",
					"sZeroRecords": "Nenhum registroi foi encontrado.",
					"sEmptyTable": "Nenhum registroi foi encontrado.",
					"sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
					"sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
					"sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
					"sInfoPostFix": "",
					"sSearch": "Buscar:",
					"sUrl": "",
					"sInfoThousands": ",",
					"sLoadingRecords": "Carregando...",
					"oPaginate": {
						"sFirst": "Primero",
						"sLast": "Último",
						"sNext": "Seguinte",
						"sPrevious": "Anterior"
					},
					"oAria": {
						"sSortAscending": ": Ordenar Ascendente",
						"sSortDescending": ": Ordenar Descendente"
					}
				}
			});
		});
	</script>
</body>

</html>
