<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * MasterListRecords Controller
 *
 * @property \App\Model\Table\MasterListRecordsTable $MasterListRecords
 */
class MasterListRecordsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->MasterListRecords->find();
        $masterListRecords = $this->paginate($query);

        $this->set(compact('masterListRecords'));
        $this->viewBuilder()->setOption('serialize', ['masterListRecords']);
    }

    /**
     * View method
     *
     * @param string|null $id Master List Record id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $masterListRecord = $this->MasterListRecords->get($id, contain: []);
        $this->set(compact('masterListRecord'));
        $this->viewBuilder()->setOption('serialize', ['masterListRecord']);
    }
}
