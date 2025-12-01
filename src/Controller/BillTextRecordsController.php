<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * BillTextRecords Controller
 *
 * @property \App\Model\Table\BillTextRecordsTable $BillTextRecords
 */
class BillTextRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->BillTextRecords->find();
        $billTextRecords = $this->paginate($query);

        $this->set(compact('billTextRecords'));
        $this->viewBuilder()->setOption('serialize', ['billTextRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Bill Text Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $billTextRecord = $this->BillTextRecords->get($id, contain: []);
        $this->set(compact('billTextRecord'));
        $this->viewBuilder()->setOption('serialize', ['billTextRecord']);
    }
}
