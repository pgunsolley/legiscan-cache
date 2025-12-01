<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * SupplementRecords Controller
 *
 * @property \App\Model\Table\SupplementRecordsTable $SupplementRecords
 */
class SupplementRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->SupplementRecords->find();
        $supplementRecords = $this->paginate($query);

        $this->set(compact('supplementRecords'));
        $this->viewBuilder()->setOption('serialize', ['supplementRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Supplement Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $supplementRecord = $this->SupplementRecords->get($id, contain: []);
        $this->set(compact('supplementRecord'));
        $this->viewBuilder()->setOption('serialize', ['supplementRecord']);
    }
}
