<?php

namespace App\Controller;

use App\Model\InvoiceTrainingManager;

class InvoiceTrainingController extends AbstractController
{
    /**
     * Only when adding a new invoice
     */
    public function add(array $invoice): ?int
    {
            $invoiceTraining = new InvoiceTrainingManager();
            return $invoiceTraining->insert($invoice);
    }

    /**
     * Only when deleting a specific invoice
     */
    public function delete(int $invoiceId): void
    {
            $invoiceTraining = new InvoiceTrainingManager();
            $invoiceTraining->delete((int)$invoiceId);
    }

    // Since it is an intermediate table, there is no need to create
    // a read or update function to this point.
}
