<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Transaction</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Transaction view">
    <meta name="author" content="Damian Barczyk">
    <meta name="HandheldFriendly" content="True" /> 		<meta name="MobileOptimized" content="320" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="robots" content="noindex,follow,noodp,noydir" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>
<body>

<table id="table" class="display" style="width:100%">
    <thead>
    <tr>
        <th>Id</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Created Date</th>
    </tr>
    </thead>

</table>

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<script>

    $(document).ready(function() {
        var table = $('#table').DataTable({
            "ajax": {
                "url": "gui/json",
                "dataSrc": ""
            },

        });
    });
</script>
</body>
</html>