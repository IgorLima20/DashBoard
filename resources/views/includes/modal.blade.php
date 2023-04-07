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
                    @foreach ($itens as $key => item)
                        <div class="form-group">
                            <label>{{ item->label }}</label>
                            <input type="text" class="form-control" id="{{  }}" name="{{ item->name }}"
                                placeholder="Nome da Marca">
                        </div>
                    @endforeach
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
