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
                <h3 class="card-title">Clienti</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%"> Foto </th>
                        <th style="width: 1%">
                            ID
                        </th>
                        <th style="width: 15%">
                            Nome
                        </th>
                        <th style="width: 15%">
                            Email
                        </th>
                        <th style="width: 15%">
                            Data di nascita
                        </th>
                        <th style="width: 15%" class="text-center">
                            Data di iscrizione
                        </th>

                        <th style="width: 5%" class="text-center">
                            Verificato
                        </th>

                        <th style="width: 40%" class="text-center">
                        </th>
                    </tr>

                    </thead>
                    <tbody>
                    {foreach $clienti as $cliente}
                    <tr>
                        <td>
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    {if isset($cliente->getImmagine())}
                                        <img  class="table-avatar" src="{$cliente->getImmagine()->viewImageHTML()}">
                                    {else}  <img class="table-avatar" src="{$path}Smarty/img/icons/avatar.png">
                                    {/if}
                                </li>
                            </ul>
                        </td>
                        <td>
                            {$cliente->getId()}
                        </td>
                        <td>
                            <a>
                                {$cliente->getNome()} {$cliente->getCognome()}
                            </a>

                        </td>
                        <td>
                            <a>{$cliente->getEmail()}</a>
                        </td>
                        <td >
                            <a>
                                {$cliente->getDataNascita()->getDateString()}
                            </a>
                        </td>

                        <td >
                            <a>{$cliente->getIscrizione()->getDateString()}</a>
                        </td>

                        <td class="project-state">
                            {if $cliente->isAttivato()}
                                <span class="badge badge-success">Attivo</span>
                                {else} <span class="badge badge-danger">Non Attivo</span>
                            {/if}
                        </td>



                        <td class="project-actions text-right">
                            <a class="project-state" href="{$path}Admin/modificaCliente/id/{$cliente->getId()}">
                                {if $cliente->isAttivato()}
                                    <button class="btn btn-primary btn-sm" style="" onclick="  disattiva({$cliente->getId()})">
                                        <i class="fas fa-folder" >

                                        </i>
                                        Disattiva
                                    </button>
                                {else}
                                    <button class="btn btn-primary btn-sm" onclick=" attiva({$cliente->getId()})">
                                        <i class="fas fa-folder" >
                                        </i>
                                        Attiva
                                    </button>
                                {/if}

                                <button class="btn btn-primary btn-sm" onclick=" modifica({$cliente->getId()})">
                                    <i class="fas fa-trash">
                                    </i>
                                    Modifica
                                </button>
                            <button class="btn btn-danger btn-sm" onclick=" elimina({$cliente->getId()})">
                                <i class="fas fa-trash">
                                </i>
                                Elimina
                            </button>
                            </a>
                        </td>

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
        form.setAttribute('action', '{$path}'+'Admin/attivazioneUtente');

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
        alert("PORCODIO");
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '/AgenziaImmobiliare/Admin/attivazioneUtente');

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
    function modifica(idParam)
    {
        alert("PORCODIO");
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '/AgenziaImmobiliare/Admin/modificaUtente');

        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = idParam;
        form.appendChild(id);


        document.body.appendChild(form);
        form.submit();

    }

</script>
<script>
    function elimina(idParam)
    {
        alert("PORCODIO");
        var form = document.createElement('form');
        form.setAttribute('method', 'post');
        form.setAttribute('action', '/AgenziaImmobiliare/Admin/eliminaUtente');

        const id = document.createElement('input');
        id.type = 'hidden';
        id.name = 'id';
        id.value = idParam;
        form.appendChild(id);


        document.body.appendChild(form);
        form.submit();

    }

</script>