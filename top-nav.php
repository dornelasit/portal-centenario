<nav id="top">
	<div class="container">

		<div id="top-links" class="pull-left">
			<ul class="list-inline">
				<li id="liCustomerNameTopNav" style="display: none;">
					<label>Olá, <strong id="labelCustomerNameTopNav">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></label>
				</li>
			</ul>
		</div>

		<div id="top-links" class="nav pull-right">
			<ul class="list-inline">
				<li class="dropdown">
					<a href="account" title="Minha conta" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user"></i>
						<span class="hidden-xs hidden-sm hidden-md">Minha conta</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu dropdown-menu-right">
						<li id="maAccess" style="display : none;">
							<a href="customer-login">Acessar</a>
						</li>
						<li id="maDataAndOrders" style="display : none;">
							<a href="account">Meus Dados</a>
						</li>
						<li id="maExit" style="display : none;">
							<a href="" onClick="logOffCustomer();">Sair</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>