<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Immobili</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%"> Foto </th>
                        <th style="width: 1%"> ID </th>
                        <th style="width: 15%"> Nome </th>
                        <th style="width: 15%"> Città </th>
                        <th style="width: 15%"> Indirizzo </th>
                        <th style="width: 15%"> Tipologia </th>
                        <th style="width: 15%"> Dimensione </th>
                        <th style="width: 15%"> Vendita/Affitto </th>
                        <th style="width: 15%"> Prezzo </th>
                        <th style="width: 5%"> Stato </th>
                        <th style="width: 40%"> </th>

                    </tr>
                    </thead>
                    <tbody>
                    {foreach $immobili as $immobile}
                    <tr>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <img alt="Immobile" class="table-avatar" src="{$immobile->getPresentationImg()}">
                                </li>
                            </ul>
                        </td>
                        <td> {$immobile->getId()} </td>
                        <td> <a>{$immobile->getNome()}</a> </td>
                        <td> <a>{$immobile->getComune()}</a> </td>
                        <td > <a>{$immobile->getIndirizzo()}</a> </td>
                        <td > <a>{$immobile->getTipologia()}</a> </td>
                        <td > <a>{$immobile->getGrandezza()} mq</a> </td>
                        <td ><a>{$immobile->getTipoAnnuncio()}</a></td>
                        <td > <a>€ {$immobile->getPrezzo()}</a> </td>

                        <td class="project-state">
                            {if $immobile->isAttivo()}
                                <span class="badge badge-success">Attivo</span>
                            {else}
                                <span class="badge badge-danger">Non Attivo</span>
                            {/if}
                        </td>

                        <td class="project-actions text-right">
                            {if $immobile->isAttivo()}
                                <button class="btn btn-dark btn-xs"
                                        onclick="disattiva('{$immobile->getId()}')">
                                    <i class="fas fa-ban"  title="Disattiva"> </i>
                                </button>
                            {else}
                                <button class="btn btn-dark btn-xs"
                                        onclick="attiva('{$immobile->getId()}')">
                                    <i class="fas fa-smile" title="Attiva"> </i>
                                </button>
                            {/if}
                            <a href="{$path}Admin/modificaImmobile/{$immobile->getId()}">
                            <button class="btn btn-primary btn-xs" >
                                <i class="fas fa-pen" title="Modifica"> </i>
                            </button>
                            </a>

                            <button class="btn btn-danger btn-xs"
                                    onclick="elimina('{$immobile->getId()}')">
                                <i class="fas fa-trash" title="Elimina"> </i>
                            </button>

                        </td>
                    </tr>
                    {/foreach}

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
    function attiva(idParam)

    {
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '{$path}'+'Admin/attivazioneImmobile');

        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = idParam;
        form.appendChild(id);

        const attiva = document.createElement('input');
        attiva.type = 'hidden';
        attiva.name = 'attiva';
        attiva.value = 'true';
        form.appendChild(attiva);

        document.body.appendChild(form);
        form.submit();

    }
</script>
<script>
    function disattiva(idParam)
    {

        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '{$path}'+'Admin/attivazioneImmobile');

        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = idParam;
        form.appendChild(id);

        const attiva = document.createElement('input');
        attiva.type = 'hidden';
        attiva.name = 'attiva';
        attiva.value = 'false';
        form.appendChild(attiva);

        document.body.appendChild(form);
        form.submit();

    }
</script>

<script>
    function elimina(idParam)
    {

        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '{$path}'+'Admin/eliminaImmobile');

        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = idParam;
        form.appendChild(id);


        document.body.appendChild(form);
        form.submit();

    }

</script>