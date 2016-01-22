<link rel="stylesheet" href="<?= get_template_directory_uri() ?>/css/admin.jquery.dataTables.css" />
<script src="<?= get_template_directory_uri() ?>/js/libs/jquery.dataTables.min.js"></script>
<script>
    (function($){ $(function() {
        $('#requests').DataTable();    
    }); })(jQuery);
</script>

<div class="wrap">  
    <h1>Customer Requests</h1>

    <table id="requests" class="widefat striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Property</th>
                <th>Type</th>                
                <th>Name</th>
                <th>Phone</th>
                <th>E-mail</th>
                <th>Message</th>
                <th>First Date</th>
                <th>Second Date</th>
            </tr>
        </thead>
        
        <tbody>
            <?php foreach ($requests as $request) { ?>
                <tr>                
                    <td><?= $request->creation_date ?></td>
                    <td><a href="<?= site_url("/properties/{$request->property->id}/") ?>"><?= $request->property->mls_id ?></td>
                    <td><?= $request->type ?></td>
                    <td><?= $request->name ?></td>
                    <td><?= $request->phone ?></td>
                    <td><?= $request->email ?></td>
                    <td><?= $request->message ?></td>
                    <td><?= $request->first_preferred_date ?></td>
                    <td><?= $request->second_preferred_date ?></td>                       
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
