<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal avec DataTable et Ajout de Compétences</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.0/css/select.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>

    <!-- Button to Open Modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Ouvrir Modal</button>

    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Liste des Compétences</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <table id="competenceTable" class="table responsive" style="width: 100%;">
                        <thead>
                            <tr>
                                <th style="width: 10px;"></th>
                                <th style="width: 250px;">Nom de Compétence</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <input type="text" id="newCompetenceInput" class="form-control" placeholder="Ajouter une nouvelle compétence">
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer d-flex justify-content-between">
                    <button id="btn_select" type="button" class="btn btn-secondary">valider</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.0/js/select.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            // Création du DataTable




            $('.modal').on('shown.bs.modal', function() {
                DataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            })


            var table = $('#competenceTable').DataTable({
                dom: 'ft',
                data: comptetences,
                scrollY: '200px',
                scrollCollapse: false,
                paging: false,
                select: {
                    style: 'multi',
                    selector: 'td:first-child .checkable'
                },
                columnDefs: [{
                        targets: 0,
                        data: 'id',
                        className: 'text-right ',
                        //render: DataTable.render.select(),
                        render: function(data, type, row) {
                            return '<input class="form-check-input checkable " type="checkbox">'
                        }
                    },
                    {
                        targets: 1,
                        data: 'text'
                    },
                ]
            });

            // Ajouter une compétence quand on appuie sur la touche Entrée dans l'input
            $("#newCompetenceInput").keypress(function(e) {
                if (e.which == 13) { // 13 corresponds à la touche Entrée
                    var newCompetence = $(this).val();

                    var table = $('#competenceTable').DataTable();
                    var count = table.rows().count();

                    console.log(count);
                    console.log(newCompetence);

                    table.row.add({
                        id: count++,
                        text: newCompetence
                    }).draw(false);

                    $(this).val(''); // Vider l'input après l'ajout
                }
            });

            $('#btn_select').on('click', function(e) {
                var table = $('#competenceTable').DataTable();
                var rows = table.rows({
                    selected: true
                }).data();
                var ids = rows.map((o, i) => {
                    return o.id;
                });

                console.log(ids);

            })
        });
    </script>

</body>

</html>