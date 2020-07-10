<!-- Modal -->
<div class="modal fade" id="search-client" tabindex="-1" role="dialog" aria-labelledby="search-client-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="search-client-label">{{ __('Search Customer') }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="d-flex justify-content-center spinner">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="col-md-12 result">
                <fieldset id='fieldset-client-modal'>
                    <dl class="row">
                        <dt class="col-sm-4">Nome</dt>
                        <dd class="col-sm-8" id="nome"></dd>
                        <dt class="col-sm-4">Telefone</dt>
                        <dd class="col-sm-8" id="telefone"></dd>
                        <dt class="col-sm-4">Logradouro</dt>
                        <dd class="col-sm-8" id="logradouro"></dd>
                        <dt class="col-sm-4">Bairro</dt>
                        <dd class="col-sm-8" id="bairro"></dd>
                        <dt class="col-sm-4">Município</dt>
                        <dd class="col-sm-8" id="municipio"></dd>
                        <dt class="col-sm-4">UF</dt>
                        <dd class="col-sm-8" id="uf"></dd>
                        <dt class="col-sm-4">Número</dt>
                        <dd class="col-sm-8" id="numero"></dd>
                        <dt class="col-sm-4">CEP</dt>
                        <dd class="col-sm-8" id="cep"></dd>
                    </dl>
                </fieldset>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
          <button type="button" class="btn btn-primary import">{{ __('Import') }}</button>
        </div>
      </div>
    </div>
</div>
