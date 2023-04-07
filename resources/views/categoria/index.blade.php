@extends('layouts.layout')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de Categorias</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#modalCategoriaCreate">Nova
                            Categoria</button>
                    </div>
                    <div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="inpCategoriaPesq" placeholder="Pesquisar por Categoria">
                            <div class="input-group-append">
                                <button onclick="filtrar()" class="btn btn-outline-primary" type="button" id="button-addon2">Pesquisar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Categoria</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="gridCategoriaBody">
                    </tbody>
                </table>

                <nav>
                    <ul class="pagination" id="paginate">
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalCategoriaCreate" tabindex="-1" role="dialog" aria-labelledby="modalCategoiraLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCategoriaCreate" class="forms-sample">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCategoiraLabel">Adicionar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" class="form-control" id="idCategoria" name="categoria"
                                placeholder="Nome da Categoria">
                        </div>
                        <div class="form-group">
                            <label>Imagem</label>
                            <div class="input-group col-xs-12">
                                <label id="labelImagem" class="form-control file-upload-info text"
                                    placeholder="Upload Imagem"></label>
                                <span class="input-group-append">
                                    <button onclick="escolherArquivo()" class="file-upload-browse btn btn-primary"
                                        type="button">Enviar</button>
                                    <input type="file" id="arquivo" style="display:none" name="imagem"
                                        accept="imagem/*">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 mt-2 text-center">
                                <img src="" class="img-fluid" id="PreviewImage" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cadastrar Categoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalCategoriaEdit" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaEditLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formCategoriaEdit" class="forms-sample">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCategoriaEditLabel">Editar Categoria</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="idEdit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" class="form-control" id="idCategoriaEdit" name="categoria"
                                placeholder="Nome da Categoria">
                        </div>
                        <div class="form-group">
                            <label>Imagem</label>
                            <div class="input-group col-xs-12">
                                <label id="labelImagemEdit" for="arquivo" class="form-control file-upload-info text"
                                    placeholder="Upload Imagem"></label>
                                <span class="input-group-append">
                                    <button onclick="escolherArquivoEdit()" class="file-upload-browse btn btn-primary"
                                        type="button">Enviar</button>
                                    <input type="file" id="arquivoEdit" style="display:none" name="imagem"
                                        accept="imagem/*">
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12 mt-2 text-center">
                                <img src="" class="img-fluid" id="PreviewImageEdit" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Editar Categoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Show -->
    <div class="modal fade" id="modalCategoriaShow" tabindex="-1" role="dialog" aria-labelledby="modalCategoriaShowLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form class="forms-sample">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Categoria</label>
                            <input type="text" class="form-control" id="idCategoriaShow" value="" disabled>
                        </div>
                        <div class="form-group">
                            <div class="col-12 mt-2 text-center">
                                <img src="" class="img-fluid" id="PreviewImageShow" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Voltar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function escolherArquivo() {
            var arquivo = document.getElementById('arquivo');
            arquivo.click();
        }

        document.getElementById('arquivo').addEventListener('change', function() {
            document.querySelector('.text').textContent = this.files[0].name;
        });


        document.getElementById('arquivo').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('PreviewImage');
                img.src = URL.createObjectURL(this.files[0]);
            }
        });

        function escolherArquivoEdit() {
            var arquivo = document.getElementById('arquivoEdit');
            arquivo.click();
        }

        document.getElementById('arquivoEdit').addEventListener('change', function() {
            document.getElementById('labelImagemEdit').textContent = this.files[0].name;
        });

        document.getElementById('arquivoEdit').addEventListener('change', function() {
            if (this.files && this.files[0]) {
                var img = document.getElementById('PreviewImageEdit');
                img.src = URL.createObjectURL(this.files[0]);
            }
        });

        function AbreModalEditar(id) {
            let request = new XMLHttpRequest();
            request.open('GET', 'http://127.0.0.1:8000/categoria/' + id);
            request.onload = function() {
                if (request.status === 200) {
                    $('.loading').hide();
                    let response = JSON.parse(request.responseText);
                    document.getElementById('idEdit').value = response.categoria.id;
                    document.getElementById('idCategoriaEdit').value = response.categoria.categoria;
                    document.getElementById('PreviewImageEdit').src = '/storage/' + response.categoria.imagem;
                    $('#modalCategoriaEdit').modal('show');
                } else {
                    $('.loading').hide();
                    Swal.fire('Erro', 'Falha para carregar marca', 'error');
                }
            };
            request.onerror = function(e) {
                $('.loading').hide();
                Swal.fire('Erro', e, 'error');
            };
            $('.loading').show();
            request.send();
        }

        function AbreModalShow(id) {
            let request = new XMLHttpRequest();
            request.open('GET', 'http://127.0.0.1:8000/categoria/' + id);
            request.setRequestHeader('Accept', 'application/json');
            request.onload = function() {
                if (request.status === 200) {
                    $('.loading').hide();
                    let response = JSON.parse(request.responseText);
                    document.getElementById('idCategoriaShow').value = response.categoria.categoria;
                    document.getElementById('PreviewImageShow').src = '/storage/' + response.categoria.imagem;
                    $('#modalCategoriaShow').modal('show');
                } else {
                    $('.loading').hide();
                    Swal.fire('Erro', 'Falha para carregar marca', 'error');
                }
            };
            request.onerror = function(e) {
                $('.loading').hide();
                Swal.fire('Erro', e, 'error');
            };
            $('.loading').show();
            request.send();
        }

        document.getElementById('formCategoriaCreate').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(document.getElementById('formCategoriaCreate'));
            let request = new XMLHttpRequest();
            request.open('POST', 'http://127.0.0.1:8000/categoria');
            request.setRequestHeader('Accept', 'application/json');
            request.onload = function() {
                if (request.status === 201) {
                    $('.loading').hide();
                    CarregarTabela();
                    let response = JSON.parse(request.responseText);
                    Swal.fire('Sucesso', response.msg, 'success');
                } else if (request.status === 422) {
                    $('.loading').hide();
                    let response = JSON.parse(request.responseText);
                    Swal.fire('Erro', response.message, 'error');
                } else {
                    $('.loading').hide();
                    Swal.fire('Erro', 'Falha no processamento', 'error');
                }
            };
            request.onerror = function(e) {
                $('.loading').hide();
                Swal.fire('Erro', e, 'error');
            };
            $('#modalCategoriaCreate').modal('hide');
            $('.loading').show();
            request.send(form);
        });

        document.getElementById('formCategoriaEdit').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(document.getElementById('formCategoriaEdit'));
            form.append('_method', 'PATCH');
            let request = new XMLHttpRequest();
            request.open('POST', 'http://127.0.0.1:8000/categoria/' + document.getElementById('idEdit').value);
            request.onload = function() {
                if (request.status === 200) {
                    $('.loading').hide();
                    CarregarTabela();
                    let response = JSON.parse(request.responseText);
                    Swal.fire('Sucesso', response.msg, 'success');
                } else if (request.status === 422) {
                    $('.loading').hide();
                    let response = JSON.parse(request.responseText);
                    Swal.fire('Erro', response.message, 'error');
                } else {
                    $('.loading').hide();
                    Swal.fire('Erro', 'Falha no processamento', 'error');
                }
            };
            request.onerror = function(e) {
                $('.loading').hide();
                Swal.fire('Erro', e, 'error');
            };
            $('#modalCategoriaEdit').modal('hide');
            $('.loading').show();
            request.send(form);
        });

        function deleteCategoria(id) {
            Swal.fire({
                title: 'Deseja realmente excluir essa Categoria ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = new FormData();
                    form.append('_token', document.getElementsByName('_token')[0].value);
                    form.append('_method', 'DELETE');
                    let request = new XMLHttpRequest();
                    request.open('POST', 'http://127.0.0.1:8000/categoria/' + id);
                    request.onload = function() {
                        if (request.status === 200) {
                            $('.loading').hide();
                            CarregarTabela();
                            let response = JSON.parse(request.responseText);
                            Swal.fire('Sucesso', response.msg, 'success');

                        } else {
                            $('.loading').hide();
                            Swal.fire('Erro', 'Falha no processamento', 'error');
                        }
                    };
                    request.onerror = function(e) {
                        $('.loading').hide();
                        Swal.fire('Erro', e, 'error');
                    };
                    $('.loading').show();
                    request.send(form);
                }
            })
        };

        function CarregarTabela(url) {
            let request = new XMLHttpRequest();
            let route = url ? url : '{{ Route('categoria.tabela') }}';
            request.open('GET', route);
            request.setRequestHeader('Accept', 'application/json');
            request.onload = function() {
                if (request.status === 200) {
                    let dataCategoria = JSON.parse(request.responseText);
                    let divTable = document.getElementById('gridCategoriaBody');
                    let divPaginate = document.getElementById('paginate');
                    let table = '';
                    let paginate = '';
                    for (let data of dataCategoria.categoria.data) {
                        table += '<tr>';
                        table += '<td>' + data.id + '</td>';
                        table += '<td>' + data.categoria + '</td>';
                        table += '<td>';
                        table += '<button onclick="AbreModalEditar(' + data.id +
                            ')" class="btn btn-sm btn-primary" type="button">';
                        table += '<i class="mdi mdi-grease-pencil" style="font-size: 14px;"></i>';
                        table += '</button> ';
                        table += '<button onclick="AbreModalShow(' + data.id +
                            ')" class="btn btn-sm btn-secondary" type="button">';
                        table += '<i class="mdi mdi-format-list-bulleted" style="font-size: 14px;"></i>';
                        table += '</button> ';
                        table += '<button onclick="deleteCategoria(' + data.id + ')" class="btn btn-sm btn-danger">';
                        table += '<i class="mdi mdi-delete-sweep" style="font-size: 14px;"></i>';
                        table += '</button>';
                        table += '</td>';
                        table += '</tr>';
                    }

                    let search = dataCategoria.search;
                    let perPage = 'disabled';
                    let prevUrl = '';
                    let currentPage = '';
                    let url = '';
                    let lastUrl = '';
                    let lastPage = 'disabled';
                    if (dataCategoria.categoria.prev_page_url) {
                        perPage = '';
                        prevUrl = "'" + dataCategoria.categoria.prev_page_url + '&search=' + search + "'";

                    }
                    if (dataCategoria.categoria.next_page_url) {
                        lastPage = '';
                        lastUrl = "'" + dataCategoria.categoria.next_page_url + '&search=' + search + "'";
                    }
                    paginate += '<li class="page-item ' + perPage + '">';
                    paginate += '<button class="page-link" onclick="CarregarTabela(' + prevUrl + ')">Previous</button>';
                    paginate += '</li>';
                    for (let i = 1; i <= dataCategoria.categoria.links; i++) {
                        currentPage = dataCategoria.categoria.to == i ? 'active' : '';
                        url = "'" + dataCategoria.categoria.links[i].url + "'";
                        paginate += '<li class="page-item ' + currentPage + '">';
                        paginate += '<button class="page-link" onclick="CarregarTabela(' + url + '&search=' + search +
                            ')">' + i +
                            '</button>';
                        paginate += '</li>';
                    }
                    paginate += '<li class="page-item ' + lastPage + '">';
                    paginate += '<button class="page-link" onclick="CarregarTabela(' + lastUrl + ')">Next</button>';
                    paginate += '</li>';
                    divTable.innerHTML = table;
                    divPaginate.innerHTML = paginate;
                } else {

                    console.log('Falha para carregar tabela.');
                }
            };
            request.onerror = function(e) {
                console.log(e);
            };
            request.send();
        };

        function filtrar() {
            let url = '{{ Route('categoria.tabela') }}' + '?search=' + document.getElementById('inpCategoriaPesq').value;
            CarregarTabela(url);
        }

        $('#modalCategoriaCreate').on('hide.bs.modal', function(event) {
            document.getElementById('idCategoria').value = '';
            document.getElementById('labelImagem').innerHTML = '';
            document.getElementById('arquivo').value = '';
            document.getElementById('PreviewImage').src = '';
        })

        $('#modalCategoriaEdit').on('hide.bs.modal', function(event) {
            document.getElementById('idCategoriaEdit').value = '';
            document.getElementById('labelImagemEdit').innerHTML = '';
            document.getElementById('arquivoEdit').value = '';
            document.getElementById('PreviewImageEdit').src = '';
        })

        $('#modalCategoriaShow').on('hide.bs.modal', function(event) {
            document.getElementById('idCategoriaShow').value = '';
            document.getElementById('PreviewImageShow').src = '';
        })

        document.addEventListener("DOMContentLoaded", function() {
            CarregarTabela();
        });
    </script>
@endsection
