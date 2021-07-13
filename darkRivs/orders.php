<?php
require_once("../LDLRIVS.php");

my_session_start();

$verification_token = base64_encode(openssl_random_pseudo_bytes(32));
$_SESSION['verification_token'] = $verification_token;
$security_token = $_SESSION["security_admin_token"];
$security_token1 = $_COOKIE["security_admin_token"];

if ($security_token == null || $security_token1 == null) {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
    exit();
}

if (hash_equals($security_token, $security_token1)) {
?>
    <? include("functions/header.php"); ?>
    <div class="card mb-4">
        <div class="card-header">Активні замовлення</div>
        <div class="card-body">
            <div class="datatable">
                <table class="table table-bordered table-hover" id="ordersInProcess" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th></th>
                            <th>Номер</th>
                            <th>Email</th>
                            <th>ПІБ</th>
                            <th>Телефон</th>
                            <th>Дата прийняття</th>
                            <th>Загальна сума</th>
                            <th>Поточний статус</th>
                            <th>Історія статусів</th>
                            <th>Зміна статусу</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Номер</th>
                            <th>Email</th>
                            <th>ПІБ</th>
                            <th>Телефон</th>
                            <th>Дата прийняття</th>
                            <th>Загальна сума</th>
                            <th>Поточний статус</th>
                            <th>Історія статусів</th>
                            <th>Зміна статусу</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">Виконані замовлення</div>
        <div class="card-body">
            <div class="datatable">
                <table class="table table-bordered table-hover" id="allOrders" width="100%" cellspacing="0">
                    <thead>
                        <tr role="row">
                            <th></th>
                            <th>Номер</th>
                            <th>Email</th>
                            <th>ПІБ</th>
                            <th>Телефон</th>
                            <th>Дата прийняття</th>
                            <th>Загальна сума</th>
                            <th>Поточний статус</th>
                            <th>Історія статусів</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Номер</th>
                            <th>Email</th>
                            <th>ПІБ</th>
                            <th>Телефон</th>
                            <th>Дата прийняття</th>
                            <th>Загальна сума</th>
                            <th>Поточний статус</th>
                            <th>Історія статусів</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <? include("functions/footer.php"); ?>
    <? include("functions/myScripts.php"); ?>
    <script>
        var elem = document.getElementById("orders-nav");
        elem.classList.add('active');
        // Call the dataTables jQuery plugin
        $(document).ready(function() {
            formData = {
                'verification_token': `<?= $verification_token ?>`,
                'type': 'active'
            };
            var ordersInProcessTable = $('#ordersInProcess').DataTable({
                language: {
                    url: '/css/Ukrainian.lang.json'
                },
                drawCallback: function(settings) {
                    $('[data-toggle="popover"]').popover();
                },
                ajax: {
                    url: "functions/orders.php",
                    type: "POST",
                    data: formData,
                    dataSrc: ""
                },
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: "orderLink"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "phone"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "totalPrice"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "statuses",
                        orderable: false
                    },
                    {
                        data: "buttons",
                        orderable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
            $('#ordersInProcess tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = ordersInProcessTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
            $('#ordersInProcess').on('page.dt', function() {
                $('.chevron-up').trigger('click');
            });
            formData2 = {
                'verification_token': `<?= $verification_token ?>`,
                'type': 'finished'
            };
            var allOrdersTable = $('#allOrders').DataTable({
                language: {
                    url: '/css/Ukrainian.lang.json'
                },
                drawCallback: function(settings) {
                    $('[data-toggle="popover"]').popover();
                },
                ajax: {
                    url: "functions/orders.php",
                    type: "POST",
                    data: formData2,
                    dataSrc: ""
                },
                columns: [{
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    {
                        data: "orderLink"
                    },
                    {
                        data: "email"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "phone"
                    },
                    {
                        data: "date"
                    },
                    {
                        data: "totalPrice"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "statuses",
                        orderable: false
                    }
                ],
                order: [
                    [1, 'desc']
                ]
            });
            $('#allOrders tbody').on('click', 'td.details-control', function() {
                var tr = $(this).closest('tr');
                var row = allOrdersTable.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
            $('#allOrders').on('page.dt', function() {
                $('.chevron-up').trigger('click');
            });
        });
        function changeOrderStatus(orderId, statusId, verificationToken) {
                formData = {
                    'verification_token': verificationToken,
                    'orderId': orderId,
                    'statusId': statusId
                };
                $.ajax({
                    type: "POST",
                    url: "functions/changeOrderStatus.php",
                    data: formData,
                    success: function(response) {
                        if (response != null) {
                            
                            // parse response from server
                            var jsonData = JSON.parse(response);
                            if (jsonData.success == true) {
                                var ordersInProcessTable = $('#ordersInProcess').DataTable();
                                ordersInProcessTable.ajax.reload();
                                var allOrdersTable = $('#allOrders').DataTable();
                                allOrdersTable.ajax.reload();
                            }
                        }
                    },
                    error: function(data) {
                        console.log('An error occurred.');
                        console.log(data);
                    },
                });
            }
    </script>
<?php } else {
    include("../scripts.php");
    echo "<script>$(document).ready(function() { $.redirect('login.php'); });</script>";
    exit();
} ?>