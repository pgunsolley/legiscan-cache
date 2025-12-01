<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AmendmentRecords Controller
 *
 * @property \App\Model\Table\AmendmentRecordsTable $AmendmentRecords
 */
class AmendmentRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->AmendmentRecords->find();
        $amendmentRecords = $this->paginate($query);

        $this->set(compact('amendmentRecords'));
        $this->viewBuilder()->setOption('serialize', ['amendmentRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Amendment Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $amendmentRecord = $this->AmendmentRecords->get($id, contain: []);
        $this->set(compact('amendmentRecord'));
        $this->viewBuilder()->setOption('serialize', ['amendmentRecord']);
    }
}
