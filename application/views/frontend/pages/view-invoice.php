<main class="content-wrapper">
    <section class="content-sec">
        <div class="col-md-12">
            <div class="dash_box">
                <div class="dash_box_hed">
                    <p>Invoice <span class="text-uppercase float-right">#<?= $invoice_no ?></span></p>
                </div>
                <div class="content-area p-3">
                    <table class="invoice-table" width="100%">
                        <tbody>
                            <tr>
                                <th>Billing Name</th>
                                <td>
                                    <?= $payment['payer']['payer_info']['shipping_address']['recipient_name'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Billing Address</th>
                                <td>
                                    <?= $payment['payer']['payer_info']['shipping_address']['line1'] . '<br/>' . $payment['payer']['payer_info']['shipping_address']['city'] . ', ' . $payment['payer']['payer_info']['shipping_address']['state'] . ' ' . $payment['payer']['payer_info']['shipping_address']['postal_code'] . ', ' . $payment['payer']['payer_info']['shipping_address']['country_code'] ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Purchased At</th>
                                <td>
                                    <?= date('M d, Y g:i A', strtotime( $payment['create_time'] ) ) ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Paid Amount</th>
                                <td>
                                    <?= currency_format( $payment['transactions'][0]['amount']['total'] ) ?>
                                </td>                                
                            </tr>
                            <tr>
                                <th>Payment ID</th>
                                <td><?= $payment['id'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>