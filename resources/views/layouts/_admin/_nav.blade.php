<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Admin</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="conta" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Configurações<span class="sr-only">(current)</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="conta">
          <a class="dropdown-item" href="#">Acesso / Segurança</a>
          <a class="dropdown-item" href="#">Usuários</a>
          <a class="dropdown-item" href="{{route('site.home')}}">Site</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Sair</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="massas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Produtos
        </a>
        <div class="dropdown-menu" aria-labelledby="massas">
          <a class="dropdown-item" href="{{route('produto.head')}}">Produtos</a>
          <a class="dropdown-item" href="{{route('marca.head')}}">Marcas</a>
          <a class="dropdown-item" href="{{route('categoria.head')}}">Categorias</a>
          <a class="dropdown-item" href="#">Estoques</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Ouras</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="financeiro" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Financeiro
        </a>
        <div class="dropdown-menu" aria-labelledby="financeiro">
          <a class="dropdown-item" href="#">Contas a Receber</a>
          <a class="dropdown-item" href="#">Contas a Pagar</a>
          <a class="dropdown-item" href="#">Lançar Despesa</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Outros</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="vendas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Vendas
        </a>
        <div class="dropdown-menu" aria-labelledby="vendas">
          <a class="dropdown-item" href="{{route('venda.pdv')}}">PDV</a>
          <a class="dropdown-item" href="#">Vendas</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Outros</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="vendas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Produtos
        </a>
        <div class="dropdown-menu" aria-labelledby="vendas">
          
          <a class="dropdown-item" href="{{route('produto.head')}}">Produtos</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Outros</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="rh" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Recurso Humanos
        </a>
        <div class="dropdown-menu" aria-labelledby="rh">
          <a class="dropdown-item" href="#">Funcionários</a>
          <a class="dropdown-item" href="#">Cadastrar Funcionário</a>
          <a class="dropdown-item" href="#">Folha de Pagamento</a>
          <a class="dropdown-item" href="#"></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Outros</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Mais
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>