@extends('layouts.layout')

@section('content')
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Lista de Marcas</h4>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#modalMarcaCreate">Nova
                            Marca</button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Marca</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="gridMarcaBody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="modalMarcaCreate" tabindex="-1" role="dialog" aria-labelledby="modalMarcaLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formMarcaCreate" class="forms-sample">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMarcaLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" id="idMarca" name="marca"
                                placeholder="Nome da Marca">
                        </div>
                        <div class="form-group">
                            <label>Imagem</label>
                            <div class="input-group col-xs-12">
                                <label for="arquivo" class="form-control file-upload-info text"
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
                        <button type="submit" class="btn btn-primary">Cadastrar Marca</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalMarcaEdit" tabindex="-1" role="dialog" aria-labelledby="modalMarcaEditLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formMarcaEdit" class="forms-sample">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalMarcaEditLabel">Editar Marca</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <input type="hidden" id="idEdit">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Marca</label>
                            <input type="text" class="form-control" id="idMarcaEdit" name="marca"
                                placeholder="Nome da Marca">
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
                        <button type="submit" class="btn btn-primary">Editar Marca</button>
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
            request.open('GET', 'http://127.0.0.1:8000/marca/' + id);
            request.onload = function() {
                if (request.status === 200) {
                    $('.loading').hide();
                    let response = JSON.parse(request.responseText);
                    document.getElementById('idEdit').value = response.marca.id;
                    document.getElementById('idMarcaEdit').value = response.marca.marca;
                    document.getElementById('PreviewImageEdit').src = '/storage/' + response.marca.imagem;
                    $('#modalMarcaEdit').modal('show');
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

        document.getElementById('formMarcaCreate').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(document.getElementById('formMarcaCreate'));
            let request = new XMLHttpRequest();
            request.open('POST', 'http://127.0.0.1:8000/marca');
            request.onload = function() {
                if (request.status === 201) {
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
            $('#modalMarcaCreate').modal('hide');
            $('.loading').show();
            request.send(form);
        });

        document.getElementById('formMarcaEdit').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(document.getElementById('formMarcaEdit'));
            form.append('_method', 'PATCH');
            let request = new XMLHttpRequest();
            request.open('POST', 'http://127.0.0.1:8000/marca/' + document.getElementById('idEdit').value);
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
            $('#modalMarcaEdit').modal('hide');
            $('.loading').show();
            request.send(form);
        });

        function deleteMarca(id) {
            Swal.fire({
                title: 'Deseja realmente excluir essa Marca ?',
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
                    request.open('POST', 'http://127.0.0.1:8000/marca/' + id);
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

        function CarregarTabela() {
            let request = new XMLHttpRequest();
            request.open('GET', '{{ Route('marca.tabela') }}');
            request.onload = function() {
                if (request.status === 200) {
                    let dataMarca = JSON.parse(request.responseText);
                    let divTable = document.getElementById('gridMarcaBody');
                    let table = '';
                    for (let data of dataMarca) {
                        table += '<tr>';
                        table += '<td>' + data.id + '</td>';
                        table += '<td>' + data.marca + '</td>';
                        table += '<td>';
                        table += '<button onclick="AbreModalEditar(' + data.id +')" class="btn btn-sm btn-primary" type="button">';
                        table += '<i class="mdi mdi-grease-pencil" style="font-size: 14px;"></i>';
                        table += '</button> ';
                        table += '<button onclick="deleteMarca(' + data.id + ')" class="btn btn-sm btn-danger">';
                        table += '<i class="mdi mdi-delete-sweep" style="font-size: 14px;"></i>';
                        table += '</button>';
                        table += '</td>';
                        table += '</tr>';
                    }
                    divTable.innerHTML = table;
                } else {

                    console.log('Falha para carregar tabela.');
                }
            };
            request.onerror = function(e) {
                console.log(e);
            };
            request.send();
        };

        window.addEventListener('load', function() {
            CarregarTabela();
        });
    </script>
@endsection
